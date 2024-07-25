<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tongseng_ngarep_gor';


$con = mysqli_connect("localhost", "root", "", "tongseng_ngarep_gor");


if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


