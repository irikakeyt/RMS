<?php
    session_start();
    session_destroy();
?>

    <script>
        alert("Log Out Successfully!")
        window.location.href="index.php";
    </script>