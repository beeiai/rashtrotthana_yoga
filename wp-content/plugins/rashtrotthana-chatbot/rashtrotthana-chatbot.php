<?php
/**
 * Plugin Name: Rashtrotthana Chatbot
 * Plugin URI:  https://rashtrotthana.org
 * Description: A modern, rounded floating chatbot widget powered by client-side FAQ JSON data. No backend required.
 * Version:     1.0.0
 * Author:      Rashtrotthana Yoga
 * License:     GPL-2.0-or-later
 * Text Domain: rashtrotthana-chatbot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'RCHT_VERSION',    '1.0.0' );
define( 'RCHT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RCHT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

function rcht_enqueue_assets(): void {
    wp_enqueue_style(
        'rashtrotthana-chatbot',
        RCHT_PLUGIN_URL . 'assets/css/chatbot.css',
        [],
        RCHT_VERSION
    );
    wp_enqueue_script(
        'rashtrotthana-chatbot',
        RCHT_PLUGIN_URL . 'assets/js/chatbot.js',
        [],
        RCHT_VERSION,
        true
    );
    wp_localize_script(
        'rashtrotthana-chatbot',
        'RCHTConfig',
        [
            'dataUrl'  => RCHT_PLUGIN_URL . 'assets/data/responses.json',
            'botName'  => 'Yoga Assistant',
            'greeting' => 'Namaste \ud83d\ude4f Welcome to Rashtrotthana Yoga! How can I help you today?',
        ]
    );
}
add_action( 'wp_enqueue_scripts', 'rcht_enqueue_assets' );

function rcht_render_chatbot(): void {
    ?>
    <div id="rcht-widget" role="region" aria-label="Chatbot Widget">
        <div id="rcht-window" role="dialog" aria-modal="true" aria-labelledby="rcht-bot-name" aria-hidden="true">
            <div id="rcht-header">
                <div id="rcht-header-info">
                    <div id="rcht-avatar" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 32 32" fill="none">
                          <path d="M16 1 C16.6 7,25 15.4,31 16 C25 16.6,16.6 25,16 31 C15.4 25,7 16.6,1 16 C7 15.4,15.4 7,16 1Z" fill="white" opacity="0.95"/>
                          <circle cx="16" cy="16" r="2.5" fill="white"/>
                        </svg>
                    </div>
                    <div>
                        <div id="rcht-bot-name">Yoga Assistant</div>
                        <div id="rcht-bot-status">Online &middot; Rashtrotthana Yoga</div>
                    </div>
                </div>
                <button id="rcht-close" type="button" aria-label="Close chat">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div id="rcht-messages" role="log" aria-live="polite" aria-atomic="false" aria-label="Chat messages"></div>
            <div id="rcht-quick-replies" aria-label="Quick reply options">
                <button class="rcht-quick-btn" data-query="classes">Classes</button>
                <button class="rcht-quick-btn" data-query="fees">Fees</button>
                <button class="rcht-quick-btn" data-query="location">Location</button>
                <button class="rcht-quick-btn" data-query="timings">Timings</button>
                <button class="rcht-quick-btn" data-query="register">Register</button>
            </div>
            <div id="rcht-input-area">
                <input id="rcht-input" type="text" placeholder="Type your message&hellip;" autocomplete="off" aria-label="Type your message" maxlength="300" />
                <button id="rcht-send" type="button" aria-label="Send message">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>
        <button id="rcht-toggle" type="button" aria-label="Open chat" aria-expanded="false" aria-controls="rcht-window">
            <span id="rcht-toggle-icon-open" aria-hidden="true">
                <!-- Modern AI Star (Gemini-style 4-pointed star) -->
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true">
                  <!-- Main 4-pointed elongated star -->
                  <path d="M16 1
                    C 16.6 7, 25 15.4, 31 16
                    C 25 16.6, 16.6 25, 16 31
                    C 15.4 25, 7 16.6, 1 16
                    C 7 15.4, 15.4 7, 16 1 Z"
                    fill="white" opacity="0.96"/>
                  <!-- Bright inner core -->
                  <circle cx="16" cy="16" r="3" fill="white"/>
                  <!-- Accent dot top-right -->
                  <circle cx="25" cy="7" r="1.8" fill="white" opacity="0.55"/>
                  <!-- Accent dot bottom-left -->
                  <circle cx="7" cy="25" r="1.2" fill="white" opacity="0.35"/>
                </svg>
            </span>
            <span id="rcht-toggle-icon-close" aria-hidden="true" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </span>
            <div id="rcht-tooltip" role="tooltip" aria-hidden="true">Namaste! 🙏 Ask me anything</div>
            <span id="rcht-unread-badge" aria-label="New message" hidden></span>
        </button>
    </div>
    <?php
}
add_action( 'wp_footer', 'rcht_render_chatbot' );
