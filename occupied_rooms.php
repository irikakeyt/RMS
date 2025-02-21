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
    <title>ADD ROOM</title>
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

    <style>
        /* Room panel CSS */
        .room-panel {
            border: 2px solid red;
            padding: 10px;
            width: calc(15% - 5px); /* Adjust the width to fit 5 rooms in a row */
            height: 300px;
            margin: 30px;
            background-color: black;
            text-align: center;
            display: inline-block;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background-size: cover; /* Image will cover the entire container */
            background-position: center; 
            background-repeat: no-repeat; 
            font-family: Georgia, serif; /* Change font to Georgia */
            font-size: 20px; /* Change font size to 14px */
        }

        .room-panel:hover {
            transform: scale(1.05);
        }

        .room-panel p {
            margin-bottom: 10px;
        }

        .room-panel button {
            background-color: black;
            color: #fff;
            border: 2px solid red;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 190px;
        }

        .room-panel button:hover {
            background-color: #0056b3;
        }

        .occupied {
            color: red;
        }

        .available {
            color: green;
        }
        .room-panel.occupied {
            background-size: 80%; 
        }

        .room-panel.available {
            background-size: 80%; 
        }
    </style>
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
        <a href="index.php" class="navbar-brand mx-4 mb-3">
            <img src="img/logo.png" alt="VECTO Corp. Logo" class="logo-img" style="width: 200px; height: 50px;">
        </a>
        <div class="navbar-nav w-100">
            <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown"><i class="bi bi-person me-2"></i>Tenants</a>
                <div class="dropdown-menu bg-transparent border-0 rounded-0 rounded-bottom m-0">
                    <a href="addtenants.php" class="dropdown-item">Add Tenants</a>
                    <a href="tenantsinfo.php" class="dropdown-item ">Tenants Information</a>
                </div>
            </div>
            <a href="addroom.php" class="nav-item nav-link"><i class="fa fa-bed me-2 "></i>Rooms</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown"><i class="bi bi-wallet me-2"></i>Payment</a>
                <div class="dropdown-menu bg-transparent border-0 rounded-0 rounded-bottom m-0">
                    <a href="payment.php" class="dropdown-item">Payments Record</a>
                    <a href="payment_history.php" class="dropdown-item a">Monthly Payment Record</a>
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
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="pass" placeholder="Password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye" style="color: red;"></i>
                            </button>
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
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordField = document.getElementById('password');
        var icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>



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
     
<?php
include_once "conn.php"; // Include database connection

$sql = "SELECT * FROM newtenant WHERE date_occupied IS NOT NULL";
$result = $conn->query($sql);

// Check if there are occupied rooms
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roomNum = $row['room_num'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $roomPrice = $row['room_price'];
        $contact = $row['contact'];

        // Output room panel for occupied rooms
        echo "<div class='room-panel occupied' style='background-image: url(\"img/o.png\")'>";
        echo "<p>Room Number: $roomNum</p>";
        echo "<button class='btn btn-primary showinfo' onclick='showTenantInfo(\"$fname\", \"$lname\", $roomPrice, \"$contact\", $roomNum)'>Show Info</button>";
        echo "</div>";
    }
} else {
    echo "No occupied rooms found.";
}
?>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function showTenantInfo(fname, lname, roomPrice, tenantContact, roomNum) {
        // Update modal with tenant information and room price
        document.getElementById("tenantName").innerText = "Tenant: " + fname + " " + lname;
        document.getElementById("tenantRoom").innerText = "Room: " + roomNum;
        document.getElementById("roomPrice").innerText = "Price: Php " + roomPrice.toFixed(2);
        document.getElementById("tenantContact").innerText = "Contact No. : " + tenantContact;
        // Show the tenant modal
        $('#tenantModal').modal('show'); // Trigger Bootstrap modal display
    }
</script>

<div class="modal fade" id="tenantModal" tabindex="-1" aria-labelledby="tenantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: black; border: 2px solid red; color: white; font-family: Georgia;">
            <div class="modal-header">
                <h5 class="modal-title" id="tenantModalLabel">Tenant Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="tenantName"></p>
                <p id="tenantRoom"></p>
                <p id="roomPrice"></p> 
                <p id="tenantContact"></p><!-- Display room price here -->
            </div>
        </div>
    </div>
</div>








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
            margin-top: 480px;
        }
        </style>

</html>
