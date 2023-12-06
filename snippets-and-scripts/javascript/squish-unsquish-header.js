window.addEventListener('DOMContentLoaded', function() {
  const header    = document.querySelector('.header'),
        headerTop = document.querySelector('.header-top');

  window.addEventListener('scroll', squishHeader, false);
  window.addEventListener('scroll', unSquishHeader, false);

  function unSquishHeader() {
    if(Math.round(window.scrollY) < 116) {
      headerTop.classList.remove('squished');

      header.classList.remove('squished-insides');
    }

    return;
  }

  function squishHeader() {
    if(Math.round(window.scrollY) > 195) {
      headerTop.classList.add('squished');

      header.classList.add('squished-insides');
    }

    return;
  }
})
