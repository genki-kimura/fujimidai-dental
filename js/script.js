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