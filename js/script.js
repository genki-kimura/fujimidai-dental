/* ----------------------------------------
smooth scroll
---------------------------------------- */
// #で始まるリンクを取得
const jsSmoothScroll = document.querySelectorAll('a[href^="#"]');

// forで回してaddEventListenerする
for (let i = 0; i < jsSmoothScroll.length; i++){
  jsSmoothScroll[i].addEventListener('click', (e) => {
    e.preventDefault();
    // href属性の取得
    let href = jsSmoothScroll[i].getAttribute('href');
    let target = document.getElementById(href.replace('#', ''));
    if (!target) return; // 移動先がない（href="#" など）場合は何もしない
    const rect = target.getBoundingClientRect().top;
    const offset = window.pageYOffset -0;
    // 移動先のポジション取得
    const position = rect + offset;
    // window.scrollToでスクロール
    window.scrollTo({
      top: position,
      behavior: 'smooth',
    });
  });
}

// ハンバーガーメニューの開閉
(function () {
  var toggle = document.querySelector('.header__toggle');
  var nav = document.getElementById('header-menu');
  if (!toggle || !nav) return;
 
  // _sec00-Header.scss の $header-bp と同じ値にしてください
  var pcQuery = window.matchMedia('(min-width: 1200px)');
 
  function setOpen(open) {
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? 'メニューを閉じる' : 'メニューを開く');
    nav.classList.toggle('is-open', open);
    document.body.classList.toggle('is-menu-open', open);
  }
 
  toggle.addEventListener('click', function () {
    setOpen(toggle.getAttribute('aria-expanded') !== 'true');
  });
 
  // メニュー内のリンクを押したら閉じる（ページ内リンク対策）
  nav.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () { setOpen(false); });
  });
 
  // Escキーで閉じる
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') setOpen(false);
  });
 
  // PC幅に戻ったら閉じた状態にリセット
  pcQuery.addEventListener('change', function (e) {
    if (e.matches) setOpen(false);
  });
})();

/* ----------------------------------------
MV 写真の自動切り替え
---------------------------------------- */
(function () {
  var mv = document.querySelector('.Mv');
  if (!mv) return;

  var photos = mv.querySelectorAll('.Mv__photo');
  var thumbs = mv.querySelectorAll('.Mv__thumb');
  if (photos.length < 2 || photos.length !== thumbs.length) return;

  var INTERVAL = 5000; // 切り替わるまでの時間（ミリ秒）
  var current = 0;
  var timer = null;
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

  // index 番目の写真を表示し、対応する小さい写真だけ暗くする（is-active）
  function show(index) {
    current = index;
    photos.forEach(function (photo, i) {
      photo.classList.toggle('is-active', i === index);
      photo.setAttribute('aria-hidden', i === index ? 'false' : 'true');
    });
    thumbs.forEach(function (thumb, i) {
      thumb.classList.toggle('is-active', i === index);
      thumb.setAttribute('aria-current', i === index ? 'true' : 'false');
    });
  }

  function next() {
    show((current + 1) % photos.length);
  }

  function stop() {
    if (timer) {
      clearInterval(timer);
      timer = null;
    }
  }

  function start() {
    stop();
    // 動きを減らす設定の人・タブが裏に隠れている間は自動で切り替えない
    if (reduceMotion.matches || document.hidden) return;
    timer = setInterval(next, INTERVAL);
  }

  // 小さい写真をクリックしたら、その写真に切り替えて、時間を数え直す
  thumbs.forEach(function (thumb, i) {
    thumb.addEventListener('click', function () {
      show(i);
      start();
    });
  });

  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      stop();
    } else {
      start();
    }
  });

  show(0);
  start();
})();

