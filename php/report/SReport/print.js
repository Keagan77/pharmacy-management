function printTable() {
    let startDate = document.getElementById("start").value;
    let endDate = document.getElementById("end").value;
    let printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<link rel="stylesheet" type="text/css" href="table.css">'); // Include external CSS file
    printWindow.document.write('<style>');
    printWindow.document.write('@media print { .navbar { display: none; } }'); // Hide navbar when printing
    printWindow.document.write('#salesTable { border-collapse: collapse; width: 100%; }');
    printWindow.document.write('#salesTable th, #salesTable td { border: 1px solid #dddddd; text-align: left; padding: 8px; }');
    printWindow.document.write('#salesTable th { background-color: #f2f2f2; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h1 style="text-align:center;margin-bottom:0;">Maharashtra Medical</h1>');
    printWindow.document.write('<p style="text-align:center;margin:0;padding:0;">Shop 6, Chandresh Society, Station Road,</p>');
    printWindow.document.write("<p style='text-align:center;margin:0;padding:0;'>Nallasopara(W), Palghar, Maharashtra</p>");
    printWindow.document.write("<p style='text-align:center;margin:0;padding:0;'>Tel:02223466672 / 02276346532</p>");
    printWindow.document.write("<p style='text-align:center;margin:0;padding:0;'>(Mob):996757323 / 9978745705</p><br>"); // Address added here
    printWindow.document.write("<hr style='font-weight:bold'>");
    printWindow.document.write("<h2 style='text-align:center;text-decoration:underline;'>Sales Report</h2>");

    // Condition to display start and end date
    if (startDate && endDate) {
        printWindow.document.write('<h4>Start Date: ' + startDate + '</h4>'); 
        printWindow.document.write('<h4>End Date: ' + endDate + '</h4><br>'); 
    }
    
    printWindow.document.write(document.getElementById('salesTable').outerHTML);
    printWindow.document.write("<br><br><hr style='font-weight:bold'>");
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
