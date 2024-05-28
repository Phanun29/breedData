$(document).ready(function () {
  let slideIndex = 0;
  showSlides();

  function showSlides() {
    let slides = $(".mySlides");
    let imageCount = slides.length;

    slides.attr("hidden", true);

    if (slideIndex >= imageCount) {
      slideIndex = 0;
    }
    if (slideIndex < 0) {
      slideIndex = imageCount - 1;
    }

    slides.eq(slideIndex).removeAttr("hidden");

    // Update the image numbering
    $("#imageCount").text(`Image ${slideIndex + 1} of ${imageCount}`);
  }

  function nextSlide() {
    slideIndex++;
    showSlides();
  }

  function prevSlide() {
    slideIndex--;
    showSlides();
  }

  // Ensure the next and previous buttons work correctly
  $(".next").click(function () {
    nextSlide();
  });

  $(".prev").click(function () {
    prevSlide();
  });
});
