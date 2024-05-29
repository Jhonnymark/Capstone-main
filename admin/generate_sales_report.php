<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
require '../DB/db_con.php';
require_once('../tcpdf/tcpdf.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedMonth = intval($_POST['month']);
    $selectedYear = intval($_POST['year']);

    try {
        // Calculate the first and last day of the selected month
        $firstDayOfMonth = date('Y-m-01', strtotime("$selectedYear-$selectedMonth-01"));
        $lastDayOfMonth = date('Y-m-t', strtotime("$selectedYear-$selectedMonth-01"));
        $selectedMonthFormatted = date('F Y', strtotime("$selectedYear-$selectedMonth-01"));

        // Modify the SQL query to filter orders created within the selected month
        $sql = "SELECT o.order_id, o.order_status, u.first_name, a.barangay, a.street,
                       p.prod_name, od.quantity, od.price, (od.quantity * od.price) as total
                FROM orders o
                INNER JOIN users u ON o.user_id = u.user_id
                INNER JOIN address a ON o.address_id = a.address_id
                INNER JOIN orders_details od ON o.order_id = od.order_id
                INNER JOIN products p ON od.product_id = p.product_id
                WHERE DATE(o.date_ordered) BETWEEN :firstDayOfMonth AND :lastDayOfMonth"; 

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':firstDayOfMonth', $firstDayOfMonth); 
        $stmt->bindParam(':lastDayOfMonth', $lastDayOfMonth); 
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate total amount
        $totalAmount = 0;
        foreach ($orders as $order) {
            $totalAmount += $order['total'];
        }

        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('4M MINIMART');
        $pdf->SetTitle('Monthly Orders Report');
        $pdf->SetSubject('Orders Report');
        $pdf->SetKeywords('TCPDF, PDF, report, orders, monthly');
        
        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Set font
        $pdf->SetFont('dejavusans', '', 10);

        // Add a page
        $pdf->AddPage();

        // Create an HTML content string
        $html = '<h1>Monthly Orders Report</h1>';
        $html .= '<p>Month: ' . $selectedMonthFormatted . '</p>';
        $html .= '<table border="1" cellspacing="0" cellpadding="4">'; 

        $html .= '<tr style="background-color: #f2f2f2;">
                    <th>Order ID</th>
                    <th>First Name</th>
                    <th>Street</th>
                    <th>Barangay</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                  </tr>';

        foreach ($orders as $order) {
            $html .= '<tr>
                        <td>' . $order['order_id'] . '</td>
                        <td>' . $order['first_name'] . '</td>
                        <td>' . $order['street'] . '</td>
                        <td>' . $order['barangay'] . '</td>
                        <td>' . $order['prod_name'] . '</td>
                        <td>' . $order['quantity'] . '</td>
                        <td>' . $order['price'] . '</td>
                        <td>' . $order['total'] . '</td>
                    </tr>';
        }

        // Add total row
        $html .= '<tr>
                    <td colspan="7" style="text-align: right;"><strong>Total Amount:</strong></td>
                    <td>' . number_format($totalAmount, 2) . '</td>
                  </tr>';

        $html .= '</table>';

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        $pdf->Output('monthly_orders_report_' . date('Y_m', strtotime("$selectedYear-$selectedMonth-01")) . '.pdf', 'I');

        $stmt = null;

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>
