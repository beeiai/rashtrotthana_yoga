/**
 * Rashtrotthana Admin Portal -- admin-portal.js
 * All dummy data removed. Everything calls real WordPress AJAX endpoints.
 */

( function () {
    'use strict';

    var cfg     = window.RADMConfig || {};
    var ajaxUrl = cfg.ajaxUrl || window.ajaxurl || '/wp-admin/admin-ajax.php';
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

    function getEditEventElements() {
        return {
            overlay:     document.getElementById( 'radm-edit-event-overlay' ),
            idInput:     document.getElementById( 'radm-edit-event-id' ),
            nameInput:   document.getElementById( 'radm-edit-event-name' ),
            dateInput:   document.getElementById( 'radm-edit-event-date' ),
            regInput:    document.getElementById( 'radm-edit-event-reg-open' ),
            regLbl:      document.getElementById( 'radm-edit-reg-label' ),
            saveBtn:     document.getElementById( 'radm-edit-event-save' ),
            useGfInput:  document.getElementById( 'radm-edit-use-google-form' ),
            gfUrlInput:  document.getElementById( 'radm-edit-google-form-url' )
        };
    }

    function openEditEventModal( btn ) {
        var els = getEditEventElements();
        if ( !els.overlay ) return;
        if ( els.idInput )   els.idInput.value   = btn.dataset.id     || '';
        if ( els.nameInput ) els.nameInput.value = btn.dataset.name   || '';
        if ( els.dateInput ) els.dateInput.value = btn.dataset.date   || '';
        var open = btn.dataset.status === 'open';
        if ( els.regInput )  els.regInput.checked = open;
        if ( els.useGfInput ) els.useGfInput.checked = btn.dataset.useGoogleForm === '1';
        if ( els.gfUrlInput ) els.gfUrlInput.value   = btn.dataset.googleFormUrl || '';
        if ( els.regLbl )    els.regLbl.textContent = open ? 'Registrations are open' : 'Registrations are closed';
        els.overlay.setAttribute( 'aria-hidden', 'false' );
        els.overlay.classList.add( 'radm-modal-open' );
        if ( els.nameInput ) els.nameInput.focus();
    }

    function closeEditEventModal() {
        var els = getEditEventElements();
        if ( !els.overlay ) return;
        els.overlay.classList.remove( 'radm-modal-open' );
        els.overlay.setAttribute( 'aria-hidden', 'true' );
    }

    document.addEventListener( 'click', function ( e ) {
        var btn = e.target.closest( '.radm-edit-event-btn' );
        if ( btn ) openEditEventModal( btn );
        var close = e.target.closest( '#radm-edit-event-close, #radm-edit-event-cancel' );
        if ( close ) closeEditEventModal();

        var overlay = document.getElementById( 'radm-edit-event-overlay' );
        if ( overlay && e.target === overlay ) closeEditEventModal();
    } );

    document.addEventListener( 'click', function ( e ) {
        var saveBtn = e.target.closest( '#radm-edit-event-save' );
        if ( !saveBtn ) return;
        var els = getEditEventElements();
        var evId  = els.idInput && els.idInput.value;
        var evNm  = els.nameInput && els.nameInput.value.trim();
        var evDt  = els.dateInput && els.dateInput.value;
        var regOp = els.regInput  && els.regInput.checked ? '1' : '0';
        if ( !evNm ) { radmToast( 'Event name is required.', 'error' ); return; }
        setLoading( saveBtn, true );
        ajaxPost( 'radm_update_event', {
            event_id: evId, event_name: evNm, event_date: evDt, registration_open: regOp, use_google_form: (els.useGfInput && els.useGfInput.checked ? 1 : 0), google_form_url: (els.gfUrlInput ? els.gfUrlInput.value : '')
        }, function ( res ) {
            setLoading( saveBtn, false );
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

    /* ================================================================
       DELETE CONFIRM MODAL (events + participants)
    ================================================================ */

    var pendTarget = null;

    function getDelModalElements() {
        return {
            overlay: document.getElementById( 'radm-delete-modal-overlay' ),
            labelEl: document.getElementById( 'radm-delete-label' ),
            yesBtn:  document.getElementById( 'radm-delete-confirm-btn' )
        };
    }

    function openDelModal( target ) {
        var els = getDelModalElements();
        if ( !els.overlay ) return;
        pendTarget = target;
        if ( els.labelEl ) els.labelEl.textContent = target.label;
        els.overlay.setAttribute( 'aria-hidden', 'false' );
        els.overlay.classList.add( 'radm-modal-open' );
    }

    function closeDelModal() {
        var els = getDelModalElements();
        if ( !els.overlay ) return;
        els.overlay.classList.remove( 'radm-modal-open' );
        els.overlay.setAttribute( 'aria-hidden', 'true' );
        pendTarget = null;
    }

    document.addEventListener( 'click', function ( e ) {
        if ( e.target.closest( '#radm-delete-cancel-btn, #radm-delete-modal-close' ) ) closeDelModal();
        var overlay = document.getElementById( 'radm-delete-modal-overlay' );
        if ( overlay && e.target === overlay ) closeDelModal();
    } );

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

    document.addEventListener( 'click', function ( e ) {
        var yesBtn = e.target.closest( '#radm-delete-confirm-btn' );
        if ( !yesBtn || !pendTarget ) return;
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

    var usersSearch   = document.getElementById( 'radm-users-search' );
    var branchFilter  = document.getElementById( 'radm-users-branch-filter' );
    var statusFilter  = document.getElementById( 'radm-users-status-filter' );

    window.filterParticipants = function() {
        var q = ( usersSearch ? usersSearch.value : '' ).trim().toLowerCase();
        var b = ( branchFilter ? branchFilter.value : '' ).trim().toLowerCase();
        var s = ( statusFilter ? statusFilter.value : '' ).trim().toLowerCase();

        var visibleCount = 0;
        document.querySelectorAll( '#radm-users-table .radm-user-row' ).forEach( function ( row ) {
            var matchQ = !q
                || ( row.dataset.name && row.dataset.name.includes( q ) )
                || ( row.dataset.phone && row.dataset.phone.includes( q ) )
                || ( row.dataset.email && row.dataset.email.includes( q ) )
                || ( row.dataset.branch && row.dataset.branch.includes( q ) );
            var matchB = !b || ( row.dataset.branch && row.dataset.branch.toLowerCase().includes( b ) );
            var matchS = !s || ( row.dataset.status && row.dataset.status.toLowerCase() === s );

            var show = matchQ && matchB && matchS;
            row.style.display = show ? '' : 'none';
            if ( show ) visibleCount++;
        } );

        var cnt = document.getElementById( 'radm-users-count' );
        if ( cnt ) cnt.textContent = visibleCount + ' participant' + ( visibleCount !== 1 ? 's' : '' );
    };

    if ( usersSearch )  usersSearch.addEventListener( 'input', window.filterParticipants );
    if ( branchFilter ) branchFilter.addEventListener( 'change', window.filterParticipants );
    if ( statusFilter ) statusFilter.addEventListener( 'change', window.filterParticipants );

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
    /* ═══════════════════════════════════════════════════════════════════
       FORM GROUPS SYSTEM (MULTI-STEP CREATION, CENTER LINKS, ACTIONS)
       ═══════════════════════════════════════════════════════════════════ */
    if ( curPage === 'radm-form-groups' || document.getElementById( 'radm-fg-tbody' ) || document.getElementById( 'radm-fg-create-btn' ) ) {
        var fgPage     = 1;
        var fgPerPage  = 10;
        var fgSearch   = '';
        var fgStatus   = '';

        var fgTbody       = document.getElementById( 'radm-fg-tbody' );
        var fgFooter      = document.getElementById( 'radm-fg-footer' );
        var fgStartEl     = document.getElementById( 'radm-fg-start' );
        var fgEndEl       = document.getElementById( 'radm-fg-end' );
        var fgTotalEl     = document.getElementById( 'radm-fg-total' );
        var fgPagination  = document.getElementById( 'radm-fg-pagination' );

        var fgSearchInput = document.getElementById( 'radm-fg-search-input' );
        var fgStatusFilter= document.getElementById( 'radm-fg-status-filter' );
        var fgCreateBtn   = document.getElementById( 'radm-fg-create-btn' );

        // Multi-step Wizard Modal Elements
        var wizardOverlay = document.getElementById( 'radm-fg-wizard-overlay' );
        var wizardClose   = document.getElementById( 'radm-fg-wizard-close' );
        var modalHeading  = document.getElementById( 'radm-fg-modal-heading' );
        var fgIdInput     = document.getElementById( 'radm-fg-input-id' );
        var fgNameInput   = document.getElementById( 'radm-fg-input-name' );
        var fgStatusInput = document.getElementById( 'radm-fg-input-status' );
        var fgStatusLabel = document.getElementById( 'radm-fg-status-label' );
        var fgDescInput   = document.getElementById( 'radm-fg-input-desc' );
        var fgCharCount   = document.getElementById( 'radm-fg-char-count' );

        var stepNav1      = document.getElementById( 'radm-step-nav-1' );
        var stepNav2      = document.getElementById( 'radm-step-nav-2' );
        var stepNav3      = document.getElementById( 'radm-step-nav-3' );

        var stepPanel1    = document.getElementById( 'radm-step-panel-1' );
        var stepPanel2    = document.getElementById( 'radm-step-panel-2' );
        var stepPanel3    = document.getElementById( 'radm-step-panel-3' );

        var step1NextBtn  = document.getElementById( 'radm-step1-next-btn' );
        var step2BackBtn  = document.getElementById( 'radm-step2-back-btn' );
        var step2NextBtn  = document.getElementById( 'radm-step2-next-btn' );
        var step3BackBtn  = document.getElementById( 'radm-step3-back-btn' );
        var saveSubmitBtn = document.getElementById( 'radm-fg-save-submit-btn' );
        var saveSubmitText= document.getElementById( 'radm-fg-save-submit-text' );

        var centersTbody  = document.getElementById( 'radm-fg-centers-tbody' );
        var addCenterBtn  = document.getElementById( 'radm-fg-add-center-row-btn' );

        // Review elements
        var revName       = document.getElementById( 'radm-rev-name' );
        var revStatus     = document.getElementById( 'radm-rev-status' );
        var revDesc       = document.getElementById( 'radm-rev-desc' );
        var revTotal      = document.getElementById( 'radm-rev-total-centers' );
        var revList       = document.getElementById( 'radm-rev-centers-list' );

        // View Modal Elements
        var viewOverlay   = document.getElementById( 'radm-fg-view-overlay' );
        var viewTitle     = document.getElementById( 'radm-fg-view-title' );
        var viewDesc      = document.getElementById( 'radm-fg-view-desc' );
        var viewShortcode = document.getElementById( 'radm-fg-view-shortcode' );
        var viewCenterCnt = document.getElementById( 'radm-fg-view-center-count' );
        var viewCenterList= document.getElementById( 'radm-fg-view-centers-list' );
        var viewCopyBtn   = document.getElementById( 'radm-fg-copy-shortcode-btn' );
        var viewEditBtn   = document.getElementById( 'radm-fg-view-edit-btn' );
        var viewClose     = document.getElementById( 'radm-fg-view-close' );
        var viewCloseBtn  = document.getElementById( 'radm-fg-view-close-btn' );
        var currentViewingId = null;

        // Delete Modal Elements
        var delOverlay    = document.getElementById( 'radm-fg-delete-overlay' );
        var delName       = document.getElementById( 'radm-fg-delete-name' );
        var delClose      = document.getElementById( 'radm-fg-delete-close' );
        var delCancelBtn  = document.getElementById( 'radm-fg-delete-cancel-btn' );
        var delConfirmBtn = document.getElementById( 'radm-fg-delete-confirm-btn' );
        var pendingDelId  = null;

        var currentStep   = 1;

        // ── Load Form Groups List ───────────────────────────────────────
        function loadFormGroups() {
            if ( !fgTbody ) return;
            fgTbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--radm-text-muted);"><div class="radm-spinner" style="margin:0 auto 10px;"></div>Loading form groups...</td></tr>';

            ajaxPost( 'radm_get_form_groups', {
                search:   fgSearch,
                status:   fgStatus,
                page:     fgPage,
                per_page: fgPerPage
            }, function ( res ) {
                if ( !res.success ) {
                    fgTbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:30px;color:#ef4444;">Failed to load form groups.</td></tr>';
                    return;
                }

                var d = res.data;
                if ( !d.items || d.items.length === 0 ) {
                    fgTbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:50px 20px;color:var(--radm-text-muted);">'
                        + '<p style="font-size:15px;font-weight:600;margin:0 0 6px;color:var(--radm-text);">No Form Groups Found</p>'
                        + '<p style="font-size:13px;margin:0 0 16px;">Configure center-wise Google Form links to manage event registrations easily.</p>'
                        + '<button type="button" class="radm-btn radm-btn-primary" onclick="window.radmOpenCreateFormGroupModal();">+ Create Form Group</button>'
                        + '</td></tr>';
                    if ( fgFooter ) fgFooter.style.display = 'none';
                    return;
                }

                var html = '';
                d.items.forEach( function ( item, idx ) {
                    var rowNum = ( ( d.page - 1 ) * d.per_page ) + idx + 1;
                    var isActive = item.status === 'active';
                    var statusDotClass = isActive ? 'published' : 'draft';
                    var statusLabel = isActive ? 'Active' : 'Inactive';

                    // Center tags
                    var tagsHtml = '';
                    var cNames = item.center_names || [];
                    var maxTags = 3;
                    var visibleTags = cNames.slice( 0, maxTags );
                    visibleTags.forEach( function ( name ) {
                        tagsHtml += '<span class="radm-center-tag">' + esc( name ) + '</span>';
                    } );
                    if ( cNames.length > maxTags ) {
                        tagsHtml += '<span class="radm-center-tag-more">+' + ( cNames.length - maxTags ) + '</span>';
                    }
                    if ( !cNames.length ) {
                        tagsHtml = '<span style="color:var(--radm-text-muted);font-size:12px;">No centers</span>';
                    }

                    html += '<tr data-id="' + item.id + '" data-group=\'' + esc( JSON.stringify( item ) ) + '\'>'
                        + '<td style="text-align:center;color:var(--radm-text-muted);font-weight:500;">' + rowNum + '</td>'
                        + '<td class="radm-fg-name-cell">'
                        + '<strong>' + esc( item.name ) + '</strong>'
                        + ( item.description ? '<small>' + esc( item.description ) + '</small>' : '' )
                        + '</td>'
                        + '<td><div class="radm-center-tags-wrap">' + tagsHtml + '</div></td>'
                        + '<td style="text-align:center;font-weight:600;">' + item.total_centers + '</td>'
                        + '<td>'
                        + '<div class="radm-status-pill ' + statusDotClass + '" data-action="toggle-fg-status" title="Click to toggle status">'
                        + '<span class="dot"></span><span class="label-text">' + statusLabel + '</span>'
                        + '</div>'
                        + '</td>'
                        + '<td style="color:var(--radm-text-muted);font-size:13px;">' + esc( item.created_fmt ) + '</td>'
                        + '<td style="text-align:right;">'
                        + '<div class="radm-action-btn-group">'
                        + '<button type="button" class="radm-action-btn" data-action="view-fg">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>'
                        + ' View</button>'
                        + '<div class="radm-card-actions-wrap">'
                        + '<button type="button" class="radm-card-more-btn" title="More Actions">•••</button>'
                        + '<div class="radm-card-dropdown">'
                        + '<button type="button" class="radm-card-menu-item" data-action="edit-fg">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>'
                        + ' Edit</button>'
                        + '<button type="button" class="radm-card-menu-item" data-action="copy-fg-link">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>'
                        + ' Copy Direct Link</button>'
                        + '<button type="button" class="radm-card-menu-item radm-card-menu-item--delete" data-action="delete-fg">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>'
                        + ' Delete</button>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</td>'
                        + '</tr>';
                } );

                fgTbody.innerHTML = html;

                // Footer Pagination
                if ( fgFooter ) {
                    fgFooter.style.display = 'flex';
                    var startIdx = ( ( d.page - 1 ) * d.per_page ) + 1;
                    var endIdx   = Math.min( d.page * d.per_page, d.total );
                    if ( fgStartEl ) fgStartEl.textContent = startIdx;
                    if ( fgEndEl   ) fgEndEl.textContent   = endIdx;
                    if ( fgTotalEl ) fgTotalEl.textContent = d.total;

                    if ( fgPagination ) {
                        var pBtns = '';
                        pBtns += '<button type="button" class="radm-pg-btn" data-page="' + ( d.page - 1 ) + '" ' + ( d.page <= 1 ? 'disabled' : '' ) + '>&lt;</button>';
                        for ( var p = 1; p <= d.total_pages; p++ ) {
                            pBtns += '<button type="button" class="radm-pg-btn ' + ( p === d.page ? 'is-active' : '' ) + '" data-page="' + p + '">' + p + '</button>';
                        }
                        pBtns += '<button type="button" class="radm-pg-btn" data-page="' + ( d.page + 1 ) + '" ' + ( d.page >= d.total_pages ? 'disabled' : '' ) + '>&gt;</button>';
                        fgPagination.innerHTML = pBtns;
                    }
                }
            } );
        }

        // Initialize load
        loadFormGroups();

        // ── Search with debounce ────────────────────────────────────────
        var fgSearchTimer = null;
        if ( fgSearchInput ) {
            fgSearchInput.addEventListener( 'input', function () {
                var q = this.value.trim();
                clearTimeout( fgSearchTimer );
                fgSearchTimer = setTimeout( function () {
                    fgSearch = q;
                    fgPage   = 1;
                    loadFormGroups();
                }, 280 );
            } );
        }

        // ── Status Filter ───────────────────────────────────────────────
        if ( fgStatusFilter ) {
            fgStatusFilter.addEventListener( 'change', function () {
                fgStatus = this.value;
                fgPage   = 1;
                loadFormGroups();
            } );
        }

        // ── Pagination Click ────────────────────────────────────────────
        if ( fgPagination ) {
            fgPagination.addEventListener( 'click', function ( e ) {
                var btn = e.target.closest( '.radm-pg-btn' );
                if ( !btn || btn.disabled ) return;
                var p = parseInt( btn.dataset.page, 10 );
                if ( p && p !== fgPage ) {
                    fgPage = p;
                    loadFormGroups();
                }
            } );
        }

        // ── Wizard Step Navigation ──────────────────────────────────────
        function goToStep( stepNum ) {
            currentStep = stepNum;

            // Nav Indicators
            [ stepNav1, stepNav2, stepNav3 ].forEach( function ( item, idx ) {
                if ( !item ) return;
                var s = idx + 1;
                item.classList.remove( 'is-active', 'is-completed' );
                if ( s === stepNum ) {
                    item.classList.add( 'is-active' );
                } else if ( s < stepNum ) {
                    item.classList.add( 'is-completed' );
                }
            } );

            // Panels
            if ( stepPanel1 ) stepPanel1.style.display = ( stepNum === 1 ) ? 'block' : 'none';
            if ( stepPanel2 ) stepPanel2.style.display = ( stepNum === 2 ) ? 'block' : 'none';
            if ( stepPanel3 ) stepPanel3.style.display = ( stepNum === 3 ) ? 'block' : 'none';

            if ( stepNum === 3 ) {
                populateReview();
            }
        }

        if ( stepNav1 ) stepNav1.addEventListener( 'click', function () { goToStep( 1 ); } );
        if ( stepNav2 ) stepNav2.addEventListener( 'click', function () {
            if ( validateStep1() ) goToStep( 2 );
        } );
        if ( stepNav3 ) stepNav3.addEventListener( 'click', function () {
            if ( validateStep1() && validateStep2() ) goToStep( 3 );
        } );

        function validateStep1() {
            var name = fgNameInput ? fgNameInput.value.trim() : '';
            if ( !name ) {
                radmToast( 'Please enter a Form Group Name.', 'error' );
                if ( fgNameInput ) fgNameInput.focus();
                return false;
            }
            return true;
        }

        function validateStep2() {
            var rows = getCenterRowsData();
            if ( !rows.length ) {
                radmToast( 'Please add at least one center with a Google Form link.', 'error' );
                return false;
            }
            for ( var i = 0; i < rows.length; i++ ) {
                if ( !rows[i].center_name ) {
                    radmToast( 'Center Name is required for row #' + ( i + 1 ), 'error' );
                    return false;
                }
                if ( !rows[i].form_url || ( !rows[i].form_url.startsWith( 'http://' ) && !rows[i].form_url.startsWith( 'https://' ) ) ) {
                    radmToast( 'Please enter a valid URL (https://...) for row #' + ( i + 1 ), 'error' );
                    return false;
                }
            }
            return true;
        }

        if ( step1NextBtn ) {
            step1NextBtn.addEventListener( 'click', function () {
                if ( validateStep1() ) {
                    goToStep( 2 );
                }
            } );
        }

        if ( step2BackBtn ) {
            step2BackBtn.addEventListener( 'click', function () {
                goToStep( 1 );
            } );
        }

        if ( step2NextBtn ) {
            step2NextBtn.addEventListener( 'click', function () {
                if ( validateStep2() ) {
                    goToStep( 3 );
                }
            } );
        }

        if ( step3BackBtn ) {
            step3BackBtn.addEventListener( 'click', function () {
                goToStep( 2 );
            } );
        }

        // Status switch label update
        if ( fgStatusInput && fgStatusLabel ) {
            fgStatusInput.addEventListener( 'change', function () {
                if ( this.checked ) {
                    fgStatusLabel.textContent = 'Active';
                    fgStatusLabel.style.color = '#166534';
                } else {
                    fgStatusLabel.textContent = 'Inactive';
                    fgStatusLabel.style.color = '#64748b';
                }
            } );
        }

        // Char counter
        if ( fgDescInput && fgCharCount ) {
            fgDescInput.addEventListener( 'input', function () {
                fgCharCount.textContent = this.value.length + '/200';
            } );
        }

        // ── Dynamic Center Rows Management ──────────────────────────────
        function addCenterRow( name, url ) {
            if ( !centersTbody ) return;
            var tr = document.createElement( 'tr' );
            tr.className = 'radm-center-entry-row';
            tr.innerHTML = '<td class="radm-row-num" style="text-align:center;color:var(--radm-text-muted);font-weight:600;">1</td>'
                + '<td><input type="text" list="radm-fg-centers-datalist" class="radm-input radm-center-name-input" placeholder="Choose or type center..." value="' + esc( name || '' ) + '" required /></td>'
                + '<td><input type="url" class="radm-input radm-center-url-input" placeholder="https://forms.gle/..." value="' + esc( url || '' ) + '" required /></td>'
                + '<td style="text-align:center;"><button type="button" class="radm-btn-trash" title="Remove row"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg></button></td>';
            centersTbody.appendChild( tr );
            reindexCenterRows();
        }

        function reindexCenterRows() {
            if ( !centersTbody ) return;
            var rows = centersTbody.querySelectorAll( '.radm-center-entry-row' );
            rows.forEach( function ( r, idx ) {
                var numCell = r.querySelector( '.radm-row-num' );
                if ( numCell ) numCell.textContent = idx + 1;
            } );
        }

        if ( addCenterBtn ) {
            addCenterBtn.addEventListener( 'click', function () {
                addCenterRow( '', '' );
            } );
        }

        if ( centersTbody ) {
            centersTbody.addEventListener( 'click', function ( e ) {
                var trash = e.target.closest( '.radm-btn-trash' );
                if ( trash ) {
                    var row = trash.closest( 'tr' );
                    if ( row ) {
                        row.remove();
                        reindexCenterRows();
                    }
                }
            } );
        }

        function getCenterRowsData() {
            var data = [];
            if ( !centersTbody ) return data;
            var rows = centersTbody.querySelectorAll( '.radm-center-entry-row' );
            rows.forEach( function ( r ) {
                var nameInput = r.querySelector( '.radm-center-name-input' );
                var urlInput  = r.querySelector( '.radm-center-url-input' );
                var name = nameInput ? nameInput.value.trim() : '';
                var url  = urlInput ? urlInput.value.trim() : '';
                if ( name || url ) {
                    data.push( { center_name: name, form_url: url } );
                }
            } );
            return data;
        }

        function populateReview() {
            if ( revName ) revName.textContent = fgNameInput ? fgNameInput.value.trim() : '-';
            var isAct = fgStatusInput && fgStatusInput.checked;
            if ( revStatus ) {
                revStatus.innerHTML = '<span class="radm-status-pill ' + ( isAct ? 'published' : 'draft' ) + '"><span class="dot"></span>' + ( isAct ? 'Active' : 'Inactive' ) + '</span>';
            }
            if ( revDesc ) revDesc.textContent = ( fgDescInput && fgDescInput.value.trim() ) ? fgDescInput.value.trim() : 'No description provided';

            var centers = getCenterRowsData();
            if ( revTotal ) revTotal.textContent = centers.length;

            if ( revList ) {
                var cHtml = '';
                centers.forEach( function ( c, idx ) {
                    cHtml += '<div class="radm-review-center-item">'
                        + '<span><strong>' + ( idx + 1 ) + '. ' + esc( c.center_name ) + '</strong></span>'
                        + '<span class="radm-review-center-url" title="' + esc( c.form_url ) + '">' + esc( c.form_url ) + '</span>'
                        + '</div>';
                } );
                revList.innerHTML = cHtml || '<p style="color:var(--radm-text-muted);font-size:13px;margin:0;">No centers added.</p>';
            }
        }

        // ── Open / Close Wizard Modal ───────────────────────────────────
        function openFormGroupModal( group ) {
            if ( !wizardOverlay ) return;
            var isEdit = !!( group && group.id );

            if ( modalHeading ) modalHeading.textContent = isEdit ? 'Edit Form Group' : 'Create Form Group';
            if ( saveSubmitText ) saveSubmitText.textContent = isEdit ? 'Update Form Group' : 'Save Form Group';

            if ( fgIdInput ) fgIdInput.value = isEdit ? group.id : '';
            if ( fgNameInput ) fgNameInput.value = isEdit ? ( group.name || '' ) : '';
            if ( fgDescInput ) {
                fgDescInput.value = isEdit ? ( group.description || '' ) : '';
                if ( fgCharCount ) fgCharCount.textContent = fgDescInput.value.length + '/200';
            }

            var isAct = isEdit ? ( group.status === 'active' ) : true;
            if ( fgStatusInput ) fgStatusInput.checked = isAct;
            if ( fgStatusLabel ) {
                fgStatusLabel.textContent = isAct ? 'Active' : 'Inactive';
                fgStatusLabel.style.color = isAct ? '#166534' : '#64748b';
            }

            // Populate Centers
            if ( centersTbody ) {
                centersTbody.innerHTML = '';
                if ( isEdit && group.centers && group.centers.length ) {
                    group.centers.forEach( function ( c ) {
                        addCenterRow( c.center_name, c.form_url );
                    } );
                } else {
                    // Default empty 3 rows for fresh create matching preview
                    addCenterRow( '', '' );
                    addCenterRow( '', '' );
                }
            }

            goToStep( 1 );

            wizardOverlay.setAttribute( 'aria-hidden', 'false' );
            wizardOverlay.classList.add( 'radm-modal-open' );
            if ( fgNameInput ) fgNameInput.focus();
        }

        window.radmOpenCreateFormGroupModal = function () { openFormGroupModal( null ); };

        function closeWizardModal() {
            if ( !wizardOverlay ) return;
            wizardOverlay.classList.remove( 'radm-modal-open' );
            wizardOverlay.setAttribute( 'aria-hidden', 'true' );
        }

        if ( fgCreateBtn ) fgCreateBtn.addEventListener( 'click', function () { openFormGroupModal( null ); } );
        if ( wizardClose ) wizardClose.addEventListener( 'click', closeWizardModal );
        document.querySelectorAll( '.radm-wizard-cancel-btn' ).forEach( function ( b ) {
            b.addEventListener( 'click', closeWizardModal );
        } );

        // ── Save Form Group Form Submission ─────────────────────────────
        if ( saveSubmitBtn ) {
            saveSubmitBtn.addEventListener( 'click', function () {
                if ( !validateStep1() || !validateStep2() ) return;

                var id = fgIdInput ? parseInt( fgIdInput.value, 10 ) : 0;
                var name = fgNameInput.value.trim();
                var desc = fgDescInput.value.trim();
                var status = ( fgStatusInput && fgStatusInput.checked ) ? 'active' : 'inactive';
                var centers = getCenterRowsData();

                setLoading( saveSubmitBtn, true );

                ajaxPost( 'radm_save_form_group', {
                    id:          id,
                    name:        name,
                    description: desc,
                    status:      status,
                    centers:     JSON.stringify( centers )
                }, function ( res ) {
                    setLoading( saveSubmitBtn, false );
                    if ( res.success ) {
                        closeWizardModal();
                        radmToast( res.data.message || 'Form Group saved!', 'success' );
                        loadFormGroups();
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to save form group.', 'error' );
                    }
                } );
            } );
        }

        // ── Actions Delegation (3-Dots Menu, View, Edit, Delete, Toggle Status) ──
        document.addEventListener( 'click', function ( e ) {
            function closeAllDropdowns() {
                document.querySelectorAll( '.radm-card-dropdown.is-open' ).forEach( function ( d ) { d.classList.remove( 'is-open' ); } );
                document.querySelectorAll( '.radm-card-more-btn.is-active' ).forEach( function ( b ) { b.classList.remove( 'is-active' ); } );
            }

            // 3-Dots More Button Toggle
            var moreBtn = e.target.closest( '.radm-card-more-btn' );
            if ( moreBtn ) {
                e.stopPropagation();
                var menu = moreBtn.nextElementSibling;
                var isOpen = menu && menu.classList.contains( 'is-open' );
                closeAllDropdowns();
                if ( menu && !isOpen ) {
                    menu.classList.add( 'is-open' );
                    moreBtn.classList.add( 'is-active' );
                }
                return;
            }

            // Close all dropdowns if clicking outside
            if ( !e.target.closest( '.radm-card-dropdown' ) ) {
                closeAllDropdowns();
            }

            // View Action
            var viewBtn = e.target.closest( '[data-action="view-fg"]' );
            if ( viewBtn ) {
                closeAllDropdowns();
                var row = viewBtn.closest( 'tr' );
                if ( row && row.dataset.group ) {
                    try {
                        var group = JSON.parse( row.dataset.group );
                        openViewModal( group );
                    } catch ( err ) {}
                }
                return;
            }

            // Edit Action (inside 3-dots)
            var editBtn = e.target.closest( '[data-action="edit-fg"]' );
            if ( editBtn ) {
                closeAllDropdowns();
                var eRow = editBtn.closest( 'tr' );
                if ( eRow && eRow.dataset.group ) {
                    try {
                        var gData = JSON.parse( eRow.dataset.group );
                        openFormGroupModal( gData );
                    } catch ( err ) {}
                }
                return;
            }

            // Copy Link Action (inside 3-dots)
            var copyBtn = e.target.closest( '[data-action="copy-fg-link"]' );
            if ( copyBtn ) {
                closeAllDropdowns();
                var cRow = copyBtn.closest( 'tr' );
                if ( cRow && cRow.dataset.id ) {
                    var directUrl = window.location.origin + '/?ry_form_group=' + cRow.dataset.id;
                    navigator.clipboard.writeText( directUrl );
                    radmToast( 'Direct Registration Link copied! (Share on WhatsApp, Posters, Events)', 'success' );
                }
                return;
            }

            // Delete Action (inside 3-dots)
            var delBtn = e.target.closest( '[data-action="delete-fg"]' );
            if ( delBtn ) {
                closeAllDropdowns();
                var dRow = delBtn.closest( 'tr' );
                if ( dRow && dRow.dataset.group ) {
                    try {
                        var delGroup = JSON.parse( dRow.dataset.group );
                        openDeleteModal( delGroup );
                    } catch ( err ) {}
                }
                return;
            }

            // Status Toggle Action
            var statusPill = e.target.closest( '[data-action="toggle-fg-status"]' );
            if ( statusPill ) {
                var sRow = statusPill.closest( 'tr' );
                if ( !sRow ) return;
                var gid = sRow.dataset.id;
                ajaxPost( 'radm_toggle_form_group_status', { id: gid }, function ( res ) {
                    if ( res.success ) {
                        var isAct = res.data.new_status === 'active';
                        statusPill.className = 'radm-status-pill ' + ( isAct ? 'published' : 'draft' );
                        statusPill.querySelector( '.label-text' ).textContent = isAct ? 'Active' : 'Inactive';
                        radmToast( res.data.message || 'Status updated.', 'success' );
                    } else {
                        radmToast( 'Failed to toggle status.', 'error' );
                    }
                } );
                return;
            }
        } );

        // ── View Modal Logic ────────────────────────────────────────────
        var viewDirectLink    = document.getElementById( 'radm-fg-view-directlink' );
        var viewOpenLink      = document.getElementById( 'radm-fg-view-open-link' );
        var viewCopyDirectBtn = document.getElementById( 'radm-fg-copy-directlink-btn' );

        function openViewModal( group ) {
            if ( !viewOverlay ) return;
            currentViewingId = group.id;

            if ( viewTitle ) viewTitle.textContent = group.name || 'Form Group';
            if ( viewDesc ) viewDesc.textContent = group.description || 'No description provided';
            if ( viewShortcode ) viewShortcode.value = '[ry_form_group id="' + group.id + '"]';

            var directUrl = window.location.origin + '/?ry_form_group=' + group.id;
            if ( viewDirectLink ) viewDirectLink.value = directUrl;
            if ( viewOpenLink ) viewOpenLink.href = directUrl;

            var centers = group.centers || [];
            if ( viewCenterCnt ) viewCenterCnt.textContent = centers.length;

            if ( viewCenterList ) {
                var html = '';
                centers.forEach( function ( c, idx ) {
                    html += '<div style="display:flex;justify-content:space-between;align-items:center;padding:10px 14px;border-bottom:1px solid #f1f5f9;font-size:13px;">'
                        + '<span><strong>' + ( idx + 1 ) + '. ' + esc( c.center_name ) + '</strong></span>'
                        + '<a href="' + esc( c.form_url ) + '" target="_blank" style="color:#0284c7;font-size:12px;text-decoration:underline;">Test Link &rarr;</a>'
                        + '</div>';
                } );
                viewCenterList.innerHTML = html || '<div style="padding:14px;color:var(--radm-text-muted);">No centers configured.</div>';
            }

            viewOverlay.setAttribute( 'aria-hidden', 'false' );
            viewOverlay.classList.add( 'radm-modal-open' );
        }

        function closeViewModal() {
            if ( !viewOverlay ) return;
            viewOverlay.classList.remove( 'radm-modal-open' );
            viewOverlay.setAttribute( 'aria-hidden', 'true' );
            currentViewingId = null;
        }

        if ( viewClose ) viewClose.addEventListener( 'click', closeViewModal );
        if ( viewCloseBtn ) viewCloseBtn.addEventListener( 'click', closeViewModal );

        if ( viewCopyDirectBtn && viewDirectLink ) {
            viewCopyDirectBtn.addEventListener( 'click', function () {
                viewDirectLink.select();
                navigator.clipboard.writeText( viewDirectLink.value );
                radmToast( 'Direct Registration Link copied! (Ready for WhatsApp, Posters, Events)', 'success' );
            } );
        }

        if ( viewCopyBtn && viewShortcode ) {
            viewCopyBtn.addEventListener( 'click', function () {
                viewShortcode.select();
                navigator.clipboard.writeText( viewShortcode.value );
                radmToast( 'Shortcode copied to clipboard!', 'success' );
            } );
        }

        if ( viewEditBtn ) {
            viewEditBtn.addEventListener( 'click', function () {
                if ( currentViewingId ) {
                    var row = document.querySelector( 'tr[data-id="' + currentViewingId + '"]' );
                    if ( row && row.dataset.group ) {
                        closeViewModal();
                        try {
                            var gData = JSON.parse( row.dataset.group );
                            openFormGroupModal( gData );
                        } catch ( err ) {}
                    }
                }
            } );
        }

        var viewDelBtn = document.getElementById( 'radm-fg-view-del-btn' );
        if ( viewDelBtn ) {
            viewDelBtn.addEventListener( 'click', function () {
                if ( currentViewingId ) {
                    var row = document.querySelector( 'tr[data-id="' + currentViewingId + '"]' );
                    if ( row && row.dataset.group ) {
                        closeViewModal();
                        try {
                            var gData = JSON.parse( row.dataset.group );
                            openDeleteModal( gData );
                        } catch ( err ) {}
                    }
                }
            } );
        }

        // ── Delete Modal Logic ──────────────────────────────────────────
        function openDeleteModal( group ) {
            if ( !delOverlay ) return;
            pendingDelId = group.id;
            if ( delName ) delName.textContent = '"' + ( group.name || 'this form group' ) + '"';
            delOverlay.setAttribute( 'aria-hidden', 'false' );
            delOverlay.classList.add( 'radm-modal-open' );
        }

        function closeDeleteModal() {
            if ( !delOverlay ) return;
            delOverlay.classList.remove( 'radm-modal-open' );
            delOverlay.setAttribute( 'aria-hidden', 'true' );
            pendingDelId = null;
        }

        if ( delClose ) delClose.addEventListener( 'click', closeDeleteModal );
        if ( delCancelBtn ) delCancelBtn.addEventListener( 'click', closeDeleteModal );

        if ( delConfirmBtn ) {
            delConfirmBtn.addEventListener( 'click', function () {
                if ( !pendingDelId ) return;
                var id = pendingDelId;
                setLoading( delConfirmBtn, true );

                ajaxPost( 'radm_delete_form_group', { id: id }, function ( res ) {
                    setLoading( delConfirmBtn, false );
                    closeDeleteModal();
                    if ( res.success ) {
                        var row = document.querySelector( 'tr[data-id="' + id + '"]' );
                        if ( row ) {
                            row.style.transition = 'opacity 0.25s, transform 0.25s';
                            row.style.opacity = '0';
                            row.style.transform = 'scale(0.95)';
                            setTimeout( function () { loadFormGroups(); }, 260 );
                        } else {
                            loadFormGroups();
                        }
                        radmToast( 'Form Group deleted successfully.', 'success' );
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to delete form group.', 'error' );
                    }
                } );
            } );
        }

    } // end radm-form-groups

    /* ═══════════════════════════════════════════════════════════════════
       GALLERY PAGE LOGIC (IMAGE + VIDEO TABS, 4 FILTERS, RICH MODAL)
       ═══════════════════════════════════════════════════════════════════ */
    if ( curPage === 'radm-gallery' || document.getElementById( 'radm-gallery-grid' ) || document.getElementById( 'radm-upload-media-btn' ) ) {

        var gType     = 'all';
        var gCategory = '';
        var gEventId  = 0;
        var gAlbumId  = 0;
        var gStatus   = '';
        var gSearch   = '';
        var gSort     = 'latest';
        var gPage     = 1;
        var gPerPage  = 8;

        var gridEl        = document.getElementById( 'radm-gallery-grid' );
        var footerEl      = document.getElementById( 'radm-gallery-footer' );
        var pgStartEl     = document.getElementById( 'radm-pg-start' );
        var pgEndEl       = document.getElementById( 'radm-pg-end' );
        var pgTotalEl     = document.getElementById( 'radm-pg-total' );
        var paginationEl  = document.getElementById( 'radm-gallery-pagination' );

        var countAllEl    = document.getElementById( 'radm-gcount-all' );
        var countImageEl  = document.getElementById( 'radm-gcount-image' );
        var countVideoEl  = document.getElementById( 'radm-gcount-video' );

        var searchInput   = document.getElementById( 'radm-gallery-search-input' );
        var catSelect     = document.getElementById( 'radm-filter-category' );
        var albumSelect   = document.getElementById( 'radm-filter-album' );
        var eventSelect   = document.getElementById( 'radm-filter-event' );
        var statusSelect  = document.getElementById( 'radm-filter-status' );
        var sortSelect    = document.getElementById( 'radm-filter-sort' );

        // Modal Elements
        var gModalOverlay = document.getElementById( 'radm-gallery-modal-overlay' );
        var gModalTitle   = document.getElementById( 'radm-gallery-modal-title' );
        var gModalClose   = document.getElementById( 'radm-gallery-modal-close' );
        var gModalCancel  = document.getElementById( 'radm-gallery-modal-cancel' );
        var gForm         = document.getElementById( 'radm-gallery-form' );
        var gSubmitBtn    = document.getElementById( 'radm-gallery-modal-submit' );
        var gSubmitText   = document.getElementById( 'radm-gsubmit-text' );

        var gTypeImgRadio = document.getElementById( 'radm-type-img' );
        var gTypeVidRadio = document.getElementById( 'radm-type-vid' );
        var gSectionImg   = document.getElementById( 'radm-section-image' );
        var gSectionVid   = document.getElementById( 'radm-section-video' );

        var gIdInput      = document.getElementById( 'radm-gmedia-id' );
        var gTitleInput   = document.getElementById( 'radm-gtitle' );
        var gCatInput     = document.getElementById( 'radm-gcategory' );
        var gEventIdInput = document.getElementById( 'radm-gevent-id' );
        var gAlbumIdInput = document.getElementById( 'radm-galbum-id' );
        var gImageUrl     = document.getElementById( 'radm-gimage-url' );
        var gVideoUrl     = document.getElementById( 'radm-gvideo-url' );
        var gVideoDur     = document.getElementById( 'radm-gvideo-dur' );
        var gVideoPost    = document.getElementById( 'radm-gvideo-poster' );
        var gStatusSelect = document.getElementById( 'radm-gstatus' );

        var gPreviewWrap  = document.getElementById( 'radm-gpreview-wrap' );
        var gPreviewImg   = document.getElementById( 'radm-gpreview-img' );
        var gUploadPrompt = document.getElementById( 'radm-gupload-prompt' );
        var gRemovePrevBtn= document.getElementById( 'radm-gremove-preview' );
        var gFileInput    = document.getElementById( 'radm-gfile-input' );
        var gPickMediaBtn = document.getElementById( 'radm-gpick-media-btn' );
        var gBrowseBtn    = document.getElementById( 'radm-gbrowse-btn' );

        // Delete Modal Elements
        var gDelOverlay   = document.getElementById( 'radm-gdelete-modal-overlay' );
        var gDelTitle     = document.getElementById( 'radm-gdelete-title' );
        var gDelConfirmBtn= document.getElementById( 'radm-gdelete-confirm-btn' );
        var gDelCancelBtn = document.getElementById( 'radm-gdelete-cancel-btn' );
        var gDelCloseBtn  = document.getElementById( 'radm-gdelete-modal-close' );
        var pendingDelId  = null;

        // Fetch & Render Gallery Cards
        function loadGallery() {
            if ( !gridEl ) return;
            gridEl.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:50px 20px;color:var(--radm-text-muted);"><div class="radm-spinner" style="margin:0 auto 12px;"></div>Loading media...</div>';

            ajaxPost( 'radm_get_gallery_items', {
                type:      gType,
                category:  gCategory,
                event_id:  gEventId,
                album_id:  gAlbumId,
                status:    gStatus,
                search:    gSearch,
                sort:      gSort,
                page:      gPage,
                per_page:  gPerPage
            }, function ( res ) {
                if ( !res.success ) {
                    gridEl.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:40px;color:#ef4444;">Failed to load gallery items.</div>';
                    return;
                }

                var d = res.data;

                // Update tab counters
                if ( d.counts ) {
                    if ( countAllEl )   countAllEl.textContent   = d.counts.all   || 0;
                    if ( countImageEl ) countImageEl.textContent = d.counts.image || 0;
                    if ( countVideoEl ) countVideoEl.textContent = d.counts.video || 0;
                }
                var curBadge = document.getElementById( 'radm-badge-curated-count' );
                if ( curBadge ) curBadge.textContent = ( d.counts && d.counts.all != null ) ? d.counts.all : d.total;

                if ( !d.items || d.items.length === 0 ) {
                    gridEl.innerHTML = '<div style="grid-column:1/-1;background:#ffffff;border:1px dashed var(--radm-border);border-radius:12px;text-align:center;padding:60px 20px;">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="48" height="48" style="color:#94a3b8;margin-bottom:12px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>'
                        + '<h3 style="font-size:16px;color:var(--radm-text);margin:0 0 6px;">No media found</h3>'
                        + '<p style="font-size:13px;color:var(--radm-text-muted);margin:0 0 16px;">Upload new photos or videos to display them on your website gallery.</p>'
                        + '<button type="button" class="radm-btn radm-btn-primary" onclick="if(window.radmOpenGalleryModal){window.radmOpenGalleryModal(null);}">+ Upload Media</button>'
                        + '</div>';
                    if ( footerEl ) footerEl.style.display = 'none';
                    return;
                }

                // Render Cards cleanly matching screenshot
                var html = '';
                d.items.forEach( function ( item ) {
                    var isPub = item.status === 'publish';
                    var statusClass = isPub ? 'published' : 'draft';
                    var statusLabel = isPub ? 'Published' : 'Draft';
                    var isVid = item.type === 'video';

                    var typeBadge = isVid
                        ? '<span class="radm-card-type-badge video"><svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg> Video</span>'
                        : '<span class="radm-card-type-badge">Image</span>';

                    var durationBadge = ( isVid && item.video_duration )
                        ? '<span class="radm-card-duration-badge">' + esc( item.video_duration ) + '</span>'
                        : '';

                    var subTagText = item.sub_tag || ( item.category ? 'Category: ' + item.category : 'Category: General' );

                    html += '<div class="radm-gallery-card" data-id="' + item.id + '" data-item=\'' + esc( JSON.stringify( item ) ) + '\'>'
                        + '<div class="radm-card-thumb-wrap">'
                        + '<img class="radm-card-thumb" src="' + esc( item.image_url ) + '" alt="' + esc( item.title ) + '" loading="lazy" onerror="this.style.opacity=\'0.5\';">'
                        + typeBadge
                        + durationBadge
                        + '</div>'
                        + '<div class="radm-card-content">'
                        + '<h3 class="radm-card-title" title="' + esc( item.title ) + '">' + esc( item.title ) + '</h3>'
                        + '<div class="radm-card-date">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>'
                        + '<span>' + esc( item.date_fmt ) + '</span>'
                        + '</div>'
                        + '<div class="radm-card-subtag">' + esc( subTagText ) + '</div>'
                        + '<div class="radm-card-footer">'
                        + '<div class="radm-status-pill ' + statusClass + '" data-action="toggle-status" title="Click to toggle status">'
                        + '<span class="dot"></span>'
                        + '<span class="label-text">' + statusLabel + '</span>'
                        + '</div>'
                        + '<div class="radm-card-actions-wrap">'
                        + '<button type="button" class="radm-card-more-btn" title="Actions">•••</button>'
                        + '<div class="radm-card-dropdown">'
                        + '<button type="button" class="radm-card-menu-item" data-action="edit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Edit</button>'
                        + '<button type="button" class="radm-card-menu-item" data-action="toggle-status"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Change Status</button>'
                        + '<a href="' + esc( ajaxUrl.replace( 'admin-ajax.php', '' ) + '../gallery/' ) + '" target="_blank" class="radm-card-menu-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg> View on Website</a>'
                        + '<button type="button" class="radm-card-menu-item radm-card-menu-item--delete" data-action="delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg> Delete</button>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>';
                } );

                gridEl.innerHTML = html;

                // Update Footer Pagination
                if ( footerEl ) {
                    footerEl.style.display = 'flex';
                    var startIdx = ( ( d.page - 1 ) * d.per_page ) + 1;
                    var endIdx   = Math.min( d.page * d.per_page, d.total );
                    if ( pgStartEl ) pgStartEl.textContent = startIdx;
                    if ( pgEndEl   ) pgEndEl.textContent   = endIdx;
                    if ( pgTotalEl ) pgTotalEl.textContent = d.total;

                    // Build page buttons
                    if ( paginationEl ) {
                        var pBtns = '';
                        pBtns += '<button type="button" class="radm-pg-btn" data-page="' + ( d.page - 1 ) + '" ' + ( d.page <= 1 ? 'disabled' : '' ) + '>&lt;</button>';
                        for ( var p = 1; p <= d.total_pages; p++ ) {
                            pBtns += '<button type="button" class="radm-pg-btn ' + ( p === d.page ? 'is-active' : '' ) + '" data-page="' + p + '">' + p + '</button>';
                        }
                        pBtns += '<button type="button" class="radm-pg-btn" data-page="' + ( d.page + 1 ) + '" ' + ( d.page >= d.total_pages ? 'disabled' : '' ) + '>&gt;</button>';
                        paginationEl.innerHTML = pBtns;
                    }
                }
            } );
        }

        // Initialize first load
        loadGallery();

        // ── Type Tabs Click (All, Images, Videos) ───────────────────────
        var typeTabs = document.querySelectorAll( '.radm-gallery-tab' );
        typeTabs.forEach( function ( tab ) {
            tab.addEventListener( 'click', function () {
                typeTabs.forEach( function ( t ) { t.classList.remove( 'is-active' ); } );
                this.classList.add( 'is-active' );
                gType = this.dataset.type || 'all';
                gPage = 1;
                loadGallery();
            } );
        } );

        // ── Search with debounce ────────────────────────────────────────
        var searchTimer = null;
        if ( searchInput ) {
            searchInput.addEventListener( 'input', function () {
                var val = this.value.trim();
                clearTimeout( searchTimer );
                searchTimer = setTimeout( function () {
                    gSearch = val;
                    gPage   = 1;
                    loadGallery();
                }, 280 );
            } );
        }

        // ── Secondary 4 Filters ─────────────────────────────────────────
        if ( catSelect ) {
            catSelect.addEventListener( 'change', function () {
                gCategory = this.value;
                gPage     = 1;
                loadGallery();
            } );
        }
        if ( albumSelect ) {
            albumSelect.addEventListener( 'change', function () {
                gAlbumId = parseInt( this.value, 10 ) || 0;
                gPage    = 1;
                loadGallery();
            } );
        }
        if ( eventSelect ) {
            eventSelect.addEventListener( 'change', function () {
                gEventId = parseInt( this.value, 10 ) || 0;
                gPage    = 1;
                loadGallery();
            } );
        }
        if ( statusSelect ) {
            statusSelect.addEventListener( 'change', function () {
                gStatus = this.value;
                gPage   = 1;
                loadGallery();
            } );
        }
        if ( sortSelect ) {
            sortSelect.addEventListener( 'change', function () {
                gSort = this.value;
                gPage = 1;
                loadGallery();
            } );
        }

        // ── Pagination Click ────────────────────────────────────────────
        if ( paginationEl ) {
            paginationEl.addEventListener( 'click', function ( e ) {
                var btn = e.target.closest( '.radm-pg-btn' );
                if ( !btn || btn.disabled ) return;
                var p = parseInt( btn.dataset.page, 10 );
                if ( p && p !== gPage ) {
                    gPage = p;
                    loadGallery();
                    window.scrollTo( { top: 0, behavior: 'smooth' } );
                }
            } );
        }

        // ── Modal Type Toggle (Image vs Video) ──────────────────────────
        function updateModalMediaType( type ) {
            if ( type === 'video' ) {
                if ( gTypeVidRadio ) gTypeVidRadio.checked = true;
                if ( gSectionImg ) gSectionImg.style.display = 'none';
                if ( gSectionVid ) gSectionVid.style.display = 'block';
            } else {
                if ( gTypeImgRadio ) gTypeImgRadio.checked = true;
                if ( gSectionImg ) gSectionImg.style.display = 'block';
                if ( gSectionVid ) gSectionVid.style.display = 'none';
            }
        }

        if ( gTypeImgRadio ) gTypeImgRadio.addEventListener( 'change', function () { updateModalMediaType( 'image' ); } );
        if ( gTypeVidRadio ) gTypeVidRadio.addEventListener( 'change', function () { updateModalMediaType( 'video' ); } );

        // ── Dropdown & Actions Delegation ───────────────────────────────
        document.addEventListener( 'click', function ( e ) {
            var moreBtn = e.target.closest( '.radm-card-more-btn' );
            if ( moreBtn ) {
                e.stopPropagation();
                var menu = moreBtn.nextElementSibling;
                var isOpen = menu.classList.contains( 'is-open' );
                document.querySelectorAll( '.radm-card-dropdown.is-open' ).forEach( function ( d ) { d.classList.remove( 'is-open' ); } );
                document.querySelectorAll( '.radm-card-more-btn.is-active' ).forEach( function ( b ) { b.classList.remove( 'is-active' ); } );
                if ( !isOpen ) {
                    menu.classList.add( 'is-open' );
                    moreBtn.classList.add( 'is-active' );
                }
                return;
            }

            // Close all dropdowns if clicking outside
            if ( !e.target.closest( '.radm-card-dropdown' ) ) {
                document.querySelectorAll( '.radm-card-dropdown.is-open' ).forEach( function ( d ) { d.classList.remove( 'is-open' ); } );
                document.querySelectorAll( '.radm-card-more-btn.is-active' ).forEach( function ( b ) { b.classList.remove( 'is-active' ); } );
            }

            // Status Toggle action
            var statusBtn = e.target.closest( '[data-action="toggle-status"]' );
            if ( statusBtn ) {
                var card = statusBtn.closest( '.radm-gallery-card' );
                if ( !card ) return;
                var id = card.dataset.id;
                ajaxPost( 'radm_toggle_gallery_status', { media_id: id }, function ( res ) {
                    if ( res.success ) {
                        var isPub = res.data.new_status === 'publish';
                        var pill = card.querySelector( '.radm-status-pill' );
                        if ( pill ) {
                            pill.className = 'radm-status-pill ' + ( isPub ? 'published' : 'draft' );
                            pill.querySelector( '.label-text' ).textContent = isPub ? 'Published' : 'Draft';
                        }
                        radmToast( res.data.message || 'Status updated.', 'success' );
                    } else {
                        radmToast( 'Failed to update status.', 'error' );
                    }
                } );
                return;
            }

            // Edit Action
            var editBtn = e.target.closest( '[data-action="edit"]' );
            if ( editBtn ) {
                var editCard = editBtn.closest( '.radm-gallery-card' );
                if ( !editCard || !editCard.dataset.item ) return;
                try {
                    var itm = JSON.parse( editCard.dataset.item );
                    openGalleryModal( itm );
                } catch ( err ) {}
                return;
            }

            // Delete Action
            var delBtn = e.target.closest( '[data-action="delete"]' );
            if ( delBtn ) {
                var delCard = delBtn.closest( '.radm-gallery-card' );
                if ( !delCard ) return;
                try {
                    var itemData = JSON.parse( delCard.dataset.item );
                    openGalleryDeleteModal( itemData );
                } catch ( err ) {}
                return;
            }
        } );

        // ── Preview Image Helper ────────────────────────────────────────
        function setPreviewImage( src ) {
            if ( !gPreviewImg || !gPreviewWrap || !gUploadPrompt ) return;
            if ( src ) {
                gPreviewImg.src = src;
                gPreviewWrap.style.display = 'block';
                gUploadPrompt.style.display = 'none';
            } else {
                gPreviewImg.src = '';
                gPreviewWrap.style.display = 'none';
                gUploadPrompt.style.display = 'block';
            }
        }

        if ( gRemovePrevBtn ) {
            gRemovePrevBtn.addEventListener( 'click', function ( e ) {
                e.stopPropagation();
                setPreviewImage( '' );
                if ( gImageUrl ) gImageUrl.value = '';
                if ( gFileInput ) gFileInput.value = '';
            } );
        }

        // Browse Device Button Trigger
        var gBrowseBtn = document.getElementById( 'radm-gbrowse-btn' );
        if ( gBrowseBtn && gFileInput ) {
            gBrowseBtn.addEventListener( 'click', function ( e ) {
                e.preventDefault();
                e.stopPropagation();
                gFileInput.click();
            } );
        }

        // File Input Change
        if ( gFileInput ) {
            gFileInput.addEventListener( 'change', function () {
                var file = this.files && this.files[0];
                if ( file ) {
                    if ( gTitleInput && ! gTitleInput.value.trim() ) {
                        var fileName = file.name.replace( /\.[^/.]+$/, '' );
                        gTitleInput.value = fileName.replace( /[-_]+/g, ' ' );
                    }
                    var reader = new FileReader();
                    reader.onload = function ( ev ) {
                        setPreviewImage( ev.target.result );
                    };
                    reader.readAsDataURL( file );
                }
            } );
        }

        // Drag and drop onto uploader box
        var gUploaderBox = document.getElementById( 'radm-guploader-box' );
        if ( gUploaderBox && gFileInput ) {
            gUploaderBox.addEventListener( 'dragover', function ( e ) {
                e.preventDefault();
                e.stopPropagation();
                gUploaderBox.style.borderColor = 'var(--radm-green-primary, #2E7D32)';
                gUploaderBox.style.background = '#f0fdf4';
            } );
            gUploaderBox.addEventListener( 'dragleave', function ( e ) {
                e.preventDefault();
                e.stopPropagation();
                gUploaderBox.style.borderColor = '';
                gUploaderBox.style.background = '';
            } );
            gUploaderBox.addEventListener( 'drop', function ( e ) {
                e.preventDefault();
                e.stopPropagation();
                gUploaderBox.style.borderColor = '';
                gUploaderBox.style.background = '';
                if ( e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0 ) {
                    var file = e.dataTransfer.files[0];
                    if ( file.type.indexOf( 'image/' ) === 0 ) {
                        gFileInput.files = e.dataTransfer.files;
                        if ( gTitleInput && ! gTitleInput.value.trim() ) {
                            var fName = file.name.replace( /\.[^/.]+$/, '' );
                            gTitleInput.value = fName.replace( /[-_]+/g, ' ' );
                        }
                        var reader = new FileReader();
                        reader.onload = function ( ev ) {
                            setPreviewImage( ev.target.result );
                        };
                        reader.readAsDataURL( file );
                    } else {
                        radmToast( 'Please select a valid image file.', 'error' );
                    }
                }
            } );
        }

        if ( gImageUrl ) {
            gImageUrl.addEventListener( 'input', function () {
                var val = this.value.trim();
                if ( val.startsWith( 'http://' ) || val.startsWith( 'https://' ) ) {
                    setPreviewImage( val );
                }
            } );
        }

        // WP Media Library Picker
        if ( gPickMediaBtn ) {
            gPickMediaBtn.addEventListener( 'click', function ( e ) {
                e.preventDefault();
                e.stopPropagation();
                window.radmOpenDbMediaPicker(
                    'radm-gimage-url',
                    null,
                    'radm-gpreview-wrap',
                    null,
                    function ( attachment ) {
                        if ( attachment && attachment.url ) {
                            if ( gImageUrl ) gImageUrl.value = attachment.url;
                            if ( gFileInput ) gFileInput.value = '';
                            if ( gTitleInput && ! gTitleInput.value.trim() ) {
                                gTitleInput.value = attachment.title || attachment.caption || attachment.filename || '';
                            }
                            setPreviewImage( attachment.url );
                        }
                    }
                );
            } );
        }

        function openGalleryModal( item ) {
            if ( !gModalOverlay ) return;
            var isEdit = !!( item && item.id );

            if ( gModalTitle ) gModalTitle.textContent = isEdit ? 'Edit Media' : 'Upload Media';
            if ( gSubmitText ) gSubmitText.textContent = isEdit ? 'Update Media' : 'Upload Media';

            if ( gIdInput ) gIdInput.value = isEdit ? item.id : '';
            if ( gTitleInput ) gTitleInput.value = isEdit ? ( item.title || '' ) : '';
            if ( gCatInput ) gCatInput.value = ( isEdit && item.category ) ? item.category : 'General';
            if ( gEventIdInput ) gEventIdInput.value = ( isEdit && item.event_id ) ? item.event_id : '0';
            if ( gAlbumIdInput ) gAlbumIdInput.value = ( isEdit && item.album_id ) ? item.album_id : '0';
            var inlineAlbumWrap = document.getElementById( 'radm-inline-album-wrap' );
            if ( inlineAlbumWrap ) inlineAlbumWrap.style.display = 'none';
            var newAlbumInput = document.getElementById( 'radm-new-album-title' );
            if ( newAlbumInput ) newAlbumInput.value = '';

            // Multi-select albums setup
            var checkedAids = [];
            if ( isEdit ) {
                if ( item.album_ids && item.album_ids.length ) {
                    checkedAids = item.album_ids.map( String );
                } else if ( item.album_id ) {
                    checkedAids = [ String( item.album_id ) ];
                }
            }
            document.querySelectorAll( '.radm-galbum-cb' ).forEach( function ( cb ) {
                cb.checked = checkedAids.indexOf( String( cb.value ) ) !== -1;
            } );
            updateGalbumSelection();

            // Multi-select centers setup
            var checkedCids = [];
            if ( isEdit && item.center_ids && item.center_ids.length ) {
                checkedCids = item.center_ids.map( String );
            }
            document.querySelectorAll( '.radm-gcenter-cb' ).forEach( function ( cb ) {
                cb.checked = checkedCids.indexOf( String( cb.value ) ) !== -1;
            } );
            updateGcenterSelection();

            if ( gImageUrl ) gImageUrl.value = ( isEdit && item.image_url ) ? item.image_url : '';
            if ( gVideoUrl ) gVideoUrl.value = ( isEdit && item.video_url ) ? item.video_url : '';
            if ( gVideoDur ) gVideoDur.value = ( isEdit && item.video_duration ) ? item.video_duration : '';
            if ( gVideoPost ) gVideoPost.value = ( isEdit && item.video_poster ) ? item.video_poster : '';
            if ( gStatusSelect ) gStatusSelect.value = ( isEdit && item.status ) ? item.status : 'publish';
            if ( gFileInput ) gFileInput.value = '';

            var mType = ( isEdit && item.type ) ? item.type : 'image';
            updateModalMediaType( mType );

            setPreviewImage( isEdit && item.image_url ? item.image_url : '' );

            gModalOverlay.setAttribute( 'aria-hidden', 'false' );
            gModalOverlay.classList.add( 'radm-modal-open' );
            if ( gTitleInput ) gTitleInput.focus();
        }

        window.radmOpenGalleryModal = openGalleryModal;

        // ── Album Dropdown Multi-Select Handlers ────────────────────────
        var galbumMsBtn      = document.getElementById( 'radm-galbum-ms-btn' );
        var galbumMsDropdown = document.getElementById( 'radm-galbum-ms-dropdown' );
        var galbumSearchBox  = document.getElementById( 'radm-galbum-search-box' );
        var galbumPills      = document.getElementById( 'radm-galbum-pills' );
        var galbumMsLabel    = document.getElementById( 'radm-galbum-ms-label' );

        function toggleGalbumDropdown() {
            if ( galbumMsDropdown ) {
                var isOpen = galbumMsDropdown.style.display === 'block';
                galbumMsDropdown.style.display = isOpen ? 'none' : 'block';
                if ( !isOpen && galbumSearchBox ) {
                    galbumSearchBox.value = '';
                    filterGalbumOptions( '' );
                    galbumSearchBox.focus();
                }
            }
        }
        if ( galbumMsBtn ) galbumMsBtn.addEventListener( 'click', toggleGalbumDropdown );

        function filterGalbumOptions( q ) {
            var query = ( q || '' ).trim().toLowerCase();
            var items = document.querySelectorAll( '#radm-galbum-options-list .radm-ms-item' );
            items.forEach( function ( it ) {
                var t = it.getAttribute( 'data-title' ) || '';
                it.style.display = ( !query || t.indexOf( query ) !== -1 ) ? 'flex' : 'none';
            } );
        }
        if ( galbumSearchBox ) {
            galbumSearchBox.addEventListener( 'input', function () { filterGalbumOptions( this.value ); } );
        }

        function renderGalbumPills( selected ) {
            if ( !galbumPills ) return;
            galbumPills.innerHTML = '';
            if ( !selected || !selected.length ) {
                if ( galbumMsLabel ) galbumMsLabel.textContent = 'Choose Albums…';
                return;
            }
            if ( galbumMsLabel ) galbumMsLabel.textContent = selected.length + ' Album' + ( selected.length > 1 ? 's' : '' ) + ' selected';

            selected.forEach( function ( item ) {
                var pill = document.createElement( 'span' );
                pill.style.cssText = 'display:inline-flex; align-items:center; gap:5px; background:#e8f5e9; color:#1b5e20; padding:3px 9px; border-radius:14px; font-size:12px; font-weight:600; border:1px solid #c8e6c9;';
                pill.innerHTML = '<span>' + esc( item.name ) + '</span><button type="button" style="background:none; border:none; color:#1b5e20; font-size:13px; cursor:pointer; padding:0; line-height:1;" title="Remove">×</button>';
                pill.querySelector( 'button' ).onclick = function () {
                    var cb = document.querySelector( '.radm-galbum-cb[value="' + CSS.escape( item.id ) + '"]' );
                    if ( cb ) { cb.checked = false; }
                    updateGalbumSelection();
                };
                galbumPills.appendChild( pill );
            } );
        }

        function updateGalbumSelection() {
            var cbs = document.querySelectorAll( '.radm-galbum-cb:checked' );
            var selected = [];
            cbs.forEach( function ( cb ) {
                selected.push( { id: cb.value, name: cb.getAttribute( 'data-name' ) || cb.parentElement.textContent.trim() } );
            } );
            renderGalbumPills( selected );
            if ( gAlbumIdInput && selected.length ) {
                gAlbumIdInput.value = selected[0].id;
            } else if ( gAlbumIdInput ) {
                gAlbumIdInput.value = '0';
            }
        }

        document.querySelectorAll( '.radm-galbum-cb' ).forEach( function ( cb ) {
            cb.addEventListener( 'change', updateGalbumSelection );
        } );

        // ── Center Dropdown Multi-Select Handlers in Gallery Modal ──────
        var gcenterMsBtn      = document.getElementById( 'radm-gcenter-ms-btn' );
        var gcenterMsDropdown = document.getElementById( 'radm-gcenter-ms-dropdown' );
        var gcenterPills      = document.getElementById( 'radm-gcenter-pills' );
        var gcenterMsLabel    = document.getElementById( 'radm-gcenter-ms-label' );

        function toggleGcenterDropdown() {
            if ( gcenterMsDropdown ) {
                var isOpen = gcenterMsDropdown.style.display === 'block';
                gcenterMsDropdown.style.display = isOpen ? 'none' : 'block';
            }
        }
        if ( gcenterMsBtn ) gcenterMsBtn.addEventListener( 'click', toggleGcenterDropdown );

        function renderGcenterPills( selected ) {
            if ( !gcenterPills ) return;
            gcenterPills.innerHTML = '';
            if ( !selected || !selected.length ) {
                if ( gcenterMsLabel ) gcenterMsLabel.textContent = 'Choose Centers…';
                return;
            }
            if ( gcenterMsLabel ) gcenterMsLabel.textContent = selected.length + ' Center' + ( selected.length > 1 ? 's' : '' ) + ' tagged';

            selected.forEach( function ( item ) {
                var pill = document.createElement( 'span' );
                pill.style.cssText = 'display:inline-flex; align-items:center; gap:5px; background:#e0f2fe; color:#0369a1; padding:3px 9px; border-radius:14px; font-size:12px; font-weight:600; border:1px solid #bae6fd;';
                pill.innerHTML = '<span>' + esc( item.name ) + '</span><button type="button" style="background:none; border:none; color:#0369a1; font-size:13px; cursor:pointer; padding:0; line-height:1;" title="Remove">×</button>';
                pill.querySelector( 'button' ).onclick = function () {
                    var cb = document.querySelector( '.radm-gcenter-cb[value="' + CSS.escape( item.id ) + '"]' );
                    if ( cb ) { cb.checked = false; }
                    updateGcenterSelection();
                };
                gcenterPills.appendChild( pill );
            } );
        }

        function updateGcenterSelection() {
            var cbs = document.querySelectorAll( '.radm-gcenter-cb:checked' );
            var selected = [];
            cbs.forEach( function ( cb ) {
                selected.push( { id: cb.value, name: cb.getAttribute( 'data-name' ) || cb.parentElement.textContent.trim() } );
            } );
            renderGcenterPills( selected );
        }

        document.querySelectorAll( '.radm-gcenter-cb' ).forEach( function ( cb ) {
            cb.addEventListener( 'change', updateGcenterSelection );
        } );

        // Close gallery multiselect dropdowns when clicking outside
        document.addEventListener( 'click', function ( e ) {
            var aWrap = document.getElementById( 'radm-galbum-ms-wrap' );
            if ( aWrap && !aWrap.contains( e.target ) && galbumMsDropdown ) {
                galbumMsDropdown.style.display = 'none';
            }
            var cWrap = document.getElementById( 'radm-gcenter-ms-wrap' );
            if ( cWrap && !cWrap.contains( e.target ) && gcenterMsDropdown ) {
                gcenterMsDropdown.style.display = 'none';
            }
        } );

        // Inline Album Create wiring
        var createAlbumBtn = document.getElementById( 'radm-create-album-btn' );
        var inlineAlbumWrap = document.getElementById( 'radm-inline-album-wrap' );
        var cancelAlbumBtn = document.getElementById( 'radm-cancel-album-btn' );
        var saveAlbumBtn = document.getElementById( 'radm-save-album-btn' );
        var newAlbumInput = document.getElementById( 'radm-new-album-title' );

        if ( createAlbumBtn && inlineAlbumWrap ) {
            createAlbumBtn.addEventListener( 'click', function( e ) {
                e.preventDefault();
                inlineAlbumWrap.style.display = inlineAlbumWrap.style.display === 'none' ? 'block' : 'none';
                if ( newAlbumInput && inlineAlbumWrap.style.display === 'block' ) {
                    newAlbumInput.focus();
                }
            } );
        }
        if ( cancelAlbumBtn && inlineAlbumWrap ) {
            cancelAlbumBtn.addEventListener( 'click', function( e ) {
                e.preventDefault();
                inlineAlbumWrap.style.display = 'none';
                if ( newAlbumInput ) newAlbumInput.value = '';
            } );
        }
        if ( saveAlbumBtn && newAlbumInput ) {
            saveAlbumBtn.addEventListener( 'click', function( e ) {
                e.preventDefault();
                var albumTitle = newAlbumInput.value.trim();
                if ( !albumTitle ) {
                    radmToast( 'Please enter an album name.', 'error' );
                    return;
                }
                saveAlbumBtn.disabled = true;
                saveAlbumBtn.textContent = 'Saving…';
                ajaxPost( 'radm_create_gallery_album', {
                    title: albumTitle,
                    category: gCatInput ? gCatInput.value : 'General'
                }, function( res ) {
                    saveAlbumBtn.disabled = false;
                    saveAlbumBtn.textContent = 'Save Album';
                    if ( res.success && res.data.album_id ) {
                        // Add checkbox to list, check it and update
                        var optList = document.getElementById( 'radm-galbum-options-list' );
                        if ( optList ) {
                            var lbl = document.createElement( 'label' );
                            lbl.className = 'radm-ms-item';
                            lbl.style.cssText = 'display:flex; align-items:center; gap:8px; padding:6px 8px; border-radius:6px; cursor:pointer; font-size:13px;';
                            lbl.setAttribute( 'data-title', albumTitle.toLowerCase() );
                            lbl.innerHTML = '<input type="checkbox" name="album_ids[]" value="' + res.data.album_id + '" class="radm-galbum-cb" data-name="' + esc( res.data.title ) + '" checked /><span>' + esc( res.data.title ) + '</span>';
                            lbl.querySelector( 'input' ).addEventListener( 'change', updateGalbumSelection );
                            optList.appendChild( lbl );
                        }
                        updateGalbumSelection();

                        inlineAlbumWrap.style.display = 'none';
                        newAlbumInput.value = '';
                        radmToast( 'Album created and selected!', 'success' );
                    } else {
                        radmToast( res.data && res.data.message ? res.data.message : 'Error creating album.', 'error' );
                    }
                } );
            } );
        }

        function closeGalleryModal() {
            if ( !gModalOverlay ) return;
            gModalOverlay.classList.remove( 'radm-modal-open' );
            gModalOverlay.setAttribute( 'aria-hidden', 'true' );
        }

        // Delegated / Direct Upload Button click
        var openUploadBtn = document.getElementById( 'radm-upload-media-btn' );
        if ( openUploadBtn ) {
            openUploadBtn.addEventListener( 'click', function ( e ) {
                e.preventDefault();
                openGalleryModal( null );
            } );
        }

        document.addEventListener( 'click', function ( e ) {
            var upBtn = e.target.closest( '#radm-upload-media-btn, .radm-open-upload-btn' );
            if ( upBtn ) {
                e.preventDefault();
                openGalleryModal( null );
            }
        } );

        if ( gModalClose  ) gModalClose.addEventListener( 'click', closeGalleryModal );
        if ( gModalCancel ) gModalCancel.addEventListener( 'click', closeGalleryModal );
        if ( gModalOverlay ) {
            gModalOverlay.addEventListener( 'click', function ( e ) {
                if ( e.target === gModalOverlay ) closeGalleryModal();
            } );
        }

        // Form Submit
        if ( gForm ) {
            gForm.addEventListener( 'submit', function ( e ) {
                e.preventDefault();
                var title = gTitleInput ? gTitleInput.value.trim() : '';
                if ( !title ) {
                    radmToast( 'Please enter a name for the media.', 'error' );
                    return;
                }

                setLoading( gSubmitBtn, true );

                var fd = new FormData( gForm );
                fd.set( 'action', 'radm_save_gallery_item' );
                fd.set( 'nonce', nonce );

                fetch( ajaxUrl, { method: 'POST', body: fd } )
                    .then( function ( r ) { return r.json(); } )
                    .then( function ( res ) {
                        setLoading( gSubmitBtn, false );
                        if ( res.success ) {
                            closeGalleryModal();
                            radmToast( res.data.message || 'Media saved successfully!', 'success' );
                            loadGallery();
                        } else {
                            radmToast( ( res.data && res.data.message ) || 'Failed to save media.', 'error' );
                        }
                    } )
                    .catch( function () {
                        setLoading( gSubmitBtn, false );
                        radmToast( 'Network error. Please try again.', 'error' );
                    } );
            } );
        }

        // ── Delete Modal Handling ───────────────────────────────────────
        function openGalleryDeleteModal( item ) {
            if ( !gDelOverlay ) return;
            pendingDelId = item.id;
            if ( gDelTitle ) gDelTitle.textContent = '"' + ( item.title || 'this item' ) + '"';
            gDelOverlay.setAttribute( 'aria-hidden', 'false' );
            gDelOverlay.classList.add( 'radm-modal-open' );
        }

        function closeGalleryDeleteModal() {
            if ( !gDelOverlay ) return;
            gDelOverlay.classList.remove( 'radm-modal-open' );
            gDelOverlay.setAttribute( 'aria-hidden', 'true' );
            pendingDelId = null;
        }

        if ( gDelCancelBtn ) gDelCancelBtn.addEventListener( 'click', closeGalleryDeleteModal );
        if ( gDelCloseBtn  ) gDelCloseBtn.addEventListener( 'click', closeGalleryDeleteModal );
        if ( gDelOverlay ) {
            gDelOverlay.addEventListener( 'click', function ( e ) {
                if ( e.target === gDelOverlay ) closeGalleryDeleteModal();
            } );
        }

        if ( gDelConfirmBtn ) {
            gDelConfirmBtn.addEventListener( 'click', function () {
                if ( !pendingDelId ) return;
                var id = pendingDelId;
                setLoading( gDelConfirmBtn, true );
                ajaxPost( 'radm_delete_gallery_item', { media_id: id }, function ( res ) {
                    setLoading( gDelConfirmBtn, false );
                    closeGalleryDeleteModal();
                    if ( res.success ) {
                        var card = document.querySelector( '.radm-gallery-card[data-id="' + id + '"]' );
                        if ( card ) {
                            card.style.transition = 'opacity 0.25s, transform 0.25s';
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.92)';
                            setTimeout( function () {
                                loadGallery();
                            }, 280 );
                        } else {
                            loadGallery();
                        }
                        radmToast( 'Media deleted successfully.', 'success' );
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to delete media.', 'error' );
                    }
                } );
            } );
        }

        // ═══════════════════════════════════════════════════════════════════
        // DUAL-TAB SWITCHER & "ALL MEDIA FILES" (WORDPRESS MEDIA FOLDER)
        // ═══════════════════════════════════════════════════════════════════
        window.radmSwitchGalleryMainTab = function( tabKey ) {
            var curatedView   = document.getElementById( 'radm-gallery-curated-view' );
            var allMediaView  = document.getElementById( 'radm-gallery-all-media-view' );
            var curatedTabBtn = document.getElementById( 'radm-main-tab-curated' );
            var allMediaTabBtn= document.getElementById( 'radm-main-tab-all-media' );

            if ( tabKey === 'all-media' ) {
                if ( curatedView ) curatedView.style.display = 'none';
                if ( allMediaView ) allMediaView.style.display = 'block';
                if ( curatedTabBtn ) curatedTabBtn.classList.remove( 'is-active' );
                if ( allMediaTabBtn ) allMediaTabBtn.classList.add( 'is-active' );
                loadAllMediaFiles();
            } else {
                if ( curatedView ) curatedView.style.display = 'block';
                if ( allMediaView ) allMediaView.style.display = 'none';
                if ( curatedTabBtn ) curatedTabBtn.classList.add( 'is-active' );
                if ( allMediaTabBtn ) allMediaTabBtn.classList.remove( 'is-active' );
                loadGallery();
            }
        };

        var allMediaGrid       = document.getElementById( 'radm-allmedia-grid' );
        var allMediaFooter     = document.getElementById( 'radm-allmedia-footer' );
        var allMediaPgStart    = document.getElementById( 'radm-allmedia-pg-start' );
        var allMediaPgEnd      = document.getElementById( 'radm-allmedia-pg-end' );
        var allMediaPgTotal    = document.getElementById( 'radm-allmedia-pg-total' );
        var allMediaPagination = document.getElementById( 'radm-allmedia-pagination' );
        var allMediaSearch     = document.getElementById( 'radm-allmedia-search-input' );

        var amMime  = 'all';
        var amQuery = '';
        var amPage  = 1;
        var amPerPg = 24;
        var pendingAllMediaDelId = null;

        function loadAllMediaFiles() {
            if ( !allMediaGrid ) return;
            allMediaGrid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--radm-text-muted);"><div class="radm-spinner" style="margin:0 auto 12px;"></div>Loading media files from WordPress storage...</div>';

            ajaxPost( 'radm_get_db_images', {
                search:    amQuery,
                mime_type: amMime,
                page:      amPage,
                per_page:  amPerPg
            }, function( res ) {
                if ( !res.success || !res.data ) {
                    allMediaGrid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:40px;color:#ef4444;">Failed to load media files.</div>';
                    return;
                }
                var d = res.data;
                var mediaBadge = document.getElementById( 'radm-badge-media-count' );
                if ( mediaBadge ) mediaBadge.textContent = d.total || 0;

                if ( !d.items || !d.items.length ) {
                    allMediaGrid.innerHTML = '<div style="grid-column:1/-1;background:#ffffff;border:1px dashed var(--radm-border);border-radius:12px;text-align:center;padding:60px 20px;">'
                        + '<h3 style="font-size:16px;color:var(--radm-text);margin:0 0 6px;">No media files found</h3>'
                        + '<p style="font-size:13px;color:var(--radm-text-muted);margin:0 0 16px;">Upload images or documents to your WordPress storage using the button above.</p>'
                        + '</div>';
                    if ( allMediaFooter ) allMediaFooter.style.display = 'none';
                    return;
                }

                var html = '';
                d.items.forEach( function( item ) {
                    var thumbHtml = item.is_image
                        ? '<img class="radm-allmedia-thumb" src="' + esc( item.thumb || item.url ) + '" alt="' + esc( item.title ) + '" loading="lazy" />'
                        : '<div class="radm-allmedia-doc-icon"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg><span style="font-size:11px; font-weight:600;">' + esc( ( item.mime && item.mime.split('/')[1] ) ? item.mime.split('/')[1].toUpperCase() : 'DOC' ) + '</span></div>';

                    html += '<div class="radm-allmedia-card" data-id="' + item.id + '" data-item=\'' + esc( JSON.stringify( item ) ) + '\'>'
                        + '<div class="radm-allmedia-thumb-box" onclick="radmOpenMediaPreviewModal(' + item.id + ')" style="cursor:pointer;" title="Click to view details">'
                        + thumbHtml
                        + '</div>'
                        + '<div class="radm-allmedia-info">'
                        + '<div class="radm-allmedia-title" title="' + esc( item.filename ) + '">' + esc( item.title || item.filename ) + '</div>'
                        + '<div class="radm-allmedia-meta">'
                        + '<span>' + esc( item.dimensions || item.filesize || '' ) + '</span>'
                        + '<span>' + esc( item.date ) + '</span>'
                        + '</div>'
                        + '</div>'
                        + '<div class="radm-allmedia-actions">'
                        + '<button type="button" class="radm-allmedia-btn radm-allmedia-btn--copy" onclick="radmCopyMediaUrl(\'' + esc( item.url ) + '\')" title="Copy Direct URL">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy URL'
                        + '</button>'
                        + '<button type="button" class="radm-allmedia-btn" onclick="radmOpenMediaPreviewModal(' + item.id + ')" title="Preview">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg> View'
                        + '</button>'
                        + '<button type="button" class="radm-allmedia-btn radm-allmedia-btn--delete" onclick="radmPromptDeleteAllMedia(' + item.id + ', \'' + esc( addslashes( item.filename ) ) + '\')" title="Delete File">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>'
                        + '</button>'
                        + '</div>'
                        + '</div>';
                } );

                allMediaGrid.innerHTML = html;

                if ( allMediaFooter ) {
                    allMediaFooter.style.display = 'flex';
                    var startIdx = ( ( d.page - 1 ) * d.per_page ) + 1;
                    var endIdx   = Math.min( d.page * d.per_page, d.total );
                    if ( allMediaPgStart ) allMediaPgStart.textContent = startIdx;
                    if ( allMediaPgEnd )   allMediaPgEnd.textContent   = endIdx;
                    if ( allMediaPgTotal ) allMediaPgTotal.textContent = d.total;

                    if ( allMediaPagination ) {
                        var pBtns = '';
                        pBtns += '<button type="button" class="radm-pg-btn" data-ampage="' + ( d.page - 1 ) + '" ' + ( d.page <= 1 ? 'disabled' : '' ) + '>&lt;</button>';
                        for ( var p = 1; p <= d.total_pages; p++ ) {
                            pBtns += '<button type="button" class="radm-pg-btn ' + ( p === d.page ? 'is-active' : '' ) + '" data-ampage="' + p + '">' + p + '</button>';
                        }
                        pBtns += '<button type="button" class="radm-pg-btn" data-ampage="' + ( d.page + 1 ) + '" ' + ( d.page >= d.total_pages ? 'disabled' : '' ) + '>&gt;</button>';
                        allMediaPagination.innerHTML = pBtns;
                    }
                }
            } );
        }

        window.radmFilterAllMediaMime = function( mime ) {
            amMime = mime;
            amPage = 1;
            document.querySelectorAll( '#radm-allmedia-mime-tabs .radm-gallery-tab' ).forEach( function( t ) {
                t.classList.toggle( 'is-active', t.getAttribute( 'data-mime' ) === mime );
            } );
            loadAllMediaFiles();
        };

        if ( allMediaSearch ) {
            var amSearchTimer = null;
            allMediaSearch.addEventListener( 'input', function() {
                var val = this.value.trim();
                clearTimeout( amSearchTimer );
                amSearchTimer = setTimeout( function() {
                    amQuery = val;
                    amPage  = 1;
                    loadAllMediaFiles();
                }, 300 );
            } );
        }

        if ( allMediaPagination ) {
            allMediaPagination.addEventListener( 'click', function( e ) {
                var btn = e.target.closest( '.radm-pg-btn' );
                if ( !btn || btn.disabled ) return;
                var p = parseInt( btn.getAttribute( 'data-ampage' ), 10 );
                if ( p && p !== amPage ) {
                    amPage = p;
                    loadAllMediaFiles();
                    window.scrollTo( { top: 0, behavior: 'smooth' } );
                }
            } );
        }

        window.radmCopyMediaUrl = function( url ) {
            if ( navigator.clipboard && navigator.clipboard.writeText ) {
                navigator.clipboard.writeText( url ).then( function() {
                    radmToast( 'Media URL copied to clipboard!', 'success' );
                } ).catch( function() {
                    prompt( 'Copy media URL:', url );
                } );
            } else {
                prompt( 'Copy media URL:', url );
            }
        };

        window.radmCopyMediaUrlFromModal = function() {
            var inp = document.getElementById( 'radm-media-prev-url-input' );
            if ( inp && inp.value ) {
                radmCopyMediaUrl( inp.value );
            }
        };

        window.radmOpenMediaPreviewModal = function( id ) {
            var card = document.querySelector( '.radm-allmedia-card[data-id="' + id + '"]' );
            if ( !card || !card.getAttribute( 'data-item' ) ) return;
            try {
                var item = JSON.parse( card.getAttribute( 'data-item' ) );
                var overlay = document.getElementById( 'radm-media-preview-modal-overlay' );
                if ( !overlay ) return;

                document.getElementById( 'radm-media-prev-title' ).textContent = item.title || item.filename;
                document.getElementById( 'radm-media-prev-filename' ).textContent = item.filename;
                document.getElementById( 'radm-media-prev-date' ).textContent = item.date;
                document.getElementById( 'radm-media-prev-dims' ).textContent = item.dimensions || 'N/A';
                document.getElementById( 'radm-media-prev-size' ).textContent = item.filesize || 'N/A';
                document.getElementById( 'radm-media-prev-url-input' ).value = item.url;
                document.getElementById( 'radm-media-prev-open-link' ).href = item.url;

                var imgEl = document.getElementById( 'radm-media-prev-img' );
                var docEl = document.getElementById( 'radm-media-prev-doc' );
                if ( item.is_image ) {
                    imgEl.src = item.url;
                    imgEl.style.display = 'block';
                    docEl.style.display = 'none';
                } else {
                    imgEl.style.display = 'none';
                    docEl.style.display = 'block';
                    document.getElementById( 'radm-media-prev-docname' ).textContent = item.filename;
                }

                overlay.classList.add( 'radm-modal-open' );
                overlay.setAttribute( 'aria-hidden', 'false' );
            } catch( e ) {}
        };

        window.radmCloseMediaPreviewModal = function() {
            var overlay = document.getElementById( 'radm-media-preview-modal-overlay' );
            if ( overlay ) {
                overlay.classList.remove( 'radm-modal-open' );
                overlay.setAttribute( 'aria-hidden', 'true' );
            }
        };

        window.radmPromptDeleteAllMedia = function( id, name ) {
            pendingAllMediaDelId = id;
            var overlay = document.getElementById( 'radm-allmedia-delete-overlay' );
            var nameEl  = document.getElementById( 'radm-allmedia-delete-name' );
            if ( nameEl ) nameEl.textContent = '"' + name + '"';
            if ( overlay ) {
                overlay.classList.add( 'radm-modal-open' );
                overlay.setAttribute( 'aria-hidden', 'false' );
            }
        };

        window.radmCloseAllMediaDeleteModal = function() {
            var overlay = document.getElementById( 'radm-allmedia-delete-overlay' );
            if ( overlay ) {
                overlay.classList.remove( 'radm-modal-open' );
                overlay.setAttribute( 'aria-hidden', 'true' );
            }
            pendingAllMediaDelId = null;
        };

        var allMediaDelConfirmBtn = document.getElementById( 'radm-allmedia-delete-confirm-btn' );
        if ( allMediaDelConfirmBtn ) {
            allMediaDelConfirmBtn.addEventListener( 'click', function() {
                if ( !pendingAllMediaDelId ) return;
                var id = pendingAllMediaDelId;
                allMediaDelConfirmBtn.disabled = true;
                allMediaDelConfirmBtn.textContent = 'Deleting…';

                ajaxPost( 'radm_delete_attachment', { attachment_id: id }, function( res ) {
                    allMediaDelConfirmBtn.disabled = false;
                    allMediaDelConfirmBtn.textContent = 'Delete File';
                    radmCloseAllMediaDeleteModal();
                    if ( res.success ) {
                        radmToast( 'File deleted permanently.', 'success' );
                        loadAllMediaFiles();
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to delete file.', 'error' );
                    }
                } );
            } );
        }

        window.radmHandleAllMediaUpload = function( input ) {
            var files = input.files;
            if ( !files || !files.length ) return;
            var total = files.length;
            var completed = 0;
            radmToast( 'Uploading ' + total + ' file(s) to WordPress...', 'info' );

            Array.from( files ).forEach( function( file ) {
                var fd = new FormData();
                fd.append( 'action', 'radm_upload_image_file' );
                fd.append( 'image_file', file );
                fd.append( 'nonce', nonce );

                fetch( ajaxUrl, { method: 'POST', body: fd } )
                    .then( function( r ) { return r.json(); } )
                    .then( function( res ) {
                        completed++;
                        if ( completed === total ) {
                            input.value = '';
                            radmToast( 'All ' + total + ' file(s) uploaded successfully!', 'success' );
                            loadAllMediaFiles();
                        }
                    } )
                    .catch( function() {
                        completed++;
                        if ( completed === total ) {
                            input.value = '';
                            loadAllMediaFiles();
                        }
                    } );
            } );
        };

        // Drag & drop on all media dropzone banner
        var amDropzone = document.getElementById( 'radm-allmedia-dropzone' );
        var amFileInput = document.getElementById( 'radm-allmedia-file-input' );
        if ( amDropzone && amFileInput ) {
            amDropzone.addEventListener( 'dragover', function( e ) {
                e.preventDefault();
                amDropzone.style.borderColor = '#2E7D32';
                amDropzone.style.background = '#f0fdf4';
            } );
            amDropzone.addEventListener( 'dragleave', function( e ) {
                e.preventDefault();
                amDropzone.style.borderColor = '#cbd5e1';
                amDropzone.style.background = '#f8fafc';
            } );
            amDropzone.addEventListener( 'drop', function( e ) {
                e.preventDefault();
                amDropzone.style.borderColor = '#cbd5e1';
                amDropzone.style.background = '#f8fafc';
                if ( e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length ) {
                    amFileInput.files = e.dataTransfer.files;
                    radmHandleAllMediaUpload( amFileInput );
                }
            } );
        }

    } // end radm-gallery

    /* ═══════════════════════════════════════════════════════════════════
       ROLES & MODULE ACCESS MANAGER (TAG MULTI-SELECT & CENTER RESTRICTIONS)
       ═══════════════════════════════════════════════════════════════════ */
    if ( curPage === 'radm-roles' || document.getElementById( 'radm-users-tbody' ) ) {

        var usersTbody      = document.getElementById( 'radm-users-tbody' );
        var usersSearch     = document.getElementById( 'radm-users-search' );
        var roleFilter      = document.getElementById( 'radm-users-role-filter' );
        
        // User Access Modal Elements
        var uaOverlay       = document.getElementById( 'radm-user-access-overlay' );
        var uaModalClose    = document.getElementById( 'radm-ua-modal-close' );
        var uaModalCancel   = document.getElementById( 'radm-ua-modal-cancel-btn' );
        var uaModalDeleteBtn= document.getElementById( 'radm-ua-modal-delete-btn' );
        var uaForm          = document.getElementById( 'radm-user-access-form' );
        var uaUserIdInput   = document.getElementById( 'radm-ua-user-id' );
        var uaTitle         = document.getElementById( 'radm-ua-modal-title' );
        var uaSubtitle      = document.getElementById( 'radm-ua-modal-subtitle' );
        var uaRoleSelect    = document.getElementById( 'radm-ua-role' );
        var uaSaveBtn       = document.getElementById( 'radm-ua-modal-save-btn' );
        var uaSaveText      = document.getElementById( 'radm-ua-save-text' );

        // Tag Multi-Select Elements
        var uaTagBox        = document.getElementById( 'radm-ua-mods-tags-container' );
        var uaTagDropdown   = document.getElementById( 'radm-ua-mods-dropdown' );
        var uaTagSearch     = document.getElementById( 'radm-ua-mods-search' );
        var uaSelectAllBtn  = document.getElementById( 'radm-ua-select-all-mods' );
        var uaClearAllBtn   = document.getElementById( 'radm-ua-clear-all-mods' );
        var uaModCheckboxes = document.querySelectorAll( 'input[name="radm_ua_mod_check"]' );

        // Center Restrictions Elements
        var uaCenterToggle  = document.getElementById( 'radm-ua-restrict-center-toggle' );
        var uaCentersWrap   = document.getElementById( 'radm-ua-centers-wrapper' );
        var uaCenterChecks  = document.querySelectorAll( 'input[name="radm_ua_center_check"]' );

        // Create User Modal Elements
        var cuOverlay       = document.getElementById( 'radm-create-user-overlay' );
        var cuOpenBtn       = document.getElementById( 'radm-open-create-user-btn' );
        var cuCloseBtn      = document.getElementById( 'radm-create-user-close' );
        var cuCancelBtn     = document.getElementById( 'radm-create-user-cancel' );
        var cuForm          = document.getElementById( 'radm-create-user-form' );

        // Local state
        var allUsersList    = [];
        var allModulesMap   = {};
        var allRolesMap     = {};
        var customRolesMap  = {};
        var selectedModules = [];

        function syncRoleDropdowns() {
            var roleKeys = Object.keys( allRolesMap );
            if ( !roleKeys.length ) return;

            if ( roleFilter ) {
                var curVal = roleFilter.value;
                var optHtml = '<option value="">All Roles</option>';
                roleKeys.forEach( function ( rk ) {
                    optHtml += '<option value="' + esc( rk ) + '">' + esc( allRolesMap[ rk ].name ) + '</option>';
                } );
                roleFilter.innerHTML = optHtml;
                if ( curVal ) roleFilter.value = curVal;
            }

            var cuRoleSelect = document.getElementById( 'radm-cu-role' );
            if ( cuRoleSelect ) {
                var curCuVal = cuRoleSelect.value || 'radm_admin';
                var cuOptHtml = '';
                roleKeys.forEach( function ( rk ) {
                    var isSys = allRolesMap[ rk ].is_system ? '(System)' : '(Custom)';
                    cuOptHtml += '<option value="' + esc( rk ) + '">' + esc( allRolesMap[ rk ].name ) + ' ' + isSys + '</option>';
                } );
                cuRoleSelect.innerHTML = cuOptHtml;
                if ( curCuVal ) cuRoleSelect.value = curCuVal;
            }

            if ( uaRoleSelect ) {
                var curUaVal = uaRoleSelect.value;
                var uaOptHtml = '';
                roleKeys.forEach( function ( rk ) {
                    var isSys = allRolesMap[ rk ].is_system ? '(System)' : '(Custom)';
                    uaOptHtml += '<option value="' + esc( rk ) + '">' + esc( allRolesMap[ rk ].name ) + ' ' + isSys + '</option>';
                } );
                uaRoleSelect.innerHTML = uaOptHtml;
                if ( curUaVal ) uaRoleSelect.value = curUaVal;
            }
        }

        function loadStaffUsers() {
            if ( !usersTbody ) return;
            usersTbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--radm-text-muted);"><div class="radm-spinner" style="margin:0 auto 10px;"></div>Loading staff users...</td></tr>';

            ajaxPost( 'radm_get_staff_users', {}, function ( res ) {
                if ( !res.success ) {
                    usersTbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:30px;color:#ef4444;">Failed to load staff users.</td></tr>';
                    return;
                }

                allUsersList   = res.data.users || [];
                allModulesMap  = res.data.all_modules || {};
                allRolesMap    = res.data.all_roles || {};
                customRolesMap = res.data.custom_roles || {};
                syncRoleDropdowns();
                renderUsersTable();
                renderCustomRolesTable();
            } );
        }

        function renderUsersTable() {
            if ( !usersTbody ) return;

            var q = ( usersSearch ? usersSearch.value.trim().toLowerCase() : '' );
            var r = ( roleFilter ? roleFilter.value : '' );

            var filtered = allUsersList.filter( function ( u ) {
                var matchQ = ( !q || u.name.toLowerCase().indexOf( q ) !== -1 || u.email.toLowerCase().indexOf( q ) !== -1 );
                var matchR = ( !r || u.role === r );
                return matchQ && matchR;
            } );

            if ( !filtered.length ) {
                usersTbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--radm-text-muted);">No staff users match your search criteria.</td></tr>';
                return;
            }

            var html = '';
            filtered.forEach( function ( u, idx ) {
                var initial = ( u.name ? u.name.charAt( 0 ).toUpperCase() : 'U' );
                
                // Role Badge
                var roleClass = 'radm-badge--open';
                if ( u.role === 'administrator' ) roleClass = 'radm-badge--open';
                else if ( u.role === 'radm_admin' ) roleClass = 'radm-badge--pending';
                else if ( u.role === 'radm_gallery' ) roleClass = 'radm-badge--confirmed';
                else if ( u.role === 'radm_center_admin' ) roleClass = 'radm-badge--attended';

                // Modules Tags
                var modsHtml = '';
                if ( u.is_super_admin ) {
                    modsHtml = '<span class="radm-tag-pill" style="background:#f0fdf4;color:#166534;border-color:#bbf7d0;">👑 Full Access (All 8 Modules)</span>';
                } else if ( u.module_items && u.module_items.length ) {
                    modsHtml = '<div class="radm-module-tags-list">';
                    u.module_items.forEach( function ( mi ) {
                        modsHtml += '<span class="radm-tag-pill radm-tag-pill--sm">' + esc( mi.label ) + '</span>';
                    } );
                    modsHtml += '</div>';
                } else {
                    modsHtml = '<span style="color:var(--radm-text-muted);font-size:12px;">No modules assigned</span>';
                }

                // Center Scope
                var centerHtml = '';
                if ( u.restrict_center && u.centers && u.centers.length ) {
                    centerHtml = '<span style="font-size:12px;color:#1e293b;font-weight:600;">📍 ' + esc( u.centers.join( ', ' ) ) + '</span>';
                } else {
                    centerHtml = '<span style="font-size:12px;color:var(--radm-text-muted);">All Centers</span>';
                }

                // Actions 3-dots Menu
                var deleteItemHtml = '<button type="button" class="radm-card-menu-item radm-card-menu-item--delete" data-action="delete-user" data-id="' + u.id + '">'
                    + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>'
                    + ' Delete User'
                    + '</button>';

                html += '<tr data-user-id="' + u.id + '">'
                    + '<td style="text-align:center;color:var(--radm-text-muted);font-weight:500;">' + ( idx + 1 ) + '</td>'
                    + '<td>'
                    + '<div style="display:flex;align-items:center;gap:10px;">'
                    + '<div style="width:34px;height:34px;border-radius:50%;background:#e8f5e9;color:#2E7D32;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0;">' + initial + '</div>'
                    + '<div>'
                    + '<strong style="display:block;color:var(--radm-text);font-size:13.5px;">' + esc( u.name ) + ( u.is_self ? ' <span style="font-size:11px;font-weight:600;color:var(--radm-green-primary);background:#e8f5e9;padding:1px 6px;border-radius:10px;">You</span>' : '' ) + '</strong>'
                    + '<span style="font-size:12px;color:var(--radm-text-muted);">' + esc( u.email ) + '</span>'
                    + '</div>'
                    + '</div>'
                    + '</td>'
                    + '<td><span class="radm-badge ' + roleClass + '">' + esc( u.role_label ) + '</span></td>'
                    + '<td>' + modsHtml + '</td>'
                    + '<td>' + centerHtml + '</td>'
                    + '<td style="text-align:right;">'
                    + '<div class="radm-card-actions-wrap" style="display:inline-block;">'
                    + '<button type="button" class="radm-card-more-btn" title="User Actions">•••</button>'
                    + '<div class="radm-card-dropdown">'
                    + '<button type="button" class="radm-card-menu-item" data-action="edit-user-access" data-id="' + u.id + '">'
                    + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>'
                    + ' Edit Access</button>'
                    + '<button type="button" class="radm-card-menu-item" data-action="reset-user-pwd" data-id="' + u.id + '">'
                    + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>'
                    + ' Reset Password</button>'
                    + deleteItemHtml
                    + '</div>'
                    + '</div>'
                    + '</td>'
                    + '</tr>';
            } );

            usersTbody.innerHTML = html;
        }

        // Search & Filter listeners
        if ( usersSearch ) usersSearch.addEventListener( 'input', renderUsersTable );
        if ( roleFilter  ) roleFilter.addEventListener( 'change', renderUsersTable );

        // ── Tag Multi-Select Box Rendering ──────────────────────────────
        function renderTagsBox() {
            if ( !uaTagBox ) return;
            uaTagBox.innerHTML = '';

            if ( !selectedModules.length ) {
                uaTagBox.innerHTML = '<span class="radm-tag-placeholder">Click to select accessible modules...</span>';
            } else {
                selectedModules.forEach( function ( key ) {
                    var label = allModulesMap[ key ] ? allModulesMap[ key ].label : key;
                    var tag = document.createElement( 'span' );
                    tag.className = 'radm-tag-pill';
                    tag.dataset.key = key;
                    tag.innerHTML = esc( label ) + '<button type="button" class="radm-tag-remove-btn" title="Remove">&times;</button>';
                    uaTagBox.appendChild( tag );
                } );
            }

            // Sync Checkboxes in dropdown
            if ( uaModCheckboxes ) {
                uaModCheckboxes.forEach( function ( cb ) {
                    cb.checked = ( selectedModules.indexOf( cb.value ) !== -1 );
                } );
            }
        }

        function toggleTagDropdown( show ) {
            if ( !uaTagDropdown ) return;
            if ( typeof show === 'boolean' ) {
                uaTagDropdown.style.display = show ? 'block' : 'none';
            } else {
                var isHidden = ( uaTagDropdown.style.display === 'none' || !uaTagDropdown.style.display );
                uaTagDropdown.style.display = isHidden ? 'block' : 'none';
            }
            if ( uaTagBox ) {
                if ( uaTagDropdown.style.display === 'block' ) {
                    uaTagBox.classList.add( 'is-focused' );
                    if ( uaTagSearch ) uaTagSearch.focus();
                } else {
                    uaTagBox.classList.remove( 'is-focused' );
                }
            }
        }

        if ( uaTagBox ) {
            uaTagBox.addEventListener( 'click', function ( e ) {
                // If clicked on remove cross
                var removeBtn = e.target.closest( '.radm-tag-remove-btn' );
                if ( removeBtn ) {
                    e.stopPropagation();
                    var pill = removeBtn.closest( '.radm-tag-pill' );
                    if ( pill && pill.dataset.key ) {
                        var k = pill.dataset.key;
                        selectedModules = selectedModules.filter( function ( m ) { return m !== k; } );
                        renderTagsBox();
                    }
                    return;
                }
                toggleTagDropdown();
            } );
        }

        // Close dropdown when clicking outside
        document.addEventListener( 'click', function ( e ) {
            if ( !e.target.closest( '#radm-ua-mods-multiselect' ) ) {
                toggleTagDropdown( false );
            }
        } );

        // Module Checkbox change
        if ( uaModCheckboxes ) {
            uaModCheckboxes.forEach( function ( cb ) {
                cb.addEventListener( 'change', function () {
                    var val = this.value;
                    if ( this.checked ) {
                        if ( selectedModules.indexOf( val ) === -1 ) selectedModules.push( val );
                    } else {
                        selectedModules = selectedModules.filter( function ( m ) { return m !== val; } );
                    }
                    renderTagsBox();
                } );
            } );
        }

        // Filter modules in dropdown
        if ( uaTagSearch ) {
            uaTagSearch.addEventListener( 'input', function () {
                var sq = this.value.trim().toLowerCase();
                var rows = document.querySelectorAll( '.radm-tag-opt-row' );
                rows.forEach( function ( row ) {
                    var title = row.querySelector( '.radm-tag-opt-title' );
                    var text = title ? title.textContent.toLowerCase() : '';
                    row.style.display = ( !sq || text.indexOf( sq ) !== -1 ) ? 'flex' : 'none';
                } );
            } );
        }

        // Select All & Clear All Modules
        if ( uaSelectAllBtn ) {
            uaSelectAllBtn.addEventListener( 'click', function () {
                selectedModules = Object.keys( allModulesMap );
                renderTagsBox();
            } );
        }

        if ( uaClearAllBtn ) {
            uaClearAllBtn.addEventListener( 'click', function () {
                selectedModules = [];
                renderTagsBox();
            } );
        }

        // Role change auto-defaults
        if ( uaRoleSelect ) {
            uaRoleSelect.addEventListener( 'change', function () {
                var r = this.value;
                if ( r === 'administrator' ) {
                    selectedModules = Object.keys( allModulesMap );
                    if ( uaCenterToggle ) uaCenterToggle.checked = false;
                } else if ( r === 'radm_admin' ) {
                    selectedModules = [ 'dashboard', 'registrations', 'gallery', 'form-groups', 'whatsapp' ];
                    if ( uaCenterToggle ) uaCenterToggle.checked = false;
                } else if ( r === 'radm_gallery' ) {
                    selectedModules = [ 'dashboard', 'gallery' ];
                    if ( uaCenterToggle ) uaCenterToggle.checked = false;
                } else if ( r === 'radm_center_admin' ) {
                    selectedModules = [ 'dashboard', 'registrations', 'form-groups' ];
                    if ( uaCenterToggle ) uaCenterToggle.checked = true;
                } else {
                    selectedModules = [ 'dashboard' ];
                }
                renderTagsBox();
                if ( uaCentersWrap && uaCenterToggle ) {
                    uaCentersWrap.style.display = uaCenterToggle.checked ? 'block' : 'none';
                }
            } );
        }

        // Center toggle listener
        if ( uaCenterToggle ) {
            uaCenterToggle.addEventListener( 'change', function () {
                if ( uaCentersWrap ) {
                    uaCentersWrap.style.display = this.checked ? 'block' : 'none';
                }
            } );
        }

        // ── Open User Access Modal ──────────────────────────────────────
        function openUserAccessModal( userId ) {
            var user = allUsersList.find( function ( u ) { return u.id === parseInt( userId, 10 ); } );
            if ( !user || !uaOverlay ) return;

            if ( uaUserIdInput ) uaUserIdInput.value = user.id;
            if ( uaTitle ) uaTitle.textContent = 'Edit Module Access: ' + user.name;
            if ( uaSubtitle ) uaSubtitle.textContent = user.email;
            if ( uaRoleSelect ) uaRoleSelect.value = user.role;

            if ( uaModalDeleteBtn ) {
                uaModalDeleteBtn.dataset.id = user.id;
                uaModalDeleteBtn.style.display = user.is_self ? 'none' : 'inline-flex';
            }

            selectedModules = Array.isArray( user.modules ) ? user.modules.slice() : [];
            renderTagsBox();

            // Center Restrictions
            var isRestricted = !!user.restrict_center;
            if ( uaCenterToggle ) uaCenterToggle.checked = isRestricted;
            if ( uaCentersWrap ) uaCentersWrap.style.display = isRestricted ? 'block' : 'none';

            var assignedCenters = user.centers || [];
            if ( uaCenterChecks ) {
                uaCenterChecks.forEach( function ( ccb ) {
                    ccb.checked = ( assignedCenters.indexOf( ccb.value ) !== -1 );
                } );
            }

            toggleTagDropdown( false );
            uaOverlay.setAttribute( 'aria-hidden', 'false' );
            uaOverlay.classList.add( 'radm-modal-open' );
        }

        function closeUserAccessModal() {
            if ( !uaOverlay ) return;
            uaOverlay.classList.remove( 'radm-modal-open' );
            uaOverlay.setAttribute( 'aria-hidden', 'true' );
            toggleTagDropdown( false );
        }

        if ( uaModalClose ) uaModalClose.addEventListener( 'click', closeUserAccessModal );
        if ( uaModalCancel ) uaModalCancel.addEventListener( 'click', closeUserAccessModal );
        if ( uaModalDeleteBtn ) {
            uaModalDeleteBtn.addEventListener( 'click', function () {
                var uid = this.dataset.id;
                closeUserAccessModal();
                if ( uid ) openDeleteUserModal( uid );
            } );
        }

        // ── Delete Staff User Confirmation Modal ────────────────────────
        var delUserOverlay    = document.getElementById( 'radm-delete-user-overlay' );
        var delUserCloseBtn   = document.getElementById( 'radm-del-user-close' );
        var delUserCancelBtn  = document.getElementById( 'radm-del-user-cancel-btn' );
        var delUserConfirmBtn = document.getElementById( 'radm-del-user-confirm-btn' );
        var delUserNameEl     = document.getElementById( 'radm-del-user-name' );
        var pendingDelUserId  = null;

        function openDeleteUserModal( userId ) {
            var user = allUsersList.find( function ( u ) { return u.id === parseInt( userId, 10 ); } );
            if ( !user || !delUserOverlay ) return;

            if ( user.is_self ) {
                radmToast( 'You cannot delete your own logged-in Super Admin account.', 'warning' );
                return;
            }

            pendingDelUserId = user.id;
            if ( delUserNameEl ) delUserNameEl.textContent = user.name + ' (' + user.email + ')';

            delUserOverlay.setAttribute( 'aria-hidden', 'false' );
            delUserOverlay.classList.add( 'radm-modal-open' );
        }

        function closeDeleteUserModal() {
            if ( !delUserOverlay ) return;
            delUserOverlay.classList.remove( 'radm-modal-open' );
            delUserOverlay.setAttribute( 'aria-hidden', 'true' );
            pendingDelUserId = null;
        }

        if ( delUserCloseBtn ) delUserCloseBtn.addEventListener( 'click', closeDeleteUserModal );
        if ( delUserCancelBtn ) delUserCancelBtn.addEventListener( 'click', closeDeleteUserModal );
        if ( delUserOverlay ) {
            delUserOverlay.addEventListener( 'click', function ( e ) {
                if ( e.target === delUserOverlay ) closeDeleteUserModal();
            } );
        }

        if ( delUserConfirmBtn ) {
            delUserConfirmBtn.addEventListener( 'click', function () {
                if ( !pendingDelUserId ) return;
                var uid = pendingDelUserId;

                setLoading( delUserConfirmBtn, true );
                ajaxPost( 'radm_delete_staff_user', { user_id: uid }, function ( res ) {
                    setLoading( delUserConfirmBtn, false );
                    closeDeleteUserModal();

                    if ( res.success ) {
                        radmToast( res.data.message || 'Staff user deleted successfully.', 'success' );
                        var tr = document.querySelector( 'tr[data-user-id="' + uid + '"]' );
                        if ( tr ) {
                            tr.style.transition = 'opacity 0.25s, transform 0.25s';
                            tr.style.opacity = '0';
                            tr.style.transform = 'scale(0.96)';
                            setTimeout( function () {
                                loadStaffUsers();
                            }, 280 );
                        } else {
                            loadStaffUsers();
                        }
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to delete user.', 'error' );
                    }
                } );
            } );
        }

        // ── 3-Dots Kebab & Actions Click Delegation ─────────────────────
        function closeAllRolesCardDropdowns() {
            document.querySelectorAll( '.radm-roles-table .radm-card-dropdown.is-open' ).forEach( function ( d ) { d.classList.remove( 'is-open' ); } );
            document.querySelectorAll( '.radm-roles-table .radm-card-more-btn.is-active' ).forEach( function ( b ) { b.classList.remove( 'is-active' ); } );
        }

        document.addEventListener( 'click', function ( e ) {
            var moreBtn = e.target.closest( '.radm-roles-table .radm-card-more-btn' );
            if ( moreBtn ) {
                e.stopPropagation();
                var menu = moreBtn.nextElementSibling;
                var isOpen = menu && menu.classList.contains( 'is-open' );
                closeAllRolesCardDropdowns();
                if ( menu && !isOpen ) {
                    menu.classList.add( 'is-open' );
                    moreBtn.classList.add( 'is-active' );
                }
                return;
            }

            if ( !e.target.closest( '.radm-roles-table .radm-card-dropdown' ) ) {
                closeAllRolesCardDropdowns();
            }

            // Edit User Access inside dropdown
            var editBtn = e.target.closest( '[data-action="edit-user-access"]' );
            if ( editBtn ) {
                closeAllRolesCardDropdowns();
                var uid = editBtn.dataset.id;
                if ( uid ) openUserAccessModal( uid );
                return;
            }

            // Reset User Password inside dropdown
            var rpBtn = e.target.closest( '[data-action="reset-user-pwd"]' );
            if ( rpBtn ) {
                closeAllRolesCardDropdowns();
                var rpUid = rpBtn.dataset.id;
                if ( rpUid ) openResetPwdModal( rpUid );
                return;
            }

            // Delete User inside dropdown
            var delBtn = e.target.closest( '[data-action="delete-user"]' );
            if ( delBtn ) {
                closeAllRolesCardDropdowns();
                var dUid = delBtn.dataset.id;
                if ( dUid ) openDeleteUserModal( dUid );
                return;
            }
        } );

        // ── Save User Access Form Submission ────────────────────────────
        if ( uaForm ) {
            uaForm.addEventListener( 'submit', function ( e ) {
                e.preventDefault();

                var uid = uaUserIdInput ? parseInt( uaUserIdInput.value, 10 ) : 0;
                if ( !uid ) return;

                var centers = [];
                if ( uaCenterChecks ) {
                    uaCenterChecks.forEach( function ( ccb ) {
                        if ( ccb.checked ) centers.push( ccb.value );
                    } );
                }

                var payload = {
                    user_id: uid,
                    role: uaRoleSelect ? uaRoleSelect.value : '',
                    modules: JSON.stringify( selectedModules ),
                    restrict_center: ( uaCenterToggle && uaCenterToggle.checked ) ? 1 : 0,
                    centers: JSON.stringify( centers )
                };

                if ( uaSaveBtn ) {
                    uaSaveBtn.disabled = true;
                    if ( uaSaveText ) uaSaveText.textContent = 'Saving...';
                }

                ajaxPost( 'radm_save_user_access', payload, function ( res ) {
                    if ( uaSaveBtn ) {
                        uaSaveBtn.disabled = false;
                        if ( uaSaveText ) uaSaveText.textContent = 'Save Access Permissions';
                    }

                    if ( res.success ) {
                        radmToast( res.data.message || 'Access permissions updated successfully!', 'success' );
                        closeUserAccessModal();
                        loadStaffUsers();
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to update access.', 'error' );
                    }
                } );
            } );
        }

        // ── Create Staff User Modal Logic ───────────────────────────────
        function openCreateUserModal() {
            if ( !cuOverlay ) return;
            if ( cuForm ) cuForm.reset();
            cuOverlay.setAttribute( 'aria-hidden', 'false' );
            cuOverlay.classList.add( 'radm-modal-open' );
            var nameInput = document.getElementById( 'radm-cu-name' );
            if ( nameInput ) nameInput.focus();
        }

        function closeCreateUserModal() {
            if ( !cuOverlay ) return;
            cuOverlay.classList.remove( 'radm-modal-open' );
            cuOverlay.setAttribute( 'aria-hidden', 'true' );
        }

        if ( cuOpenBtn ) cuOpenBtn.addEventListener( 'click', openCreateUserModal );
        if ( cuCloseBtn ) cuCloseBtn.addEventListener( 'click', closeCreateUserModal );
        if ( cuCancelBtn ) cuCancelBtn.addEventListener( 'click', closeCreateUserModal );

        if ( cuForm ) {
            cuForm.addEventListener( 'submit', function ( e ) {
                e.preventDefault();

                var nameEl  = document.getElementById( 'radm-cu-name' );
                var emailEl = document.getElementById( 'radm-cu-email' );
                var userEl  = document.getElementById( 'radm-cu-username' );
                var passEl  = document.getElementById( 'radm-cu-password' );
                var roleEl  = document.getElementById( 'radm-cu-role' );

                var payload = {
                    name:     nameEl ? nameEl.value.trim() : '',
                    email:    emailEl ? emailEl.value.trim() : '',
                    username: userEl ? userEl.value.trim() : '',
                    password: passEl ? passEl.value : '',
                    role:     roleEl ? roleEl.value : 'radm_admin',
                };

                var submitBtn = document.getElementById( 'radm-create-user-submit' );
                if ( submitBtn ) submitBtn.disabled = true;

                ajaxPost( 'radm_create_staff_user', payload, function ( res ) {
                    if ( submitBtn ) submitBtn.disabled = false;
                    if ( res.success ) {
                        radmToast( res.data.message || 'Staff user created successfully!', 'success' );
                        closeCreateUserModal();
                        loadStaffUsers();
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to create user.', 'error' );
                    }
                } );
            } );
        }

        // ── Reset User Password Modal Logic (Super Admin) ──────────────
        var rpOverlay    = document.getElementById( 'radm-reset-password-overlay' );
        var rpCloseBtn   = document.getElementById( 'radm-reset-pwd-close' );
        var rpCancelBtn  = document.getElementById( 'radm-reset-pwd-cancel' );
        var rpForm       = document.getElementById( 'radm-reset-password-form' );
        var rpUserIdIn   = document.getElementById( 'radm-rp-user-id' );
        var rpUserNameEl = document.getElementById( 'radm-rp-user-name' );
        var rpUserEmailEl= document.getElementById( 'radm-rp-user-email' );
        var rpUserInitEl = document.getElementById( 'radm-rp-user-initial' );
        var rpNewPassIn  = document.getElementById( 'radm-rp-new-password' );
        var rpConfPassIn = document.getElementById( 'radm-rp-confirm-password' );
        var rpGenBtn     = document.getElementById( 'radm-rp-generate-btn' );
        var rpSubmitBtn  = document.getElementById( 'radm-reset-pwd-submit' );
        var rpSubmitText = document.getElementById( 'radm-reset-pwd-submit-text' );

        function openResetPwdModal( userId ) {
            var user = allUsersList.find( function ( u ) { return u.id === parseInt( userId, 10 ); } );
            if ( !user || !rpOverlay ) return;

            if ( rpUserIdIn ) rpUserIdIn.value = user.id;
            if ( rpUserNameEl ) rpUserNameEl.textContent = user.name;
            if ( rpUserEmailEl ) rpUserEmailEl.textContent = user.email;
            if ( rpUserInitEl ) rpUserInitEl.textContent = user.name ? user.name.charAt( 0 ).toUpperCase() : 'U';
            if ( rpNewPassIn ) rpNewPassIn.value = '';
            if ( rpConfPassIn ) rpConfPassIn.value = '';

            rpOverlay.setAttribute( 'aria-hidden', 'false' );
            rpOverlay.classList.add( 'radm-modal-open' );
            if ( rpNewPassIn ) rpNewPassIn.focus();
        }

        function closeResetPwdModal() {
            if ( !rpOverlay ) return;
            rpOverlay.classList.remove( 'radm-modal-open' );
            rpOverlay.setAttribute( 'aria-hidden', 'true' );
        }

        if ( rpCloseBtn ) rpCloseBtn.addEventListener( 'click', closeResetPwdModal );
        if ( rpCancelBtn ) rpCancelBtn.addEventListener( 'click', closeResetPwdModal );

        if ( rpGenBtn ) {
            rpGenBtn.addEventListener( 'click', function ( e ) {
                e.preventDefault();
                var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%^&*';
                var pass = '';
                for ( var i = 0; i < 12; i++ ) {
                    pass += chars.charAt( Math.floor( Math.random() * chars.length ) );
                }
                if ( rpNewPassIn ) {
                    rpNewPassIn.value = pass;
                    rpNewPassIn.type = 'text';
                }
                if ( rpConfPassIn ) {
                    rpConfPassIn.value = pass;
                    rpConfPassIn.type = 'text';
                }
                radmToast( 'Strong password generated!', 'info' );
            } );
        }

        if ( rpForm ) {
            rpForm.addEventListener( 'submit', function ( e ) {
                e.preventDefault();
                var uid = rpUserIdIn ? parseInt( rpUserIdIn.value, 10 ) : 0;
                var nPass = rpNewPassIn ? rpNewPassIn.value : '';
                var cPass = rpConfPassIn ? rpConfPassIn.value : '';

                if ( !uid || !nPass || !cPass ) {
                    radmToast( 'All password fields are compulsory.', 'warning' );
                    return;
                }

                if ( nPass.length < 6 ) {
                    radmToast( 'Password must be at least 6 characters long.', 'warning' );
                    return;
                }

                if ( nPass !== cPass ) {
                    radmToast( 'Password and confirmation do not match.', 'error' );
                    return;
                }

                if ( rpSubmitBtn ) rpSubmitBtn.disabled = true;
                if ( rpSubmitText ) rpSubmitText.textContent = 'Resetting...';

                ajaxPost( 'radm_admin_reset_user_password', {
                    user_id: uid,
                    new_password: nPass,
                    confirm_password: cPass
                }, function ( res ) {
                    if ( rpSubmitBtn ) rpSubmitBtn.disabled = false;
                    if ( rpSubmitText ) rpSubmitText.textContent = 'Reset Password';

                    if ( res.success ) {
                        radmToast( res.data.message || 'Password reset successfully!', 'success' );
                        closeResetPwdModal();
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to reset password.', 'error' );
                    }
                } );
            } );
        }

        // ── Sub-tabs Switching Logic ────────────────────────────────────
        var tabBtnStaffUsers   = document.getElementById( 'radm-tab-staff-users' );
        var tabBtnCustomRoles  = document.getElementById( 'radm-tab-custom-roles' );
        var tabPaneStaffUsers  = document.getElementById( 'radm-tab-pane-staff-users' );
        var tabPaneCustomRoles = document.getElementById( 'radm-tab-pane-custom-roles' );

        function switchRolesTab( tabKey ) {
            if ( tabKey === 'custom-roles' ) {
                if ( tabBtnCustomRoles ) {
                    tabBtnCustomRoles.classList.add( 'is-active' );
                    tabBtnCustomRoles.style.background = '#e8f5e9';
                    tabBtnCustomRoles.style.color = '#2E7D32';
                    tabBtnCustomRoles.style.border = 'none';
                }
                if ( tabBtnStaffUsers ) {
                    tabBtnStaffUsers.classList.remove( 'is-active' );
                    tabBtnStaffUsers.style.background = '#fff';
                    tabBtnStaffUsers.style.color = 'var(--radm-text)';
                    tabBtnStaffUsers.style.border = '1px solid var(--radm-border)';
                }
                if ( tabPaneStaffUsers ) tabPaneStaffUsers.style.display = 'none';
                if ( tabPaneCustomRoles ) tabPaneCustomRoles.style.display = 'block';
            } else {
                if ( tabBtnStaffUsers ) {
                    tabBtnStaffUsers.classList.add( 'is-active' );
                    tabBtnStaffUsers.style.background = '#e8f5e9';
                    tabBtnStaffUsers.style.color = '#2E7D32';
                    tabBtnStaffUsers.style.border = 'none';
                }
                if ( tabBtnCustomRoles ) {
                    tabBtnCustomRoles.classList.remove( 'is-active' );
                    tabBtnCustomRoles.style.background = '#fff';
                    tabBtnCustomRoles.style.color = 'var(--radm-text)';
                    tabBtnCustomRoles.style.border = '1px solid var(--radm-border)';
                }
                if ( tabPaneStaffUsers ) tabPaneStaffUsers.style.display = 'block';
                if ( tabPaneCustomRoles ) tabPaneCustomRoles.style.display = 'none';
            }
        }

        if ( tabBtnStaffUsers ) {
            tabBtnStaffUsers.addEventListener( 'click', function () { switchRolesTab( 'staff-users' ); } );
        }
        if ( tabBtnCustomRoles ) {
            tabBtnCustomRoles.addEventListener( 'click', function () { switchRolesTab( 'custom-roles' ); } );
        }

        // ── Custom Roles Table Rendering & Management ───────────────────
        var rolesListTbody = document.getElementById( 'radm-roles-list-tbody' );

        function renderCustomRolesTable() {
            if ( !rolesListTbody ) return;
            var roleKeys = Object.keys( allRolesMap );
            if ( !roleKeys.length ) {
                rolesListTbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:30px;color:var(--radm-text-muted);">No roles configured.</td></tr>';
                return;
            }

            var html = '';
            roleKeys.forEach( function ( rKey, idx ) {
                var rInfo = allRolesMap[ rKey ];
                var isSystem = !!rInfo.is_system;

                // User count
                var userCount = allUsersList.filter( function ( u ) { return u.role === rKey; } ).length;

                // Modules Tags
                var modTags = '';
                if ( rKey === 'administrator' ) {
                    modTags = '<span class="radm-tag-pill" style="background:#f0fdf4;color:#166534;border-color:#bbf7d0;">👑 Full Access (All 8 Modules)</span>';
                } else if ( rInfo.modules && rInfo.modules.length ) {
                    modTags = '<div class="radm-module-tags-list">';
                    rInfo.modules.forEach( function ( mk ) {
                        var mLabel = allModulesMap[ mk ] ? allModulesMap[ mk ].label : mk;
                        modTags += '<span class="radm-tag-pill radm-tag-pill--sm">' + esc( mLabel ) + '</span>';
                    } );
                    modTags += '</div>';
                } else {
                    modTags = '<span style="color:var(--radm-text-muted);font-size:12px;">No modules</span>';
                }

                // Scope
                var scopeText = '';
                if ( rInfo.restrict_center && rInfo.centers && rInfo.centers.length ) {
                    scopeText = '<span style="font-size:12px;color:#1e293b;font-weight:600;">📍 ' + esc( rInfo.centers.join( ', ' ) ) + '</span>';
                } else {
                    scopeText = '<span style="font-size:12px;color:var(--radm-text-muted);">All Centers</span>';
                }

                // Action
                var actionHtml = '';
                if ( isSystem ) {
                    actionHtml = '<span class="radm-badge radm-badge--draft" style="font-size:11px;background:#f1f5f9;color:#64748b;border-color:#e2e8f0;">System Protected</span>';
                } else {
                    actionHtml = '<button type="button" class="radm-btn radm-btn-danger radm-btn--sm" data-action="delete-custom-role" data-slug="' + esc( rKey ) + '" data-name="' + esc( rInfo.name ) + '" style="background:#fee2e2;color:#dc2626;border-color:#fecaca;padding:4px 10px;font-size:12px;">'
                        + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13" style="vertical-align:middle;margin-right:2px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>'
                        + ' Delete</button>';
                }

                html += '<tr>'
                    + '<td style="text-align:center;color:var(--radm-text-muted);font-weight:500;">' + ( idx + 1 ) + '</td>'
                    + '<td><strong style="color:var(--radm-text);font-size:13.5px;">' + esc( rInfo.name ) + '</strong></td>'
                    + '<td><code style="font-size:12px;background:#f8fafc;padding:2px 6px;border-radius:4px;border:1px solid #e2e8f0;">' + esc( rKey ) + '</code></td>'
                    + '<td>' + modTags + '</td>'
                    + '<td>' + scopeText + '</td>'
                    + '<td style="text-align:center;"><span class="radm-badge radm-badge--open" style="font-weight:700;">' + userCount + '</span></td>'
                    + '<td style="text-align:right;">' + actionHtml + '</td>'
                    + '</tr>';
            } );

            rolesListTbody.innerHTML = html;
        }

        // Delete Custom Role delegation
        if ( rolesListTbody ) {
            rolesListTbody.addEventListener( 'click', function ( e ) {
                var delRoleBtn = e.target.closest( '[data-action="delete-custom-role"]' );
                if ( delRoleBtn ) {
                    var rSlug = delRoleBtn.getAttribute( 'data-slug' );
                    var rName = delRoleBtn.getAttribute( 'data-name' );
                    if ( !rSlug ) return;

                    if ( !confirm( 'Are you sure you want to delete custom role "' + rName + '"?\n\nAny users currently assigned this role will be reassigned to Subscriber.' ) ) {
                        return;
                    }

                    delRoleBtn.disabled = true;
                    ajaxPost( 'radm_delete_custom_role', { role_slug: rSlug }, function ( res ) {
                        if ( res.success ) {
                            radmToast( res.data.message || 'Custom role deleted successfully.', 'success' );
                            loadStaffUsers();
                        } else {
                            delRoleBtn.disabled = false;
                            radmToast( ( res.data && res.data.message ) || 'Failed to delete custom role.', 'error' );
                        }
                    } );
                }
            } );
        }

        // ── Create Custom Role Modal Logic ──────────────────────────────
        var crOverlay     = document.getElementById( 'radm-create-role-overlay' );
        var crOpenBtn     = document.getElementById( 'radm-open-create-role-btn' );
        var crCloseBtn    = document.getElementById( 'radm-create-role-close' );
        var crCancelBtn   = document.getElementById( 'radm-create-role-cancel' );
        var crForm        = document.getElementById( 'radm-create-role-form' );
        var crNameIn      = document.getElementById( 'radm-cr-name' );
        var crSlugIn      = document.getElementById( 'radm-cr-slug' );
        var crSelectAllBtn= document.getElementById( 'radm-cr-select-all-mods' );
        var crClearAllBtn = document.getElementById( 'radm-cr-clear-all-mods' );
        var crModChecks   = document.querySelectorAll( 'input[name="radm_cr_mod_check"]' );
        var crCenterToggle= document.getElementById( 'radm-cr-restrict-center-toggle' );
        var crCentersWrap = document.getElementById( 'radm-cr-centers-wrapper' );
        var crCenterChecks= document.querySelectorAll( 'input[name="radm_cr_center_check"]' );
        var crSubmitBtn   = document.getElementById( 'radm-create-role-submit' );
        var crSubmitText  = document.getElementById( 'radm-create-role-submit-text' );

        function openCreateRoleModal() {
            if ( !crOverlay ) return;
            if ( crForm ) crForm.reset();
            if ( crCentersWrap ) crCentersWrap.style.display = 'none';
            if ( crModChecks ) {
                crModChecks.forEach( function ( cb ) {
                    cb.checked = ( cb.value === 'dashboard' );
                } );
            }
            crOverlay.setAttribute( 'aria-hidden', 'false' );
            crOverlay.classList.add( 'radm-modal-open' );
            if ( crNameIn ) crNameIn.focus();
        }

        function closeCreateRoleModal() {
            if ( !crOverlay ) return;
            crOverlay.classList.remove( 'radm-modal-open' );
            crOverlay.setAttribute( 'aria-hidden', 'true' );
        }

        if ( crOpenBtn ) crOpenBtn.addEventListener( 'click', openCreateRoleModal );
        if ( crCloseBtn ) crCloseBtn.addEventListener( 'click', closeCreateRoleModal );
        if ( crCancelBtn ) crCancelBtn.addEventListener( 'click', closeCreateRoleModal );

        if ( crSelectAllBtn ) {
            crSelectAllBtn.addEventListener( 'click', function () {
                if ( crModChecks ) crModChecks.forEach( function ( cb ) { cb.checked = true; } );
            } );
        }
        if ( crClearAllBtn ) {
            crClearAllBtn.addEventListener( 'click', function () {
                if ( crModChecks ) crModChecks.forEach( function ( cb ) { cb.checked = ( cb.value === 'dashboard' ); } );
            } );
        }

        if ( crCenterToggle ) {
            crCenterToggle.addEventListener( 'change', function () {
                if ( crCentersWrap ) crCentersWrap.style.display = this.checked ? 'block' : 'none';
            } );
        }

        if ( crForm ) {
            crForm.addEventListener( 'submit', function ( e ) {
                e.preventDefault();
                var rName = crNameIn ? crNameIn.value.trim() : '';
                var rSlug = crSlugIn ? crSlugIn.value.trim() : '';

                if ( !rName ) {
                    radmToast( 'Role Display Name is compulsory.', 'warning' );
                    return;
                }

                var selectedMods = [];
                if ( crModChecks ) {
                    crModChecks.forEach( function ( cb ) {
                        if ( cb.checked ) selectedMods.push( cb.value );
                    } );
                }

                if ( selectedMods.indexOf( 'dashboard' ) === -1 ) {
                    selectedMods.unshift( 'dashboard' );
                }

                var selectedCenters = [];
                if ( crCenterChecks ) {
                    crCenterChecks.forEach( function ( ccb ) {
                        if ( ccb.checked ) selectedCenters.push( ccb.value );
                    } );
                }

                if ( crSubmitBtn ) crSubmitBtn.disabled = true;
                if ( crSubmitText ) crSubmitText.textContent = 'Creating...';

                ajaxPost( 'radm_create_custom_role', {
                    role_name: rName,
                    role_slug: rSlug,
                    modules: JSON.stringify( selectedMods ),
                    restrict_center: ( crCenterToggle && crCenterToggle.checked ) ? 1 : 0,
                    centers: JSON.stringify( selectedCenters )
                }, function ( res ) {
                    if ( crSubmitBtn ) crSubmitBtn.disabled = false;
                    if ( crSubmitText ) crSubmitText.textContent = 'Create Role';

                    if ( res.success ) {
                        radmToast( res.data.message || 'Custom role created successfully!', 'success' );
                        closeCreateRoleModal();
                        loadStaffUsers();
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to create custom role.', 'error' );
                    }
                } );
            } );
        }

        // Initialize Load
        loadStaffUsers();

    } // end radm-roles

    /* ═══════════════════════════════════════════════════════════════════
       SETTINGS PAGE (ORGANIZATION SETTINGS & CENTERS MANAGEMENT)
       ═══════════════════════════════════════════════════════════════════ */
    if ( curPage === 'radm-settings' || document.getElementById( 'radm-centers-tbody' ) || document.getElementById( 'radm-change-password-form' ) ) {

        // Organization Settings Form
        var orgForm        = document.getElementById( 'radm-org-settings-form' );
        var orgNameInput   = document.getElementById( 'radm-org-name' );
        var orgLogoInput   = document.getElementById( 'radm-org-logo-url' );
        var orgLogoImg     = document.getElementById( 'radm-logo-img-preview' );
        var changeLogoBtn  = document.getElementById( 'radm-change-logo-btn' );
        var contactEmailIn = document.getElementById( 'radm-contact-email' );
        var saveOrgBtn     = document.getElementById( 'radm-save-org-btn' );
        var saveOrgText    = document.getElementById( 'radm-save-org-text' );

        // In-Portal Media Picker for Logo
        if ( changeLogoBtn ) {
            changeLogoBtn.addEventListener( 'click', function ( e ) {
                e.preventDefault();
                window.radmOpenDbMediaPicker(
                    'radm-org-logo-url',
                    null,
                    null,
                    null,
                    function ( attachment ) {
                        if ( attachment && attachment.url ) {
                            if ( orgLogoInput ) orgLogoInput.value = attachment.url;
                            if ( orgLogoImg ) orgLogoImg.src = attachment.url;
                            radmToast( 'Logo selected. Click "Save Changes" to apply.', 'success' );
                        }
                    }
                );
            } );
        }

        // Save Org Settings Submission
        if ( orgForm ) {
            orgForm.addEventListener( 'submit', function ( e ) {
                e.preventDefault();

                var payload = {
                    org_name:      orgNameInput ? orgNameInput.value.trim() : '',
                    org_logo:      orgLogoInput ? orgLogoInput.value.trim() : '',
                    contact_email: contactEmailIn ? contactEmailIn.value.trim() : '',
                };

                if ( saveOrgBtn ) {
                    saveOrgBtn.disabled = true;
                    if ( saveOrgText ) saveOrgText.textContent = 'Saving...';
                }

                ajaxPost( 'radm_save_org_settings', payload, function ( res ) {
                    if ( saveOrgBtn ) {
                        saveOrgBtn.disabled = false;
                        if ( saveOrgText ) saveOrgText.textContent = 'Save Changes';
                    }

                    if ( res.success ) {
                        radmToast( res.data.message || 'Organization settings saved successfully!', 'success' );
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to save settings.', 'error' );
                    }
                } );
            } );
        }

        // Centers Management Elements
        var centersTbody   = document.getElementById( 'radm-centers-tbody' );
        var addCenterBtn   = document.getElementById( 'radm-add-center-btn' );
        
        // Add/Edit Center Modal Elements
        var cModalOverlay  = document.getElementById( 'radm-center-modal-overlay' );
        var cModalTitle    = document.getElementById( 'radm-center-modal-title' );
        var cModalClose    = document.getElementById( 'radm-center-modal-close' );
        var cModalCancel   = document.getElementById( 'radm-center-modal-cancel' );
        var cForm          = document.getElementById( 'radm-center-form' );
        var cIdInput       = document.getElementById( 'radm-center-id' );
        var cNameInput     = document.getElementById( 'radm-center-name' );
        var cLocInput      = document.getElementById( 'radm-center-location' );
        var cSubmitBtn     = document.getElementById( 'radm-center-modal-submit' );
        var cSubmitText    = document.getElementById( 'radm-center-submit-text' );

        // Delete Center Modal Elements
        var cDelOverlay    = document.getElementById( 'radm-delete-center-overlay' );
        var cDelCloseBtn   = document.getElementById( 'radm-del-center-close' );
        var cDelCancelBtn  = document.getElementById( 'radm-del-center-cancel-btn' );
        var cDelConfirmBtn = document.getElementById( 'radm-del-center-confirm-btn' );
        var cDelNameEl     = document.getElementById( 'radm-del-center-name' );
        var pendingCenterId= null;

        var allCentersData = [];

        function loadCenters() {
            if ( !centersTbody ) return;
            centersTbody.innerHTML = '<tr><td colspan="5" style="text-align:center;padding:40px;color:var(--radm-text-muted);"><div class="radm-spinner" style="margin:0 auto 10px;"></div>Loading centers...</td></tr>';

            ajaxPost( 'radm_get_centers', {}, function ( res ) {
                if ( !res.success ) {
                    centersTbody.innerHTML = '<tr><td colspan="5" style="text-align:center;padding:30px;color:#ef4444;">Failed to load centers.</td></tr>';
                    return;
                }

                allCentersData = res.data.centers || [];
                renderCentersTable();
            } );
        }

        function renderCentersTable() {
            if ( !centersTbody ) return;

            if ( !allCentersData.length ) {
                centersTbody.innerHTML = '<tr><td colspan="5" style="text-align:center;padding:40px;color:var(--radm-text-muted);">No centers configured yet. Click "+ Add New Center" above.</td></tr>';
                return;
            }

            var html = '';
            allCentersData.forEach( function ( c, idx ) {
                var isActive = ( c.status === 'active' );
                var badgeHtml = isActive 
                    ? '<span class="radm-badge radm-badge--open">Active</span>'
                    : '<span class="radm-badge radm-badge--draft" style="background:#fee2e2;color:#991b1b;border-color:#fecaca;">Inactive</span>';

                html += '<tr data-center-id="' + esc( c.id ) + '">'
                    + '<td style="text-align:center;color:var(--radm-text-muted);font-weight:600;">' + ( idx + 1 ) + '</td>'
                    + '<td><strong style="color:var(--radm-text);font-size:13.5px;">' + esc( c.name ) + '</strong></td>'
                    + '<td style="color:#475569;font-size:13px;">' + esc( c.location || 'Bangalore' ) + '</td>'
                    + '<td>' + badgeHtml + '</td>'
                    + '<td style="text-align:right;">'
                    + '<button type="button" class="radm-action-square-btn" data-action="edit-center" data-id="' + esc( c.id ) + '" title="Edit Center">'
                    + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>'
                    + '</button>'
                    + '<button type="button" class="radm-action-square-btn radm-action-square-btn--delete" data-action="delete-center" data-id="' + esc( c.id ) + '" title="Delete Center">'
                    + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>'
                    + '</button>'
                    + '</td>'
                    + '</tr>';
            } );

            centersTbody.innerHTML = html;
        }

        // Open Add Center Modal
        function openAddCenterModal() {
            if ( !cModalOverlay ) return;
            if ( cForm ) cForm.reset();
            if ( cIdInput ) cIdInput.value = '';
            if ( cLocInput ) cLocInput.value = 'Bangalore';
            if ( cModalTitle ) cModalTitle.textContent = 'Add New Center';
            if ( cSubmitText ) cSubmitText.textContent = 'Add Center';

            var activeRadio = document.querySelector( 'input[name="radm_center_status"][value="active"]' );
            if ( activeRadio ) activeRadio.checked = true;

            cModalOverlay.setAttribute( 'aria-hidden', 'false' );
            cModalOverlay.classList.add( 'radm-modal-open' );
            if ( cNameInput ) cNameInput.focus();
        }

        // Open Edit Center Modal
        function openEditCenterModal( centerId ) {
            var center = allCentersData.find( function ( c ) { return c.id === centerId; } );
            if ( !center || !cModalOverlay ) return;

            if ( cIdInput ) cIdInput.value = center.id;
            if ( cNameInput ) cNameInput.value = center.name;
            if ( cLocInput ) cLocInput.value = center.location || 'Bangalore';
            if ( cModalTitle ) cModalTitle.textContent = 'Edit Center: ' + center.name;
            if ( cSubmitText ) cSubmitText.textContent = 'Save Center';

            var statusVal = ( center.status === 'inactive' ) ? 'inactive' : 'active';
            var statusRadio = document.querySelector( 'input[name="radm_center_status"][value="' + statusVal + '"]' );
            if ( statusRadio ) statusRadio.checked = true;

            cModalOverlay.setAttribute( 'aria-hidden', 'false' );
            cModalOverlay.classList.add( 'radm-modal-open' );
            if ( cNameInput ) cNameInput.focus();
        }

        function closeCenterModal() {
            if ( !cModalOverlay ) return;
            cModalOverlay.classList.remove( 'radm-modal-open' );
            cModalOverlay.setAttribute( 'aria-hidden', 'true' );
        }

        if ( addCenterBtn ) addCenterBtn.addEventListener( 'click', openAddCenterModal );
        if ( cModalClose )  cModalClose.addEventListener( 'click', closeCenterModal );
        if ( cModalCancel ) cModalCancel.addEventListener( 'click', closeCenterModal );

        // Center Form Submit
        if ( cForm ) {
            cForm.addEventListener( 'submit', function ( e ) {
                e.preventDefault();

                var statusEl = document.querySelector( 'input[name="radm_center_status"]:checked' );
                var payload = {
                    center_id: cIdInput ? cIdInput.value : '',
                    name:      cNameInput ? cNameInput.value.trim() : '',
                    location:  cLocInput ? cLocInput.value.trim() : 'Bangalore',
                    status:    statusEl ? statusEl.value : 'active',
                };

                if ( cSubmitBtn ) {
                    cSubmitBtn.disabled = true;
                    if ( cSubmitText ) cSubmitText.textContent = 'Saving...';
                }

                ajaxPost( 'radm_save_center', payload, function ( res ) {
                    if ( cSubmitBtn ) {
                        cSubmitBtn.disabled = false;
                        if ( cSubmitText ) cSubmitText.textContent = 'Save Center';
                    }

                    if ( res.success ) {
                        radmToast( res.data.message || 'Center saved successfully!', 'success' );
                        closeCenterModal();
                        if ( res.data.centers ) {
                            allCentersData = res.data.centers;
                            renderCentersTable();
                        } else {
                            loadCenters();
                        }
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to save center.', 'error' );
                    }
                } );
            } );
        }

        // Delete Center Modal Logic
        function openDeleteCenterModal( centerId ) {
            var center = allCentersData.find( function ( c ) { return c.id === centerId; } );
            if ( !center || !cDelOverlay ) return;

            pendingCenterId = center.id;
            if ( cDelNameEl ) cDelNameEl.textContent = center.name;

            cDelOverlay.setAttribute( 'aria-hidden', 'false' );
            cDelOverlay.classList.add( 'radm-modal-open' );
        }

        function closeDeleteCenterModal() {
            if ( !cDelOverlay ) return;
            cDelOverlay.classList.remove( 'radm-modal-open' );
            cDelOverlay.setAttribute( 'aria-hidden', 'true' );
            pendingCenterId = null;
        }

        if ( cDelCloseBtn )  cDelCloseBtn.addEventListener( 'click', closeDeleteCenterModal );
        if ( cDelCancelBtn ) cDelCancelBtn.addEventListener( 'click', closeDeleteCenterModal );
        if ( cDelOverlay ) {
            cDelOverlay.addEventListener( 'click', function ( e ) {
                if ( e.target === cDelOverlay ) closeDeleteCenterModal();
            } );
        }

        if ( cDelConfirmBtn ) {
            cDelConfirmBtn.addEventListener( 'click', function () {
                if ( !pendingCenterId ) return;
                var cid = pendingCenterId;

                setLoading( cDelConfirmBtn, true );
                ajaxPost( 'radm_delete_center', { center_id: cid }, function ( res ) {
                    setLoading( cDelConfirmBtn, false );
                    closeDeleteCenterModal();

                    if ( res.success ) {
                        radmToast( res.data.message || 'Center deleted successfully.', 'success' );
                        if ( res.data.centers ) {
                            allCentersData = res.data.centers;
                            renderCentersTable();
                        } else {
                            loadCenters();
                        }
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to delete center.', 'error' );
                    }
                } );
            } );
        }

        // Table Action Click Delegation
        document.addEventListener( 'click', function ( e ) {
            var editBtn = e.target.closest( '[data-action="edit-center"]' );
            if ( editBtn ) {
                var cid = editBtn.dataset.id;
                if ( cid ) openEditCenterModal( cid );
                return;
            }

            var delBtn = e.target.closest( '[data-action="delete-center"]' );
            if ( delBtn ) {
                var dCid = delBtn.dataset.id;
                if ( dCid ) openDeleteCenterModal( dCid );
                return;
            }
        } );

        // ── Self Password Change Form Handler ───────────────────────────
        var changePwdForm = document.getElementById( 'radm-change-password-form' );
        if ( changePwdForm ) {
            changePwdForm.addEventListener( 'submit', function ( e ) {
                e.preventDefault();
                var currPass = document.getElementById( 'radm-current-password' );
                var newPass  = document.getElementById( 'radm-new-password' );
                var confPass = document.getElementById( 'radm-confirm-password' );
                var btn      = document.getElementById( 'radm-change-pwd-btn' );
                var btnText  = document.getElementById( 'radm-change-pwd-text' );

                var cVal  = currPass ? currPass.value : '';
                var nVal  = newPass ? newPass.value : '';
                var cfVal = confPass ? confPass.value : '';

                if ( !cVal || !nVal || !cfVal ) {
                    radmToast( 'All password fields are compulsory.', 'warning' );
                    return;
                }

                if ( nVal.length < 6 ) {
                    radmToast( 'New password must be at least 6 characters long.', 'warning' );
                    return;
                }

                if ( nVal !== cfVal ) {
                    radmToast( 'New password and confirmation do not match.', 'error' );
                    return;
                }

                if ( btn ) btn.disabled = true;
                if ( btnText ) btnText.textContent = 'Updating...';

                ajaxPost( 'radm_change_own_password', {
                    current_password: cVal,
                    new_password: nVal,
                    confirm_password: cfVal
                }, function ( res ) {
                    if ( btn ) btn.disabled = false;
                    if ( btnText ) btnText.textContent = 'Update Password';

                    if ( res.success ) {
                        radmToast( res.data.message || 'Password updated successfully!', 'success' );
                        changePwdForm.reset();
                    } else {
                        radmToast( ( res.data && res.data.message ) || 'Failed to update password.', 'error' );
                    }
                } );
            } );
        }

        // Initial Load (only if centers table is present on page)
        if ( document.getElementById( 'radm-centers-tbody' ) ) {
            loadCenters();
        }

    } // end radm-settings

    /* ── Show / Hide Password Toggle ──────────────────────────────────── */
    document.addEventListener( 'click', function ( e ) {
        var toggleBtn = e.target.closest( '.radm-pwd-toggle-btn' );
        if ( toggleBtn ) {
            e.preventDefault();
            var targetId = toggleBtn.getAttribute( 'data-target' );
            var input = targetId ? document.getElementById( targetId ) : null;
            if ( input ) {
                var isPass = input.type === 'password';
                input.type = isPass ? 'text' : 'password';
                toggleBtn.style.color = isPass ? 'var(--radm-green-primary)' : 'var(--radm-text-muted)';
            }
        }
    } );

    /* ── ESC closes any modal ─────────────────────────────────────────── */
    document.addEventListener( 'keydown', function ( e ) {
        if ( e.key === 'Escape' ) {
            if ( typeof closeParticipantModal === 'function' ) closeParticipantModal();
            if ( typeof closeDelModal === 'function' ) closeDelModal();
            if ( typeof closeEditEventModal === 'function' ) closeEditEventModal();
            if ( typeof closeGalleryModal === 'function' ) closeGalleryModal();
            if ( typeof closeGalleryDeleteModal === 'function' ) closeGalleryDeleteModal();
            if ( typeof closeWizardModal === 'function' ) closeWizardModal();
            if ( typeof closeViewModal === 'function' ) closeViewModal();
            if ( typeof closeDeleteModal === 'function' ) closeDeleteModal();
            if ( typeof closeUserAccessModal === 'function' ) closeUserAccessModal();
            if ( typeof closeDeleteUserModal === 'function' ) closeDeleteUserModal();
            if ( typeof closeCreateUserModal === 'function' ) closeCreateUserModal();
            if ( typeof closeResetPwdModal === 'function' ) closeResetPwdModal();
            if ( typeof closeCreateRoleModal === 'function' ) closeCreateRoleModal();
            if ( typeof closeCenterModal === 'function' ) closeCenterModal();
            if ( typeof closeDeleteCenterModal === 'function' ) closeDeleteCenterModal();
            if ( typeof radmCloseMediaPickerModal === 'function' ) radmCloseMediaPickerModal();
            if ( typeof radmDismissOrphanModal === 'function' ) radmDismissOrphanModal();
        }
    } );

    /* ══════════════════════════════════════════════════════════════════════════
       UNIVERSAL IN-PORTAL MEDIA PICKER & ORPHAN DELETION CONTROLLER
       ══════════════════════════════════════════════════════════════════════════ */
    window.radmMediaPickerState = {
        targetUrlId: null,
        targetAttId: null,
        targetPrevId: null,
        targetOldAttId: null,
        onSelectCallback: null,
        selectedItem: null,
        items: [],
        page: 1,
        search: ''
    };

    window.radmOrphanState = {
        attachmentId: 0,
        filename: '',
        onComplete: null
    };

    window.radmOpenDbMediaPicker = function(urlInputId, attInputId, previewId, oldAttInputId, onSelectCallback) {
        window.radmMediaPickerState.targetUrlId       = urlInputId;
        window.radmMediaPickerState.targetAttId       = attInputId;
        window.radmMediaPickerState.targetPrevId      = previewId;
        window.radmMediaPickerState.targetOldAttId    = oldAttInputId;
        window.radmMediaPickerState.onSelectCallback  = onSelectCallback || null;
        window.radmMediaPickerState.selectedItem      = null;

        var modal = document.getElementById('radm-db-media-picker-modal');
        if (!modal) return;

        var selectBtn = document.getElementById('radm-media-picker-select-btn');
        if (selectBtn) selectBtn.disabled = true;

        var infoEl = document.getElementById('radm-media-picker-info');
        if (infoEl) infoEl.innerHTML = '<span>Click an image to select</span>';

        modal.classList.add('radm-modal-open');
        modal.setAttribute('aria-hidden', 'false');

        radmLoadDbMediaItems('');
    };

    window.radmCloseMediaPickerModal = function() {
        var modal = document.getElementById('radm-db-media-picker-modal');
        if (modal) {
            modal.classList.remove('radm-modal-open');
            modal.setAttribute('aria-hidden', 'true');
        }
    };

    window.radmTriggerPickerUpload = function() {
        var fileIn = document.getElementById('radm-universal-file-input');
        if (fileIn) {
            fileIn.value = '';
            fileIn.click();
        }
    };

    window.radmUploadFromLocal = function(urlInputId, attInputId, previewId, oldAttInputId, onSelectCallback) {
        window.radmMediaPickerState.targetUrlId       = urlInputId;
        window.radmMediaPickerState.targetAttId       = attInputId;
        window.radmMediaPickerState.targetPrevId      = previewId;
        window.radmMediaPickerState.targetOldAttId    = oldAttInputId;
        window.radmMediaPickerState.onSelectCallback  = onSelectCallback || null;

        var fileIn = document.getElementById('radm-universal-file-input');
        if (fileIn) {
            fileIn.value = '';
            fileIn.click();
        }
    };

    window.radmHandleUniversalFileSelect = function(fileInput) {
        if (!fileInput.files || !fileInput.files[0]) return;
        var file = fileInput.files[0];

        radmToast('Uploading image directly to database…', 'info');

        var fd = new FormData();
        fd.append('action', 'radm_direct_image_upload');
        fd.append('image_file', file);
        if (window.RADMConfig && window.RADMConfig.nonce) {
            fd.append('nonce', window.RADMConfig.nonce);
        }

        fetch((window.RADMConfig && window.RADMConfig.ajaxUrl) || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: fd
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success && res.data) {
                radmToast('Image uploaded and registered in database!', 'success');
                var data = res.data;

                // Apply to targeted form fields
                radmApplySelectedMedia({
                    id: data.attachment_id,
                    url: data.url,
                    thumb: data.thumb_url || data.url,
                    filename: data.filename,
                    title: data.filename
                });

                // If media picker modal is open, refresh grid
                var modal = document.getElementById('radm-db-media-picker-modal');
                if (modal && modal.classList.contains('radm-modal-open')) {
                    radmLoadDbMediaItems('');
                }
            } else {
                radmToast((res.data && res.data.message) || 'Image upload failed.', 'error');
            }
        })
        .catch(function() {
            radmToast('Network error during image upload.', 'error');
        });
    };

    function radmLoadDbMediaItems(searchQuery) {
        var grid = document.getElementById('radm-media-picker-grid');
        var loading = document.getElementById('radm-media-picker-loading');
        var empty = document.getElementById('radm-media-picker-empty');
        if (!grid) return;

        grid.innerHTML = '';
        if (loading) loading.style.display = 'block';
        if (empty) empty.style.display = 'none';

        var fd = new FormData();
        fd.append('action', 'radm_get_db_images');
        fd.append('search', searchQuery || '');
        fd.append('per_page', '36');
        if (window.RADMConfig && window.RADMConfig.nonce) {
            fd.append('nonce', window.RADMConfig.nonce);
        }

        fetch((window.RADMConfig && window.RADMConfig.ajaxUrl) || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: fd
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (loading) loading.style.display = 'none';
            if (res.success && res.data && res.data.items) {
                var items = res.data.items;
                window.radmMediaPickerState.items = items;

                if (!items.length) {
                    if (empty) empty.style.display = 'block';
                    return;
                }

                items.forEach(function(item) {
                    var el = document.createElement('div');
                    el.className = 'radm-media-grid-item';
                    el.setAttribute('data-id', item.id);
                    el.innerHTML =
                        '<img class="radm-grid-thumb" src="' + escAttr(item.thumb || item.url) + '" alt="' + escAttr(item.title) + '" loading="lazy" />' +
                        '<div class="radm-grid-title" title="' + escAttr(item.title || item.filename) + '">' + escHtml(item.title || item.filename) + '</div>' +
                        '<div class="radm-grid-check">✓</div>';

                    el.addEventListener('click', function() {
                        document.querySelectorAll('.radm-media-grid-item').forEach(function(c) {
                            c.classList.remove('is-selected');
                        });
                        el.classList.add('is-selected');
                        window.radmMediaPickerState.selectedItem = item;

                        var selectBtn = document.getElementById('radm-media-picker-select-btn');
                        if (selectBtn) selectBtn.disabled = false;

                        var infoEl = document.getElementById('radm-media-picker-info');
                        if (infoEl) {
                            infoEl.innerHTML = '<strong>' + escHtml(item.filename) + '</strong> ' + (item.dimensions ? '<span>(' + escHtml(item.dimensions) + ')</span>' : '');
                        }
                    });

                    // Double click to instantly select and confirm
                    el.addEventListener('dblclick', function() {
                        window.radmMediaPickerState.selectedItem = item;
                        radmConfirmMediaPickerSelection();
                    });

                    grid.appendChild(el);
                });
            } else {
                if (empty) empty.style.display = 'block';
            }
        })
        .catch(function() {
            if (loading) loading.style.display = 'none';
            if (empty) empty.style.display = 'block';
        });
    }

    var pickerSearchInput = document.getElementById('radm-media-picker-search');
    if (pickerSearchInput) {
        var pTimer = null;
        pickerSearchInput.addEventListener('input', function() {
            clearTimeout(pTimer);
            var q = this.value;
            pTimer = setTimeout(function() {
                radmLoadDbMediaItems(q);
            }, 300);
        });
    }

    window.radmConfirmMediaPickerSelection = function() {
        var item = window.radmMediaPickerState.selectedItem;
        if (!item) return;

        radmApplySelectedMedia(item);
        radmCloseMediaPickerModal();
    };

    function radmApplySelectedMedia(item) {
        var state = window.radmMediaPickerState;

        if (state.targetUrlId) {
            var urlIn = document.getElementById(state.targetUrlId);
            if (urlIn) urlIn.value = item.url;
        }

        if (state.targetAttId) {
            var attIn = document.getElementById(state.targetAttId);
            if (attIn) attIn.value = item.id;
        }

        if (state.targetPrevId) {
            var prevWrap = document.getElementById(state.targetPrevId);
            if (prevWrap) {
                prevWrap.style.display = 'flex';
                var img = prevWrap.querySelector('img');
                if (img) img.src = item.url;
                var nameEl = prevWrap.querySelector('.radm-image-preview-name');
                if (nameEl) nameEl.textContent = item.filename || item.title || 'Selected Image';
                var urlEl = prevWrap.querySelector('.radm-image-preview-url');
                if (urlEl) urlEl.textContent = item.url;
            }
        }

        if (typeof state.onSelectCallback === 'function') {
            state.onSelectCallback(item);
        }
    }

    window.radmClearSelectedImage = function(urlInputId, attInputId, previewId) {
        if (urlInputId) {
            var u = document.getElementById(urlInputId);
            if (u) u.value = '';
        }
        if (attInputId) {
            var a = document.getElementById(attInputId);
            if (a) a.value = '0';
        }
        if (previewId) {
            var p = document.getElementById(previewId);
            if (p) p.style.display = 'none';
        }
    };

    // ── Orphan Image Detection and Cleanup Prompt ──────────────────────────────
    window.radmCheckAndPromptOrphan = function(oldAttId, currentPostId, callback) {
        oldAttId = parseInt(oldAttId, 10) || 0;
        currentPostId = parseInt(currentPostId, 10) || 0;

        if (!oldAttId || oldAttId <= 0) {
            if (typeof callback === 'function') callback();
            return;
        }

        var fd = new FormData();
        fd.append('action', 'radm_check_attachment_usage');
        fd.append('attachment_id', oldAttId);
        fd.append('current_post_id', currentPostId);
        if (window.RADMConfig && window.RADMConfig.nonce) {
            fd.append('nonce', window.RADMConfig.nonce);
        }

        fetch((window.RADMConfig && window.RADMConfig.ajaxUrl) || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: fd
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success && res.data && !res.data.is_used) {
                // Image is completely unused anywhere else! Prompt for deletion
                window.radmOrphanState.attachmentId = oldAttId;
                window.radmOrphanState.filename     = res.data.filename || ('image #' + oldAttId);
                window.radmOrphanState.onComplete   = callback;

                var fNameEl = document.getElementById('radm-orphan-filename');
                if (fNameEl) fNameEl.textContent = window.radmOrphanState.filename;

                var modal = document.getElementById('radm-orphan-delete-modal');
                if (modal) {
                    modal.classList.add('radm-modal-open');
                    modal.setAttribute('aria-hidden', 'false');
                }
            } else {
                // In use elsewhere or check failed; safely proceed
                if (typeof callback === 'function') callback();
            }
        })
        .catch(function() {
            if (typeof callback === 'function') callback();
        });
    };

    window.radmDismissOrphanModal = function() {
        var modal = document.getElementById('radm-orphan-delete-modal');
        if (modal) {
            modal.classList.remove('radm-modal-open');
            modal.setAttribute('aria-hidden', 'true');
        }
        if (typeof window.radmOrphanState.onComplete === 'function') {
            window.radmOrphanState.onComplete();
        }
    };

    window.radmExecuteOrphanDelete = function() {
        var attId = window.radmOrphanState.attachmentId;
        var btn = document.getElementById('radm-orphan-delete-btn');
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Deleting…';
        }

        var fd = new FormData();
        fd.append('action', 'radm_delete_attachment');
        fd.append('attachment_id', attId);
        if (window.RADMConfig && window.RADMConfig.nonce) {
            fd.append('nonce', window.RADMConfig.nonce);
        }

        fetch((window.RADMConfig && window.RADMConfig.ajaxUrl) || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: fd
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (btn) {
                btn.disabled = false;
                btn.textContent = 'Delete from Storage';
            }
            radmToast('Unused previous image deleted from server storage.', 'success');
            radmDismissOrphanModal();
        })
        .catch(function() {
            if (btn) {
                btn.disabled = false;
                btn.textContent = 'Delete from Storage';
            }
            radmDismissOrphanModal();
        });
    };

    function escHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    function escAttr(str) {
        if (!str) return '';
        return String(str).replace(/"/g, '&quot;');
    }

} )();





