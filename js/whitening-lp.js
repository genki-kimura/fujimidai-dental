/* ホワイトニングLP：メインビジュアルの「施術実績」数字をカウントアップ */
(function () {
  'use strict';
 
  var targets = document.querySelectorAll('[data-countup]');
  if (!targets.length) return;
 
  // 動きを減らす設定の人には、そのまま数字を表示（HTMLに最終値が入っています）
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
 
  var DURATION = 1600;
 
  function easeOutCubic(t) {
    return 1 - Math.pow(1 - t, 3);
  }
 
  function run(el) {
    var end = parseInt(el.getAttribute('data-countup'), 10);
    if (isNaN(end)) return;
    var start = null;
 
    function step(ts) {
      if (start === null) start = ts;
      var p = Math.min((ts - start) / DURATION, 1);
      el.textContent = Math.round(end * easeOutCubic(p));
      if (p < 1) {
        requestAnimationFrame(step);
      } else {
        el.textContent = end;
      }
    }
 
    el.textContent = 0;
    requestAnimationFrame(step);
  }
 
  if (!('IntersectionObserver' in window)) return;
 
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        run(entry.target);
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.6 });
 
  targets.forEach(function (el) { io.observe(el); });
})();

/* ホワイトニングLP：症例の Before/After スライダー
   ・中央のつまみをドラッグ（画像の上をドラッグ／タップでも動きます）
   ・つまみにフォーカスして ← → キーでも動かせます
   ・左右の矢印で症例を切り替え */
(function () {
  'use strict';

  var viewers = document.querySelectorAll('[data-case-viewer]');
  if (!viewers.length) return;

  function clamp(n) { return Math.max(0, Math.min(100, n)); }

  // つまみの線が BEFORE / AFTER の文字にかかったら、その文字を隠す
  // （かかってから端に着くまで、ずっと隠したままにする）
  var TAG_MARGIN = 8; // 文字の少し手前から隠し始める(px)
  function updateTags(compare, pos) {
    var width = compare.clientWidth;
    if (!width) return;
    var x = (pos / 100) * width;
    compare.querySelectorAll('.wl-case__tag').forEach(function (tag) {
      var left = tag.offsetLeft;
      var right = left + tag.offsetWidth;
      var hide;
      if (tag.classList.contains('wl-case__tag--before')) {
        // BEFORE（左）：線が文字の右端より左にきたら、左端まで隠す
        hide = x - TAG_MARGIN < right;
      } else {
        // AFTER（右）：線が文字の左端より右にきたら、右端まで隠す
        hide = x + TAG_MARGIN > left;
      }
      tag.classList.toggle('is-hidden', hide);
    });
  }

  function setPos(compare, value) {
    var pos = clamp(value);
    compare.style.setProperty('--pos', pos + '%');
    compare.dataset.pos = pos;
    var handle = compare.querySelector('[data-handle]');
    if (handle) handle.setAttribute('aria-valuenow', Math.round(pos));
    updateTags(compare, pos);
  }

  function initCompare(compare) {
    var dragging = false;

    function fromEvent(e) {
      var rect = compare.getBoundingClientRect();
      setPos(compare, ((e.clientX - rect.left) / rect.width) * 100);
    }

    compare.addEventListener('pointerdown', function (e) {
      if (e.button !== undefined && e.button !== 0) return;
      dragging = true;
      try { compare.setPointerCapture(e.pointerId); } catch (err) {}
      fromEvent(e);
    });
    compare.addEventListener('pointermove', function (e) {
      if (dragging) fromEvent(e);
    });
    function end(e) {
      dragging = false;
      try { compare.releasePointerCapture(e.pointerId); } catch (err) {}
    }
    compare.addEventListener('pointerup', end);
    compare.addEventListener('pointercancel', end);

    var handle = compare.querySelector('[data-handle]');
    if (handle) {
      handle.addEventListener('keydown', function (e) {
        var now = parseFloat(handle.getAttribute('aria-valuenow')) || 50;
        if (e.key === 'ArrowLeft') { setPos(compare, now - 5); e.preventDefault(); }
        if (e.key === 'ArrowRight') { setPos(compare, now + 5); e.preventDefault(); }
        if (e.key === 'Home') { setPos(compare, 0); e.preventDefault(); }
        if (e.key === 'End') { setPos(compare, 100); e.preventDefault(); }
      });
    }
  }

  viewers.forEach(function (viewer) {
    var slides = viewer.querySelectorAll('[data-case-slide]');
    var prev = viewer.querySelector('[data-case-prev]');
    var next = viewer.querySelector('[data-case-next]');
    var current = 0;

    slides.forEach(function (slide) {
      var compare = slide.querySelector('[data-compare]');
      if (compare) initCompare(compare);
    });

    // 画面サイズが変わったときも、文字の表示/非表示を合わせ直す
    window.addEventListener('resize', function () {
      viewer.querySelectorAll('[data-compare]').forEach(function (compare) {
        updateTags(compare, parseFloat(compare.dataset.pos) || 50);
      });
    });

    function show(index) {
      current = (index + slides.length) % slides.length;
      slides.forEach(function (slide, i) {
        var active = i === current;
        slide.classList.toggle('is-active', active);
        if (active) { slide.removeAttribute('aria-hidden'); } else { slide.setAttribute('aria-hidden', 'true'); }
        // 切り替えたら、境目は真ん中に戻す
        var compare = slide.querySelector('[data-compare]');
        if (compare && active) setPos(compare, 50);
      });
    }

    if (prev) prev.addEventListener('click', function () { show(current - 1); });
    if (next) next.addEventListener('click', function () { show(current + 1); });
  });
})();

