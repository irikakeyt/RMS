<?php
// Ensure session is started only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "conn.php";

// add new tenant
if(isset($_POST['submit'])){
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $roomnum = $_POST['roomnum'];
    $deposit = $_POST['deposit'];
    $roomprice = $_POST['roomprice'];
    $date = $_POST['date'];

    // Check if the room number already exists
    $check_room_query = "SELECT * FROM newtenant WHERE room_num = '$roomnum'";
    $check_room_result = mysqli_query($conn, $check_room_query);
    if(mysqli_num_rows($check_room_result) > 0){
        echo "<script>
        alert('Room number $roomnum is already taken! Please choose another room.');
        window.location='addtenants.php';
        </script>";
    } else {
        // Room number is available, proceed with insertion
        $insert = mysqli_query ($conn, "INSERT INTO newtenant VALUES('0','$lname','$fname','$age','$gender','$address','$contact','$roomnum','$deposit','$roomprice','$date')");
        
        if($insert == true){
            header("Location: tenantsinfo.php");
            exit();
        } else {
            echo "<script>alert('Failed to add tenant!');</script>";
        }
    }
}

//update tenant details
if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $roomnum = $_POST['roomnum'];
    $deposit = $_POST['deposit'];
    $roomprice = $_POST['roomprice'];
    $date = $_POST['date'];

    // Check if the room is available
    $room_check_sql = "SELECT * FROM newtenant WHERE room_num='$roomnum' AND id<>'$id'";
    $room_check_result = mysqli_query($conn, $room_check_sql);
    if(mysqli_num_rows($room_check_result) > 0) {
        echo "<script>
        alert('Room number $roomnum is already taken! Please choose another room.');
        window.location='tenantsinfo.php';
      </script>";
        exit;
    }

    $sql = "UPDATE newtenant SET lname='$lname', fname='$fname', age='$age', gender='$gender', address='$address', contact='$contact', room_num='$roomnum',adv='$deposit', room_price='$roomprice', date_occupied='$date' WHERE id='$id'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}



//this code is for create account

if(isset($_POST['create'])) {
    // Get form data
    $picname = $_FILES['pic']['name'];
    $fileTemplate = $_FILES['pic']['tmp_name'];
    $fn = $_POST['fn'];
    $ln = $_POST['ln'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $val = mysqli_query($conn, "SELECT * FROM landlord WHERE email = '$email'");
    $val_num = mysqli_num_rows($val);

    if($val_num <= 0) {
        $insert = mysqli_query($conn, "INSERT INTO landlord (profile_pic, fname, lname, email, password) VALUES ('$picname', '$fn', '$ln', '$email', '$pass')");

        if($insert) {
            $fileDestination = 'upload/'.$picname;
            if(move_uploaded_file($fileTemplate, $fileDestination)) {
                echo "<script>
                alert('Account Registered Successfully!'); 
                window.location.href='index.php';</script>";
                exit;
            } else {
                echo 
                "<script>
                    alert('Error moving uploaded file!');
                </script>";
            }
        } else {
            echo "<script>
            alert('Registration Failed! MySQL Error: " . mysqli_error($conn) . "');
            </script>";
        }
    } else {
        echo "<script>
        alert('EMAIL ALREADY EXISTS!'); 
        window.location.href='dashboard.php';
        </script>";
    }
}





//login
if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];


    $check = mysqli_query($conn, "SELECT * FROM landlord WHERE email='$email' AND password ='$pass'");
    $num_check = mysqli_num_rows($check);

    if($num_check <= 0) {
        $_SESSION['error_message'] = "Incorrect email or password. Please try again.";
        header("Location: index.php");
        exit(); 
    } else {
        $_SESSION['email'] = $email; 
        header("Location: dashboard.php"); 
        exit();
    }
}


