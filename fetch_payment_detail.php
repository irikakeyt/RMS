<?php
// Include your database connection
include "conn.php";

// Check if the payment_id parameter is provided
if(isset($_GET['payment_id'])) {
    $paymentId = $_GET['payment_id'];

    // Query to fetch payment details from the database based on payment_id
    $sql = "SELECT * FROM payments WHERE payment_id = $paymentId";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        // Payment details found, fetch the data
        $row = mysqli_fetch_assoc($result);

        // Prepare payment details array
        $paymentDetails = array(
            'invoice' => $row['invoice_number'],
            'payment_amount' => $row['payment_amount'],
            'payment_date' => $row['payment_date']
            // Add more payment details here if needed
        );

        // Return success response with payment details as JSON
        echo json_encode(array('success' => true, 'data' => $paymentDetails));
    } else {
        // Payment not found
        echo json_encode(array('success' => false, 'message' => 'Payment details not found'));
    }
} else {
    // Payment_id parameter not provided
    echo json_encode(array('success' => false, 'message' => 'Payment ID parameter not provided'));
}
?>
