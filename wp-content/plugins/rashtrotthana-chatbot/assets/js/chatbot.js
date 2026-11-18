/**
 * Rashtrotthana Chatbot — chatbot.js
 * Specific Question-Based Answers & Centre-Specific Assistant
 * Architecture: User Query → Question & Centre Intent Parser → Direct Bullet-Point Response with Clickable Blue Links
 */
(function () {
  'use strict';

  /* ── State ──────────────────────────────────────────────── */
  let faqData        = [];
  let isOpen         = false;
  let isBusy         = false;
  let isExpanded     = false;
  let firstOpen      = true;
  let selectedCentre = null; // Remembers selected centre throughout the session

  /* ── DOM References ─────────────────────────────────────── */
  const toggle    = document.getElementById('rcht-toggle');
  const window_   = document.getElementById('rcht-window');
  const closeBtn  = document.getElementById('rcht-close');
  const expandBtn = document.getElementById('rcht-expand');
  const iconMax   = document.getElementById('rcht-icon-maximize');
  const iconMin   = document.getElementById('rcht-icon-minimize');
  const messages  = document.getElementById('rcht-messages');
  const input     = document.getElementById('rcht-input');
  const sendBtn   = document.getElementById('rcht-send');
  const iconOpen  = document.getElementById('rcht-toggle-icon-open');
  const iconClose = document.getElementById('rcht-toggle-icon-close');
  const badge     = document.getElementById('rcht-unread-badge');
  const tooltip   = document.getElementById('rcht-tooltip');
  const quickBtns = document.querySelectorAll('.rcht-quick-btn');

  /* ── Verified Bangalore Centres List ────────────────────── */
  const ALL_CENTRES = [
    'Sadashivnagar',
    'Jayanagar',
    'Kundalahalli',
    'KG Nagar',
    'Sunkenahalli / Basavanagudi',
    'Vijaynagar',
    'Gayathrinagar',
    'Kamakshipalya',
    'Nagarbhavi',
    'RBI Layout',
    'Girinagar',
    'Kalyana Nagar'
  ];

  /* ── Load Knowledge Base JSON ───────────────────────────── */
  fetch(RCHTConfig.dataUrl)
    .then(function (r) { return r.json(); })
    .then(function (data) { faqData = Array.isArray(data) ? data : []; })
    .catch(function () { faqData = []; });

  /* ── Helpers ─────────────────────────────────────────────── */
  function formatTime() {
    const d = new Date();
    return d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
  }

  function scrollBottom() {
    messages.scrollTop = messages.scrollHeight;
  }

  function isKannada(text) {
    return /[\u0C80-\u0CFF]/.test(text || '');
  }

  function cleanText(str) {
    if (!str || typeof str !== 'string') return '';
    return str
      .toLowerCase()
      .replace(/[^\w\s\u0C80-\u0CFF]/g, ' ')
      .replace(/\s+/g, ' ')
      .trim();
  }

  function decodeUnicodeEscapes(str) {
    if (!str || typeof str !== 'string') return str;
    return str.replace(/\\u([0-9a-fA-F]{4})/g, function (match, grp) {
      return String.fromCharCode(parseInt(grp, 16));
    });
  }

  /* Format raw text into clean HTML spans while preserving clickable links & tags */
  function formatBotText(text) {
    text = decodeUnicodeEscapes(text || '');
    return text
      .split('\n')
      .filter(function (line) { return line.trim() !== ''; })
      .map(function (line) {
        var trimmed = line.trim();

        // Bullet lines: • or -
        if (/^[\u2022\-]\s/.test(trimmed)) {
          var content = trimmed.replace(/^[\u2022\-]\s*/, '');
          return '<span class="rcht-bullet"><span class="rcht-bullet-dot" aria-hidden="true">&#x2022;</span><span class="rcht-bullet-text">' + content + '</span></span>';
        }

        // Numbered lines: 1. 2. 3.
        if (/^\d+\.\s/.test(trimmed)) {
          var num = trimmed.match(/^(\d+)\.\s/)[1];
          var ncontent = trimmed.replace(/^\d+\.\s*/, '');
          return '<span class="rcht-bullet"><span class="rcht-bullet-dot rcht-bullet-num" aria-hidden="true">' + num + '.</span><span class="rcht-bullet-text">' + ncontent + '</span></span>';
        }

        return '<span class="rcht-line">' + trimmed + '</span>';
      })
      .join('');
  }

  /* ── Message Rendering with Interactive Options ─────────── */
  function addMessage(text, role, options) {
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

    if (role === 'bot') {
      bubble.innerHTML = formatBotText(text);

      if (options && options.length > 0) {
        const optsDiv = document.createElement('div');
        optsDiv.className = 'rcht-options';
        options.forEach(function (opt) {
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'rcht-option-btn';
          btn.textContent = opt;

          if (opt.toLowerCase().includes('enquire')) {
            btn.classList.add('rcht-btn-primary');
          }

          btn.addEventListener('click', function () {
            handleUserChoice(opt);
          });
          optsDiv.appendChild(btn);
        });
        bubble.appendChild(optsDiv);
      }
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

  /* ── User Option Click Handler ───────────────────────────── */
  function handleUserChoice(choiceText) {
    if (isBusy) return;
    addMessage(choiceText, 'user');

    const qr = document.getElementById('rcht-quick-replies');
    if (qr) qr.style.display = 'none';

    botReply(choiceText);
  }

  /* ── Typing Indicator ────────────────────────────────────── */
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

  /* ── Centre Identification Helper ────────────────────────── */
  function detectCentre(query) {
    const q = cleanText(query);
    if (!q) return null;

    // Longer keys checked first to avoid substring collision
    const centreRules = [
      { id: 'sadashivnagar', keys: ['sadashivnagar', 'sadashivanagar', 'sankey tank', 'palace orchards'] },
      { id: 'kamakshipalya', keys: ['kamakshipalya', 'basaveshwar nagar', 'vinayaka layout'] },
      { id: 'kundalahalli',  keys: ['kundalahalli', 'aecs layout', 'brookefield', 'whitefield'] },
      { id: 'sunkenahalli',  keys: ['sunkenahalli', 'basavanagudi', 'bull temple', 'basavangudi'] },
      { id: 'gayathrinagar', keys: ['gayathrinagar', 'gayatrinagar', 'siddaramanna'] },
      { id: 'kalyana-nagar', keys: ['kalyana nagar', 'kalyannagar'] },
      { id: 'vijaynagar',    keys: ['vijaynagar', 'vijayanagar', 'mrcr'] },
      { id: 'nagarbhavi',    keys: ['nagarbhavi', 'nagarabhavi', 'nandagokula'] },
      { id: 'rbi-layout',    keys: ['rbi layout', 'jp nagar', 'poornaprajna'] },
      { id: 'girinagar',     keys: ['girinagar', 'aksharam', 'raghavendra mutt'] },
      { id: 'kg-nagar',      keys: ['kg nagar', 'kempegowda nagar', 'keshavashilpa', 'registered office', 'main center'] },
      { id: 'jayanagar',     keys: ['jayanagar', '4th block'] }
    ];

    for (let i = 0; i < centreRules.length; i++) {
      const rule = centreRules[i];
      for (let k = 0; k < rule.keys.length; k++) {
        const key = rule.keys[k];
        if (q.indexOf(key) !== -1) {
          return faqData.find(function (item) {
            return item.center_id === rule.id || item.id === 'center_' + rule.id;
          });
        }
      }
    }
    return null;
  }

  /* ── 62 FAQ Knowledge Base Matcher (Bilingual English / Kannada) ── */
  function findMatchingFaq(userText, qClean) {
    if (!faqData || !faqData.length) return null;
    const isKn = isKannada(userText);

    // 1. Direct Regex match
    for (let i = 0; i < faqData.length; i++) {
      const item = faqData[i];
      if (item.regex_source) {
        try {
          const re = new RegExp(item.regex_source, item.regex_flags || 'i');
          if (re.test(userText)) {
            return {
              faq_id: item.faq_id,
              text: isKn ? (item.answer_kn || item.response_kn || item.response) : (item.answer_en || item.response),
              options: isKn ? ['ಎಲ್ಲಾ ಬೆಂಗಳೂರು ಶಾಖೆಗಳು', 'ವಿಚಾರಣೆ'] : ['All Bangalore Centres', 'Yes, Enquire']
            };
          }
        } catch (e) {}
      }
    }

    // 2. Keyword & phrase score matching
    let bestScore = 0;
    let bestItem = null;

    for (let i = 0; i < faqData.length; i++) {
      const item = faqData[i];
      if (!item.faq_id && (!item.id || !item.id.startsWith('faq_'))) continue;

      let score = 0;
      if (item.keywords && Array.isArray(item.keywords)) {
        for (let k = 0; k < item.keywords.length; k++) {
          const kwClean = cleanText(item.keywords[k]);
          if (!kwClean || kwClean.length < 2) continue;
          if (isKn || kwClean.indexOf(' ') !== -1) {
            if (qClean.indexOf(kwClean) !== -1) {
              score += kwClean.length;
            }
          } else {
            try {
              const reWord = new RegExp('\\b' + kwClean + '\\b', 'i');
              if (reWord.test(qClean)) {
                score += kwClean.length;
              }
            } catch (e) {
              if (qClean.indexOf(kwClean) !== -1) {
                score += kwClean.length;
              }
            }
          }
        }
      }

      if (item.question_en) {
        const qEnClean = cleanText(item.question_en);
        if (qClean === qEnClean) score += 30;
      }

      if (score > bestScore) {
        bestScore = score;
        bestItem = item;
      }
    }

    if (bestItem && bestScore >= 4) {
      return {
        faq_id: bestItem.faq_id,
        text: isKn ? (bestItem.answer_kn || bestItem.response_kn || bestItem.response) : (bestItem.answer_en || bestItem.response),
        options: isKn ? ['ಎಲ್ಲಾ ಬೆಂಗಳೂರು ಶಾಖೆಗಳು', 'ವಿಚಾರಣೆ'] : ['All Bangalore Centres', 'Yes, Enquire']
      };
    }

    return null;
  }

  /* ── Specific Question-Based Conversational Router ───────── */
  function getBotResponse(userText) {
    const q = cleanText(userText);
    const isKn = isKannada(userText);

    // 1. Change Centre
    if (/\b(change|switch|different|other)\s*(centre|center|branch)\b/i.test(userText) || q === 'change centre' || q === 'change center' || /ಶಾಖೆ\s*ಬದಲಾವಣೆ/i.test(userText)) {
      selectedCentre = null;
      return {
        text: isKn ? "ನಮ್ಮ ಬೆಂಗಳೂರಿನ ಶಾಖೆಗಳು:" : "Here are our Bangalore centres:",
        options: ALL_CENTRES
      };
    }

    // 2. Bangalore Centre Listing (Requirement 4)
    if (/(branches\s*(in\s*bangalore)?|all\s*(bangalore\s*)?(centres|centers)|list\s*(all\s*)?(centres|centers)|show\s*(all\s*)?(centres|centers)|bangalore\s*(centres|centers)|where\s*are\s*your\s*(centres|centers))/i.test(userText) || /ಎಲ್ಲಾ\s*ಶಾಖೆಗಳು|ಶಾಖೆಗಳು/i.test(userText)) {
      return {
        text: isKn ? "ನಮ್ಮ ಬೆಂಗಳೂರಿನ ಶಾಖೆಗಳು:" : "Here are our Bangalore centres:",
        options: ALL_CENTRES
      };
    }

    // 3. Enquiry Form Integration (Good Vibes & Broad Detection)
    if (/\b(enquir(y|ies|e)|admission\s*form|enquiry\s*form|enquiry\s*link|how\s+to\s+enquire|contact\s*form|registration\s*form|further\s*quer(y|ies)|have\s+a\s+query|submit\s+enquiry)\b/i.test(userText) || /ವಿಚಾರಣೆ|ವಿಚಾರಣಾ\s*ಫಾರ್ಮ್/i.test(userText) || ((q === 'yes' || q === 'ಹೌದು') && selectedCentre)) {
      if (isKn) {
        return {
          text: "ರಾಷ್ಟ್ರೋತ್ಥಾನ ಯೋಗ ಪರಿವಾರಕ್ಕೆ ನಿಮ್ಮನ್ನು ಪ್ರೀತಿಯಿಂದ ಸ್ವಾಗತಿಸುತ್ತೇವೆ! 🙏✨\n\nತರಗತಿ ಪ್ರವೇಶ, ವೇಳಾಪಟ್ಟಿ ಅಥವಾ ನಿಮ್ಮ ಯಾವುದೇ ಹೆಚ್ಚಿನ ವಿಚಾರಣೆಗಳಿಗೆ ನಮ್ಮ ತಂಡವು ನಿಮಗೆ ಸಂತೋಷದಿಂದ ಮಾರ್ಗದರ್ಶನ ನೀಡುತ್ತದೆ.\n\nದಯವಿಟ್ಟು ಕೆಳಗಿನ ಅಧಿಕೃತ ವಿಚಾರಣೆ ಫಾರ್ಮ್ ಅನ್ನು ಕ್ಲಿಕ್ ಮಾಡಿ ಭರ್ತಿ ಮಾಡಿ:\n\n👉 <a href=\"https://yogaapp.rashtrotthana.org/Account/Enquiry\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">ಅಧಿಕೃತ ವಿಚಾರಣೆ ಫಾರ್ಮ್ ತೆರೆಯಿರಿ</a>",
          options: ['ಮುಂದುವರಿಸಿ', 'ಶಾಖೆ ಬದಲಾವಣೆ']
        };
      }
      return {
        text: "We would love to welcome you to Rashtrotthana Yoga! 🙏✨\n\nFor new admissions, class schedules, or any further queries, our friendly team is always here to assist you.\n\nPlease click below to fill out our quick enquiry form, and we'll be delighted to guide you:\n\n👉 <a href=\"https://yogaapp.rashtrotthana.org/Account/Enquiry\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">Open Official Enquiry Form</a>",
        options: ['Continue Asking Questions', 'Change Centre']
      };
    }

    // 4. Continue Asking Questions Option
    if (/continue\s*asking|ಮುಂದುವರಿಸಿ/i.test(userText)) {
      const name = selectedCentre ? selectedCentre.name : (isKn ? 'ನಮ್ಮ ಯೋಗ ಕೇಂದ್ರಗಳು' : 'our yoga centres');
      if (isKn) {
        return {
          text: "ದಯವಿಟ್ಟು ನಿಮ್ಮ ಪ್ರಶ್ನೆಯನ್ನು ಕೇಳಿ. " + name + " ಕುರಿತು ವಿಳಾಸ, ಸಮಯ, ಸಂಪರ್ಕ ಸಂಖ್ಯೆಗಳು, ಇಮೇಲ್, ಕಾರ್ಯಕ್ರಮಗಳು ಮತ್ತು ಶುಲ್ಕಗಳ ವಿವರಗಳನ್ನು ನಾನು ನೀಡಬಲ್ಲೆ.",
          options: ['ಶಾಖೆ ಬದಲಾವಣೆ', 'ವಿಚಾರಣೆ']
        };
      }
      return {
        text: "Please go ahead and ask your question. I can provide details on " + name + ", including address, timings, contact numbers, email addresses, programs, and fees.",
        options: ['Change Centre', 'Yes, Enquire']
      };
    }

    // 5. Check if user mentioned/selected a centre in this message
    const mentionedCentre = detectCentre(userText);
    if (mentionedCentre) {
      selectedCentre = mentionedCentre;

      // Check if user asked a SPECIFIC attribute question about this centre:
      // a) Contact Number / Phone
      if (/\b(contact|phone|number|mobile|call|telephone)\b/i.test(userText) || /ದೂರವಾಣಿ|ಸಂಪರ್ಕ\s*ಸಂಖ್ಯೆ|ಫೋನ್/i.test(userText)) {
        if (selectedCentre.phones_html) {
          return {
            text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Contact:</b> " + selectedCentre.phones_html,
            options: ['Change Centre', 'Yes, Enquire']
          };
        }
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n\nWe would love to connect you directly with our " + selectedCentre.name + " team! 🙏✨\n\nFor direct contact, class schedules, or admissions, please click below to submit your enquiry:\n\n👉 <a href=\"https://yogaapp.rashtrotthana.org/Account/Enquiry\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">Open Official Enquiry Form</a>",
          options: ['Change Centre', 'Yes, Enquire']
        };
      }

      // b) Email Address
      if (/\b(email|email\s*id|mail|e\s*mail)\b/i.test(userText) || /ಇಮೇಲ್/i.test(userText)) {
        if (selectedCentre.email_html) {
          return {
            text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Email:</b> " + selectedCentre.email_html,
            options: ['Change Centre', 'Yes, Enquire']
          };
        }
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n\nWe would love to assist you with " + selectedCentre.name + "! 🙏✨\n\nFor email enquiries, class schedules, or admissions, please click below to submit your enquiry:\n\n👉 <a href=\"https://yogaapp.rashtrotthana.org/Account/Enquiry\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">Open Official Enquiry Form</a>",
          options: ['Change Centre', 'Yes, Enquire']
        };
      }

      // c) Address / Location / Where
      if (/\b(where|location|address|directions|map|situated)\b/i.test(userText) || /ವಿಳಾಸ|ಸ್ಥಳ|ಎಲ್ಲಿದೆ/i.test(userText)) {
        const mapsHtml = '<a href="' + selectedCentre.maps_url + '" target="_blank" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">View Location</a>';
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Address:</b> " + selectedCentre.address + "\n• <b>Location:</b> " + mapsHtml,
          options: ['Change Centre', 'Yes, Enquire']
        };
      }

      // d) Timings
      if (/\b(timing|timings|time|hours|batch|batches|schedule|when)\b/i.test(userText) || /ಸಮಯ|ವೇಳಾಪಟ್ಟಿ/i.test(userText)) {
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Timings:</b> " + selectedCentre.timings,
          options: ['Change Centre', 'Yes, Enquire']
        };
      }

      // e) Programs
      if (/\b(program|programs|programmes|classes|courses|activities|therapy|what programs)\b/i.test(userText) || /ಕಾರ್ಯಕ್ರಮಗಳು|ತರಗತಿಗಳು/i.test(userText)) {
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Programs:</b> " + selectedCentre.programs,
          options: ['Change Centre', 'Yes, Enquire']
        };
      }

      // Default Basic Selection Response (Requirement 1 & 4: Answer only basic details)
      const mapsHtml = '<a href="' + selectedCentre.maps_url + '" target="_blank" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">View Location</a>';
      return {
        text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Location:</b> " + selectedCentre.address + "\n• <b>Maps:</b> " + mapsHtml,
        options: ['Change Centre', 'Yes, Enquire']
      };
    }

    // 6. Follow-up Questions when a Centre is ALREADY Selected (Requirement 2 & 5)
    if (selectedCentre) {
      // a) Contact Number
      if (/\b(contact|phone|number|mobile|call|telephone)\b/i.test(userText) || /ದೂರವಾಣಿ|ಸಂಪರ್ಕ\s*ಸಂಖ್ಯೆ|ಫೋನ್/i.test(userText)) {
        if (selectedCentre.phones_html) {
          return {
            text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Contact:</b> " + selectedCentre.phones_html,
            options: ['Change Centre', 'Yes, Enquire']
          };
        }
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n\nWe would love to connect you directly with our " + selectedCentre.name + " team! 🙏✨\n\nFor direct contact, class schedules, or admissions, please click below to submit your enquiry:\n\n👉 <a href=\"https://yogaapp.rashtrotthana.org/Account/Enquiry\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">Open Official Enquiry Form</a>",
          options: ['Change Centre', 'Yes, Enquire']
        };
      }

      // b) Email Address
      if (/\b(email|email\s*id|mail|e\s*mail)\b/i.test(userText) || /ಇಮೇಲ್/i.test(userText)) {
        if (selectedCentre.email_html) {
          return {
            text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Email:</b> " + selectedCentre.email_html,
            options: ['Change Centre', 'Yes, Enquire']
          };
        }
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n\nWe would love to assist you with " + selectedCentre.name + "! 🙏✨\n\nFor email enquiries, class schedules, or admissions, please click below to submit your enquiry:\n\n👉 <a href=\"https://yogaapp.rashtrotthana.org/Account/Enquiry\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">Open Official Enquiry Form</a>",
          options: ['Change Centre', 'Yes, Enquire']
        };
      }

      // c) Address / Location / Where
      if (/\b(where|location|address|directions|map|situated)\b/i.test(userText) || /ವಿಳಾಸ|ಸ್ಥಳ|ಎಲ್ಲಿದೆ/i.test(userText)) {
        const mapsHtml = '<a href="' + selectedCentre.maps_url + '" target="_blank" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">View Location</a>';
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Address:</b> " + selectedCentre.address + "\n• <b>Location:</b> " + mapsHtml,
          options: ['Change Centre', 'Yes, Enquire']
        };
      }

      // d) Timings
      if (/\b(timing|timings|time|hours|batch|batches|schedule|when)\b/i.test(userText) || /ಸಮಯ|ವೇಳಾಪಟ್ಟಿ/i.test(userText)) {
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Timings:</b> " + selectedCentre.timings,
          options: ['Change Centre', 'Yes, Enquire']
        };
      }

      // e) Programs
      if (/\b(program|programs|programmes|classes|courses|activities|therapy)\b/i.test(userText) || /ಕಾರ್ಯಕ್ರಮಗಳು|ತರಗತಿಗಳು/i.test(userText)) {
        return {
          text: "• <b>Centre:</b> " + selectedCentre.name + "\n• <b>Programs:</b> " + selectedCentre.programs,
          options: ['Change Centre', 'Yes, Enquire']
        };
      }
    }

    // 7. Match against the 62 FAQ Knowledge Base
    const matchedFaq = findMatchingFaq(userText, q);
    if (matchedFaq) {
      return matchedFaq;
    }

    // 8. General Questions (fees, trial, about - fallback)
    if (/\b(fee|fees|cost|price|charges|how much)\b/i.test(userText)) {
      return {
        text: "• <b>Monthly:</b> ₹800\n• <b>Quarterly:</b> ₹2,100\n• <b>Annual:</b> ₹6,500\n• First class is a <b>FREE trial</b>!",
        options: ['All Bangalore Centres', 'Yes, Enquire']
      };
    }

    if (/\b(trial|free trial|demo)\b/i.test(userText)) {
      return {
        text: "• First-time visitors get a <b>FREE trial class</b>.\n• Please wear loose, comfortable cotton clothing and arrive 10 minutes before batch time.",
        options: ['All Bangalore Centres', 'Yes, Enquire']
      };
    }

    if (/\b(about|who founded|history|established)\b/i.test(userText)) {
      return {
        text: "• Founded in 1972 by <b>Sri Ajith Kumar</b> under Rashtrotthana Parishat.\n• Over 24+ centres across Bengaluru dedicated to holistic health (*Swastha-Susthira Samajanirmanam*).",
        options: ['All Bangalore Centres', 'Yes, Enquire']
      };
    }

    // 9. Greetings / Welcome
    if (/^(hi|hello|hey|namaste|namaskara|namaskar|ನಮಸ್ಕಾರ)[\s!.,?]*$/i.test(userText.trim())) {
      if (isKn) {
        return {
          text: "ನಮಸ್ಕಾರ! 🙏 ರಾಷ್ಟ್ರೋತ್ಥಾನ ಯೋಗಕ್ಕೆ ಸುಸ್ವಾಗತ.\n\nನಮ್ಮ ಯೋಗ ಕೇಂದ್ರಗಳು ಮತ್ತು ಕಾರ್ಯಕ್ರಮಗಳನ್ನು ಅನ್ವೇಷಿಸಲು ನಾವು ನಿಮಗೆ ಸಹಾಯ ಮಾಡುತ್ತೇವೆ.",
          options: ['ಎಲ್ಲಾ ಬೆಂಗಳೂರು ಶಾಖೆಗಳು', 'ಸಮಯ', 'ಶುಲ್ಕ', 'ವಿಚಾರಣೆ']
        };
      }
      return {
        text: "Namaskara! 🙏 Welcome to Rashtrotthana Yoga.\n\nWe help you explore our yoga centres and programs.",
        options: ['All Bangalore Centres', 'Timings', 'Fees', 'Yes, Enquire']
      };
    }

    // 10. Fallback (Warm, Positive Good Vibes)
    if (isKn) {
      return {
        text: "ನಿಮಗೆ ಸಹಾಯ ಮಾಡಲು ನಾವು ಸದಾ ಸಂತೋಷಪಡುತ್ತೇವೆ! 🙏✨\n\nಹೆಚ್ಚಿನ ವಿವರಗಳು ಅಥವಾ ನಿಮ್ಮ ಯಾವುದೇ ಪ್ರಶ್ನೆಗಳಿಗೆ ನಮ್ಮ ತಂಡವು ನಿಮಗೆ ಪ್ರೀತಿಯಿಂದ ಮಾರ್ಗದರ್ಶನ ನೀಡುತ್ತದೆ.\n\nದಯವಿಟ್ಟು ನಮ್ಮ ಅಧಿಕೃತ ವಿಚಾರಣೆ ಫಾರ್ಮ್ ಮೂಲಕ ನಮ್ಮನ್ನು ಸಂಪರ್ಕಿಸಿ:\n\n👉 <a href=\"https://yogaapp.rashtrotthana.org/Account/Enquiry\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">ಅಧಿಕೃತ ವಿಚಾರಣೆ ಫಾರ್ಮ್ ತೆರೆಯಿರಿ</a>",
        options: ['ಎಲ್ಲಾ ಬೆಂಗಳೂರು ಶಾಖೆಗಳು', 'ವಿಚಾರಣೆ']
      };
    }
    return {
      text: "We would love to help you with that! 🙏✨\n\nFor this specific detail or any further queries, our friendly team will be glad to assist you personally.\n\nFeel free to connect with us through our quick enquiry form:\n\n👉 <a href=\"https://yogaapp.rashtrotthana.org/Account/Enquiry\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"rcht-blue-link\">Open Official Enquiry Form</a>",
      options: ['All Bangalore Centres', 'Yes, Enquire']
    };
  }

  /* ── Bot Reply Execution ─────────────────────────────────── */
  function botReply(userText) {
    if (isBusy) return;
    isBusy = true;
    sendBtn.disabled = true;

    const result = getBotResponse(userText);
    const delay = 350 + Math.random() * 200;

    showTyping();

    setTimeout(function () {
      hideTyping();
      addMessage(result.text, 'bot', result.options);
      isBusy = false;
      sendBtn.disabled = false;
      input.focus();
    }, delay);
  }

  /* ── User Input Send ─────────────────────────────────────── */
  function handleSend() {
    const text = input.value.trim();
    if (!text || isBusy) return;

    addMessage(text, 'user');
    input.value = '';

    const qr = document.getElementById('rcht-quick-replies');
    if (qr) qr.style.display = 'none';

    botReply(text);
  }

  /* ── Fullscreen / Maximize Toggle ───────────────────────── */
  function toggleFullscreen() {
    isExpanded = !isExpanded;
    if (isExpanded) {
      window_.classList.add('rcht-fullscreen');
      if (expandBtn) {
        expandBtn.setAttribute('aria-label', 'Exit full screen');
        expandBtn.setAttribute('title', 'Exit Full Page');
      }
      if (iconMax) iconMax.style.display = 'none';
      if (iconMin) iconMin.style.display = 'inline-block';
    } else {
      window_.classList.remove('rcht-fullscreen');
      if (expandBtn) {
        expandBtn.setAttribute('aria-label', 'Toggle full page');
        expandBtn.setAttribute('title', 'Toggle Full Page / Normal Size');
      }
      if (iconMax) iconMax.style.display = 'inline-block';
      if (iconMin) iconMin.style.display = 'none';
    }
    scrollBottom();
  }

  /* ── Open / Close Chat Window ────────────────────────────── */
  function openChat() {
    isOpen = true;
    hideTooltip();
    window_.classList.add('rcht-open');
    window_.setAttribute('aria-hidden', 'false');
    toggle.setAttribute('aria-label', 'Close chat');
    toggle.setAttribute('aria-expanded', 'true');
    iconOpen.style.display  = 'none';
    iconClose.style.display = 'flex';
    badge.hidden = true;

    if (firstOpen) {
      firstOpen = false;
      setTimeout(function () {
        addMessage(
          RCHTConfig.greeting,
          'bot',
          ['All Bangalore Centres', 'Timings', 'Fees', 'Yes, Enquire']
        );
      }, 250);
    }

    setTimeout(function () { input.focus(); }, 300);
  }

  function closeChat() {
    isOpen = false;
    window_.classList.remove('rcht-open');
    window_.setAttribute('aria-hidden', 'true');
    if (isExpanded) {
      toggleFullscreen();
    }
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
  if (expandBtn) {
    expandBtn.addEventListener('click', toggleFullscreen);
  }
  sendBtn.addEventListener('click', handleSend);

  input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      handleSend();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && isOpen) closeChat();
  });

  quickBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      const query = btn.getAttribute('data-query');
      input.value = query;
      handleSend();
    });
  });

  // Show unread badge after 4 s if chat not opened
  setTimeout(function () {
    if (!isOpen) {
      badge.hidden = false;
    }
  }, 4000);

  /* ── Attention-Seeking Sequence ──────────────────────────── */
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

  setTimeout(function () {
    showTooltip();
  }, 1500);

})();