//delete
if (isset($_GET['del_id']) && !empty($_GET['del_id'])) {
    $tenant_id = mysqli_real_escape_string($conn, $_GET['del_id']);
    $sql = "DELETE FROM newtenant WHERE id = $tenant_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: tenantsinfo.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

//changepassword


if(isset($_POST['change'])) {
    $newPassword = $_POST['new'];
    $confirmPassword = $_POST['confirm'];

    if($newPassword === $confirmPassword) {
        $email = $_SESSION['email'];
        $updatePasswordQuery = "UPDATE landlord SET password = '$newPassword' WHERE email = '$email'";

        if(mysqli_query($conn, $updatePasswordQuery)) {
            echo "<script>alert('Password changed successfully!');</script>";
            header("Location: index.php?success=password_changed");
            exit();
        } else {
            echo "<script>alert('Failed to update password!');</script>";
        }
    } else {
        echo "<script>alert('New password and confirmation password do not match!');</script>";
        header("Location: dashboard.php?error=password_mismatch");
        exit();
    }
}
if(isset($_POST['pay'])){
    // Extract form data
    $invoice = $_POST['invoice'];
    $payment_date = $_POST['payment_date'];
    $tenant_id = $_POST['tenant_id']; // Add tenant_id from the form

    // Add validation to ensure that required input values are not empty
    if(empty($invoice) || empty($payment_date) || empty($tenant_id)) {
        echo "<script>alert('Please fill in all required fields!'); window.location='payment.php';</script>";
        exit(); // Stop execution if any required field is empty
    }

    // Check if the checkbox for deducting from deposit is checked
    if(isset($_POST['from_deposit'])) {
        // Get the remaining deposit amount from the newtenant table
        $query = "SELECT adv FROM newtenant WHERE id = $tenant_id";
        $result = mysqli_query($conn, $query);
        if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $remaining_deposit = $row['adv'];
            mysqli_free_result($result);
        } else {
            echo "<script>alert('Error retrieving remaining deposit!');</script>";
            exit();
        }

        // Deduct the payment amount from the remaining deposit
        $payment_amount = $remaining_deposit;

        // Update the remaining deposit in the newtenant table
        $new_remaining_deposit = 0;
        $update_query = "UPDATE newtenant SET adv = $new_remaining_deposit WHERE id = $tenant_id";
        $update_result = mysqli_query($conn, $update_query);
        if(!$update_result) {
            echo "<script>alert('Error updating remaining deposit!');</script>";
            exit();
        }
    } else {
        // If checkbox is not checked, validate and extract payment_amount
        $payment_amount = $_POST['payment_amount'];

        // Validate payment_amount if needed
        // For example, checking if it's numeric, non-negative, etc.
    }

    // Escape values to prevent SQL injection (assuming $conn is your database connection)
    $invoice = mysqli_real_escape_string($conn, $invoice);
    $payment_date = mysqli_real_escape_string($conn, $payment_date);
    $tenant_id = mysqli_real_escape_string($conn, $tenant_id);

    // Construct the SQL query
    $sql = "INSERT INTO payments (payment_date, payment_amount, invoice, tenant_id) VALUES ('$payment_date', '$payment_amount', '$invoice', '$tenant_id')";

    // Execute the query
    $insert = mysqli_query($conn, $sql);

    // Check if the query was successful
    if($insert) {
        // Redirect to payments.php after successful insertion
        header("Location: payment.php");
        exit();
    } else {
        // Display error message if insertion failed
        echo "<script>alert('Failed to add payment!');</script>";
    }
}



//for selecting in payment
if(isset($_GET['tenant_id'])) {
    // Sanitize the input to prevent SQL injection
    $tenantId = mysqli_real_escape_string($conn, $_GET['tenant_id']);
    
    // SQL query to select tenant details based on the provided tenant_id
    $query = "SELECT id, fname, lname, room_num, room_price, adv, date_occupied FROM newtenant WHERE id = '$tenantId'";
    
    // Execute the query
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $tenant = mysqli_fetch_assoc($result);
            
            // Get payment details for the tenant
            $paymentQuery = "SELECT SUM(payment_amount) AS total_paid FROM payments WHERE tenant_id = '$tenantId'";
            $paymentResult = mysqli_query($conn, $paymentQuery);
            
            if ($paymentResult) {
                $paymentData = mysqli_fetch_assoc($paymentResult);
                $tenant['total_paid'] = $paymentData['total_paid'];
            } else {
                $tenant['total_paid'] = 0; // If no payments found, set total paid to 0
            }
            
            // Calculate remaining balance
            $roomPrice = floatval($tenant['room_price']);
            $paymentAmount = floatval($tenant['total_paid']);
            $remainingBalance = $roomPrice - $paymentAmount;
            
            // Calculate the number of months passed since the date occupied
            $dateOccupied = new DateTime($tenant['date_occupied']);
            $currentDate = new DateTime();
            $monthsPassed = $currentDate->diff($dateOccupied)->m + ($currentDate->diff($dateOccupied)->y * 12);
            
            // Calculate remaining balance based on monthly addition of room price
            $remainingBalance += $roomPrice * $monthsPassed;
            
            // Calculate due date (1 month after the date occupied)
            $dueDate = $dateOccupied->modify('+' . $monthsPassed + 1 . ' month')->format('Y-m-d');
            
            // Include remaining balance and due date in tenant data
            $tenant['remaining_balance'] = $remainingBalance;
            $tenant['due_date'] = $dueDate;
            
            // Send JSON response with tenant details
            echo json_encode(array('success' => true, 'data' => $tenant));
        } else {
            echo json_encode(array('success' => false, 'message' => 'No tenant found with the provided ID'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error executing the query: ' . mysqli_error($conn)));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Tenant ID parameter is missing'));
}

function calculateRemainingMonths($dateOccupied) {
    $dateOccupied = new DateTime($dateOccupied);
    $now = new DateTime();
    $diff = $now->diff($dateOccupied);
    $remainingMonths = ($diff->y * 12) + $diff->m + 1; 
    return $remainingMonths;
}






//payment delete

if (isset($_GET['del']) && !empty($_GET['del'])) {
    $payment_id = mysqli_real_escape_string($conn, $_GET['del']);
    $sql = "DELETE FROM payments WHERE payment_id = $payment_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: payment.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}



//edit payment
if(isset($_POST['save'])) {
    // Extract form data
    $invoice = $_POST['invoice'];
    $paymentAmount = $_POST['payment_amount'];
    $paymentDate = $_POST['payment_date'];

    // Validate form data
    if(empty($invoice) || empty($paymentAmount) || empty($paymentDate)) {
        // Handle empty fields
        echo "Please fill in all required fields!";
        exit();
    }
    header("Location: payments.php");
    exit();
}

?>













