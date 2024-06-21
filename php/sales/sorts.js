function parseDate(dateString) {
  var parts = dateString.split("/");
  return new Date(parts[2], parts[1] - 1, parts[0]);
}

function sortTableByInvoiceNo(tableId, column) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(tableId);
  switching = true;

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < rows.length - 1; i++) {
      shouldSwitch = false;

      x = rows[i].getElementsByTagName("td")[column].innerText.toLowerCase();
      y = rows[i + 1]
        .getElementsByTagName("td")
        [column].innerText.toLowerCase();

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

function sortTableByCustomer(tableId, column) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(tableId);
  switching = true;

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < rows.length - 1; i++) {
      shouldSwitch = false;

      x = rows[i].getElementsByTagName("td")[column].innerText.toLowerCase();
      y = rows[i + 1]
        .getElementsByTagName("td")
        [column].innerText.toLowerCase();

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

function sortTableByCustomer(tableId, column) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(tableId);
  switching = true;

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < rows.length - 1; i++) {
      shouldSwitch = false;

      x = rows[i].getElementsByTagName("td")[column].innerText.toLowerCase();
      y = rows[i + 1]
        .getElementsByTagName("td")
        [column].innerText.toLowerCase();

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

function sortTableByPaymentMethod(tableId, column) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(tableId);
  switching = true;

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < rows.length - 1; i++) {
      shouldSwitch = false;

      x = rows[i].getElementsByTagName("td")[column].innerText.toLowerCase();
      y = rows[i + 1]
        .getElementsByTagName("td")
        [column].innerText.toLowerCase();

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

    for (i = 1; i < rows.length - 1; i++) {
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

function sortTableBySellingPrice(tableId, column) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(tableId);
  switching = true;

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < rows.length - 1; i++) {
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

    for (i = 1; i < rows.length - 1; i++) {
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

    for (i = 1; i < rows.length - 1; i++) {
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

function sortTableByTotalSales(tableId, column) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(tableId);
  switching = true;

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < rows.length - 1; i++) {
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

function sortTableBySalesDate(tableId, column) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(tableId);
  switching = true;

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < rows.length - 1; i++) {
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

window.onload = function () {
  document
    .getElementById("sort-select")
    .addEventListener("change", function () {
      var selectedIndex = this.value;
      if (selectedIndex === "1") {
        sortTableByInvoiceNo("sales-table", 1);
      } else if (selectedIndex === "2") {
        sortTableByCustomer("sales-table", 2);
      } else if (selectedIndex === "3") {
        sortTableByMedicine("sales-table", 3);
      } else if (selectedIndex === "4") {
        sortTableByPaymentMethod("sales-table", 4);
      } else if (selectedIndex === "5") {
        sortTableByQuantity("sales-table", 5);
      } else if (selectedIndex === "6") {
        sortTableBySellingPrice("sales-table", 6);
      } else if (selectedIndex === "7") {
        sortTableByDiscount("sales-table", 7);
      } else if (selectedIndex === "8") {
        sortTableByGST("sales-table", 8);
      } else if (selectedIndex === "9") {
        sortTableByTotalSales("sales-table", 9);
      } else if (selectedIndex === "10") {
        sortTableBySalesDate("sales-table", 10);
        //sortTableByInvoiceNo("sales-table",1);
      }
    });
};
