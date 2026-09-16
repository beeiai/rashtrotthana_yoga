/**
 * Rashtrotthana Chatbot — chatbot.js
 * Architecture: User → WordPress Frontend → Chatbot UI → JS Logic → JSON Data → Response
 */
(function () {
  'use strict';

  /* ── State ──────────────────────────────────────────────── */
  let faqData   = [];
  let isOpen    = false;
  let isBusy    = false;
  let firstOpen = true;

  /* ── DOM References ─────────────────────────────────────── */
  const toggle    = document.getElementById('rcht-toggle');
  const window_   = document.getElementById('rcht-window');
  const closeBtn  = document.getElementById('rcht-close');
  const messages  = document.getElementById('rcht-messages');
  const input     = document.getElementById('rcht-input');
  const sendBtn   = document.getElementById('rcht-send');
  const iconOpen  = document.getElementById('rcht-toggle-icon-open');
  const iconClose = document.getElementById('rcht-toggle-icon-close');
  const badge     = document.getElementById('rcht-unread-badge');
  const tooltip   = document.getElementById('rcht-tooltip');
  const quickBtns = document.querySelectorAll('.rcht-quick-btn');

  /* ── Load FAQ JSON data ─────────────────────────────────── */
  fetch(RCHTConfig.dataUrl)
    .then(function (r) { return r.json(); })
    .then(function (data) { faqData = data; })
    .catch(function () { faqData = []; });

  /* ── Helpers ─────────────────────────────────────────────── */
  function formatTime() {
    const d = new Date();
    return d.getHours().toString().padStart(2,'0') + ':' + d.getMinutes().toString().padStart(2,'0');
  }

  function scrollBottom() {
    messages.scrollTop = messages.scrollHeight;
  }

  /* Format raw bot text into clean HTML:
     - converts \n to structured spans
     - wraps bullet lines (• or -) in rcht-bullet spans
     - wraps numbered lines (1. 2.) in rcht-bullet spans
     - wraps plain text lines in rcht-line spans
     - preserves existing <b> tags */
  function formatBotText(text) {
    return text
      .split('\n')
      .filter(function (line) { return line.trim() !== ''; }) // skip blank lines between blocks
      .map(function (line) {
        var trimmed = line.trim();

        // Bullet lines: • or -
        if (/^[\u2022\-]\s/.test(trimmed)) {
          var content = trimmed.replace(/^[\u2022\-]\s*/, '');
          return '<span class="rcht-bullet"><span class="rcht-bullet-dot" aria-hidden="true">&#x2022;</span><span class="rcht-bullet-text">' + content + '</span></span>';
        }

        // Numbered lines: 1. 2. 3.
        if (/^\d+\.\s/.test(trimmed)) {
          var num    = trimmed.match(/^(\d+)\.\s/)[1];
          var ncontent = trimmed.replace(/^\d+\.\s*/, '');
          return '<span class="rcht-bullet"><span class="rcht-bullet-dot rcht-bullet-num" aria-hidden="true">' + num + '.</span><span class="rcht-bullet-text">' + ncontent + '</span></span>';
        }

        // Everything else: plain line (may contain <b> tags)
        return '<span class="rcht-line">' + trimmed + '</span>';
      })
      .join('');
  }

  function addMessage(text, role) {
    // Build row
    const row = document.createElement('div');
    row.className = 'rcht-row rcht-' + role;

    if (role === 'bot') {
      const av = document.createElement('div');
      av.className = 'rcht-row-avatar';
      av.setAttribute('aria-hidden', 'true');
      av.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32" fill="none"><path d="M16 1 C16.6 7,25 15.4,31 16 C25 16.6,16.6 25,16 31 C15.4 25,7 16.6,1 16 C7 15.4,15.4 7,16 1Z" fill="white" opacity="0.95"/><circle cx="16" cy="16" r="2.5" fill="white"/></svg>';
      row.appendChild(av);
    }

    const bubble = document.createElement('div');
    bubble.className = 'rcht-bubble';
    // Bot: parse and format; User: escape for safety
    if (role === 'bot') {
      bubble.innerHTML = formatBotText(text);
    } else {
      bubble.textContent = text;
    }
    row.appendChild(bubble);

    messages.appendChild(row);

    // Timestamp
    const time = document.createElement('div');
    time.className = 'rcht-time';
    time.textContent = formatTime();
    messages.appendChild(time);

    scrollBottom();
  }

  /* Typing indicator */
  function showTyping() {
    let indicator = document.getElementById('rcht-typing');
    if (!indicator) {
      indicator = document.createElement('div');
      indicator.id = 'rcht-typing';
      indicator.setAttribute('aria-label', 'Bot is typing');
      indicator.setAttribute('aria-live', 'polite');

      const av = document.createElement('div');
      av.className = 'rcht-row-avatar';
      av.setAttribute('aria-hidden', 'true');
      av.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32" fill="none"><path d="M16 1 C16.6 7,25 15.4,31 16 C25 16.6,16.6 25,16 31 C15.4 25,7 16.6,1 16 C7 15.4,15.4 7,16 1Z" fill="white" opacity="0.95"/><circle cx="16" cy="16" r="2.5" fill="white"/></svg>';

      const dots = document.createElement('div');
      dots.className = 'rcht-typing-dots';
      for (let i = 0; i < 3; i++) {
        dots.appendChild(document.createElement('span'));
      }

      indicator.appendChild(av);
      indicator.appendChild(dots);
      messages.appendChild(indicator);
    }
    indicator.classList.add('rcht-visible');
    scrollBottom();
  }

  function hideTyping() {
    const indicator = document.getElementById('rcht-typing');
    if (indicator) indicator.classList.remove('rcht-visible');
  }

  /* ── FAQ Matching Engine ────────────────────────────────── */
  function findResponse(query) {
    const q = query.toLowerCase().trim();
    if (!q) return null;

    let best     = null;
    let bestScore = 0;

    faqData.forEach(function (item) {
      const keywords = item.keywords || [];
      let score = 0;

      keywords.forEach(function (kw) {
        if (q.includes(kw.toLowerCase())) score++;
      });

      if (score > bestScore) {
        bestScore = score;
        best = item;
      }
    });

    return bestScore > 0 ? best : null;
  }

  /* ── Bot Reply Logic ─────────────────────────────────────── */
  function botReply(userText) {
    if (isBusy) return;
    isBusy = true;
    sendBtn.disabled = true;

    const matched = findResponse(userText);
    const replyText = matched
      ? matched.response
      : "I'm sorry, I didn't quite understand that. Please try asking about our <b>classes</b>, <b>fees</b>, <b>timings</b>, <b>location</b>, or <b>registration</b>.";

    const delay = 700 + Math.random() * 600;

    showTyping();

    setTimeout(function () {
      hideTyping();
      addMessage(replyText, 'bot');
      isBusy = false;
      sendBtn.disabled = false;
      input.focus();
    }, delay);
  }

  /* ── Handle User Send ───────────────────────────────────── */
  function handleSend() {
    const text = input.value.trim();
    if (!text || isBusy) return;

    addMessage(text, 'user');
    input.value = '';

    // Hide quick replies after first real message
    const qr = document.getElementById('rcht-quick-replies');
    if (qr) qr.style.display = 'none';

    botReply(text);
  }

  /* ── Open / Close ─────────────────────────────────────────── */
  function openChat() {
    isOpen = true;
    window_.classList.add('rcht-open');
    window_.setAttribute('aria-hidden', 'false');
    toggle.setAttribute('aria-label', 'Close chat');
    toggle.setAttribute('aria-expanded', 'true');
    iconOpen.style.display  = 'none';
    iconClose.style.display = 'flex';
    badge.hidden = true;

    if (firstOpen) {
      firstOpen = false;
      // Greeting from bot
      setTimeout(function () {
        addMessage(RCHTConfig.greeting, 'bot');
      }, 280);
    }

    setTimeout(function () { input.focus(); }, 320);
  }

  function closeChat() {
    isOpen = false;
    window_.classList.remove('rcht-open');
    window_.setAttribute('aria-hidden', 'true');
    toggle.setAttribute('aria-label', 'Open chat');
    toggle.setAttribute('aria-expanded', 'false');
    iconOpen.style.display  = 'flex';
    iconClose.style.display = 'none';
    toggle.focus();
  }

  /* ── Event Listeners ─────────────────────────────────────── */
  toggle.addEventListener('click', function () {
    if (isOpen) { closeChat(); } else { openChat(); }
  });

  closeBtn.addEventListener('click', closeChat);

  sendBtn.addEventListener('click', handleSend);

  input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      handleSend();
    }
  });

  // Keyboard: Escape closes the window
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && isOpen) closeChat();
  });

  // Quick reply chips
  quickBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      const query = btn.getAttribute('data-query');
      input.value = query;
      handleSend();
    });
  });

  // Show unread badge after 4 s if chat is still closed
  setTimeout(function () {
    if (!isOpen) {
      badge.hidden = false;
    }
  }, 4000);

  /* ── Attention-Seeking Sequence ──────────────────────────────── */
  // After entrance animation (0.5s delay + 0.7s anim = 1.2s),
  // show tooltip bubble for 4 s, then start periodic wiggle every 7 s.
  var attentionTimer = null;

  function showTooltip() {
    if (isOpen || !tooltip) return;
    tooltip.setAttribute('aria-hidden', 'false');
    tooltip.classList.add('rcht-tooltip-visible');
    setTimeout(hideTooltip, 4000);
  }

  function hideTooltip() {
    if (!tooltip) return;
    tooltip.classList.remove('rcht-tooltip-visible');
    tooltip.setAttribute('aria-hidden', 'true');
  }

  function doWiggle() {
    if (isOpen) return;
    toggle.classList.remove('rcht-wiggle');
    // Force reflow so animation re-triggers
    void toggle.offsetWidth;
    toggle.classList.add('rcht-wiggle');
    toggle.addEventListener('animationend', function onEnd() {
      toggle.classList.remove('rcht-wiggle');
      toggle.removeEventListener('animationend', onEnd);
    }, { once: true });
  }

  function startAttentionLoop() {
    if (isOpen) return;
    // First nudge: tooltip after 1.5 s
    setTimeout(function () {
      if (!isOpen) showTooltip();
    }, 1500);
    // Wiggle every 7 s
    attentionTimer = setInterval(function () {
      if (isOpen) {
        clearInterval(attentionTimer);
        return;
      }
      doWiggle();
      setTimeout(function () { if (!isOpen) showTooltip(); }, 600);
    }, 7000);
  }

  // Kick off after the entrance animation completes
  setTimeout(startAttentionLoop, 1300);

  // Stop all attention effects once the chat is opened
  var origOpen = openChat;
  openChat = function () {
    clearInterval(attentionTimer);
    hideTooltip();
    origOpen();
  };
  toggle.addEventListener('click', function () {}, { once: true }); // ensure re-binding

})();
