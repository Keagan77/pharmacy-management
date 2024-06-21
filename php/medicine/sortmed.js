document.addEventListener("DOMContentLoaded", function () {
    // Function to parse date strings into Date objects
    function parseDate(dateString) {
        var parts = dateString.split("-");
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }

    // Function to sort table rows by expiry date
    function sortTableByExpiryDate() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("medicine-table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = parseDate(rows[i].getElementsByTagName("td")[6].innerHTML); // 6th column is the expiry date column
                y = parseDate(rows[i + 1].getElementsByTagName("td")[6].innerHTML); // 6th column is the expiry date column
                if (x > y) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    // Function to sort table rows by manufacturing date
    function sortTableByManufacturingDate() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("medicine-table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = parseDate(rows[i].getElementsByTagName("td")[5].innerHTML); // 5th column is the manufacturing date column
                y = parseDate(rows[i + 1].getElementsByTagName("td")[5].innerHTML); // 5th column is the manufacturing date column
                if (x > y) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    // Function to sort table rows by M.R.P
    function sortTableByMRP() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("medicine-table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = parseFloat(rows[i].getElementsByTagName("td")[9].innerHTML); // 9th column is the M.R.P column
                y = parseFloat(rows[i + 1].getElementsByTagName("td")[9].innerHTML); // 9th column is the M.R.P column
                if (x > y) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    // Function to sort table rows by Quantity
    function sortTableByQuantity() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("medicine-table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = parseInt(rows[i].getElementsByTagName("td")[8].innerHTML); // 8th column is the Quantity column
                y = parseInt(rows[i + 1].getElementsByTagName("td")[8].innerHTML); // 8th column is the Quantity column
                if (x > y) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    // Function to sort table rows by Medicine Name
    function sortTableByMedicineName() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("medicine-table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[2].innerHTML.toLowerCase(); // 2nd column is the Medicine Name column
                y = rows[i + 1].getElementsByTagName("td")[2].innerHTML.toLowerCase(); // 2nd column is the Medicine Name column
                if (x > y) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    // Function to sort table rows by Pack
    function sortTableByPack() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("medicine-table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = parseInt(rows[i].getElementsByTagName("td")[3].innerHTML); // 3rd column is the Pack column
                y = parseInt(rows[i + 1].getElementsByTagName("td")[3].innerHTML); // 3rd column is the Pack column
                if (x > y) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    // Function to sort table rows
    function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("medicine-table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    // Event listener for select dropdown change
    document.getElementById("sort-select").addEventListener("change", function () {
        var selectedIndex = this.value;
        if (selectedIndex === "6") { // If expiry date is selected
            sortTableByExpiryDate();
        } else if (selectedIndex === "5") { // If manufacturing date is selected
            sortTableByManufacturingDate();
        } else if (selectedIndex === "9") { // If M.R.P is selected
            sortTableByMRP();
        } else if (selectedIndex === "8") { // If Quantity is selected
            sortTableByQuantity();
        } else if (selectedIndex === "2") { // If Medicine Name is selected
            sortTableByMedicineName();
        } else if (selectedIndex === "7") { // If Pack is selected
            sortTableByPack();
        } else {
            sortTable(selectedIndex - 1);
        }
    });
});