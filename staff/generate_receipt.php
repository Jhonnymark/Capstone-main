<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
require '../DB/db_con.php';
require '../tcpdf/tcpdf.php'; 
session_start();

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    try {
        $sql = "SELECT orders.order_id, orders.date_ordered, orders.delivery_option, users.first_name, users.last_name, 
                       orders_details.quantity, products.prod_name, orders_details.price, 
                       users.role, address.street, address.barangay, address.municipality, orders.total_price
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

        // Get total price and delivery option directly from the orders table
        $totalPrice = $orderDetails[0]['total_price'];
        $orderDate = $orderDetails[0]['date_ordered'];
        $deliveryOption = $orderDetails[0]['delivery_option'];

        // Determine shipping fee based on delivery option
        $shippingFee = ($deliveryOption == 'pickup') ? 0 : 50;
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }

    // Generate PDF receipt
    if (!empty($orderDetails)) {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('4M Minimart');
        $pdf->SetTitle('Order Receipt');
        $pdf->SetSubject('Order Receipt');
        $pdf->SetKeywords('TCPDF, PDF, receipt, order');

        // Add a page
        $pdf->AddPage();

        $pdf->SetFont('helvetica', '', 12);

        // Output order details
        // $pdf->Cell(0, 10, 'Order ID: ' . $order_id, 0, 1);
        $pdf->Cell(0, 10, 'Order Date: ' . $orderDate, 0, 1);
        $pdf->Cell(0, 10, 'Customer: ' . $orderDetails[0]['first_name'] . ' ' . $orderDetails[0]['last_name'], 0, 1);
        // $pdf->Cell(0, 10, 'Role: ' . $orderDetails[0]['role'], 0, 1);

        $pdf->Cell(0, 10, 'Address: ' . $orderDetails[0]['street'] . ', ' . $orderDetails[0]['barangay'] . ', ' . $orderDetails[0]['municipality'], 0, 1);
        $pdf->Ln();

        // Output delivery option
        // $pdf->Cell(0, 10, 'Delivery Option: ' . ucfirst($deliveryOption), 0, 1);
        // $pdf->Ln();

        // Create table header without border
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(80, 10, 'Product', 0);
        $pdf->Cell(40, 10, 'Quantity', 0);
        $pdf->Cell(40, 10, 'Unit Price', 0);
        $pdf->Ln();

        $pdf->SetFont('helvetica', '', 12);

        foreach ($orderDetails as $order) {
            $pdf->Cell(80, 10, $order['prod_name'], 0);
            $pdf->Cell(40, 10, $order['quantity'], 0);
            $pdf->Cell(40, 10, $order['price'], 0);
            $pdf->Ln();
        }
         // Output shipping fee if delivery option is 'delivery'
         if ($deliveryOption == 'delivery') {
            $pdf->Cell(80, 10, '', 0);
            $pdf->Cell(40, 10, 'Shipping Fee:', 0);
            $pdf->Cell(40, 10, $shippingFee, 0);
            $pdf->Ln();
        }

        $pdf->Cell(80, 10, '', 0);
        $pdf->Cell(40, 10, 'Total Price:', 0);
        $pdf->Cell(40, 10, $totalPrice, 0);

        // Output PDF
        $pdf->Output('order_receipt_' . $order_id . '.pdf', 'D');
    }
}
?>
