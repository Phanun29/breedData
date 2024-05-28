function exportToExcel() {
    // Create a new HTML table with only the relevant columns
    var exportTable = document.createElement('table');
    var exportTableBody = document.createElement('tbody');

    // Get the header row from the HTML table
    var headerRow = document.querySelector('#myTable1 thead tr');

    // Create a new row for the export table and add the header cells
    var exportHeaderRow = document.createElement('tr');
    headerRow.querySelectorAll('th').forEach(function(cell) {
        var exportCell = document.createElement('td');
        exportCell.textContent = cell.textContent;
        exportCell.style.border = '1px solid black'; // Add border
        exportHeaderRow.appendChild(exportCell);
    });
    exportTableBody.appendChild(exportHeaderRow);

    // Iterate over each row of the HTML table and add the data rows
    var tableRows = document.querySelectorAll('#myTable1 tbody tr');
    tableRows.forEach(function(row) {
        // Create a new row for the export table
        var exportRow = document.createElement('tr');

        // Iterate over each cell of the row and create corresponding cells in the export table
        row.querySelectorAll('td').forEach(function(cell) {
            var exportCell = document.createElement('td');
            exportCell.textContent = cell.textContent;
            exportCell.style.border = '1px solid black'; // Add border
            exportRow.appendChild(exportCell);
        });

        // Append the row to the export table body
        exportTableBody.appendChild(exportRow);
    });

    // Append the table body to the export table
    exportTable.appendChild(exportTableBody);

    // Create a Blob object containing the HTML table
    var blob = new Blob(['\ufeff', exportTable.outerHTML], {
        type: 'application/vnd.ms-excel'
    });

    // Create a link element to download the Blob
    var url = URL.createObjectURL(blob);
    var a = document.createElement("a");
    a.href = url;
    a.download = "data_corn.xls";
    document.body.appendChild(a);
    a.click();

    // Cleanup
    setTimeout(function() {
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }, 0);
}