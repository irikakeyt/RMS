<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Attendance System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898;
            background-blend-mode: multiply,multiply;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            background-image: url('img/pic.jpg');
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 91.5vh;
        }

        .attendance-container {
            height: 90%;
            width: 90%;
            border-radius: 20px;
            border: 2px solid red;
            padding: 40px;
            background-color: black;
            justify-content: center;
        }
    </style>
</head>
<body>

    <div class="main">
        
        <div class="attendance-container row">
            <div class="qr-container col-4">
                <div class="scanner-con">
                    <h3 class="text-center" style="color: white; margin-bottom: 50px;">SCAN YOUR QR CODE HERE</h3>
                    <video id="interactive" class="viewport" width="100%" height="100%"></video>
                </div>

                <div class="qr-detected-container" style="display: none;">
                    <h4 class="text-center">QR Detected!</h4>
                    <form id="attendance-form" action="dashboard.php" method="POST">
                        <input type="hidden" id="detected-qr-code" name="qr_code">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- instascan Js -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>
        let scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });
        scanner.addListener('scan', function (content) {
            let detectedQRCodeInput = document.getElementById('detected-qr-code');
            detectedQRCodeInput.value = content;
            document.getElementById('attendance-form').submit();
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["qr_code"])) {
        $uploaded_qr_code = file_get_contents("upload/download.png"); // Change this to match your uploaded QR code file
        $scanned_qr_code = $_POST["qr_code"];
        if ($scanned_qr_code == $uploaded_qr_code) {
            // Redirect to dashboard.php
            header("Location: dashboard.php");
            exit();
        } else {
            echo "QR code not found.";
        }
    }
    ?>

</body>
</html>
