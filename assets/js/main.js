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
    if (post.image) {
      image.src = post.image;
      image.hidden = false;
    } else {
      image.hidden = true;
      image.removeAttribute('src');
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
