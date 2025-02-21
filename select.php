
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

    <body>

    <!-- Modal Form Start -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background-color: black; color: white; font-family: Georgia, serif;">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Enter Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm">
                        <div class="mb-3 row">
                            <label for="tenant_id" class="col-sm-3 col-form-label">Select Tenant:</label>
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
                                                <?php echo $tenant['id'] . ', ' . $tenant['lname'] . ', ' . $tenant['fname']; ?>
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
                                    <!-- Display details here -->
                                    <p id="details"></p>
                                </div>  
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tenant_id').change(function () {
                var tenantId = $(this).val();

                // AJAX call to fetch tenant details
                $.ajax({
                    url: 'fetch_tenant_details.php', // Provide the correct path to your PHP file that fetches tenant details
                    method: 'POST',
                    data: { tenant_id: tenantId },
                    success: function (response) {
                        // Parse the JSON response
                        var data = JSON.parse(response);

                        // Construct the details string
                        var details = 'First Name: ' + data.fname + '<br>';
                        details += 'Last Name: ' + data.lname + '<br>';
                        details += 'Room Number: ' + data.room_num + '<br>';
                        details += 'Room Price: ' + data.room_price + '<br>';
                        details += 'Date Occupied: ' + data.date_occupied;

                        // Update the details element
                        $('#details').html(details);

                        // Update form fields with fetched data
                        $('#invoice').val(data.invoice);
                        $('#payment_amount').val(data.payment_amount);
                    },
                    error: function () {
                        alert('Error fetching tenant details');
                    }
                });
            });
        });
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
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>
    </html>
