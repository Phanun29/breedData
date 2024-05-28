function openModal() {
    $('#myModal').modal('show');
}

function insertData() {
    // Get form data
    var formData = $('#insertForm').serialize();
    console.log('FormData:', formData); // Log the serialized form data
    var breedName = $('#name').val();

    // Check if breed name is empty
    if (breedName.trim() === '') {
        alert('Please enter a breed name.');
        return; // Do not proceed with the submission
    }

    // AJAX request to insert data
    $.ajax({
        type: 'POST',
        url: 'insert_data.php', // PHP script to handle data insertion
        data: formData,
        success: function(response) {
            console.log('AJAX Response:', response);
            // Handle the response (e.g., display success message)


            //alert(response);
            // Close the modal
            $('#myModal').modal('hide');
            location.reload();
        }
    });
}