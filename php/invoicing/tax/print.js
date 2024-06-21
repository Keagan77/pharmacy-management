function printInvoice(invoiceNo, medName, salesDate, batchId, quantity, sp,discount, gst, totalSales, pay, cname) {
    var printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Printable Invoice</title><style>body {margin: 0;padding: 0;font-family: Arial, sans-serif;text-align: center;}h1, h2, p {margin: 0;padding: 0;}table {width: 100%;border-collapse: collapse;}th, td {border: 1px solid black;padding: 8px;text-align: left;}</style></head><body>');
    printWindow.document.write('<h1>Maharashtra Medical</h1>');
    printWindow.document.write('<p>Shop 6, Chandresh Society, Station Road,</p>');
    printWindow.document.write("<p>Nallasopara(W), Palghar, Maharashtra</p>");
    printWindow.document.write("<p style = 'margin-top:2px;'>Tel:02223466672 / 02276346532</p>");
    printWindow.document.write("<p style = 'margin-top:2px;'>(Mob):996757323 / 9978745705</p><br>");
    printWindow.document.write("<h2>Tax Invoice</h2><br>");
    printWindow.document.write("<h4 style = 'text-align:left;'>Customer Name: " + cname + "</h4>");
    printWindow.document.write("<h4 style = 'text-align:left;'>Payment Mode: " + pay + "</h4>");
    printWindow.document.write("<h4 style = 'text-align:left;'>Date: "+ salesDate +"</h4>");
    printWindow.document.write("<h4 style = 'text-align:left'>GSTIN No - 27AAAAP0267H2ZN</h4>")
    printWindow.document.write('<hr style = "font-weight:bold;"><br>');
    printWindow.document.write("<table border='1'><tr><th>Invoice No</th><th>Description</th><th>Batch ID</th><th>Qty</th><th>Unit Price (Rs.)</th><th>Discount (%)</th><th>GST (%)</th><th>Grand Total</th></tr>");
    printWindow.document.write("<tr><td>" + invoiceNo + "</td><td>" + medName + "</td><td>" + batchId + "</td><td>" + quantity + "</td><td>"+ sp +"</td><td>" + discount + "</td><td>" + gst + "</td><td>" + totalSales + "</td></tr>");
    printWindow.document.write("</table></body></html>");
    printWindow.document.write('<br><hr style = "font-weight:bold;">');
    printWindow.document.write("<h3 style = 'text-align:left; margin-bottom:0;'>Note:</h3><br>");
    printWindow.document.write("<p style = 'text-align:left;'>1) Unit price is always less than the MRP.</p>");
    printWindow.document.write("<p style = 'text-align:left;'>2) Tax Invoice generated is proof that the payment has been settled.</p>");
    printWindow.document.write("<p style = 'text-align:left;'>3) Maxiumum Discount Applicable is 15%.</p>");
    printWindow.document.write("<p style = 'text-align:left;'>4) GST is consists of SGST & CGST and is inclusive in the MRP (Max GST - 18%).</p>");
    printWindow.document.write("<p style = 'text-align:left;'>5) Exchange within 3 days with valid tax invoice.</p>");
    printWindow.document.write("<hr style = 'font-weight:bold;'>");
    printWindow.document.close();
    printWindow.print();
}