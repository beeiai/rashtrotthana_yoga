/**
 * Rashtrotthana Admin Portal -- admin-portal.js
 * All dummy data removed. Everything calls real WordPress AJAX endpoints.
 */

( function () {
    'use strict';

    var cfg     = window.RADMConfig || {};
    var ajaxUrl = cfg.ajaxUrl || '';
    var nonce   = cfg.nonce   || '';
    var curPage = cfg.page    || '';

    /* ── Utilities ────────────────────────────────────────────────────── */

    function esc( str ) {
        return String( str )
            .replace( /&/g, '&amp;' ).replace( /</g, '&lt;' )
            .replace( />/g, '&gt;'  ).replace( /"/g, '&quot;' )
            .replace( /'/g, '&#039;' );
    }

    function getInitials( name ) {
        var p = String( name ).trim().split( ' ' );
        return p.length >= 2
            ? ( p[0][0] + p[1][0] ).toUpperCase()
            : p[0].substring( 0, 2 ).toUpperCase();
    }

    function radmToast( msg, type ) {
        var old = document.getElementById( 'radm-toast-el' );
        if ( old ) old.remove();
        var icon = type === 'success'
            ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
        var t = document.createElement( 'div' );
        t.id = 'radm-toast-el';
        t.className = 'radm-toast radm-toast--' + ( type || 'success' );
        t.innerHTML = icon + msg;
        document.body.appendChild( t );
        requestAnimationFrame( function () { t.classList.add( 'radm-toast-show' ); } );
        setTimeout( function () {
            t.classList.remove( 'radm-toast-show' );
            setTimeout( function () { t.remove(); }, 300 );
        }, 2800 );
    }

    function setLoading( btn, loading ) {
        if ( !btn ) return;
        if ( loading ) {
            btn.dataset.origHtml = btn.innerHTML;
            btn.innerHTML = '<span style="opacity:.6">Saving...</span>';
            btn.disabled  = true;
        } else {
            if ( btn.dataset.origHtml ) btn.innerHTML = btn.dataset.origHtml;
            btn.disabled = false;
        }
    }

    function ajaxPost( action, data, callback ) {
        var fd = new FormData();
        fd.append( 'action', action );
        fd.append( 'nonce',  nonce  );
        Object.keys( data ).forEach( function ( k ) {
            var v = data[k];
            if ( Array.isArray( v ) ) {
                v.forEach( function ( item ) { fd.append( k + '[]', item ); } );
            } else {
                fd.append( k, v );
            }
        } );
        fetch( ajaxUrl, { method: 'POST', body: fd } )
            .then( function ( r ) { return r.json(); } )
            .then( callback )
            .catch( function () { radmToast( 'Network error. Please try again.', 'error' ); } );
    }

    /* ── Header: date + user ──────────────────────────────────────────── */

    var dateEl = document.getElementById( 'radm-date' );
    if ( dateEl ) {
        var now  = new Date();
        var opts = { weekday: 'short', year: 'numeric', month: 'short', day: '2-digit' };
        dateEl.textContent = now.toLocaleDateString( 'en-IN', opts );
    }

    var avatarEl = document.getElementById( 'radm-user-avatar' );
    if ( avatarEl && cfg.user ) {
        var pts = cfg.user.trim().split( ' ' );
        avatarEl.textContent = ( pts.length >= 2 ? pts[0][0] + pts[1][0] : pts[0][0] ).toUpperCase();
    }
    var nameEl = document.getElementById( 'radm-user-name' );
    if ( nameEl && cfg.user ) { nameEl.textContent = cfg.user; }

    /* ── Image upload preview ─────────────────────────────────────────── */

    var imageInput  = document.getElementById( 'radm-event-image' );
    var previewWrap = document.getElementById( 'radm-image-preview' );
    var previewImg  = document.getElementById( 'radm-preview-img' );
    var removeImgBtn = document.getElementById( 'radm-remove-img' );
    var uploadZone  = document.getElementById( 'radm-upload-zone' );

    if ( imageInput ) {
        imageInput.addEventListener( 'change', function () {
            var file = this.files[0];
            if ( !file ) return;
            var reader = new FileReader();
            reader.onload = function ( e ) {
                if ( previewImg ) previewImg.src = e.target.result;
                if ( previewWrap ) previewWrap.style.display = 'block';
                if ( uploadZone  ) uploadZone.style.display  = 'none';
            };
            reader.readAsDataURL( file );
        } );
    }
    if ( removeImgBtn ) {
        removeImgBtn.addEventListener( 'click', function () {
            if ( previewImg ) previewImg.src = '';
            if ( previewWrap ) previewWrap.style.display = 'none';
            if ( uploadZone  ) uploadZone.style.display  = '';
            if ( imageInput  ) imageInput.value = '';
        } );
    }
    if ( uploadZone ) {
        uploadZone.addEventListener( 'dragover', function ( e ) {
            e.preventDefault(); this.style.borderColor = '#2E7D32';
        } );
        uploadZone.addEventListener( 'dragleave', function () { this.style.borderColor = ''; } );
        uploadZone.addEventListener( 'drop', function ( e ) {
            e.preventDefault(); this.style.borderColor = '';
            var file = e.dataTransfer.files[0];
            if ( file && imageInput ) {
                var dt = new DataTransfer(); dt.items.add( file );
                imageInput.files = dt.files;
                imageInput.dispatchEvent( new Event( 'change' ) );
            }
        } );
    }

    /* ── Center search (create form) ──────────────────────────────────── */

    var centerSearch = document.getElementById( 'radm-center-search' );
    if ( centerSearch ) {
        centerSearch.addEventListener( 'input', function () {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll( '#radm-centers-list .radm-checkbox-item' ).forEach( function ( el ) {
                el.style.display = el.dataset.name.includes( q ) ? '' : 'none';
            } );
        } );
    }

    /* ── Registration toggle labels ───────────────────────────────────── */

    function wireToggle( toggleId, labelId ) {
        var toggle = document.getElementById( toggleId );
        var label  = document.getElementById( labelId );
        if ( toggle && label ) {
            toggle.addEventListener( 'change', function () {
                label.textContent = this.checked ? 'Registrations are open' : 'Registrations are closed';
            } );
        }
    }
    wireToggle( 'radm-reg-toggle', 'radm-reg-toggle-label' );
    wireToggle( 'radm-edit-event-reg-open', 'radm-edit-reg-label' );

    /* ================================================================
       DASHBOARD -- Load real stats + recent events
    ================================================================ */

    if ( curPage === 'radm-dashboard' ) {

        ajaxPost( 'radm_get_dashboard_stats', {}, function ( res ) {
            if ( !res.success ) return;
            var d = res.data;
            var el;
            el = document.getElementById( 'stat-total-registrations' );
            if ( el ) el.textContent = d.total_registrations;
            el = document.getElementById( 'stat-active-events' );
            if ( el ) el.textContent = d.active_events;
            el = document.getElementById( 'stat-today-registrations' );
            if ( el ) el.textContent = d.registrations_today;
        } );

        var dashTbody = document.getElementById( 'dash-events-tbody' );
        if ( dashTbody ) {
            ajaxPost( 'radm_get_events', { limit: 5 }, function ( res ) {
                if ( !res.success || !res.data.events.length ) {
                    dashTbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:24px;color:var(--radm-text-muted);">No events found.</td></tr>';
                    return;
                }
                var baseUrl = ajaxUrl.replace( 'admin-ajax.php', '' ) + 'admin.php';
                var html = '';
                res.data.events.forEach( function ( ev ) {
                    var viewUrl = baseUrl + '?page=radm-registrations&radm_tab=users&event=' + ev.id;
                    html += '<tr>'
                        + '<td style="color:var(--radm-text-muted);font-weight:600;">' + esc( ev.num ) + '</td>'
                        + '<td style="font-weight:500;">' + esc( ev.name ) + '</td>'
                        + '<td style="color:var(--radm-text-muted);">' + esc( ev.date ) + '</td>'
                        + '<td>' + esc( ev.reg_count ) + '</td>'
                        + '<td><span class="radm-badge ' + esc( ev.status ) + '">' + esc( ev.status.charAt(0).toUpperCase() + ev.status.slice(1) ) + '</span></td>'
                        + '<td><a href="' + esc( viewUrl ) + '" class="radm-btn-view">View<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a></td>'
                        + '</tr>';
                } );
                dashTbody.innerHTML = html;
            } );
        }
    }

    /* ================================================================
       CREATE EVENT FORM -- AJAX submit with file upload
    ================================================================ */

    var createForm   = document.getElementById( 'radm-create-event-form' );
    var createSubmit = document.getElementById( 'radm-create-event-submit' );
    var formNotice   = document.getElementById( 'radm-form-notice' );

    if ( createForm ) {
        createForm.addEventListener( 'submit', function ( e ) {
            e.preventDefault();

            var checked = createForm.querySelectorAll( '[name="centers[]"]:checked' );
            if ( !checked.length ) {
                if ( formNotice ) {
                    formNotice.textContent   = 'Please select at least one center.';
                    formNotice.className     = 'radm-notice radm-notice--error';
                    formNotice.style.display = 'block';
                    formNotice.scrollIntoView( { behavior: 'smooth', block: 'center' } );
                }
                return;
            }

            setLoading( createSubmit, true );
            if ( formNotice ) formNotice.style.display = 'none';

            var fd = new FormData( createForm );
            fd.set( 'action', 'radm_create_event' );
            fd.set( 'nonce',  nonce );
            var regToggle = document.getElementById( 'radm-reg-toggle' );
            fd.set( 'registration_open', regToggle && regToggle.checked ? '1' : '0' );

            fetch( ajaxUrl, { method: 'POST', body: fd } )
                .then( function ( r ) { return r.json(); } )
                .then( function ( res ) {
                    setLoading( createSubmit, false );
                    if ( res.success ) {
                        radmToast( 'Event created successfully!', 'success' );
                        setTimeout( function () {
                            window.location.href = ajaxUrl.replace( 'admin-ajax.php', '' ) + 'admin.php?page=radm-registrations';
                        }, 1000 );
                    } else {
                        var msg = ( res.data && res.data.message ) ? res.data.message : 'Failed to create event.';
                        if ( formNotice ) {
                            formNotice.textContent   = msg;
                            formNotice.className     = 'radm-notice radm-notice--error';
                            formNotice.style.display = 'block';
                            formNotice.scrollIntoView( { behavior: 'smooth', block: 'center' } );
                        } else {
                            radmToast( msg, 'error' );
                        }
                    }
                } )
                .catch( function () {
                    setLoading( createSubmit, false );
                    radmToast( 'Network error. Please try again.', 'error' );
                } );
        } );
    }

    /* ── Events table search ──────────────────────────────────────────── */

    var eventSearch = document.getElementById( 'radm-event-search' );
    if ( eventSearch ) {
        eventSearch.addEventListener( 'input', function () {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll( '#radm-events-table .radm-event-row' ).forEach( function ( row ) {
                var name = row.querySelector( '.radm-event-name' );
                row.style.display = ( !q || ( name && name.textContent.toLowerCase().includes( q ) ) ) ? '' : 'none';
            } );
        } );
    }

    /* ================================================================
       EDIT EVENT MODAL
    ================================================================ */

    var editOverlay   = document.getElementById( 'radm-edit-event-overlay' );
    var editIdInput   = document.getElementById( 'radm-edit-event-id' );
    var editNameInput = document.getElementById( 'radm-edit-event-name' );
    var editDateInput = document.getElementById( 'radm-edit-event-date' );
    var editRegInput  = document.getElementById( 'radm-edit-event-reg-open' );
    var editRegLbl    = document.getElementById( 'radm-edit-reg-label' );
    var editSaveBtn   = document.getElementById( 'radm-edit-event-save' );
    var editUseGoogleForm = document.getElementById( 'radm-edit-use-google-form' );
    var editGoogleFormUrl = document.getElementById( 'radm-edit-google-form-url' );

    function openEditEventModal( btn ) {
        if ( !editOverlay ) return;
        editIdInput.value   = btn.dataset.id     || '';
        editNameInput.value = btn.dataset.name   || '';
        editDateInput.value = btn.dataset.date   || '';
        var open = btn.dataset.status === 'open';
        editRegInput.checked = open;
        if ( editUseGoogleForm ) editUseGoogleForm.checked = btn.dataset.useGoogleForm === '1';
        if ( editGoogleFormUrl ) editGoogleFormUrl.value   = btn.dataset.googleFormUrl || '';
        if ( editRegLbl ) editRegLbl.textContent = open ? 'Registrations are open' : 'Registrations are closed';
        editOverlay.setAttribute( 'aria-hidden', 'false' );
        editOverlay.classList.add( 'radm-modal-open' );
        editNameInput.focus();
    }

    function closeEditEventModal() {
        if ( !editOverlay ) return;
        editOverlay.classList.remove( 'radm-modal-open' );
        editOverlay.setAttribute( 'aria-hidden', 'true' );
    }

    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-edit-event-btn' );
        if ( btn ) openEditEventModal( btn );
        var close = e.target.closest( '#radm-edit-event-close, #radm-edit-event-cancel' );
        if ( close ) closeEditEventModal();
    } );
    if ( editOverlay ) {
        editOverlay.addEventListener( 'click', function ( e ) {
            if ( e.target === editOverlay ) closeEditEventModal();
        } );
    }

    if ( editSaveBtn ) {
        editSaveBtn.addEventListener( 'click', function () {
            var evId  = editIdInput && editIdInput.value;
            var evNm  = editNameInput && editNameInput.value.trim();
            var evDt  = editDateInput && editDateInput.value;
            var regOp = editRegInput  && editRegInput.checked ? '1' : '0';
            if ( !evNm ) { radmToast( 'Event name is required.', 'error' ); return; }
            setLoading( editSaveBtn, true );
            ajaxPost( 'radm_update_event', {
                event_id: evId, event_name: evNm, event_date: evDt, registration_open: regOp, use_google_form: (editUseGoogleForm && editUseGoogleForm.checked ? 1 : 0), google_form_url: (editGoogleFormUrl ? editGoogleFormUrl.value : " \)
            }, function ( res ) {
                setLoading( editSaveBtn, false );
                if ( res.success ) {
                    closeEditEventModal();
                    var row = document.querySelector( '.radm-event-row[data-id="' + evId + '"]' );
                    if ( row ) {
                        var nc = row.querySelector( '.radm-event-name' );
                        if ( nc ) nc.textContent = res.data.new_name;
                        var badge = row.querySelector( '.radm-badge' );
                        if ( badge ) {
                            badge.className   = 'radm-badge ' + res.data.new_status;
                            badge.textContent = res.data.new_status.charAt(0).toUpperCase() + res.data.new_status.slice(1);
                        }
                        var eb = row.querySelector( '.radm-edit-event-btn' );
                        if ( eb ) {
                            eb.dataset.name   = res.data.new_name;
                            eb.dataset.date   = evDt;
                            eb.dataset.status = res.data.new_status;
                        }
                    }
                    radmToast( 'Event updated.', 'success' );
                } else {
                    radmToast( ( res.data && res.data.message ) || 'Update failed.', 'error' );
                }
            } );
        } );
    }

    /* ================================================================
       DELETE CONFIRM MODAL (events + participants)
    ================================================================ */

    var delOverlay = document.getElementById( 'radm-delete-modal-overlay' );
    var delLblEl   = document.getElementById( 'radm-delete-label' );
    var delYesBtn  = document.getElementById( 'radm-delete-confirm-btn' );
    var pendTarget = null;

    function openDelModal( target ) {
        if ( !delOverlay ) return;
        pendTarget = target;
        if ( delLblEl ) delLblEl.textContent = target.label;
        delOverlay.setAttribute( 'aria-hidden', 'false' );
        delOverlay.classList.add( 'radm-modal-open' );
    }

    function closeDelModal() {
        if ( !delOverlay ) return;
        delOverlay.classList.remove( 'radm-modal-open' );
        delOverlay.setAttribute( 'aria-hidden', 'true' );
        pendTarget = null;
    }

    document.addEventListener( 'click', function ( e ) {
        if ( e.target.closest( '#radm-delete-cancel-btn, #radm-delete-modal-close' ) ) closeDelModal();
    } );
    if ( delOverlay ) {
        delOverlay.addEventListener( 'click', function ( e ) {
            if ( e.target === delOverlay ) closeDelModal();
        } );
    }

    /* Delete event trigger */
    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-delete-event-btn' );
        if ( btn ) {
            openDelModal( {
                type:  'event',
                id:    btn.dataset.id,
                label: btn.dataset.label || 'this event',
                row:   btn.closest( '.radm-event-row' )
            } );
        }
    } );

    /* Delete participant trigger */
    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-delete-user-btn' );
        if ( btn ) {
            openDelModal( {
                type:    'participant',
                id:      btn.dataset.rowId,
                eventId: btn.dataset.eventId,
                label:   btn.dataset.label || 'this participant',
                row:     btn.closest( '.radm-user-row' )
            } );
        }
    } );

    if ( delYesBtn ) {
        delYesBtn.addEventListener( 'click', function () {
            if ( !pendTarget ) return;
            var t = pendTarget;
            closeDelModal();

            if ( t.type === 'event' ) {
                ajaxPost( 'radm_delete_event', { event_id: t.id }, function ( res ) {
                    if ( res.success ) {
                        if ( t.row ) {
                            t.row.style.transition = 'opacity .3s';
                            t.row.style.opacity    = '0';
                            setTimeout( function () { if ( t.row ) t.row.remove(); }, 320 );
                        }
                        radmToast( 'Event deleted.', 'success' );
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Delete failed.', 'error' );
                    }
                } );
            } else {
                ajaxPost( 'radm_delete_participant', { reg_id: t.id }, function ( res ) {
                    if ( res.success ) {
                        if ( t.row ) {
                            t.row.classList.add( 'radm-row-deleting' );
                            setTimeout( function () {
                                if ( t.row ) t.row.remove();
                                rebuildSerials();
                            }, 370 );
                        }
                        radmToast( 'Participant removed.', 'success' );
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Delete failed.', 'error' );
                    }
                } );
            }
        } );
    }

    /* ================================================================
       PARTICIPANTS -- Search + serial rebuild
    ================================================================ */

    function rebuildSerials() {
        var rows = document.querySelectorAll( '#radm-users-table .radm-user-row' );
        var n = 1;
        rows.forEach( function ( r ) {
            var c = r.querySelector( '.radm-row-num' );
            if ( c ) c.textContent = n++;
        } );
        var cnt = document.getElementById( 'radm-users-count' );
        if ( cnt ) cnt.textContent = ( n - 1 ) + ' participant' + ( n - 1 !== 1 ? 's' : '' );
    }

    var usersSearch = document.getElementById( 'radm-users-search' );
    if ( usersSearch ) {
        usersSearch.addEventListener( 'input', function () {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll( '#radm-users-table .radm-user-row' ).forEach( function ( row ) {
                var match = !q
                    || row.dataset.name.includes( q )
                    || row.dataset.phone.includes( q )
                    || row.dataset.email.includes( q )
                    || row.dataset.branch.includes( q );
                row.style.display = match ? '' : 'none';
            } );
        } );
    }

    /* ================================================================
       ADD / EDIT PARTICIPANT MODAL
    ================================================================ */

    var pModal     = document.getElementById( 'radm-user-modal-overlay' );
    var pTitle     = document.getElementById( 'radm-modal-title' );
    var pRowId     = document.getElementById( 'radm-modal-row-id' );
    var pEventId   = document.getElementById( 'radm-modal-event-id' );
    var pName      = document.getElementById( 'radm-modal-name' );
    var pPhone     = document.getElementById( 'radm-modal-phone' );
    var pEmail     = document.getElementById( 'radm-modal-email' );
    var pBranch    = document.getElementById( 'radm-modal-branch' );
    var pSaveBtn   = document.getElementById( 'radm-modal-save-btn' );
    var pCancelBtn = document.getElementById( 'radm-modal-cancel-btn' );
    var pCloseBtn  = document.getElementById( 'radm-modal-close-btn' );

    function openParticipantModal( opts ) {
        if ( !pModal ) return;
        if ( pTitle   ) pTitle.textContent   = opts.mode === 'edit' ? 'Edit Participant' : 'Add Participant';
        if ( pRowId   ) pRowId.value         = opts.rowId   || '';
        if ( pEventId ) pEventId.value       = opts.eventId || '';
        if ( pName    ) pName.value          = opts.name    || '';
        if ( pPhone   ) pPhone.value         = opts.phone   || '';
        if ( pEmail   ) pEmail.value         = opts.email   || '';
        if ( pBranch  ) pBranch.value        = opts.branch  || '';
        pModal.setAttribute( 'aria-hidden', 'false' );
        pModal.classList.add( 'radm-modal-open' );
        if ( pName ) pName.focus();
    }

    function closeParticipantModal() {
        if ( !pModal ) return;
        pModal.classList.remove( 'radm-modal-open' );
        pModal.setAttribute( 'aria-hidden', 'true' );
    }

    if ( pCancelBtn ) pCancelBtn.addEventListener( 'click', closeParticipantModal );
    if ( pCloseBtn  ) pCloseBtn.addEventListener(  'click', closeParticipantModal );
    if ( pModal ) pModal.addEventListener( 'click', function ( e ) {
        if ( e.target === pModal ) closeParticipantModal();
    } );

    /* Add participant button */
    var addUserBtn = document.getElementById( 'radm-add-user-btn' );
    if ( addUserBtn ) {
        addUserBtn.addEventListener( 'click', function () {
            openParticipantModal( { mode: 'add', eventId: this.dataset.eventId || '' } );
        } );
    }

    /* Edit participant click (delegated) */
    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-edit-user-btn' );
        if ( !btn ) return;
        var row = btn.closest( '.radm-user-row' );
        if ( !row ) return;
        openParticipantModal( {
            mode:    'edit',
            rowId:   btn.dataset.rowId,
            eventId: btn.dataset.eventId || '',
            name:    row.dataset.rawName  || '',
            phone:   row.dataset.rawPhone || '',
            email:   row.dataset.rawEmail || '',
            branch:  row.dataset.rawBranch || ''
        } );
    } );

    /* Save participant */
    if ( pSaveBtn ) {
        pSaveBtn.addEventListener( 'click', function () {
            var nm  = pName   ? pName.value.trim()  : '';
            var ph  = pPhone  ? pPhone.value.trim()  : '';
            var em  = pEmail  ? pEmail.value.trim()  : '';
            var br  = pBranch ? pBranch.value         : '';
            var rid = pRowId   ? pRowId.value          : '';
            var eid = pEventId ? pEventId.value        : '';

            if ( !nm || !ph ) { radmToast( 'Name and phone are required.', 'error' ); return; }

            setLoading( pSaveBtn, true );

            if ( rid ) {
                /* Edit mode */
                ajaxPost( 'radm_update_participant', {
                    reg_id: rid, name: nm, phone: ph, email: em, branch: br
                }, function ( res ) {
                    setLoading( pSaveBtn, false );
                    if ( res.success ) {
                        var row = document.querySelector( '.radm-user-row[data-id="' + rid + '"]' );
                        if ( row ) {
                            row.dataset.rawName = nm; row.dataset.name = nm.toLowerCase();
                            row.dataset.rawPhone = ph; row.dataset.phone = ph;
                            row.dataset.rawEmail = em; row.dataset.email = em.toLowerCase();
                            row.dataset.rawBranch = br; row.dataset.branch = br.toLowerCase();
                            var nc = row.querySelector( '.radm-user-name-text' );
                            var pc = row.querySelector( '.radm-cell-phone span' );
                            var ec = row.querySelector( '.radm-cell-email span' );
                            var bc = row.querySelector( '.radm-cell-branch' );
                            var ic = row.querySelector( '.radm-user-initials' );
                            if ( nc ) nc.textContent = nm;
                            if ( pc ) pc.textContent = ph;
                            if ( ec ) ec.textContent = em;
                            if ( bc ) bc.textContent = br;
                            if ( ic ) ic.textContent = getInitials( nm );
                            row.style.transition = 'background .2s';
                            row.style.background = 'var(--radm-green-bg)';
                            setTimeout( function () { if ( row ) row.style.background = ''; }, 900 );
                        }
                        closeParticipantModal();
                        radmToast( 'Participant updated.', 'success' );
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Update failed.', 'error' );
                    }
                } );
            } else {
                /* Add mode */
                ajaxPost( 'radm_add_participant', {
                    event_id: eid, name: nm, phone: ph, email: em, branch: br
                }, function ( res ) {
                    setLoading( pSaveBtn, false );
                    if ( res.success ) {
                        var newId = res.data.id;
                        var ini   = getInitials( nm );
                        var tbody = document.getElementById( 'radm-users-tbody' );
                        var tr    = document.createElement( 'tr' );
                        tr.className = 'radm-user-row';
                        tr.dataset.id       = newId;
                        tr.dataset.name     = nm.toLowerCase();
                        tr.dataset.phone    = ph;
                        tr.dataset.email    = em.toLowerCase();
                        tr.dataset.branch   = br.toLowerCase();
                        tr.dataset.rawName  = nm;
                        tr.dataset.rawPhone = ph;
                        tr.dataset.rawEmail = em;
                        tr.dataset.rawBranch = br;
                        tr.innerHTML = '<td class="radm-row-num" style="color:var(--radm-text-muted);font-weight:600;"></td>'
                            + '<td><div class="radm-user-cell"><div class="radm-user-initials">' + esc( ini ) + '</div>'
                            + '<span class="radm-user-name-text" style="font-weight:500;">' + esc( nm ) + '</span></div></td>'
                            + '<td><a href="tel:' + esc( ph ) + '" class="radm-contact-link radm-phone-link radm-cell-phone">'
                            + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 012.11 4.18 2 2 0 014.09 2H7.1a2 2 0 012 1.72c.13 1 .37 2 .72 2.93a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.15-1.15a2 2 0 012.11-.45c.93.35 1.93.59 2.93.72A2 2 0 0122 16.92z"/></svg>'
                            + '<span>' + esc( ph ) + '</span></a></td>'
                            + '<td><a href="mailto:' + esc( em ) + '" class="radm-contact-link radm-email-link radm-cell-email">'
                            + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>'
                            + '<span>' + esc( em ) + '</span></a></td>'
                            + '<td><span class="radm-branch-badge radm-cell-branch">' + esc( br ) + '</span></td>'
                            + '<td style="text-align:center;"><div class="radm-action-group" style="justify-content:center;">'
                            + '<button type="button" class="radm-icon-btn radm-icon-btn--edit radm-edit-user-btn" title="Edit participant" data-row-id="' + newId + '" data-event-id="' + esc( eid ) + '">'
                            + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>'
                            + '<button type="button" class="radm-icon-btn radm-icon-btn--delete radm-delete-user-btn" title="Delete participant" data-row-id="' + newId + '" data-event-id="' + esc( eid ) + '" data-label="' + esc( nm ) + '">'
                            + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg></button>'
                            + '</div></td>';
                        if ( tbody ) tbody.appendChild( tr );
                        rebuildSerials();
                        tr.style.opacity = '0'; tr.style.transform = 'translateY(-6px)';
                        requestAnimationFrame( function () {
                            tr.style.transition = 'opacity .3s, transform .3s';
                            tr.style.opacity = '1'; tr.style.transform = 'translateY(0)';
                        } );
                        closeParticipantModal();
                        radmToast( 'Participant added.', 'success' );
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to add participant.', 'error' );
                    }
                } );
            }
        } );
    }

    /* ── Edit Event Modal save ────────────────────────────────────────── */
    var origSaveEdit = document.getElementById( 'radm-edit-event-save' );
    if ( origSaveEdit ) {
        origSaveEdit.addEventListener( 'click', function () {
            var eid   = document.getElementById( 'radm-edit-event-id' ) ? document.getElementById( 'radm-edit-event-id' ).value : '';
            var nm    = document.getElementById( 'radm-edit-event-name' ) ? document.getElementById( 'radm-edit-event-name' ).value.trim() : '';
            var dt    = document.getElementById( 'radm-edit-event-date' ) ? document.getElementById( 'radm-edit-event-date' ).value : '';
            var op    = document.getElementById( 'radm-edit-event-reg-open' ) ? ( document.getElementById( 'radm-edit-event-reg-open' ).checked ? 1 : 0 ) : 1;

            if ( !eid || !nm ) return;

            setLoading( origSaveEdit, true );
            ajaxPost( 'radm_update_event', {
                event_id: eid, event_name: nm, event_date: dt, registration_open: op
            }, function ( res ) {
                setLoading( origSaveEdit, false );
                if ( res.success ) {
                    closeEditEventModal();
                    radmToast( 'Event updated successfully.', 'success' );
                    setTimeout( function () { location.reload(); }, 600 );
                } else {
                    radmToast( ( res.data && res.data.message ) || 'Failed to update event.', 'error' );
                }
            } );
        } );
    }

    /* ═══════════════════════════════════════════════════════════════════
       FORM GROUPS PAGE LOGIC (CRUD + DYNAMIC CENTRES + PREVIEW + ANALYTICS)
       ═══════════════════════════════════════════════════════════════════ */
    var fgModal          = document.getElementById( 'radm-fg-modal-overlay' );
    var fgModalTitle     = document.getElementById( 'radm-fg-modal-title' );
    var fgIdInput        = document.getElementById( 'radm-fg-id' );
    var fgTitleInput     = document.getElementById( 'radm-fg-title' );
    var fgSlugInput      = document.getElementById( 'radm-fg-slug' );
    var fgDescInput      = document.getElementById( 'radm-fg-desc' );
    var fgCentresWrap    = document.getElementById( 'radm-fg-centres-container' );
    var fgAddRowBtn      = document.getElementById( 'radm-fg-add-centre-row-btn' );
    var fgSaveBtn        = document.getElementById( 'radm-fg-save-btn' );
    var fgCancelBtn      = document.getElementById( 'radm-fg-cancel-btn' );
    var fgCloseBtn       = document.getElementById( 'radm-fg-modal-close' );

    // Preview modal
    var fgPrevModal      = document.getElementById( 'radm-fg-preview-overlay' );
    var fgPrevTitle      = document.getElementById( 'radm-fg-preview-title' );
    var fgPrevBody       = document.getElementById( 'radm-fg-preview-body' );
    var fgPrevCloseBtn   = document.getElementById( 'radm-fg-preview-close' );
    var fgPrevCloseBtn2  = document.getElementById( 'radm-fg-preview-close-btn' );

    // Analytics modal
    var fgAnalyticsModal     = document.getElementById( 'radm-fg-analytics-overlay' );
    var fgAnalyticsTitle     = document.getElementById( 'radm-fg-analytics-title' );
    var fgAnalyticsContent   = document.getElementById( 'radm-fg-analytics-content' );
    var fgAnalyticsCloseBtn  = document.getElementById( 'radm-fg-analytics-close' );
    var fgAnalyticsCloseBtn2 = document.getElementById( 'radm-fg-analytics-close-btn' );

    function createCentreRow( name, url, id ) {
        var row = document.createElement( 'div' );
        row.className = 'radm-fg-centre-row';
        row.style.display = 'grid';
        row.style.gridTemplateColumns = '1fr 1.5fr 36px';
        row.style.gap = '8px';
        row.style.alignItems = 'center';
        row.style.background = '#f8fafc';
        row.style.padding = '8px 12px';
        row.style.borderRadius = '8px';
        row.style.border = '1px solid var(--radm-border)';

        row.innerHTML = '<input type="hidden" class="fg-c-id" value="' + esc( id || '' ) + '">'
            + '<input type="text" class="radm-input fg-c-name" placeholder="Centre Name (e.g. Bangalore)" value="' + esc( name || '' ) + '" style="font-size:13px;padding:7px 10px;">'
            + '<input type="url" class="radm-input fg-c-url" placeholder="Google Form URL (docs.google.com/forms/...)" value="' + esc( url || '' ) + '" style="font-size:13px;padding:7px 10px;">'
            + '<button type="button" class="radm-icon-btn radm-icon-btn--delete fg-c-remove-btn" title="Remove centre" style="width:32px;height:32px;">'
            + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
            + '</button>';

        return row;
    }

    function openFgModal( opts ) {
        if ( !fgModal ) return;
        if ( fgModalTitle ) fgModalTitle.textContent = opts.mode === 'edit' ? 'Edit Form Group' : 'Add Form Group';
        if ( fgIdInput    ) fgIdInput.value    = opts.id    || '';
        if ( fgTitleInput ) fgTitleInput.value = opts.title || '';
        if ( fgSlugInput  ) fgSlugInput.value  = opts.slug  || '';
        if ( fgDescInput  ) fgDescInput.value  = opts.desc  || '';

        var mode   = opts.action_mode || 'redirect';
        var layout = opts.ui_layout    || 'cards';
        
        var radioMode   = document.querySelector( 'input[name="radm_fg_action_mode"][value="' + mode + '"]' );
        if ( radioMode ) radioMode.checked = true;

        var radioLayout = document.querySelector( 'input[name="radm_fg_ui_layout"][value="' + layout + '"]' );
        if ( radioLayout ) radioLayout.checked = true;

        if ( fgCentresWrap ) {
            fgCentresWrap.innerHTML = '';
            var centres = opts.centres || [];
            if ( centres.length === 0 ) {
                // Add default empty rows
                fgCentresWrap.appendChild( createCentreRow( 'Bangalore', '' ) );
                fgCentresWrap.appendChild( createCentreRow( 'Mysore', '' ) );
            } else {
                centres.forEach( function ( c ) {
                    fgCentresWrap.appendChild( createCentreRow( c.name, c.url, c.id ) );
                } );
            }
        }

        fgModal.setAttribute( 'aria-hidden', 'false' );
        fgModal.classList.add( 'radm-modal-open' );
        if ( fgTitleInput ) fgTitleInput.focus();
    }

    function closeFgModal() {
        if ( !fgModal ) return;
        fgModal.classList.remove( 'radm-modal-open' );
        fgModal.setAttribute( 'aria-hidden', 'true' );
    }

    var addFgBtn = document.getElementById( 'radm-add-fg-btn' );
    if ( addFgBtn ) {
        addFgBtn.addEventListener( 'click', function () {
            openFgModal( { mode: 'add' } );
        } );
    }

    if ( fgAddRowBtn && fgCentresWrap ) {
        fgAddRowBtn.addEventListener( 'click', function () {
            fgCentresWrap.appendChild( createCentreRow( '', '' ) );
        } );
    }

    /* Delegate centre row remove */
    if ( fgCentresWrap ) {
        fgCentresWrap.addEventListener( 'click', function ( e ) {
            var rmBtn = e.target.closest( '.fg-c-remove-btn' );
            if ( !rmBtn ) return;
            var row = rmBtn.closest( '.radm-fg-centre-row' );
            if ( row ) row.remove();
        } );
    }

    if ( fgCancelBtn ) fgCancelBtn.addEventListener( 'click', closeFgModal );
    if ( fgCloseBtn  ) fgCloseBtn.addEventListener(  'click', closeFgModal );
    if ( fgModal     ) fgModal.addEventListener( 'click', function ( e ) {
        if ( e.target === fgModal ) closeFgModal();
    } );

    /* Save Form Group */
    if ( fgSaveBtn ) {
        fgSaveBtn.addEventListener( 'click', function () {
            var gid   = fgIdInput    ? fgIdInput.value    : '';
            var title = fgTitleInput ? fgTitleInput.value.trim() : '';
            var slug  = fgSlugInput  ? fgSlugInput.value.trim()  : '';
            var desc  = fgDescInput  ? fgDescInput.value.trim()  : '';
            
            var selMode   = document.querySelector( 'input[name="radm_fg_action_mode"]:checked' );
            var selLayout = document.querySelector( 'input[name="radm_fg_ui_layout"]:checked' );
            
            var mode   = selMode   ? selMode.value   : 'redirect';
            var layout = selLayout ? selLayout.value : 'cards';

            if ( !title ) { radmToast( 'Form Group Title is required.', 'error' ); return; }

            var rows    = fgCentresWrap ? fgCentresWrap.querySelectorAll( '.radm-fg-centre-row' ) : [];
            var centres = [];
            rows.forEach( function ( r ) {
                var cId   = r.querySelector( '.fg-c-id' )   ? r.querySelector( '.fg-c-id' ).value   : '';
                var cName = r.querySelector( '.fg-c-name' ) ? r.querySelector( '.fg-c-name' ).value.trim() : '';
                var cUrl  = r.querySelector( '.fg-c-url' )  ? r.querySelector( '.fg-c-url' ).value.trim()  : '';
                if ( cName ) {
                    centres.push( { id: cId, name: cName, url: cUrl } );
                }
            } );

            setLoading( fgSaveBtn, true );
            ajaxPost( 'radm_save_form_group', {
                group_id: gid, title: title, slug: slug, description: desc, action_mode: mode, ui_layout: layout, centres: centres
            }, function ( res ) {
                setLoading( fgSaveBtn, false );
                if ( res.success ) {
                    closeFgModal();
                    radmToast( res.data.message || 'Form Group saved.', 'success' );
                    setTimeout( function () { location.reload(); }, 500 );
                } else {
                    radmToast( ( res.data && res.data.message ) || 'Failed to save Form Group.', 'error' );
                }
            } );
        } );
    }

    /* Edit Form Group click (delegated) */
    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-edit-fg-btn' );
        if ( !btn ) return;
        var tr = btn.closest( '.radm-fg-row' );
        if ( !tr || !tr.dataset.group ) return;
        try {
            var g = JSON.parse( tr.dataset.group );
            openFgModal( {
                mode:        'edit',
                id:          g.id,
                title:       g.title || '',
                slug:        g.slug  || g.id || '',
                desc:        g.description || '',
                action_mode: g.action_mode || 'redirect',
                ui_layout:   g.ui_layout   || 'cards',
                centres:     g.centres || []
            } );
        } catch ( err ) {}
    } );

    /* Delete Form Group click (delegated) */
    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-delete-fg-btn' );
        if ( !btn ) return;
        var gid   = btn.dataset.id;
        var title = btn.dataset.title || 'this group';
        if ( confirm( 'Are you sure you want to delete Form Group "' + title + '"?' ) ) {
            ajaxPost( 'radm_delete_form_group', { group_id: gid }, function ( res ) {
                if ( res.success ) {
                    var tr = btn.closest( '.radm-fg-row' );
                    if ( tr ) {
                        tr.style.transition = 'opacity .3s, transform .3s';
                        tr.style.opacity = '0';
                        tr.style.transform = 'translateX(20px)';
                        setTimeout( function () { tr.remove(); }, 300 );
                    }
                    radmToast( 'Form Group deleted.', 'success' );
                } else {
                    radmToast( ( res.data && res.data.message ) || 'Failed to delete group.', 'error' );
                }
            } );
        }
    } );

    /* Copy Shortcode button */
    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-copy-sc-btn' );
        if ( !btn ) return;
        var code = btn.dataset.code || '';
        if ( code && navigator.clipboard ) {
            navigator.clipboard.writeText( code ).then( function () {
                radmToast( 'Copied to clipboard!', 'success' );
            } );
        }
    } );

    /* Preview Form Group Modal */
    function openFgPreviewModal( group ) {
        if ( !fgPrevModal || !fgPrevBody ) return;
        if ( fgPrevTitle ) fgPrevTitle.textContent = 'Preview — ' + ( group.title || 'Form Group' );

        var centres = group.centres || [];
        var optsHtml = '<option value="">-- Choose your Centre --</option>';
        centres.forEach( function( c ) {
            optsHtml += '<option value="' + esc( c.id || '' ) + '" data-url="' + esc( c.url || '' ) + '">' + esc( c.name || '' ) + '</option>';
        } );

        fgPrevBody.innerHTML = '<div class="ry-fg-container" style="box-shadow:none;border:1px solid #e2e8f0;margin:0;">'
            + '<div class="ry-fg-header" style="background:#1b365d;color:#fff;padding:20px 24px;border-radius:12px 12px 0 0;">'
            + '<h3 style="margin:0 0 4px;font-size:18px;color:#fff;">' + esc( group.title || '' ) + '</h3>'
            + '<p style="margin:0;font-size:13px;opacity:.88;">' + esc( group.description || '' ) + '</p>'
            + '</div>'
            + '<div class="ry-fg-body" style="padding:20px;">'
            + '<div class="ry-fg-select-group" style="margin-bottom:16px;">'
            + '<label class="ry-fg-label" style="display:block;font-weight:600;font-size:13.5px;margin-bottom:6px;">Select Centre:</label>'
            + '<select class="ry-fg-select" id="prev-fg-select" style="width:100%;padding:10px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;">'
            + optsHtml
            + '</select>'
            + '</div>'
            + '<div class="ry-fg-iframe-wrap" id="prev-fg-iframe-wrap" style="display:none;position:relative;width:100%;min-height:500px;border-radius:8px;border:1px solid #e2e8f0;overflow:hidden;background:#f8fafc;">'
            + '<iframe src="" class="ry-fg-iframe" id="prev-fg-iframe" style="width:100%;height:520px;border:none;"></iframe>'
            + '</div>'
            + '<div id="prev-fg-no-form" style="display:none;padding:30px;text-align:center;color:#64748b;background:#f8fafc;border-radius:8px;border:1px dashed #cbd5e1;">'
            + '<p style="margin:0;font-size:13px;">No Google Form link configured for this centre.</p>'
            + '</div>'
            + '</div>'
            + '</div>';

        fgPrevModal.setAttribute( 'aria-hidden', 'false' );
        fgPrevModal.classList.add( 'radm-modal-open' );

        // Attach dynamic select handler
        var pSelect = document.getElementById( 'prev-fg-select' );
        var pWrap   = document.getElementById( 'prev-fg-iframe-wrap' );
        var pFrame  = document.getElementById( 'prev-fg-iframe' );
        var pNoForm = document.getElementById( 'prev-fg-no-form' );

        if ( pSelect ) {
            pSelect.addEventListener( 'change', function () {
                var opt = pSelect.options[pSelect.selectedIndex];
                if ( !opt || !opt.value ) {
                    pWrap.style.display = 'none'; pNoForm.style.display = 'none'; return;
                }
                var url = opt.getAttribute( 'data-url' );
                if ( !url ) {
                    pWrap.style.display = 'none'; pNoForm.style.display = 'block'; return;
                }
                pNoForm.style.display = 'none';
                pWrap.style.display  = 'block';
                var embedUrl = url;
                if ( !embedUrl.includes( 'embedded=true' ) ) {
                    embedUrl += ( embedUrl.includes( '?' ) ? '&' : '?' ) + 'embedded=true';
                }
                pFrame.src = embedUrl;
            } );
        }
    }

    function closeFgPreviewModal() {
        if ( !fgPrevModal ) return;
        fgPrevModal.classList.remove( 'radm-modal-open' );
        fgPrevModal.setAttribute( 'aria-hidden', 'true' );
    }

    if ( fgPrevCloseBtn  ) fgPrevCloseBtn.addEventListener(  'click', closeFgPreviewModal );
    if ( fgPrevCloseBtn2 ) fgPrevCloseBtn2.addEventListener( 'click', closeFgPreviewModal );
    if ( fgPrevModal     ) fgPrevModal.addEventListener( 'click', function ( e ) {
        if ( e.target === fgPrevModal ) closeFgPreviewModal();
    } );

    /* Analytics Breakdown Modal */
    function openFgAnalyticsModal( group ) {
        if ( !fgAnalyticsModal || !fgAnalyticsContent ) return;
        if ( fgAnalyticsTitle ) fgAnalyticsTitle.textContent = 'Click Analytics — ' + ( group.title || 'Form Group' );

        var centres   = group.centres   || [];
        var analytics = group.analytics || {};
        
        var totalClicks = 0;
        centres.forEach( function( c ) {
            totalClicks += parseInt( analytics[c.id] || 0, 10 );
        } );

        if ( centres.length === 0 ) {
            fgAnalyticsContent.innerHTML = '<p style="color:var(--radm-text-muted);text-align:center;padding:20px;">No centres configured for this group.</p>';
        } else {
            var rowsHtml = '';
            centres.forEach( function( c ) {
                var clicks = parseInt( analytics[c.id] || 0, 10 );
                var pct    = totalClicks > 0 ? Math.round( ( clicks / totalClicks ) * 100 ) : 0;
                rowsHtml += '<tr>'
                    + '<td style="font-weight:600;color:var(--radm-text);">' + esc( c.name ) + '</td>'
                    + '<td style="text-align:right;font-weight:700;color:#1b365d;">' + clicks + '</td>'
                    + '<td style="width:40%;">'
                    + '<div style="display:flex;align-items:center;gap:8px;">'
                    + '<div style="flex:1;background:#e2e8f0;height:8px;border-radius:4px;overflow:hidden;">'
                    + '<div style="background:#2E7D32;height:100%;width:' + pct + '%;"></div>'
                    + '</div>'
                    + '<span style="font-size:12px;color:var(--radm-text-muted);width:32px;text-align:right;">' + pct + '%</span>'
                    + '</div>'
                    + '</td>'
                    + '</tr>';
            } );

            fgAnalyticsContent.innerHTML = '<div style="margin-bottom:14px;display:flex;justify-content:space-between;align-items:center;background:#f8fafc;padding:12px 16px;border-radius:8px;border:1px solid #e2e8f0;">'
                + '<span style="color:var(--radm-text-muted);font-size:13px;">Total User Selections</span>'
                + '<strong style="font-size:18px;color:#2E7D32;">' + totalClicks + ' Clicks</strong>'
                + '</div>'
                + '<table class="radm-table" style="margin:0;">'
                + '<thead><tr><th>Centre Name</th><th style="text-align:right;">Clicks</th><th>Share</th></tr></thead>'
                + '<tbody>' + rowsHtml + '</tbody>'
                + '</table>';
        }

        fgAnalyticsModal.setAttribute( 'aria-hidden', 'false' );
        fgAnalyticsModal.classList.add( 'radm-modal-open' );
    }

    function closeFgAnalyticsModal() {
        if ( !fgAnalyticsModal ) return;
        fgAnalyticsModal.classList.remove( 'radm-modal-open' );
        fgAnalyticsModal.setAttribute( 'aria-hidden', 'true' );
    }

    if ( fgAnalyticsCloseBtn  ) fgAnalyticsCloseBtn.addEventListener(  'click', closeFgAnalyticsModal );
    if ( fgAnalyticsCloseBtn2 ) fgAnalyticsCloseBtn2.addEventListener( 'click', closeFgAnalyticsModal );
    if ( fgAnalyticsModal     ) fgAnalyticsModal.addEventListener( 'click', function ( e ) {
        if ( e.target === fgAnalyticsModal ) closeFgAnalyticsModal();
    } );

    /* Analytics button click (delegated) */
    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-fg-analytics-btn' );
        if ( !btn ) return;
        var tr = btn.closest( '.radm-fg-row' );
        if ( !tr || !tr.dataset.group ) return;
        try {
            var g = JSON.parse( tr.dataset.group );
            openFgAnalyticsModal( g );
        } catch ( err ) {}
    } );

    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-preview-fg-btn' );
        if ( !btn ) return;
        var tr = btn.closest( '.radm-fg-row' );
        if ( !tr || !tr.dataset.group ) return;
        try {
            var g = JSON.parse( tr.dataset.group );
            openFgPreviewModal( g );
        } catch ( err ) {}
    } );

    /* Filter/Search Form Groups */
    var fgSearch = document.getElementById( 'radm-fg-search' );
    if ( fgSearch ) {
        fgSearch.addEventListener( 'input', function () {
            var q = this.value.toLowerCase().trim();
            var rows = document.querySelectorAll( '.radm-fg-row' );
            rows.forEach( function ( row ) {
                var txt = ( row.textContent || '' ).toLowerCase();
                row.style.display = txt.includes( q ) ? '' : 'none';
            } );
        } );
    }

    /* ── ESC closes any modal ─────────────────────────────────────────── */
    document.addEventListener( 'keydown', function ( e ) {
        if ( e.key === 'Escape' ) {
            closeParticipantModal();
            closeDelModal();
            closeEditEventModal();
            closeFgModal();
            closeFgPreviewModal();
            closeFgAnalyticsModal();
        }
    } );

} )();