/* ホワイトニングLP：ブライダルプランのタブ切り替え
   ・タブをクリック／タップで、プランを切り替え
   ・タブにフォーカスして ← → キー（Home / End も可）でも切り替えられます */
(function () {
  'use strict';

  var roots = document.querySelectorAll('[data-plan-tabs]');
  if (!roots.length) return;

  roots.forEach(function (root) {
    var tabs = Array.prototype.slice.call(root.querySelectorAll('[data-plan-tab]'));
    var panels = Array.prototype.slice.call(root.querySelectorAll('[data-plan-panel]'));
    if (!tabs.length || tabs.length !== panels.length) return;

    function select(index, moveFocus) {
      tabs.forEach(function (tab, i) {
        var active = i === index;
        tab.classList.toggle('is-active', active);
        tab.setAttribute('aria-selected', active ? 'true' : 'false');
        tab.setAttribute('tabindex', active ? '0' : '-1');
        if (active && moveFocus) tab.focus();
      });
      panels.forEach(function (panel, i) {
        var active = i === index;
        panel.classList.toggle('is-active', active);
        if (active) { panel.removeAttribute('hidden'); } else { panel.setAttribute('hidden', ''); }
      });
    }

    tabs.forEach(function (tab, i) {
      tab.addEventListener('click', function () { select(i, false); });
      tab.addEventListener('keydown', function (e) {
        var next = null;
        if (e.key === 'ArrowRight') next = (i + 1) % tabs.length;
        if (e.key === 'ArrowLeft') next = (i - 1 + tabs.length) % tabs.length;
        if (e.key === 'Home') next = 0;
        if (e.key === 'End') next = tabs.length - 1;
        if (next !== null) { select(next, true); e.preventDefault(); }
      });
    });
  });
})();

/* ----------------------------------------
   よくあるご質問（.wl-faq）：開閉
   ・質問をクリック／タップで開閉（aria-expanded と .is-open を切り替え）
---------------------------------------- */
(function () {
  var list = document.querySelector('[data-faq]');
  if (!list) return;

  list.addEventListener('click', function (e) {
    var trigger = e.target.closest('[data-faq-trigger]');
    if (!trigger || !list.contains(trigger)) return;

    var item = trigger.closest('[data-faq-item]');
    var willOpen = trigger.getAttribute('aria-expanded') !== 'true';

    trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
    item.classList.toggle('is-open', willOpen);
  });
})();

