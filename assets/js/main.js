(function () {
  var toggle = document.getElementById('nav-toggle');
  var nav = document.getElementById('site-nav');
  if (!toggle || !nav) return;
  toggle.addEventListener('click', function () {
    var open = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
})();

(function () {
  var GA_ID = 'G-EKFBCM6EKR';
  var CONSENT_KEY = 'cookie-consent';

  function loadAnalytics() {
    if (window.gaLoaded) return;
    window.gaLoaded = true;
    var s = document.createElement('script');
    s.async = true;
    s.src = 'https://www.googletagmanager.com/gtag/js?id=' + GA_ID;
    document.head.appendChild(s);
    window.dataLayer = window.dataLayer || [];
    function gtag() { window.dataLayer.push(arguments); }
    window.gtag = gtag;
    gtag('js', new Date());
    gtag('config', GA_ID);
  }

  var banner = document.getElementById('cookie-banner');
  if (!banner) return;

  var stored;
  try {
    stored = localStorage.getItem(CONSENT_KEY);
  } catch (e) {
    stored = null;
  }

  if (stored === 'granted') {
    loadAnalytics();
    return;
  }
  if (stored === 'denied') {
    return;
  }

  banner.hidden = false;
  document.body.classList.add('has-cookie-banner');
  var acceptBtn = banner.querySelector('[data-consent-accept]');
  var declineBtn = banner.querySelector('[data-consent-decline]');
  if (acceptBtn) {
    acceptBtn.addEventListener('click', function () {
      try { localStorage.setItem(CONSENT_KEY, 'granted'); } catch (e) {}
      banner.hidden = true;
      document.body.classList.remove('has-cookie-banner');
      loadAnalytics();
    });
  }
  if (declineBtn) {
    declineBtn.addEventListener('click', function () {
      try { localStorage.setItem(CONSENT_KEY, 'denied'); } catch (e) {}
      banner.hidden = true;
      document.body.classList.remove('has-cookie-banner');
    });
  }
})();

(function () {
  var modal = document.getElementById('linkedin-modal');
  var dataScript = document.getElementById('linkedin-feed-data');
  if (!modal || !dataScript) return;

  var posts;
  try {
    posts = JSON.parse(dataScript.textContent);
  } catch (e) {
    return;
  }

  var image = modal.querySelector('.linkedin-modal-image');
  var video = modal.querySelector('.linkedin-modal-video');
  var avatar = modal.querySelector('.linkedin-modal-avatar');
  var author = modal.querySelector('.linkedin-modal-author');
  var date = modal.querySelector('.linkedin-modal-date');
  var text = modal.querySelector('.linkedin-modal-text');
  var link = modal.querySelector('.linkedin-modal-link');
  var lastTrigger = null;

  function escapeHtml(str) {
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  }

  function linkify(str) {
    var urlPattern = /(https?:\/\/[^\s<]+[^\s<.,;:!?)'"])/g;
    return escapeHtml(str).replace(urlPattern, function (url) {
      return '<a href="' + url + '" target="_blank" rel="noopener">' + url + '</a>';
    });
  }

  function open(index) {
    var post = posts[index];
    if (!post) return;
    video.pause();
    if (post.video && post.video.url) {
      video.src = post.video.url;
      if (post.video.thumbnail) { video.poster = post.video.thumbnail; }
      video.hidden = false;
      image.hidden = true;
      image.removeAttribute('src');
    } else if (post.image) {
      image.src = post.image;
      image.hidden = false;
      video.hidden = true;
      video.removeAttribute('src');
    } else {
      image.hidden = true;
      image.removeAttribute('src');
      video.hidden = true;
      video.removeAttribute('src');
    }
    if (post.authorImage) {
      avatar.src = post.authorImage;
      avatar.hidden = false;
    } else {
      avatar.hidden = true;
      avatar.removeAttribute('src');
    }
    author.textContent = post.authorName || 'Grace Pariser';
    date.textContent = post.date;
    text.innerHTML = '';
    post.text.split(/\n{2,}/).forEach(function (para) {
      para = para.trim();
      if (!para) return;
      var p = document.createElement('p');
      p.innerHTML = linkify(para).replace(/\n/g, '<br>');
      text.appendChild(p);
    });
    link.href = post.url;
    modal.hidden = false;
    document.body.style.overflow = 'hidden';
  }

  function close() {
    modal.hidden = true;
    video.pause();
    document.body.style.overflow = '';
    if (lastTrigger) lastTrigger.focus();
  }

  document.querySelectorAll('.linkedin-card-trigger').forEach(function (trigger) {
    trigger.addEventListener('click', function () {
      lastTrigger = trigger;
      open(parseInt(trigger.getAttribute('data-linkedin-index'), 10));
    });
  });

  modal.querySelectorAll('[data-linkedin-close]').forEach(function (el) {
    el.addEventListener('click', close);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !modal.hidden) close();
  });
})();

(function () {
  document.querySelectorAll('[data-copy-url]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var url = btn.getAttribute('data-copy-url');
      var original = btn.textContent;
      var flash = function (text) {
        btn.textContent = text;
        setTimeout(function () { btn.textContent = original; }, 1500);
      };
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function () {
          flash('Copied!');
        }, function () {
          flash('Copy failed');
        });
      } else {
        flash('Copy failed');
      }
    });
  });
})();

(function () {
  function scrollTrack(track, direction) {
    var slide = track.querySelector('.carousel-slide');
    var amount = slide ? slide.getBoundingClientRect().width + 24 : track.clientWidth * 0.8;
    track.scrollBy({ left: amount * direction, behavior: 'smooth' });
  }

  document.querySelectorAll('[data-carousel-prev]').forEach(function (btn) {
    var track = document.getElementById(btn.getAttribute('data-carousel-prev'));
    if (track) btn.addEventListener('click', function () { scrollTrack(track, -1); });
  });

  document.querySelectorAll('[data-carousel-next]').forEach(function (btn) {
    var track = document.getElementById(btn.getAttribute('data-carousel-next'));
    if (track) btn.addEventListener('click', function () { scrollTrack(track, 1); });
  });
})();
