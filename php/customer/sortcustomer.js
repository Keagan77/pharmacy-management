document.addEventListener("DOMContentLoaded", function () {
  // Function to sort table rows by Customer Name
  function sortTableByCustomerName() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.querySelector("table");
    switching = true;
    while (switching) {
      switching = false;
      rows = table.getElementsByTagName("tr");
      for (i = 1; i < rows.length - 1; i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("td")[2].innerText.toLowerCase(); // 2nd column is the Customer Name column
        y = rows[i + 1].getElementsByTagName("td")[2].innerText.toLowerCase(); // 2nd column is the Customer Name column
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

  // Function to sort table rows by Customer Address
  function sortTableByCustomerAddress() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.querySelector("table");
    switching = true;
    while (switching) {
      switching = false;
      rows = table.getElementsByTagName("tr");
      for (i = 1; i < rows.length - 1; i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("td")[4].innerText.toLowerCase(); // 4th column is the Customer Address column
        y = rows[i + 1].getElementsByTagName("td")[4].innerText.toLowerCase(); // 4th column is the Customer Address column
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

  // Function to sort table rows by Hospital Name
  function sortTableByHospitalName() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.querySelector("table");
    switching = true;
    while (switching) {
      switching = false;
      rows = table.getElementsByTagName("tr");
      for (i = 1; i < rows.length - 1; i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("td")[6].innerText.toLowerCase(); // 6th column is the Hospital Name column
        y = rows[i + 1].getElementsByTagName("td")[6].innerText.toLowerCase(); // 6th column is the Hospital Name column
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

  // Event listener for select dropdown change
  document
    .getElementById("sort-select")
    .addEventListener("change", function () {
      var selectedIndex = this.value;
      if (selectedIndex === "1") {
        // If Customer Name is selected
        sortTableByCustomerName();
      } else if (selectedIndex === "2") {
        // If Customer Address is selected
        sortTableByCustomerAddress();
      } else if (selectedIndex === "3") {
        // If Hospital Name is selected
        sortTableByHospitalName();
      }
    });
});