/* ----------------------------------------
   メニュー（.wl-menu）：スマホ（〜768px）のカードスライダー
   ・指でスワイプして切り替え（スクロールの吸い付きはCSSの scroll-snap）
   ・少し時間がたつと、1→2→3→1…と自動でスライド
   ・触っている間・画面の外・タブが裏のときは止まる／ドットのタップでも移動
   ・「動きを減らす」設定の人には、自動スライドはしません
---------------------------------------- */
(function () {
  'use strict';

  var roots = document.querySelectorAll('[data-menu-slider]');
  if (!roots.length) return;

  var INTERVAL = 4000; // 自動で切り替わる間隔(ms)
  var mq = window.matchMedia('(max-width: 768px)');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');

  roots.forEach(function (root) {
    var list = root.querySelector('[data-menu-list]');
    var items = list ? Array.prototype.slice.call(list.children) : [];
    var dots = Array.prototype.slice.call(root.querySelectorAll('[data-menu-dot]'));
    if (items.length < 2) return;

    var current = 0;
    var timer = null;
    var inView = false;
    var ticking = false;

    // i 番目のカードが画面の真ん中にくるときの scrollLeft
    function offsetOf(i) {
      return items[i].offsetLeft - (list.clientWidth - items[i].offsetWidth) / 2;
    }

    function setActive(i) {
      current = i;
      dots.forEach(function (dot, n) {
        var on = n === i;
        dot.classList.toggle('is-active', on);
        if (on) { dot.setAttribute('aria-current', 'true'); } else { dot.removeAttribute('aria-current'); }
      });
    }

    // いまの scrollLeft にいちばん近いカードの番号
    function indexFromScroll() {
      var max = list.scrollWidth - list.clientWidth;
      if (max > 0 && list.scrollLeft >= max - 2) return items.length - 1; // いちばん右まで来ていたら最後
      var best = 0;
      var bestDiff = Infinity;
      items.forEach(function (_, i) {
        var diff = Math.abs(list.scrollLeft - offsetOf(i));
        if (diff < bestDiff) { bestDiff = diff; best = i; }
      });
      return best;
    }

    function goTo(i) {
      var index = (i + items.length) % items.length;
      list.scrollTo({ left: offsetOf(index), behavior: reduce.matches ? 'auto' : 'smooth' });
    }

    function stop() {
      if (timer) { clearInterval(timer); timer = null; }
    }

    function start() {
      stop();
      if (!mq.matches || reduce.matches || !inView || document.hidden) return;
      timer = setInterval(function () { goTo(current + 1); }, INTERVAL);
    }

    // スクロール（スワイプ・自動どちらも）に合わせて、ドットを更新
    list.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () {
        ticking = false;
        setActive(indexFromScroll());
      });
    }, { passive: true });

    // 触っている間は止め、離してから INTERVAL たったらまた動かす
    list.addEventListener('touchstart', stop, { passive: true });
    list.addEventListener('touchend', start, { passive: true });
    list.addEventListener('touchcancel', start, { passive: true });
    list.addEventListener('pointerdown', stop);
    list.addEventListener('pointerup', start);
    list.addEventListener('pointercancel', start);
    list.addEventListener('focusin', stop);
    list.addEventListener('focusout', start);

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () {
        goTo(i);
        start(); // 押したあとも、また INTERVAL たってから動く
      });
    });

    // 画面に見えているときだけ動かす
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        inView = entries[0].isIntersecting;
        if (inView) { start(); } else { stop(); }
      }, { threshold: 0.3 }).observe(root);
    } else {
      inView = true;
    }

    document.addEventListener('visibilitychange', function () {
      if (document.hidden) { stop(); } else { start(); }
    });

    // 画面サイズが変わったとき：PC幅になったら止めて先頭に戻す
    function onChange() {
      if (mq.matches) {
        start();
      } else {
        stop();
        list.scrollLeft = 0;
        setActive(0);
      }
    }
    if (mq.addEventListener) { mq.addEventListener('change', onChange); } else if (mq.addListener) { mq.addListener(onChange); }
    window.addEventListener('resize', function () {
      if (mq.matches) goTo(current); // 回転などで幅が変わっても、いまのカードに合わせ直す
    });

    setActive(0);
  });
})();

