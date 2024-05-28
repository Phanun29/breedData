$(document).ready(function() {
    $("#applyFiltersBtn").click(function() {
        var numberOfRows = $("#rowsPerPage").val();
        var filterBreed1 = $("#filterBreed1").val();
        var filterBreed2 = $("#filterBreed2").val();
        var filterVersion = $("#version").val(); // Retrieve value from version input field

        // Check if either filterBreed1 or filterBreed2 is not empty
        if (filterBreed1 !== '' || filterBreed2 !== '' || filterVersion !== '') {
            $.ajax({
                type: "POST",   
                url: "retrieveData2.php",
                data: { 
                    numberOfRows: numberOfRows, 
                    filterBreed1: filterBreed1,
                    filterBreed2: filterBreed2,
                    version: filterVersion // Pass version filter value to retrieveData.php
                },
                success: function(response) {
                    $(".pic_breed ").html(response); // Update tbody content
                    hidePagination(); // Hide pagination after filtering
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        } else {
            // Optionally, you can display a message to the user
           // alert("Please enter a value in at least one filter field.");
        }
    });
});

function hidePagination() {
    $(".pagination").hide(); // Hide pagination controls
}
