<!-- File		: logout.php
     Deskripsi	: Form untuk logout dari halaman 
     PERPUSTAKAAN
-->
<?php
session_start();
session_destroy();
header('location: index.php');
?>
