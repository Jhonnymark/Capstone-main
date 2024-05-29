<?php
include '../DB/db_con.php';

$query = "SELECT category_id, category_name FROM category";
$result = $pdo->query($query);

if ($result->rowCount() > 0) {
    $options = '';

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $options .= '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
    }
    echo $options;
} else {
    echo '<option value="">No categories found</option>';
}
?>