/* ----------------------------------------
   ブライダルプラン（.wl-plan）：スマホ（〜768px）の「施術の流れ」スライダー
   ・指でスワイプして切り替え（吸い付きはCSSの scroll-snap）
   ・少し時間がたつと、次の流れへ自動でスライド（最後の次は最初に戻る）
   ・触っている間・画面の外・タブが裏・選ばれていないプランのときは止まる／ドットのタップでも移動
   ・プランのタブを切り替えたら、流れは最初に戻る
   ・「動きを減らす」設定の人には、自動スライドはしません
---------------------------------------- */
(function () {
  'use strict';

  var flows = document.querySelectorAll('[data-plan-flow]');
  if (!flows.length) return;

  var INTERVAL = 4500; // 自動で切り替わる間隔(ms)
  var SLIDE_MS = 1000; // 切り替わるときの動きの長さ(ms)。大きいほどゆっくり
  var mq = window.matchMedia('(max-width: 768px)');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');

  flows.forEach(function (root) {
    var list = root.querySelector('[data-plan-steps]');
    var items = list ? Array.prototype.slice.call(list.children) : [];
    var dots = Array.prototype.slice.call(root.querySelectorAll('[data-plan-dot]'));
    var panel = root.closest('[data-plan-panel]');
    if (items.length < 2) return;

    var current = 0;
    var timer = null;
    var inView = false;
    var ticking = false;

    function isShown() {
      return !panel || !panel.hasAttribute('hidden');
    }

    // i 番目のカードが左端（scroll-padding の位置）にくるときの scrollLeft
    function offsetOf(i) {
      return items[i].offsetLeft - items[0].offsetLeft;
    }

    function setActive(i) {
      current = i;
      dots.forEach(function (dot, n) {
        var on = n === i;
        dot.classList.toggle('is-active', on);
        if (on) { dot.setAttribute('aria-current', 'true'); } else { dot.removeAttribute('aria-current'); }
      });
    }

    function indexFromScroll() {
      var max = list.scrollWidth - list.clientWidth;
      if (max > 0 && list.scrollLeft >= max - 2) return items.length - 1;
      var best = 0;
      var bestDiff = Infinity;
      items.forEach(function (_, i) {
        var diff = Math.abs(list.scrollLeft - offsetOf(i));
        if (diff < bestDiff) { bestDiff = diff; best = i; }
      });
      return best;
    }

    // ブラウザ任せの smooth だと速いので、自分でゆっくり動かす（動かしている間だけ吸い付きを切る）
    var animId = 0;

    function cancelAnim() {
      animId++;
      list.style.scrollSnapType = '';
    }

    function animateTo(left) {
      var from = list.scrollLeft;
      var dist = left - from;
      if (!dist) return;
      if (reduce.matches) { list.scrollLeft = left; return; }

      var id = ++animId;
      var t0 = null;
      list.style.scrollSnapType = 'none';

      function step(ts) {
        if (id !== animId) return; // 途中で指が触れたら、そこで終わり
        if (t0 === null) t0 = ts;
        var p = Math.min((ts - t0) / SLIDE_MS, 1);
        var e = p < 0.5 ? 4 * p * p * p : 1 - Math.pow(-2 * p + 2, 3) / 2; // ゆっくり出て、ゆっくり止まる
        list.scrollLeft = from + dist * e;
        if (p < 1) {
          requestAnimationFrame(step);
        } else {
          list.style.scrollSnapType = '';
        }
      }
      requestAnimationFrame(step);
    }

    function goTo(i) {
      var index = (i + items.length) % items.length;
      animateTo(offsetOf(index));
    }

    function stop() {
      if (timer) { clearInterval(timer); timer = null; }
    }

    function start() {
      stop();
      if (!mq.matches || reduce.matches || !inView || document.hidden || !isShown()) return;
      timer = setInterval(function () { goTo(current + 1); }, INTERVAL);
    }

    list.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () {
        ticking = false;
        setActive(indexFromScroll());
      });
    }, { passive: true });

    // 触っている間は止め、離してから INTERVAL たったらまた動かす
    function hold() { cancelAnim(); stop(); }
    list.addEventListener('touchstart', hold, { passive: true });
    list.addEventListener('touchend', start, { passive: true });
    list.addEventListener('touchcancel', start, { passive: true });
    list.addEventListener('pointerdown', hold);
    list.addEventListener('pointerup', start);
    list.addEventListener('pointercancel', start);
    list.addEventListener('focusin', stop);
    list.addEventListener('focusout', start);

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () {
        goTo(i);
        start();
      });
    });

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        inView = entries[0].isIntersecting;
        if (inView) { start(); } else { stop(); }
      }, { threshold: 0.3 }).observe(root);
    } else {
      inView = true;
    }

    document.addEventListener('visibilitychange', function () {
      if (document.hidden) { stop(); } else { start(); }
    });

    // プランのタブが切り替わったら（panel の hidden が変わったら）、最初に戻して動かし直す
    if (panel && 'MutationObserver' in window) {
      new MutationObserver(function () {
        cancelAnim();
        list.scrollLeft = 0;
        setActive(0);
        start();
      }).observe(panel, { attributes: true, attributeFilter: ['hidden'] });
    }

    function onChange() {
      if (mq.matches) {
        start();
      } else {
        stop();
        list.scrollLeft = 0;
        setActive(0);
      }
    }
    if (mq.addEventListener) { mq.addEventListener('change', onChange); } else if (mq.addListener) { mq.addListener(onChange); }

    setActive(0);
  });
})();

