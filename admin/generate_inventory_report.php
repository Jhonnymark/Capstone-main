<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
require '../DB/db_con.php'; // Adjust path as per your file structure
require '../tcpdf/tcpdf.php'; // Adjust path as per your file structure

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stock_status = $_POST['stock_status'];

    $query = "SELECT * FROM products WHERE 1=1"; // Start query with 1=1 to easily append conditions

    // Determine in_stock and out_of_stock conditions
    if ($stock_status === 'in_stock') {
        $query .= " AND stock > 0 AND stock < 10";
    } elseif ($stock_status === 'out_of_stock') {
        $query .= " AND stock = 0";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Inventory Report', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(40, 10, 'Product ID', 1);
        $pdf->Cell(80, 10, 'Product Name', 1);
        $pdf->Cell(20, 10, 'Stock', 1);
        $pdf->Ln();

        $pdf->SetFont('helvetica', '', 10);
        foreach ($result as $row) {
            $pdf->Cell(40, 10, $row['product_id'], 1);
            $pdf->Cell(80, 10, $row['prod_name'], 1);
            $pdf->Cell(20, 10, $row['stock'] > 0 ? ($row['stock'] < 10 ? 'In Stock' : 'Out of Stock') : 'Out of Stock', 1);
            $pdf->Ln();
        }

        $pdf->Output();
    } else {
        echo 'No products found for the selected criteria.';
    }

    // Close PDO connection (set to null)
    $pdo = null;
}
?>
