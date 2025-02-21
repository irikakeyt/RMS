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
    <title> TENANTS INFORMATIONS</title>
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
            <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="bi bi-person me-2"></i>Tenants</a>
                <div class="dropdown-menu bg-transparent border-0 rounded-0 rounded-bottom m-0">
                    <a href="addtenants.php" class="dropdown-item">Add Tenants</a>
                    <a href="tenantsinfo.php" class="dropdown-item active">Tenants Information</a>
                </div>
            </div>
            <a href="addroom.php" class="nav-item nav-link"><i class="fa fa-bed me-2"></i>Rooms</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-wallet me-2"></i>Payment</a>
                <div class="dropdown-menu bg-transparent border-0 rounded-0 rounded-bottom m-0">
                    <a href="payment.php" class="dropdown-item">Payments Record</a>
                    <a href="payment_history.php" class="dropdown-item active">Monthly Payment Record</a>
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
</nav>




<!---Content Start--->
<div class="container-fluid pt-4 px-4">
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="mb-0">TENANTS INFORMATIONS</h5>
                <div class="input-group" style="width: 40%;">
                    <input id="searchInput" type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">&nbsp;
                    <button id="speakButton" class="btn btn-primary" type="button">Speak</button>
                </div>
        </div>
        
          <div class="table-responsive">
            <table id="tenantTable" class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">Tenant ID</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Address</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">Deposit</th>
                        <th scope="col">Room Price</th>
                        <th scope="col">Date Occupied</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "conn.php";

                $records = mysqli_query($conn, "SELECT * FROM newtenant");
                while($get_records = mysqli_fetch_array($records)){
            ?>
                        <tr>
                            <td id="id_<?php echo $get_records['id'];?>"><?php echo $get_records['id'];?></td>
                            <td id="lname_<?php echo $get_records['id'];?>"><?php echo $get_records['lname'];?></td>
                            <td id="fname_<?php echo $get_records['id'];?>"><?php echo $get_records['fname'];?></td>
                            <td id="age_<?php echo $get_records['id'];?>"><?php echo $get_records['age'];?></td>
                            <td id="gender_<?php echo $get_records['id'];?>"><?php echo $get_records['gender'];?></td>
                            <td id="address_<?php echo $get_records['id'];?>"><?php echo $get_records['address'];?></td>
                            <td id="contact_<?php echo $get_records['id'];?>"><?php echo $get_records['contact'];?></td>
                            <td id="room_num_<?php echo $get_records['id'];?>"><?php echo $get_records['room_num'];?></td>
                            <td id="deposit_<?php echo $get_records['id'];?>"><?php echo $get_records['adv'];?></td>
                            <td id="room_price_<?php echo $get_records['id'];?>"><?php echo $get_records['room_price'];?></td>
                            <td id="date_occupied_<?php echo $get_records['id'];?>"><?php echo $get_records['date_occupied'];?></td>
                            <td>
                            <a href="#" onclick="openModal(<?php echo $get_records['id']; ?>)" data-bs-toggle="modal" data-bs-target="#editModal" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                            <a href="process.php?del_id=<?php echo $get_records['id'];?>" onclick="return confirm('Are you sure you want to delete this tenant?');"><i class="fa fa-trash"></i></a>


                            </td>

                        </tr>
                        <?php
                }
            ?>
                </tbody>
            </table>

