<!DOCTYPE html>
<html>
<head>
    <title>Style Guide</title>
    <!-- Stylesheets -->
    <link rel="stylesheeet" type="text/css" href="assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/spectrum.css" />
    <!-- Less Style -->
    <link rel="stylesheet/less" type="text/css" href="assets/less/style.less" />
    <!-- Scripts -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="assets/js/spectrum.js"></script>
    <script type="text/javascript" src="assets/js/less.js"></script>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "styleguide";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>