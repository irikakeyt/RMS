<?php
include "conn.php";
session_start();

if(empty($_SESSION['email'])) {
    ?>
    <script>
        alert("Please log in first.");
        window.location.href="index.php"; // Redirect to the index page
    </script>
    <?php
} else {
    $e = $_SESSION['email'];
    $getdetails = mysqli_query($conn,"SELECT * FROM landlord WHERE email='$e'");
    while($row = mysqli_fetch_object($getdetails)) {
        $fn = $row->fname;
        $ln = $row->lname;
        $pic = $row->profile_pic;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> DASHBOARD </title>
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
            <a href="dashboard.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-person me-2"></i>Tenants</a>
                <div class="dropdown-menu bg-transparent border-0 rounded-0 rounded-bottom m-0">
                    <a href="addtenants.php" class="dropdown-item">Add Tenants</a>
                    <a href="tenantsinfo.php" class="dropdown-item ">Tenants Information</a>
                </div>
            </div>
            <a href="addroom.php" class="nav-item nav-link"><i class="fa fa-bed me-2"></i>Rooms</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-wallet me-2"></i>Payment</a>
                <div class="dropdown-menu bg-transparent border-0 rounded-0 rounded-bottom m-0">
                    <a href="payment.php" class="dropdown-item">Payments Record</a>
                    <a href="payment_history.php" class="dropdown-item ">Monthly Payment Record</a>
                </div>
            </div>
            <a href="about.php" class="nav-item nav-link"><i class="fas fa-info-circle me-2"></i>About Us</a>
        </div>
    </nav>
</div>
<!-- Sidebar End -->

<!-- Modal Start -->
<!--  CREATE ACCOUNT -->
<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-color: red;">
            <div class="modal-header" style="background-color: black; color: white; border-bottom: none;">
                <h5 class="modal-title" id="registrationModalLabel">REGISTRATION FORM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: black; color: white;">
                <form id="registrationForm" action="process.php" method="POST" enctype="multipart/form-data">
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
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="pass" placeholder="Password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye" style="color: red;"></i>
                            </button>
                        </div>
                    </div>
                    <!-- QR Code Generation Section -->
                    <div class="mb-3">
                        <label for="qrCode" class="form-label">QR Code</label>
                        <div id="qrCodeSection">
                            <button class="btn btn-primary" type="button" id="generateQRCodeBtn">Generate QR code</button>
                            <a id="downloadLink" download="qr_code.png" style="display: none;">Download QR code</a>
                            <img id="qrCodeImage" alt="QR code">
                        </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script>
    document.getElementById('generateQRCodeBtn').addEventListener('click', function() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const value = Email: ${email}\nPassword: ${password};
        const options = {
            value: value,
            size: 200,
            level: 'H'
        };
        const qrCode = new QRious(options);
        const qrCodeDataUrl = qrCode.toDataURL();
        
        // Display the QR code image
        document.getElementById('qrCodeImage').src = qrCodeDataUrl;

        // Generate download link
        const downloadLink = document.getElementById('downloadLink');
        downloadLink.href = qrCodeDataUrl;
        downloadLink.style.display = 'block';
    });
</script>

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

<script>
    function openProfileModal() {
        $('#profileModal').modal('show');
    }
</script>
<!-- JavaScript function to open the Change Password modal -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="height: 200px;">
                <i class="bi bi-people fa-5x text-primary"></i>
                <div class="ms-3"style="font-size: 24px;">
                    <p class="mb-2">All Tenants</p>
                    <?php
                    // Include database connection
                    include_once "conn.php";

                    // Query to retrieve total number of tenants
                    $sql = "SELECT COUNT(*) AS total_tenants FROM newtenant";
                    $result = $conn->query($sql);

                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Fetch the total number of tenants
                        $row = $result->fetch_assoc();
                        $totalTenants = $row['total_tenants'];
                        echo "<h1 class='mb-0'>$totalTenants</h1>";
                    } else {
                        echo "<h6 class='mb-0'>0</h6>"; // Default value if no tenants found
                    }
                    ?>
                        
                </div>
                <div class="mt-auto">
            <a href="tenantsinfo.php" class="btn btn-primary"><i class="bi bi-eye"></i></a>
        </div>
            </div>
        </div>


        <div class="col-sm-6 col-xl-3">
    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="height: 200px;">
        <i class="bi bi-house fa-5x text-primary"></i>
        <div class="ms-3" style="font-size: 24px;">
            <p class="mb-2">Total Rooms</p>
            <h1 class="mb-0">20</h1> 
        </div>
        <div class="mt-auto">
            <a href="addroom.php" class="btn btn-primary"><i class="bi bi-eye"></i></a>
        </div>
    </div>
</div>

<div class="col-sm-6 col-xl-3">
    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="height: 200px;">
        <i class="bi bi-people fa-5x text-primary"></i>
        <div class="ms-3" style="font-size: 24px;">
            <p class="mb-2">Occupied Rooms</p>
            <?php
            // Include database connection
            include_once "conn.php";

            // Query to retrieve total number of occupied rooms
            $sql = "SELECT COUNT(*) AS occupied_rooms FROM newtenant WHERE date_occupied IS NOT NULL";
            $result = $conn->query($sql);

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Fetch the total number of occupied rooms
                $row = $result->fetch_assoc();
                $occupiedRooms = $row['occupied_rooms'];
                echo "<h1 class='mb-0'>$occupiedRooms</h1>";
            } else {
                echo "<h6 class='mb-0'>0</h6>"; 
            }
            ?>
        </div>
        <div class="mt-auto">
            <!-- Button to show occupied rooms -->
            <a href="occupied_rooms.php" class="btn btn-primary">
                <i class="bi bi-eye"></i>
            </a>

        </div>
    </div>
</div>
<div class="col-sm-6 col-xl-3">
    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="height: 200px;">
        <i class="bi bi-cash fa-5x text-primary"></i>
        <div class="ms-3" style="font-size: 24px;">
            <p class="mb-2">Estimated Monthly Earnings</p>
            <?php
                include "conn.php";

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT SUM(room_price) AS total_earnings FROM newtenant";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $total_earnings = $row["total_earnings"];
                echo "<h2 class='mb-0'>Php" . $total_earnings . "</h2>";
            } else {
                echo "<h6 class='mb-0'>Php0</h6>";
            }

            ?>
        </div>
    </div>
</div>

        <!-- Content End -->

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
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

<!-- Footer Start -->
<div class="footer">
    <div class="bg-secondary rounded-top p-4">
        <div class="row">
            <div class="col-12 col-sm-6 text-center text-sm-start">
                &copy; <a href="dashboard.php">Vecto</a>, All Right Reserved. 
            </div>
            <div class="col-12 col-sm-6 text-center text-sm-end">
                Designed By <a href="https://htmlcodex.com">Vecto UI</a>
                <br>Distributed By: <a href="https://themewagon.com" target="_blank">Vecto Corporation</a>
            </div>
        </div>
    </div>
</div>
</div>

</body>
<style>
.footer{
    margin-top: 640px;
}
</style>

</html>