<!-- Content End -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const tenantTable = document.getElementById("tenantTable");
        const rows = tenantTable.getElementsByTagName("tr");
        const speakButton = document.getElementById("speakButton");

        let utterance = null; // Declare a variable to hold the utterance

        speakButton.addEventListener("click", function () {
            if (utterance && window.speechSynthesis.speaking) {
                window.speechSynthesis.cancel(); // Stop the speech if it's currently speaking
            } else {
                const searchTerm = searchInput.value.trim().toLowerCase();
                let found = false;
                let rowData = "";

                for (let i = 1; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName("td");
                    for (let j = 0; j < cells.length; j++) {
                        const cellContent = cells[j].textContent.trim().toLowerCase();
                        if (cellContent.includes(searchTerm)) {
                            found = true;
                            for (let k = 0; k < cells.length; k++) {
                                rowData += cells[k].textContent.trim() + ". "; // Concatenate the text content of each cell in the row
                            }
                            break; // Exit the loop after finding the matched row
                        }
                    }
                    if (found) {
                        break; // Exit the loop after finding the matched row
                    }
                }

                if (found) {
                    utterance = new SpeechSynthesisUtterance(rowData);
                    utterance.rate = 1.2; // Adjust the rate to make speech faster
                    window.speechSynthesis.speak(utterance); // Speak the text of the selected search result
                } else {
                    speak("No matching tenant found."); // Speak if no matching tenant is found
                }
            }
        });

        searchInput.addEventListener("input", function () {
            const searchTerm = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < rows.length; i++) {
                let found = false;
                const cells = rows[i].getElementsByTagName("td");
                for (let j = 0; j < cells.length; j++) {
                    const cellContent = cells[j].textContent.trim().toLowerCase();
                    if (cellContent.includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? "" : "none";
            }
        });

        function speak(text) {
            utterance = new SpeechSynthesisUtterance(text);
            utterance.rate = 1.5; // Adjust the rate to make speech faster
            window.speechSynthesis.speak(utterance);
        }
    });
</script>
    




<!--- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-color: red;">
            <div class="modal-header" style="background-color: black; color: white; border-bottom: none;">
                <h5 class="modal-title" id="registrationModalLabel">EDIT TENANTS INFO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: black; color: white;">
            <form action="process.php" method="post">
                <div class="mb-3 row">
                        <label for="lastName" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                        <input type="hidden" id="updateTenantId" name="id">
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="lastName" class="col-sm-3 col-form-label">Last Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lname"name="lname" placeholder="Enter the last name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="firstName" class="col-sm-3 col-form-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="fname" name="fname"placeholder="Enter the first name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="age" class="col-sm-3 col-form-label">Age</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="age" name="age"placeholder="Enter the age">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gender"name="gender" placeholder="Enter the gender">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter the address">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="contactNumber" class="col-sm-3 col-form-label">Contact No.</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="contactNumber" name="contact" placeholder="Enter the contact number">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="roomNumber" class="col-sm-3 col-form-label">Room No.</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="roomNumber" name="roomnum"placeholder="Enter the room number">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="deposit" class="col-sm-3 col-form-label">Deposit</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="deposit" name="deposit"placeholder="Enter deposit">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="roomPrice" class="col-sm-3 col-form-label">Room Price</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="roomPrice" name="roomprice"placeholder="Enter the room price">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="dateOccupied" class="col-sm-3 col-form-label">Date Occupied</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="dateOccupied" name="date"placeholder="Enter the date occupied">
                        </div>
                        <div class="col-sm-9">
                            <input type="submit" name="update" value="Update" class="btn btn-danger">
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal End -->
<script>
function openModal(tenantId) {
        var modal = document.getElementById('editModal');
        var span = document.getElementsByClassName("btn-close")[0]; // Corrected class name

        // Set the value of the input field in the modal to the tenant ID
        document.getElementById('updateTenantId').value = tenantId; // Corrected variable name

        // Fetch the tenant data corresponding to the ID and populate the modal fields
        var lname = document.getElementById('lname_' + tenantId).innerText;
        var fname = document.getElementById('fname_' + tenantId).innerText;
        var age = document.getElementById('age_' + tenantId).innerText;
        var gender = document.getElementById('gender_' + tenantId).innerText;
        var address = document.getElementById('address_' + tenantId).innerText;
        var contact = document.getElementById('contact_' + tenantId).innerText;
        var roomId = document.getElementById('room_num_' + tenantId).innerText;
        var deposit = document.getElementById('deposit_' + tenantId).innerText;
        var roomPrice = document.getElementById('room_price_' + tenantId).innerText;
        var dateOccupied = document.getElementById('date_occupied_' + tenantId).innerText;

        // Populate the modal fields with retrieved data
        document.getElementById('lname').value = lname;
        document.getElementById('fname').value = fname;
        document.getElementById('age').value = age;
        document.getElementById('gender').value = gender;
        document.getElementById('address').value = address;
        document.getElementById('contactNumber').value = contact;
        document.getElementById('roomNumber').value = roomId;
        document.getElementById('deposit').value = deposit;
        document.getElementById('roomPrice').value = roomPrice;
        document.getElementById('dateOccupied').value = dateOccupied;

    modal.style.display = "block";

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}


</script>




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

</body>

</html>
