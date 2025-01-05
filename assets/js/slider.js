const carouselContainer = document.getElementById("carouselContainer");
const carouselSlide = document.getElementById("carouselSlide"); // carouselImageshow
const carouselImages = document.getElementsByClassName("slider-item"); // carouselImageshow items
const carouselController = document.querySelectorAll(
  "#bestSellerPreview .slider-controller input[type=radio]"
);

let counter = 1;
let sliderChangeTime = 4000;
let currentSlide;

const size = carouselImages[0].clientWidth;

if (carouselImages.length !== 1) {
  const firstClone = carouselImages[0].cloneNode(true);
  const lastClone = carouselImages[carouselImages.length - 1].cloneNode(true);

  firstClone.id = "firstClone";
  lastClone.id = "lastClone";

  carouselSlide.append(firstClone);
  carouselSlide.prepend(lastClone);

  carouselSlide.style.transform = `translateX(-${size * counter}px)`;
}

// ----- clone swap ----- //
carouselSlide.addEventListener("transitionend", () => {
  if (carouselImages[counter].id === firstClone.id) {
    counter = carouselImages.length - counter;
    carouselSlide.style.transition = "none";
    carouselSlide.style.transform = "translateX(" + -size * counter + "px)";
  }
  if (carouselImages[counter].id === lastClone.id) {
    counter = carouselImages.length - 2;
    carouselSlide.style.transition = "none";
    carouselSlide.style.transform = "translateX(" + -size * counter + "px)";
  }
  clearInterval(currentSlide);
});
// ------------------------------------------------------------ //

// ----- slide autoplay ----- //
const autoplay = () => {
  currentSlide = setInterval(() => {
    moveRight();
  }, sliderChangeTime);
};

carouselContainer.addEventListener("mouseenter", () => {
  clearInterval(currentSlide);
});

carouselContainer.addEventListener("mouseleave", autoplay);

autoplay();

// ------------------------------------------------------------ //

// Move to the next slide
const moveRight = () => {
  if (counter >= carouselImages.length - 1) return;
  counter++;
  carouselSlide.style.transition = "all .7s ease-out";
  carouselSlide.style.transform = `translateX(-${size * counter}px)`;

  resetAutoplay();
};

// Move to the previous slide
const moveLeft = () => {
  if (counter <= 0) return;
  counter--;
  carouselSlide.style.transition = "all .7s ease-out";
  carouselSlide.style.transform = `translateX(-${size * counter}px)`;

  resetAutoplay();
};

// Reset autoplay interval
const resetAutoplay = () => {
  clearInterval(currentSlide); // Clear the current autoplay interval
  autoplay(); // Restart autoplay
};

const sliderNextBtn = document.getElementById("sliderNextBtn");
const sliderPrevBtn = document.getElementById("sliderPrevBtn");

sliderNextBtn.addEventListener("click", moveRight);
sliderPrevBtn.addEventListener("click", moveLeft);

// ----------------------------------------------------------- //

// Slider Controller //
// ----------------------------------------------------------- //

// category slider
const categorySlider = document.querySelector(".menuPreviewImageContainer");
const totalImageCount = document.querySelectorAll(
  ".menuPreviewImageContainer .imgContainer"
).length;
const menuSliderPrevBtn = document.getElementById("menuSliderPrevBtn");
const menuSliderNextBtn = document.getElementById("menuSliderNextBtn");
let count = 0;

let isTransitioning = false;

menuSliderPrevBtn.addEventListener("click", () => {
  if (isTransitioning) return; // Prevent new transitions if one is ongoing

  count = count > 0 ? --count : 0;

  categorySlider.style.transition = `all 750ms cubic-bezier(.56,-0.5,.59,1.63)`;
  categorySlider.style.transform = `translateX(${count * -45}rem)`;

  isTransitioning = true; // Mark transition as ongoing
});

menuSliderNextBtn.addEventListener("click", () => {
  if (isTransitioning) return; // Prevent new transitions if one is ongoing

  count = count < totalImageCount - 3 ? ++count : count;

  categorySlider.style.transition = `all 750ms cubic-bezier(.56,-0.5,.59,1.63)`;
  categorySlider.style.transform = `translateX(${count * -45}rem)`;

  isTransitioning = true; // Mark transition as ongoing
});

// Listen for the end of the transition
categorySlider.addEventListener("transitionend", () => {
  isTransitioning = false; // Allow new transitions after the current one ends
});

if (totalImageCount <= 3) {
  menuSliderNextBtn.style.opacity = 0;
  menuSliderPrevBtn.style.opacity = 0;
} else {
  menuSliderNextBtn.style.opacity = 1;
  menuSliderPrevBtn.style.opacity = 1;
}
