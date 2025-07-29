# Blaze Slider
* [Blaze Slider website](https://blaze-slider.dev/)
* [Documentation](https://blaze-slider.dev/docs/intro)

## HTML
```html
<link href="https://unpkg.com/blaze-slider@latest/dist/blaze.css" rel="stylesheet">
<script src="https://unpkg.com/blaze-slider@latest/dist/blaze-slider.min.js"></script>
<div class="blaze-slider timeline">
  <div class="blaze-container">
    <div class="blaze-track-container">
      <div class="blaze-track">
        <div class="timeline-item">
          <h2 class="subheading">1920s</h2>

          <div class="circle"></div>

          Description text, etc.
        </div>
      </div>
    </div>

    <div class="timeline__controls">
      <!-- navigation buttons -->
      <button class="blaze-prev" disabled><span class="fa fa-chevron-left"></span></button>
      <!-- pagination container -->
      <!-- <div class="blaze-pagination"></div> -->
      <button class="blaze-next"><span class="fa fa-chevron-right"></span></button>
    </div>
  </div>
</div>
```

## CSS
```css
.blaze-slider.timeline { display: block; padding: 0; }
/* .blaze-container { margin: 0 0 0 auto; max-width: 1200px; } */
.blaze-track-container { margin: 0 0 0 auto; max-width: 1200px; overflow: unset; padding: 0 60px; }
.blaze-container .timeline-item { flex: 0 0 auto; }

@media screen and (min-width: 1540px) and (max-width: 1779px) {
  .blaze-track-container { max-width: 1400px; }
}

@media screen and (min-width: 1780px) {
  .blaze-track-container { max-width: 1600px; }
}
```

## JavaScript
```js
window.addEventListener('DOMContentLoaded', () => {
  if (BlazeSlider) {
    const blazetimeline = document.querySelector('.blaze-slider'),
          prevButton    = document.querySelector('.blaze-prev'),
          nextButton    = document.querySelector('.blaze-next');

    const blazeSlider = new BlazeSlider(blazetimeline, {
      all: {
        enableAutoplay: false,
        autoplayInterval: 3000,
        loop: false,
        transitionDuration: 300,
        slideGap: '60px',
        slidesToShow: 6,
        slidesToScroll: 6,
      },
      '(max-width: 1780px)': { slidesToShow: 5, slidesToScroll: 5, },
      '(max-width: 1540px)': { slidesToShow: 4, slidesToScroll: 4, },
      '(max-width: 1024px)': { slidesToShow: 3, slidesToScroll: 3, },
      '(max-width: 680px)': { slidesToShow: 2, slidesToScroll: 2, },
      '(max-width: 480px)': { slidesToShow: 1, slidesToScroll: 1, },
    });

    // subscribe to the slide event
    const unsubscribe = blazeSlider.onSlide(
      (pageIndex, firstVisibleSlideIndex, lastVisibleSlideIndex) => {
        switch (true) {
          case (pageIndex == 0):
            prevButton.setAttribute('disabled', '');
            break;

          case (lastVisibleSlideIndex+1 == blazeSlider.totalSlides):
            nextButton.setAttribute('disabled', '');
            break;

          default:
            nextButton.removeAttribute('disabled');
            prevButton.removeAttribute('disabled');
            break;
        }
        
        // console.log(pageIndex);
        // console.log(firstVisibleSlideIndex);
        // console.log(lastVisibleSlideIndex);
    });
    // when you want to unsubscribe - call the returned `unsubscribe` function
  }
});
```
