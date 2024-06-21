document.addEventListener("DOMContentLoaded", function () {
    // Function to sort table rows by Supplier ID

    function sortTableBySupplierID() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.querySelector("table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = parseInt(rows[i].getElementsByTagName("td")[1].innerText); // 1st column is the Supplier ID column
                y = parseInt(rows[i + 1].getElementsByTagName("td")[1].innerText); // 1st column is the Supplier ID column
                if (x < y) {
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

    // Function to sort table rows by Supplier Name
    function sortTableBySupplierName() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.querySelector("table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[2].innerText.toLowerCase(); // 2nd column is the Supplier Name column
                y = rows[i + 1].getElementsByTagName("td")[2].innerText.toLowerCase(); // 2nd column is the Supplier Name column
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

    // Function to sort table rows by Supplier Address
    function sortTableBySupplierAddress() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.querySelector("table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[5].innerText.toLowerCase(); // 5th column is the Supplier Address column
                y = rows[i + 1].getElementsByTagName("td")[5].innerText.toLowerCase(); // 5th column is the Supplier Address column
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
    function sortTableBySupplierRegDate() {
        var table, rows, switching, i, shouldSwitch;
        table = document.querySelector("table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                let date1 = new Date(rows[i].getElementsByTagName("td")[6].innerText).getTime();
                let date2 = new Date(rows[i + 1].getElementsByTagName("td")[6].innerText).getTime();
                if (date1 > date2) {
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
        if (selectedIndex === "1") { // If Supplier ID is selected
            sortTableBySupplierID();
        } else if (selectedIndex === "2") { // If Supplier Name is selected
            sortTableBySupplierName();
        } else if (selectedIndex === "3") { // If Supplier Address is selected
            sortTableBySupplierAddress();
        } else if (selectedIndex === "4") { // If Supplier Registration Date is selected
            sortTableBySupplierRegDate();
        }
    });
});