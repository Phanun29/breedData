function fetchBreedOptions() {
  $.ajax({
    type: "POST",
    url: "getBreedOptions.php", // Create a new PHP file to fetch breed options
    success: function (response) {
      // Populate breed options in both breed1 and breed2 select elements
      $("#filterBreed1, #filterBreed2").html(response);
    },
  });
}

// Execute the fetchBreedOptions function on document ready
$(document).ready(function () {
  fetchBreedOptions();
});
