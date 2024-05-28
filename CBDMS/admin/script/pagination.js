function updateNumberedButtons(totalPages, currentPage) {
    var buttonsContainer = $(".pagination");

    buttonsContainer.empty(); // Clear existing buttons

    buttonsContainer.append(
        `<li class="page-item ${currentPage === 1 ? "disabled" : ""}">
        <a class="page-link" href="#" aria-label="Previous" onclick="goToPage(${currentPage - 1})">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
        </a>
    </li>`
    );

    for (var i = 1; i <= totalPages; i++) {
        buttonsContainer.append(
            `<li class="page-item ${i === currentPage ? "active" : ""}">
            <a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>
        </li>`
        );
    }

    buttonsContainer.append(
        `<li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
        <a class="page-link" href="#" aria-label="Next" onclick="goToPage(${currentPage + 1})">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
        </a>
    </li>`
    );
}

function goToPage(page) {

    // Perform the navigation or update content based on the target page
    console.log("Go to page", targetPage);
    // For now, you can use window.location.href to navigate to the URL with the selected page parameter
    // window.location.href = `your_page.php?page=${targetPage}`;

    // Update the current page and pagination buttons

}
function setDeleteParams(id, page) {
    // Set the id and page parameters in hidden form fields
    document.getElementById('deleteId').value = id;
    document.getElementById('deletePage').value = page;
}