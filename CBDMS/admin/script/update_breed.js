// Function to open the update modal with the existing dataa
function openUpdateModal(id, currentName) {
  // Set the current breed name in the input field
  $("#updatedName").val(currentName);

  // Set the ID of the record being updated in the hidden field
  $("#update_id").val(id);

  // Show the update modal
  $("#updateModal").modal("show");
}

// Function to update data
function updateData() {
  // Get updated data
  var updatedData = $("#updateForm").serialize();

  // AJAX request to update data
  $.ajax({
    type: "POST",
    url: "update_breed.php",
    data: updatedData,
    success: function (response) {
      // Handle the response
      console.log("Update response:", response);
      alert(response);

      // Close the update modal after a successful update
      $("#updateModal").modal("hide");
      // Reload the page or update the displayed data as needed
      location.reload(); // or update the displayed data without a full page reload
    },
  });
}
