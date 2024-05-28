
    function insertData() {
        // Get form data
        var formData = $('#insertForm').serialize();

        // AJAX request to insert data
        $.ajax({
            type: 'POST',
            url: 'insert_data.php',  // PHP script to handle data insertion
            data: formData,
            success: function(response) {
                // Handle the response (e.g., display success message)
                alert(response);
                // Close the modal
                $('#myModal').modal('hide');
            }
        });
    }
