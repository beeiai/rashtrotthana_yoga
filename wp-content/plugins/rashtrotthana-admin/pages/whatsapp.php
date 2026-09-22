<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

radm_portal_header( 'WhatsApp (WATI)', 'Manage WhatsApp messaging and automation via WATI' );
?>

<!-- ── WATI Hero Card ───────────────────────────────────────────────────── -->
<div class="radm-card radm-wati-hero-card">
    <div class="radm-wati-hero-inner">

        <!-- Left: Icon + Info -->
        <div class="radm-wati-hero-content">
            <div class="radm-wati-brand-row">
                <div class="radm-wati-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
                    </svg>
                </div>
                <div class="radm-wati-brand-text">
                    <strong>WATI</strong>
                    <span>WhatsApp Business API Automation</span>
                </div>
            </div>

            <p class="radm-wati-desc">
                Send automated WhatsApp messages, manage campaigns, reply to participants,
                and run broadcasts — all powered by WATI's WhatsApp Business API platform.
            </p>

            <div class="radm-wati-features">
                <div class="radm-wati-feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Automated message flows &amp; chatbots</span>
                </div>
                <div class="radm-wati-feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Bulk broadcast to participants</span>
                </div>
                <div class="radm-wati-feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Template messages &amp; campaigns</span>
                </div>
                <div class="radm-wati-feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Event registration confirmations</span>
                </div>
            </div>

            <!-- CTA Button -->
            <a href="https://app.wati.io" target="_blank" rel="noopener noreferrer"
               class="radm-btn radm-btn-primary radm-wati-cta-btn" id="radm-wati-open-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
                </svg>
                Open WATI Dashboard
                <svg class="radm-wati-ext-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                    <polyline points="15 3 21 3 21 9"/>
                    <line x1="10" y1="14" x2="21" y2="3"/>
                </svg>
            </a>
            <p class="radm-wati-ext-note">Opens in a new tab &nbsp;→&nbsp; app.wati.io</p>
        </div>

        <!-- Right: Decorative visual -->
        <div class="radm-wati-hero-visual" aria-hidden="true">
            <div class="radm-wati-phone-mock">
                <div class="radm-wati-phone-screen">
                    <div class="radm-wati-chat-bubble radm-wati-cb-in">
                        👋 Hello! Thank you for registering for <strong>Yoga Day 2026</strong>.
                    </div>
                    <div class="radm-wati-chat-bubble radm-wati-cb-in">
                        📅 Date: <strong>21 Jun 2026</strong><br>⏰ Time: <strong>6:00 AM</strong>
                    </div>
                    <div class="radm-wati-chat-bubble radm-wati-cb-out">
                        ✅ Confirmed! See you there 🙏
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ── Quick Links ───────────────────────────────────────────────────────── -->
<div class="radm-card" style="margin-top:20px;">
    <div class="radm-card-header">
        <h2>WATI Quick Links</h2>
    </div>
    <div class="radm-wati-quick-links">

        <a href="https://app.wati.io/contacts" target="_blank" rel="noopener noreferrer"
           class="radm-wati-quick-item" id="radm-wati-contacts-link">
            <div class="radm-wati-qi-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                    <path d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
            </div>
            <div class="radm-wati-qi-text">
                <strong>Contacts</strong>
                <span>Manage your WhatsApp contact list</span>
            </div>
            <svg class="radm-wati-qi-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
            </svg>
        </a>

        <a href="https://app.wati.io/broadcast" target="_blank" rel="noopener noreferrer"
           class="radm-wati-quick-item" id="radm-wati-broadcast-link">
            <div class="radm-wati-qi-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 012.11 4.18 2 2 0 014.09 2H7.1a2 2 0 012 1.72c.13 1 .37 2 .72 2.93a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.15-1.15a2 2 0 012.11-.45c.93.35 1.93.59 2.93.72A2 2 0 0122 16.92z"/>
                </svg>
            </div>
            <div class="radm-wati-qi-text">
                <strong>Broadcast</strong>
                <span>Send bulk messages to participants</span>
            </div>
            <svg class="radm-wati-qi-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
            </svg>
        </a>

        <a href="https://app.wati.io/template-messages" target="_blank" rel="noopener noreferrer"
           class="radm-wati-quick-item" id="radm-wati-templates-link">
            <div class="radm-wati-qi-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div class="radm-wati-qi-text">
                <strong>Templates</strong>
                <span>Create &amp; manage message templates</span>
            </div>
            <svg class="radm-wati-qi-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
            </svg>
        </a>

        <a href="https://app.wati.io/automation" target="_blank" rel="noopener noreferrer"
           class="radm-wati-quick-item" id="radm-wati-automation-link">
            <div class="radm-wati-qi-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
            </div>
            <div class="radm-wati-qi-text">
                <strong>Automation</strong>
                <span>Build chatbot flows &amp; auto-replies</span>
            </div>
            <svg class="radm-wati-qi-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
            </svg>
        </a>

    </div>
</div>

<?php radm_portal_footer(); ?>
