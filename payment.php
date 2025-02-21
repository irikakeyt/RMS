<?php
include "conn.php";
session_start();

if(empty($_SESSION)){
    ?>
    <script>
        alert("");
        window.location.href="dashboard.php";
    </script>
    <?php
}else{
    $e = $_SESSION['email'];
    $getdetails = mysqli_query($conn,"SELECT * FROM landlord WHERE email='$e' ");
    while($row = mysqli_fetch_object($getdetails)){
        $fn = $row -> fname;
        $ln = $row -> lname;
        $pic = $row -> profile_pic;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PAYMENT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
    /* Customize modal body background color */
    .modal-body {
        background-color: black; /* Replace with your desired color */
        color: white; /* Set text color to contrast with the background */
    }
    .modal-header {
        background-color: black; /* Replace with your desired color */
        color: white; /* Set text color to contrast with the background */
    }

    /* Customize modal footer background color */
    .modal-footer {
        background-color: black; /* Replace with your desired color */
        color: white; /* Set text color to contrast with the background */
    }
</style>


</style>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="dashboard.php" class="navbar-brand mx-4 mb-3">
            <img src="img/logo.png" alt="VECTO Corp. Logo" class="logo-img" style="width: 200px; height: 50px;">
        </a>
        <div class="navbar-nav w-100">
            <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-person me-2"></i>Tenants</a>
                <div class="dropdown-menu bg-transparent border-0 rounded-0 rounded-bottom m-0">
                    <a href="addtenants.php" class="dropdown-item">Add Tenants</a>
                    <a href="tenantsinfo.php" class="dropdown-item ">Tenants Information</a>
                </div>
            </div>
            <a href="addroom.php" class="nav-item nav-link"><i class="fa fa-bed me-2"></i>Rooms</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="bi bi-wallet me-2"></i>Payment</a>
                <div class="dropdown-menu bg-transparent border-0 rounded-0 rounded-bottom m-0">
                    <a href="payment.php" class="dropdown-item active">Payments Record</a>
                    <a href="payment_history.php" class="dropdown-item">Monthly Payment Record</a>
                </div>
            </div>
            <a href="about.php" class="nav-item nav-link"><i class="fas fa-info-circle me-2"></i>About Us</a>
        </div>
    </nav>
</div>
<!-- Sidebar End -->

<!--  CREATE ACCOUNT -->
<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-color: red;">
            <div class="modal-header" style="background-color: black; color: white; border-bottom: none;">
                <h5 class="modal-title" id="registrationModalLabel">REGISTRATION FORM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: black; color: white;">
                <form action="process.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profilePic" class="form-label">Profile Pic</label>
                        <input type="file" class="form-control" id="profilePic" accept=".jpg, .webp, .png, .jpeg, .gif, .jfif" style="background-color: black; color: white; padding: 5px 10px; border-radius: 5px;" name="pic">
                    </div>   
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="fn" placeholder="Enter your first name">
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="ln" placeholder="Enter your last name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="pass" placeholder="Password">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" value="Login" name="create">Submit</button>
                        <button type="reset" class="btn btn-primary" value="clear">Clear</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal End -->
<!-- Modal for Changing password -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-color: red;">
            <div class="modal-header" style="background-color: black; color: white; border-bottom: none;">
                <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: black; color: white;">
                <form action="process.php" method="POST" enctype="multipart/form-data">  
                    <div class="mb-3">
                        <label for="currentpassword" class="form-label">Old Password</label>
                        <input type="password" class="form-control" id="old" name="old" placeholder="Enter your current password">
                    </div>
                    <div class="mb-3">
                        <label for="newpassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new" name="new" placeholder="Enter your new password">
                    </div>
                    <div class="mb-3">
                        <label for="confirmpassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Confirm New Password">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" value="Change Password" name="change">Change Password</button>
                        <button type="reset" class="btn btn-primary" value="clear">Clear</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Profile Modal Start -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-color: red;">
                <div class="modal-header" style="background-color: black; color: white;">
                    <h5 class="modal-title" id="profileModalLabel">My Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="background-color: black; color: white;">
                    <div class="profile-picture mb-3">
                        <?php 
                        if(isset($pic) && !empty($pic)) {
                            echo '<img id="profilePic" src="./upload/'.$pic.'" class="rounded-circle" alt="Profile Picture" style="width: 150px; height: 150px;">';
                        } else {
                            echo '<p>No profile picture available.</p>';
                        }
                        ?>
                    </div>
                    <div class="profile-name">
                        <h5 id="fullName"><?php echo $fn . ' ' . $ln; ?></h5>
                    </div>

                </div>
            </div>
        </div>
    </div>

<!-- Profile Modal End -->


  
        <!-- Content Start -->
<div class="content">
  <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php 
                if(isset($pic) && !empty($pic)) {
                    echo '<img class="rounded-circle me-lg-2" src="./upload/'.$pic.'" alt="Profile Picture" style="width: 40px; height: 40px;">';
                } else {
                    echo '<img class="rounded-circle me-lg-2" src="img/user.jpg" alt="Default Profile Picture" style="width: 40px; height: 40px;">';
                }
                ?>
                <span class="d-none d-lg-inline-flex" style="color:white;"><?php echo $fn . ' ' . $ln; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0" aria-labelledby="dropdownMenuLink">
                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#registrationModal"style="color:white;">Registration</a>
                <a href="#" class="dropdown-item" onclick="openProfileModal()"style="color:white;">My Profile</a>
                <a href="#" class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#passwordModal" style="color:white;">Change Password</a>
                <a href="logout.php" class="dropdown-item"style="color:white;">Log Out</a>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<div class="container-fluid pt-4 px-4">
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="mb-0">Payment</h5>
                <div class="input-group" style="width: 40%;">
                    <input id="searchInput" type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">&nbsp;
                    <button class="btn btn-sm btn-primary" onclick="openPaymentModal()">Add Payment<i class="bi bi-credit-card"></i></button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">Payment Id</th>
                            <th scope="col">Tenant Name</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Room No.</th>
                            <th scope="col">Room Price</th>
                            <th scope="col">Date Occupied</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Payment Date</th>
                            <th scope="col">Remaining Balance</th>
                            <th scope="col">Payment Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                                    <?php
                $query = "SELECT p.*, t.* FROM payments p JOIN newtenant t ON p.tenant_id = t.id ORDER BY p.payment_date ASC";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Calculate remaining balance
                        if (isset($row['from_deposit']) && $row['from_deposit']) {
                            // If payment is from deposit, subtract payment amount from deposit
                            $remainingBalance = $row['room_price'] - 0; // Assuming payment_amount is being subtracted
                        } else {
                            // If payment is not from deposit, use payment amount
                            $remainingBalance = $row['room_price'] - $row['payment_amount'];
                        }
                        // Determine status
                        $status = ($remainingBalance == 0) ? 'Paid' : 'Unpaid';
                        $dueDate = date('Y-m-d', strtotime('+1 month', strtotime($row['date_occupied'])));
                        ?>
                        <tr data-tenant-id="<?php echo $row['tenant_id']; ?>">
                            <td><?php echo $row['payment_id']; ?></td>
                            <td><?php echo $row['lname'] . ', ' . $row['fname']; ?></td>
                            <td id="invoice_<?php echo $row['payment_id'];?>"><?php echo $row['invoice']; ?></td>
                            <td><?php echo $row['room_num']; ?></td>
                            <td><?php echo $row['room_price']; ?></td>
                            <td><?php echo $row['date_occupied']; ?></td>
                            <td><?php echo $dueDate; ?></td>
                            <td id="payment_date_<?php echo $row['payment_id'];?>"><?php echo $row['payment_date']; ?></td>
                            <td id="remaining_balance_<?php echo $row['tenant_id']; ?>"><?php echo $remainingBalance; ?></td>
                            <td id="payment_amount_<?php echo $row['payment_id']; ?>"><?php echo $row['payment_amount']; ?></td>
                            <td><?php echo $status; ?></td>
                            <td style="text-align: center;">
                            <a href="process.php?del=<?php echo $row['payment_id'];?>" onclick="return confirm('Are you sure you want to delete this tenant?');" style="text-align: center;">
                                <i class="fa fa-trash"></i>
                            </a>

                            </td>
                        </tr>
                        <?php
                    }
                    mysqli_free_result($result);
                } else {
                    echo '<tr><td colspan="11">No payments found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
        <script>
            function openPaymentModal() {
                $('#paymentModal').modal('show');
            }
        </script>
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="background-color: black; color: white; font-family: Georgia, serif;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Enter Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="paymentForm" action="process.php" method="POST">
                            <div class="mb-3 row">
                                <label for="tenant_id" class="col-sm-3 col-form-label">Select Tenant:</label>
                                <input type="hidden" id="selected_tenant_id" name="tenant_id">
                                <div class="col-sm-9">
                                    <select class="form-select" id="tenant_id" name="tenant_id">
                                        <?php
                                        // Fetch all tenants from the newtenant table
                                        $query = "SELECT * FROM newtenant";
                                        $result = mysqli_query($conn, $query);
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($tenant = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $tenant['id']; ?>">
                                            <?php echo $tenant['lname'] . ', ' . $tenant['fname']; ?>
                                        </option>
                                        <?php
                                            }
                                            mysqli_free_result($result);
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="details" class="col-sm-3 col-form-label">Details:</label>
                                <div class="col-sm-9">
                                    <p id="details"></p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="invoice" class="col-sm-3 col-form-label">Invoice:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="invoice" name="invoice" style="background-color: black; color: white; border: 1px solid white;">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="payment_amount" class="col-sm-3 col-form-label">Payment Amount:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="payment_amount" name="payment_amount" style="background-color: black; color: white; border: 1px solid white;">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="payment_date" class="col-sm-3 col-form-label">Payment Date:</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="payment_date" name="payment_date" style="background-color: black; color: white; border: 1px solid white;">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="from_deposit" class="col-sm-3 col-form-label">Payment from Deposit:</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" id="from_deposit" name="from_deposit" onchange="togglePaymentAmountField()">
                                    <label for="from_deposit">Yes, deduct from deposit</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="pay">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<script>
    function togglePaymentAmountField() {
        var paymentAmountField = document.getElementById('payment_amount');
        var fromDepositCheckbox = document.getElementById('from_deposit');
        
        if (fromDepositCheckbox.checked) {
            // If checkbox is checked, disable and hide payment amount field
            paymentAmountField.value = ''; // Clear the value
            paymentAmountField.disabled = true;
            paymentAmountField.style.display = 'none';
        } else {
            // If checkbox is not checked, enable and show payment amount field
            paymentAmountField.disabled = false;
            paymentAmountField.style.display = 'block';
        }
    }
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('tenant_id').addEventListener('change', function () {
        var tenantId = this.value;
        document.getElementById('selected_tenant_id').value = tenantId; // Set the value of the hidden input field

        // Function to clear details
        function clearDetails() {
            document.getElementById('details').innerHTML = '';
        }

        // Function to fetch tenant details and update UI
        function fetchAndUpdateDetails() {
            // Fetch tenant details using AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            var fullName = response.data.fname + ' ' + response.data.lname;
                            var remainingBalance = response.data.remaining_balance; // Get the remaining balance from the response

                            // Update details HTML
                            var detailsHTML = `
                                <b>Full Name:</b> ${fullName}<br>
                                <b>Room Number:</b> ${response.data.room_num}<br>
                                <b>Room Price:</b> ${response.data.room_price}<br>
                                <b>Advance Deposit:</b> ${response.data.adv}<br>
                                <b>Date Occupied:</b> ${response.data.date_occupied}<br>
                                <b>Total Paid:</b> ${response.data.total_paid}<br>
                                <b>Remaining Balance:</b> ${remainingBalance}<br>
                                <b>Due Date:</b> ${response.data.due_date}<br>
                            `;
                            document.getElementById('details').innerHTML = detailsHTML;

                            // Update remaining balance in the table
                            document.getElementById('remaining_balance_' + tenantId).innerText = remainingBalance;
                        } else {
                            document.getElementById('details').innerHTML = 'Error fetching details: ' + response.message;
                        }
                    } else {
                        document.getElementById('details').innerHTML = 'Error fetching details: Server Error';
                    }
                }
            };

            // Include tenant_id parameter in the request URL
            xhr.open('GET', 'process.php?tenant_id=' + tenantId, true);
            xhr.send();
        }

        // Clear details and fetch updated details
        clearDetails();
        fetchAndUpdateDetails();
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchInput');
    var tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        var searchTerm = searchInput.value.trim().toLowerCase();

        tableRows.forEach(function(row) {
            var paymentIdCell = row.querySelector('td:nth-child(1)');
            var tenantNameCell = row.querySelector('td:nth-child(2)');
            var paymentId = paymentIdCell.textContent.trim().toLowerCase();
            var tenantName = tenantNameCell.textContent.trim().toLowerCase();
            var found = false;

            if (paymentId.includes(searchTerm) || tenantName.includes(searchTerm)) {
                found = true;
            }

            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>




<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function openModal(paymentId, tenantId) {
    var invoice = document.getElementById('invoice_' + paymentId).innerText.trim();
    var paymentAmount = document.getElementById('payment_amount_' + paymentId).innerText.trim();
    var paymentDate = document.getElementById('payment_date_' + paymentId).innerText.trim();

    document.getElementById('editPaymentId').value = paymentId;
    document.getElementById('tenantId').value = tenantId;
    document.getElementById('invoice').value = invoice;
    document.getElementById('paymentAmount').value = paymentAmount;
    document.getElementById('paymentDate').value = paymentDate;

    $('#editModal').modal('show');
}
    



    // Handle form submission when Save Changes button is clicked
    $('#saveChangesBtn').click(function() {
        $('#editPaymentForm').submit();
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to fetch and update tenant details
    function fetchAndUpdateDetails(tenantId) {
        // Fetch tenant details using AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        var fullName = response.data.fname + ' ' + response.data.lname;
                        var roomNumber = response.data.room_num;
                        var roomPrice = response.data.room_price;
                        var advanceDeposit = response.data.adv;
                        var dateOccupied = response.data.date_occupied;
                        var totalPaid = response.data.total_paid;
                        var remainingBalance = response.data.remaining_balance;
                        var dueDate = response.data.due_date;

                        // Update details in the table
                        document.getElementById('remaining_balance_' + tenantId).innerText = remainingBalance;

                        // Fetch updated details every 5 seconds
                        setTimeout(function() {
                            fetchAndUpdateDetails(tenantId);
                        }, 5000);
                    } else {
                        console.error('Error fetching details:', response.message);
                    }
                } else {
                    console.error('Error fetching details: Server Error');
                }
            }
        };

        // Include tenant_id parameter in the request URL
        xhr.open('GET', 'process.php?tenant_id=' + tenantId, true);
        xhr.send();
    }

    // Fetch and update details for each tenant in the table
    var tenantRows = document.querySelectorAll('tbody tr');
    tenantRows.forEach(function(row) {
        var tenantId = row.dataset.tenantId;
        fetchAndUpdateDetails(tenantId);
    });
});

</script>




<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/chart/chart.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/tempusdominus/js/moment.min.js"></script>
<script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>


<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>
</html>
