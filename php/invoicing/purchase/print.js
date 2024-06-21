 //"$invoice\", \"$medname\", \"$date\", \"$batchId\", \"$quantity\", \"$mrp\" ,\"$discount\", \"$gst\", \"$netpurchase\",\"$pay\")
 function printInvoice(invoiceNo, medName, pdate, batchId, quantity, mrp,discount, gst, netpurchase, pay, sup) {
    var printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><style>body {margin: 0;padding: 0;font-family: Arial, sans-serif;text-align: center;}h1, h2, p {margin: 0;padding: 0;}table {width: 100%;border-collapse: collapse;}th, td {border: 1px solid black;padding: 8px;text-align: left;}</style></head><body>');
    printWindow.document.write('<h1>Maharashtra Medical</h1>');
    printWindow.document.write('<p>Shop 6, Chandresh Society, Station Road,</p>');
    printWindow.document.write("<p>Nallasopara(W), Palghar, Maharashtra</p>");
    printWindow.document.write("<p style = 'margin-top:2px;'>Tel:02223466672 / 02276346532</p>");
    printWindow.document.write("<p style = 'margin-top:2px;'>(Mob):996757323 / 9978745705</p><br>");
    printWindow.document.write("<h2>Purchase Order</h2><br>");
    printWindow.document.write("<h4 style = 'text-align:left;'>Payment Mode: " + pay + "</h4>");
    printWindow.document.write("<h4 style = 'text-align:left;'>Date: "+ pdate +"</h4>");
    printWindow.document.write("<h4 style = 'text-align:left;'>GSTIN No: 27AAAAP0267H2ZN</h4>");
    printWindow.document.write("<h4 style = 'text-align:left;'>Supplier: "+ sup +"</h4>");
    printWindow.document.write('<hr style = "font-weight:bold;"><br>');
    printWindow.document.write("<table border='1'><tr><th>P.O No</th><th>Description</th><th>Batch ID</th><th>Qty</th><th>MRP (Rs.)</th><th>Discount (%)</th><th>GST (%)</th><th>Grand Total</th></tr>");
    printWindow.document.write("<tr><td>" + invoiceNo + "</td><td>" + medName + "</td><td>" + batchId + "</td><td>" + quantity + "</td><td>"+ mrp +"</td><td>" + discount + "</td><td>" + gst + "</td><td>" + netpurchase + "</td></tr>");
    printWindow.document.write("</table></body></html>");
    printWindow.document.write('<br><hr style = "font-weight:bold;">');
    printWindow.document.write("<h3 style = 'text-align:left; margin-bottom:0;'>Note:</h3><br>");
    printWindow.document.write("<p style = 'text-align:left;'>1) Goods will be strictly exchanged within 7 days.</p>");
    printWindow.document.write("<p style = 'text-align:left;'>2) Keep Copy of P.O as proof of maintaining records.</p>");
    printWindow.document.write("<p style = 'text-align:left;'>3) Maxiumum Discount Applicable is 15%.</p>");
    printWindow.document.write("<p style = 'text-align:left;'>4) GST is consists of SGST and CGST and is included in the MRP (Max GST - 18%).</p>");
    printWindow.document.write("<p style = 'text-align:left;'>5) For any enquiry, please contact the store manager.</p>");
    printWindow.document.write("<hr style = 'font-weight:bold;'>");
    printWindow.document.close();
    printWindow.print();
}