/* ----------------------------------------
Post（Instagram 新着投稿）のスライダー
・次の投稿が真ん中にくるように、ぐるぐる回り続けます（最後の次は最初に戻る）
・矢印・丸い点・横スワイプ・自動切り替えで動きます
---------------------------------------- */
(function () {
  var root = document.querySelector('.Post');
  if (!root) return;

  var slider = root.querySelector('.Post__slider');
  var viewport = root.querySelector('.Post__viewport');
  var list = root.querySelector('.Post__list');
  var originals = Array.prototype.slice.call(root.querySelectorAll('.Post__item'));
  var prev = root.querySelector('.Post__arrow--prev');
  var next = root.querySelector('.Post__arrow--next');
  var dots = root.querySelectorAll('.Post__dot');
  var total = originals.length;
  if (!slider || !viewport || !list || total < 2) return;

  var INTERVAL = 4000; // 自動で切り替わるまでの時間（ミリ秒）
  var START = 0;       // 最初に真ん中に来る投稿（0 = 1枚目）
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

  // 左右に同じカードを増やして、端が見えても途切れないようにする
  var sets = Math.ceil(5 / total);
  function makeClone(item) {
    var clone = item.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    clone.querySelectorAll('a').forEach(function (a) { a.tabIndex = -1; });
    return clone;
  }
  var before = document.createDocumentFragment();
  var after = document.createDocumentFragment();
  for (var s = 0; s < sets; s++) {
    originals.forEach(function (item) {
      before.appendChild(makeClone(item));
      after.appendChild(makeClone(item));
    });
  }
  list.insertBefore(before, originals[0]);
  list.appendChild(after);
  list.querySelectorAll('img').forEach(function (img) { img.loading = 'eager'; });

  var items = list.querySelectorAll('.Post__item');
  var base = sets * total;     // 本物の1枚目の番号
  var index = base + START;    // いま真ん中にあるカードの番号
  var moving = false;
  var timer = null;
  var autoTimer = null;
  var fallbackTimer = null;

  // index 番目のカードが、見える範囲の真ん中にくる位置
  function setPosition(animate) {
    var el = items[index];
    var x = viewport.clientWidth / 2 - (el.offsetLeft + el.offsetWidth / 2);
    if (!animate) list.style.transition = 'none';
    list.style.transform = 'translate3d(' + x + 'px, 0, 0)';
    if (!animate) {
      void list.offsetWidth; // 動きなしで反映させる
      list.style.transition = '';
    }
  }

  function currentDot() {
    return (((index - base) % total) + total) % total;
  }

  function updateDots() {
    var active = currentDot();
    dots.forEach(function (dot, i) {
      dot.classList.toggle('is-active', i === active);
      if (i === active) {
        dot.setAttribute('aria-current', 'true');
      } else {
        dot.removeAttribute('aria-current');
      }
    });
  }

  // 増やしたカードのところまで動いたら、動きなしで本物の位置へ戻す
  function finish() {
    clearTimeout(fallbackTimer);
    while (index < base) index += total;
    while (index >= base + total) index -= total;
    setPosition(false);
    moving = false;
  }

  function go(target) {
    if (moving) return;
    moving = true;
    index = target;
    updateDots();
    if (reduceMotion.matches) {
      setPosition(false);
      finish();
      return;
    }
    setPosition(true);
    fallbackTimer = setTimeout(finish, 800); // transitionend が来なかったとき用
  }

  list.addEventListener('transitionend', function (e) {
    if (e.target === list && e.propertyName === 'transform') finish();
  });

  function stopAuto() {
    if (autoTimer) {
      clearInterval(autoTimer);
      autoTimer = null;
    }
  }

  function startAuto() {
    stopAuto();
    // 動きを減らす設定の人・タブが裏に隠れている間は自動で切り替えない
    if (reduceMotion.matches || document.hidden) return;
    autoTimer = setInterval(function () { go(index + 1); }, INTERVAL);
  }

  if (next) next.addEventListener('click', function () { go(index + 1); startAuto(); });
  if (prev) prev.addEventListener('click', function () { go(index - 1); startAuto(); });

  // 丸い点：近い方向に回って、その投稿を真ん中へ
  dots.forEach(function (dot, i) {
    dot.addEventListener('click', function () {
      var diff = i - currentDot();
      if (diff > total / 2) diff -= total;
      if (diff < -total / 2) diff += total;
      if (diff !== 0) go(index + diff);
      startAuto();
    });
  });

  // 横スワイプ
  var touchX = null;
  viewport.addEventListener('touchstart', function (e) {
    touchX = e.touches[0].clientX;
  }, { passive: true });
  viewport.addEventListener('touchend', function (e) {
    if (touchX === null) return;
    var dx = e.changedTouches[0].clientX - touchX;
    touchX = null;
    if (Math.abs(dx) < 40) return;
    go(index + (dx < 0 ? 1 : -1));
    startAuto();
  }, { passive: true });

  // マウスを乗せている間・キーボードで操作している間は止める
  slider.addEventListener('pointerenter', function (e) {
    if (e.pointerType === 'mouse') stopAuto();
  });
  slider.addEventListener('pointerleave', function (e) {
    if (e.pointerType === 'mouse') startAuto();
  });
  slider.addEventListener('focusin', stopAuto);
  slider.addEventListener('focusout', startAuto);

  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      stopAuto();
    } else {
      startAuto();
    }
  });

  window.addEventListener('resize', function () { setPosition(false); });
  window.addEventListener('load', function () { setPosition(false); });

  slider.classList.add('is-ready');
  setPosition(false);
  updateDots();
  startAuto();
})();

/* ----------------------------------------
FAQ（よくあるご質問）の開閉
・質問をクリックすると、＋ → － に変わって答えが開く
・もう一度クリックすると閉じる
---------------------------------------- */
(function () {
  var root = document.querySelector('.FAQ');
  if (!root) return;

  root.querySelectorAll('.FAQ__q').forEach(function (button) {
    var answer = document.getElementById(button.getAttribute('aria-controls'));
    if (!answer) return;

    button.addEventListener('click', function () {
      var open = button.getAttribute('aria-expanded') !== 'true';
      button.setAttribute('aria-expanded', open ? 'true' : 'false');
      answer.classList.toggle('is-open', open);
    });
  });
})();
 

/* ----------------------------------------
FAQブロック（blocks/block-faq.php）の開閉
・質問をクリックすると、＋ → － に変わって答えが開く
・もう一度クリックすると閉じる
・ページ内にブロックがいくつあっても、まとめて動く
---------------------------------------- */
(function () {
  document.addEventListener('click', function (e) {
    var button = e.target.closest ? e.target.closest('.faq-box-q, .supervisor-box-q') : null;
    if (!button) return;

    var answer = document.getElementById(button.getAttribute('aria-controls'));
    if (!answer) return;

    var open = button.getAttribute('aria-expanded') !== 'true';
    button.setAttribute('aria-expanded', open ? 'true' : 'false');
    answer.classList.toggle('is-open', open);
  });
})();
 