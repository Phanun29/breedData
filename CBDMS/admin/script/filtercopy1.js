$(document).ready(function() {
    $("#applyFiltersBtn").click(function() {
        var numberOfRows = $("#rowsPerPage").val();
        var filterBreed1 = $("#filterBreedA").val();
        var filterBreed2 = $("#filterBreedB").val();
        var filterVersion = $("#version").val(); // Retrieve value from version input field


        
        // Check if either filterBreed1 or filterBreed2 is not empty
        if (filterBreed1 !== '' || filterBreed2 !== '' || filterVersion !== '') {
            $.ajax({
                type: "POST",   
                url: "retrieveData.php",
                data: { 
                    numberOfRows: numberOfRows,
                    filterBreed1: filterBreed1,
                    filterBreed2: filterBreed2,
                    version: filterVersion // Pass version filter value to retrieveData.php
   
                },
                success: function(response) {
                    $("#list_user tbody").html(response); // Update tbody content
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
$(document).ready(function() {
    $("#applyFiltersBtn").click(function() {
        var numberOfRows = $("#rowsPerPage").val();
        var filterBreed1 = $("#filterBreedA").val();
        var filterBreed2 = $("#filterBreedB").val();
        var filterVersion = $("#version").val(); // Retrieve value from version input field


        
        // Check if either filterBreed1 or filterBreed2 is not empty
        if (filterBreed1 !== '' || filterBreed2 !== '' || filterVersion !== '') {
            $.ajax({
                type: "POST",   
                url: "retrieveData3.php",
                data: { 
                    numberOfRows: numberOfRows,
                    filterBreed1: filterBreed1,
                    filterBreed2: filterBreed2,
                    version: filterVersion // Pass version filter value to retrieveData.php
   
                },
                success: function(response) {
                    $("#list_user #tbody2").html(response); // Update tbody content
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
 // Add this inside your script tag or in a separate script file

 function applyFilters() {
    // Your filter logic here

    // Hide pagination
    $("#paginationSection").hide();
}

function clearFilters() {
    // Your logic to clear filters

    // Show pagination
    $("#paginationSection").show();
}
// ... (rest of your script)

// Adjust your filter button click event to call the applyFilters function
$("#applyFiltersBtn").on("click", function() {
    applyFilters();
});

// Optionally, add a button or logic to clear filters and show pagination
$("#clearFiltersBtn").on("click", function() {
    clearFilters();
});