/* ----------------------------------------
   流れ（.wl-flow）：スマホ（〜1024px）の写真スライダー
   ・丸い番号（01〜05）のボタンを押すと、その写真が中央にくるまでスライド
   ・指でスワイプして切り替え（中央への吸い付きはCSSの scroll-snap）
   ・少し時間がたつと、次の流れへ自動でスライド（最後の次は最初に戻る）
   ・触っている間・画面の外・タブが裏のときは止まる／下のドットのタップでも移動
   ・「動きを減らす」設定の人には、自動スライドはしません
---------------------------------------- */
(function () {
  'use strict';

  var roots = document.querySelectorAll('[data-flow]');
  if (!roots.length) return;

  var INTERVAL = 4500; // 自動で切り替わる間隔(ms)
  var SLIDE_MS = 1000; // 切り替わるときの動きの長さ(ms)。大きいほどゆっくり
  var mq = window.matchMedia('(max-width: 1024px)');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');

  roots.forEach(function (root) {
    var list = root.querySelector('[data-flow-steps]');
    var items = list ? Array.prototype.slice.call(list.children) : [];
    var navs = Array.prototype.slice.call(root.querySelectorAll('[data-flow-nav]'));
    var dots = Array.prototype.slice.call(root.querySelectorAll('[data-flow-dot]'));
    if (items.length < 2) return;

    var current = 0;
    var timer = null;
    var inView = false;
    var ticking = false;

    // i 番目のカードが、スライダーの中央にくるときの scrollLeft（CSS側で list を position: relative にしています）
    function offsetOf(i) {
      var el = items[i];
      var left = el.offsetLeft + el.offsetWidth / 2 - list.clientWidth / 2;
      var max = list.scrollWidth - list.clientWidth;
      return Math.max(0, Math.min(max, left));
    }

    function mark(buttons, i) {
      buttons.forEach(function (btn, n) {
        var on = n === i;
        btn.classList.toggle('is-active', on);
        if (on) { btn.setAttribute('aria-current', 'true'); } else { btn.removeAttribute('aria-current'); }
      });
    }

    function setActive(i) {
      current = i;
      mark(navs, i);
      mark(dots, i);
    }

    function indexFromScroll() {
      var best = 0;
      var bestDiff = Infinity;
      items.forEach(function (_, i) {
        var diff = Math.abs(list.scrollLeft - offsetOf(i));
        if (diff < bestDiff) { bestDiff = diff; best = i; }
      });
      return best;
    }

    // ブラウザ任せの smooth だと速いので、自分でゆっくり動かす（動かしている間だけ吸い付きを切る）
    var animId = 0;

    function cancelAnim() {
      animId++;
      list.style.scrollSnapType = '';
    }

    function animateTo(left) {
      var from = list.scrollLeft;
      var dist = left - from;
      if (!dist) return;
      if (reduce.matches) { list.scrollLeft = left; return; }

      var id = ++animId;
      var t0 = null;
      list.style.scrollSnapType = 'none';

      function step(ts) {
        if (id !== animId) return; // 途中で指が触れたら、そこで終わり
        if (t0 === null) t0 = ts;
        var p = Math.min((ts - t0) / SLIDE_MS, 1);
        var e = p < 0.5 ? 4 * p * p * p : 1 - Math.pow(-2 * p + 2, 3) / 2; // ゆっくり出て、ゆっくり止まる
        list.scrollLeft = from + dist * e;
        if (p < 1) {
          requestAnimationFrame(step);
        } else {
          list.style.scrollSnapType = '';
        }
      }
      requestAnimationFrame(step);
    }

    function goTo(i) {
      var index = (i + items.length) % items.length;
      animateTo(offsetOf(index));
    }

    function stop() {
      if (timer) { clearInterval(timer); timer = null; }
    }

    function start() {
      stop();
      if (!mq.matches || reduce.matches || !inView || document.hidden) return;
      timer = setInterval(function () { goTo(current + 1); }, INTERVAL);
    }

    list.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () {
        ticking = false;
        setActive(indexFromScroll());
      });
    }, { passive: true });

    // 触っている間は止め、離してから INTERVAL たったらまた動かす
    function hold() { cancelAnim(); stop(); }
    list.addEventListener('touchstart', hold, { passive: true });
    list.addEventListener('touchend', start, { passive: true });
    list.addEventListener('touchcancel', start, { passive: true });
    list.addEventListener('pointerdown', hold);
    list.addEventListener('pointerup', start);
    list.addEventListener('pointercancel', start);

    // 丸い番号・ドットのボタン：その写真へ移動（動かしたあと、また INTERVAL たってから自動で進む）
    navs.concat(dots).forEach(function (btn) {
      var i = (navs.indexOf(btn) > -1 ? navs : dots).indexOf(btn);
      btn.addEventListener('click', function () {
        cancelAnim();
        goTo(i);
        start();
      });
    });

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        inView = entries[0].isIntersecting;
        if (inView) { start(); } else { stop(); }
      }, { threshold: 0.3 }).observe(root);
    } else {
      inView = true;
    }

    document.addEventListener('visibilitychange', function () {
      if (document.hidden) { stop(); } else { start(); }
    });

    function onChange() {
      if (mq.matches) {
        start();
      } else {
        stop();
        cancelAnim();
        list.scrollLeft = 0;
        setActive(0);
      }
    }
    if (mq.addEventListener) { mq.addEventListener('change', onChange); } else if (mq.addListener) { mq.addListener(onChange); }

    setActive(0);
  });
})();
 