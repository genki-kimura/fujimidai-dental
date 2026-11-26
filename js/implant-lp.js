/* ========================================
   インプラントLP専用のJS
   ・functions.php で「インプラントLP」テンプレートのページだけ読み込みます
   ・セクションごとに処理を追加していきます
======================================== */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var lp = document.querySelector('.implant-lp');
    if (!lp) {
      return;
    }

    initVideos(lp);
    initAutoplayVideos(lp);
    initCaseSlider(lp);
    initFaq(lp);
  });

  /* ----------------------------------------
     動画（WHY NOW・ABOUT など共通）
     ・data-youtube-id を持つ枠の [data-video-play] ボタンを押したときに、はじめて YouTube を読み込みます
       （ページの表示を軽くするため）
     ・動画IDは implant-lp.php に入れたURLから自動で取り出しています
  ---------------------------------------- */
  function initVideos(lp) {
    var frames = lp.querySelectorAll('[data-youtube-id]');

    frames.forEach(function (frame) {
      var id = frame.getAttribute('data-youtube-id');
      var button = frame.querySelector('[data-video-play]');
      if (!id || !button) {
        return; // URLが未設定のあいだは何もしない
      }

      button.addEventListener('click', function () {
        var iframe = document.createElement('iframe');
        iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?autoplay=1&rel=0&playsinline=1';
        iframe.title = frame.getAttribute('data-video-title') || 'YouTube 動画';
        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
        iframe.allowFullscreen = true;
        frame.appendChild(iframe);
        frame.classList.add('is-playing');
      });
    });
  }

  /* ----------------------------------------
     自動再生の動画（WHY NOW の mp4 など）
     ・video タグの autoplay muted loop で自動再生・くり返し再生します
     ・念のため、自動で始まらなかったときは JS からも再生をかけます
     ・「動きを減らす」設定の方には、自動再生しないで止めておきます
  ---------------------------------------- */
  function initAutoplayVideos(lp) {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    lp.querySelectorAll('[data-autoplay-video]').forEach(function (video) {
      video.muted = true; // 音なしでないと自動再生できないブラウザがあるため

      if (reduce) {
        video.removeAttribute('autoplay');
        video.pause();
        video.setAttribute('controls', '');
        return;
      }

      var play = video.play();
      if (play && typeof play.catch === 'function') {
        play.catch(function () {
          // 自動再生がブロックされたときは、再生ボタンを出して手動で再生できるようにする
          video.setAttribute('controls', '');
        });
      }
    });
  }

  /* ----------------------------------------
     ESTHETIC：症例スライダー
     ・矢印・ドット・スワイプで切り替え（症例が1件のときは何もしない）
  ---------------------------------------- */
  function initCaseSlider(lp) {
    lp.querySelectorAll('[data-case-slider]').forEach(function (slider) {
      var slides = slider.querySelectorAll('.implant-esthetic__case-slide');
      var dots = slider.querySelectorAll('[data-case-dot]');
      var prev = slider.querySelector('[data-case-prev]');
      var next = slider.querySelector('[data-case-next]');
      var current = 0;
      if (slides.length < 2) {
        return;
      }

      function show(index) {
        current = (index + slides.length) % slides.length;
        slides.forEach(function (slide, i) {
          var active = i === current;
          slide.hidden = !active;
          slide.classList.toggle('is-active', active);
        });
        dots.forEach(function (dot, i) {
          var active = i === current;
          dot.classList.toggle('is-active', active);
          if (active) {
            dot.setAttribute('aria-current', 'true');
          } else {
            dot.removeAttribute('aria-current');
          }
        });
      }

      if (prev) { prev.addEventListener('click', function () { show(current - 1); }); }
      if (next) { next.addEventListener('click', function () { show(current + 1); }); }
      dots.forEach(function (dot) {
        dot.addEventListener('click', function () { show(Number(dot.getAttribute('data-case-dot'))); });
      });

      // スワイプ
      var startX = null;
      slider.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
      slider.addEventListener('touchend', function (e) {
        if (startX === null) { return; }
        var diff = e.changedTouches[0].clientX - startX;
        if (Math.abs(diff) > 40) { show(current + (diff < 0 ? 1 : -1)); }
        startX = null;
      });
    });
  }

  /* ----------------------------------------
     FAQ：アコーディオン
     ・1つ開くと、ほかに開いている質問は閉じます（いつも1つだけ開く）
     ・開いている質問をもう一度押すと閉じます
     ・開閉の速さは FAQ_SPEED（ミリ秒）で変えられます
  ---------------------------------------- */
  var FAQ_SPEED = 500;

  function initFaq(lp) {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    lp.querySelectorAll('[data-faq]').forEach(function (list) {
      var items = list.querySelectorAll('.implant-faq__item');

      function animate(panel, open) {
        if (panel._faqTimer) {
          clearTimeout(panel._faqTimer);
        }
        if (reduce) {
          panel.hidden = !open;
          panel.style.height = '';
          return;
        }
        panel.style.transition = 'height ' + FAQ_SPEED + 'ms ease';
        panel.style.overflow = 'hidden';

        if (open) {
          panel.hidden = false;
          panel.style.height = '0px';
          panel.offsetHeight; // 高さ0を確定させてから広げる
          panel.style.height = panel.scrollHeight + 'px';
        } else {
          panel.style.height = panel.scrollHeight + 'px';
          panel.offsetHeight;
          panel.style.height = '0px';
        }

        panel._faqTimer = setTimeout(function () {
          if (!open) {
            panel.hidden = true;
          }
          panel.style.height = '';
          panel.style.overflow = '';
          panel.style.transition = '';
        }, FAQ_SPEED);
      }

      function setOpen(item, open) {
        var btn = item.querySelector('.implant-faq__btn');
        var panel = item.querySelector('.implant-faq__a');
        if (item.classList.contains('is-open') === open) {
          return;
        }
        item.classList.toggle('is-open', open);
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        animate(panel, open);
      }

      items.forEach(function (item) {
        item.querySelector('.implant-faq__btn').addEventListener('click', function () {
          var willOpen = !item.classList.contains('is-open');
          items.forEach(function (other) {
            if (other !== item) {
              setOpen(other, false);
            }
          });
          setOpen(item, willOpen);
        });
      });
    });
  }
})();
