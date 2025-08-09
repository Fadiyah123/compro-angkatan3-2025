<?php 
$_HOST    = "localhost";
$USERNAME = "root";
$PASSWORD = "";
$DATABASE = "db_potro_3_2025";

$koneksi = mysqli_connect($_HOST, $USERNAME, $PASSWORD, $DATABASE);
if (!$koneksi) {
  echo "Koneksi gagal";
}