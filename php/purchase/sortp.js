function parseDate(dateString) {
    var parts = dateString.split("-");
    // Note: parts[1]-1 because months are 0-indexed in JavaScript
    return new Date(parts[0], parts[1] - 1, parts[2]);
}

function sortTable(tableId, column, dataType) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("td")[column];
            y = rows[i + 1].getElementsByTagName("td")[column];

            if (dataType === "text") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dataType === "numeric") {
                if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
                    shouldSwitch = true;
                    break;
                }
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

function sortTableByMedName(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("td")[column];
            y = rows[i + 1].getElementsByTagName("td")[column];

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

function sortTableByInvoiceNo(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("td")[column];
            y = rows[i + 1].getElementsByTagName("td")[column];

            if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
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

function sortTableByPack(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = parseFloat(rows[i].getElementsByTagName("td")[column].innerText);
            y = parseFloat(rows[i + 1].getElementsByTagName("td")[column].innerText);

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


function sortTableBySupplier(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("td")[column];
            y = rows[i + 1].getElementsByTagName("td")[column];

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

function sortTableByPayOpt(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("td")[column];
            y = rows[i + 1].getElementsByTagName("td")[column];

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

function sortTableByMfgDate(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = parseDate(rows[i].getElementsByTagName("td")[column].innerText);
            y = parseDate(rows[i + 1].getElementsByTagName("td")[column].innerText);

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

function sortTableByExpDate(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = new Date(rows[i].getElementsByTagName("td")[column].innerText);
            y = new Date(rows[i + 1].getElementsByTagName("td")[column].innerText);

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

function sortTableByQuantity(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = parseInt(rows[i].getElementsByTagName("td")[column].innerText);
            y = parseInt(rows[i + 1].getElementsByTagName("td")[column].innerText);

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

function sortTableByMRP(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = parseFloat(rows[i].getElementsByTagName("td")[column].innerText);
            y = parseFloat(rows[i + 1].getElementsByTagName("td")[column].innerText);

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

function sortTableByDiscount(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = parseFloat(rows[i].getElementsByTagName("td")[column].innerText);
            y = parseFloat(rows[i + 1].getElementsByTagName("td")[column].innerText);

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

function sortTableByGST(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = parseFloat(rows[i].getElementsByTagName("td")[column].innerText);
            y = parseFloat(rows[i + 1].getElementsByTagName("td")[column].innerText);

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

function sortTableByNetPurchase(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = parseFloat(rows[i].getElementsByTagName("td")[column].innerText);
            y = parseFloat(rows[i + 1].getElementsByTagName("td")[column].innerText);

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

function sortTableByPurchaseDate(tableId, column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tableId);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = new Date(rows[i].getElementsByTagName("td")[column].innerText);
            y = new Date(rows[i + 1].getElementsByTagName("td")[column].innerText);

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

window.onload = function () {
    document.getElementById("sort-select").addEventListener("change", function () {
        var selectedIndex = this.value;
        if (selectedIndex === "1") {
            sortTable("purchase-table", 0, "numeric");
        } else if (selectedIndex === "3") {
            sortTableByMedName("purchase-table", 2);
        } else if (selectedIndex === "2") {
            sortTableByInvoiceNo("purchase-table", 1);
        } else if (selectedIndex === "4") {
            sortTableByPack("purchase-table", 3);
        } else if (selectedIndex === "5") {
            sortTableBySupplier("purchase-table", 4);
        } else if (selectedIndex === "6") {
            sortTableByPayOpt("purchase-table", 5);
        } else if (selectedIndex === "7") {
            sortTableByMfgDate("purchase-table", 7);
        } else if (selectedIndex === "8") {
            sortTableByExpDate("purchase-table", 8);
        } else if (selectedIndex === "9") {
            sortTableByQuantity("purchase-table", 9);
        } else if (selectedIndex === "10") {
            sortTableByMRP("purchase-table", 10);
        } else if (selectedIndex === "11") {
            sortTableByDiscount("purchase-table", 11);
        } else if (selectedIndex === "12") {
            sortTableByGST("purchase-table", 12);
        } else if (selectedIndex === "13") {
            sortTableByNetPurchase("purchase-table", 13);
        } else if (selectedIndex === "14") {
            sortTableByPurchaseDate("purchase-table", 14);
        }
    });
};