<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
require '../DB/db_con.php'; // Adjust path as per your file structure
require '../tcpdf/tcpdf.php'; // Adjust path as per your file structure
session_start();

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    try {
        $sql = "SELECT orders.order_id, orders.date_ordered, orders.delivery_option, 
                       users.first_name, users.last_name, users.email, users.phone_number,
                       orders_details.quantity, products.prod_name, orders_details.price, 
                       users.role, address.street, address.barangay, address.municipality,
                       orders.total_price
                FROM orders
                INNER JOIN orders_details ON orders.order_id = orders_details.order_id
                INNER JOIN products ON orders_details.product_id = products.product_id
                INNER JOIN users ON orders.user_id = users.user_id
                INNER JOIN address ON orders.address_id = address.address_id
                WHERE orders.order_id = :order_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($orderDetails)) {
            die('Order not found.');
        }

        // Get total price and delivery option directly from the orders table
        $totalPrice = $orderDetails[0]['total_price'];
        $orderDate = date('Y-m-d', strtotime($orderDetails[0]['date_ordered']));
        $deliveryOption = ucfirst($orderDetails[0]['delivery_option']);

        // Determine shipping fee based on delivery option
        $shippingFee = ($deliveryOption == 'Delivery') ? 50 : 0;

        // VAT details (example values)
        $vatRate = 12; // VAT rate in percentage

        // Example values for VAT exempt and zero-rated sales
        $vatExemptSales = 0; // Total amount of VAT exempt sales (if applicable)
        $zeroRatedSales = 0; // Total amount of zero-rated sales (if applicable)

        // Calculate VATable sales, VAT amount, and other amounts
        $vatableSales = $totalPrice - $vatExemptSales - $zeroRatedSales;
        $vatAmount = ($vatableSales * $vatRate) / 100;

        // Create PDF receipt
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('4M Minimart');
        $pdf->SetTitle('Order Receipt');
        $pdf->SetSubject('Order Receipt');
        $pdf->SetKeywords('TCPDF, PDF, receipt, order');
        $pdf->AddPage();

        // Store details
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, '4M Minimart', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, '123 Store Avenue, City, Country', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Contact: +1234567890', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Email: info@4mminimart.com', 0, 1, 'C');
        $pdf->Ln();

        // Header
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Order Receipt', 0, 1, 'C');

        // Order details
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'Order ID: ' . $order_id, 0, 1);
        $pdf->Cell(0, 10, 'Order Date: ' . $orderDate, 0, 1);
        $pdf->Cell(0, 10, 'Customer: ' . $orderDetails[0]['first_name'] . ' ' . $orderDetails[0]['last_name'], 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $orderDetails[0]['email'], 0, 1);
        $pdf->Cell(0, 10, 'Phone: ' . $orderDetails[0]['phone_number'], 0, 1);
        $pdf->Cell(0, 10, 'Delivery Address: ' . $orderDetails[0]['street'] . ', ' . $orderDetails[0]['barangay'] . ', ' . $orderDetails[0]['municipality'], 0, 1);
        $pdf->Cell(0, 10, 'Delivery Option: ' . $deliveryOption, 0, 1);

        // Products table
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(80, 10, 'Product', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Quantity', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Unit Price', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Total Price', 1, 1, 'C');

        $pdf->SetFont('helvetica', '', 12);
        foreach ($orderDetails as $order) {
            $pdf->Cell(80, 10, $order['prod_name'], 1, 0, 'L');
            $pdf->Cell(40, 10, $order['quantity'], 1, 0, 'C');
            $pdf->Cell(40, 10, '$' . number_format($order['price'], 2), 1, 0, 'R');
            $pdf->Cell(40, 10, '$' . number_format($order['quantity'] * $order['price'], 2), 1, 1, 'R');
        }

        // Additional charges (Shipping fee)
        if ($shippingFee > 0) {
            $pdf->Cell(160, 10, 'Shipping Fee:', 1, 0, 'R');
            $pdf->Cell(40, 10, '$' . number_format($shippingFee, 2), 1, 1, 'R');
        }

        // Subtotal
        $pdf->Cell(160, 10, 'Subtotal:', 1, 0, 'R');
        $pdf->Cell(40, 10, '$' . number_format($totalPrice, 2), 1, 1, 'R');

        // VATable Sales
        $pdf->Cell(160, 10, 'VATable Sales:', 1, 0, 'R');
        $pdf->Cell(40, 10, '$' . number_format($vatableSales, 2), 1, 1, 'R');

        // VAT Amount
        $pdf->Cell(160, 10, 'VAT (' . $vatRate . '%):', 1, 0, 'R');
        $pdf->Cell(40, 10, '$' . number_format($vatAmount, 2), 1, 1, 'R');

        // Total price including VAT (unchanged for display)
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(160, 10, 'Total Price (incl. VAT):', 1, 0, 'R');
        $pdf->Cell(40, 10, '$' . number_format($totalPrice + $shippingFee + $vatAmount, 2), 1, 1, 'R');

        // Output PDF
        $pdf->Output('order_receipt_' . $order_id . '.pdf', 'D');
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
