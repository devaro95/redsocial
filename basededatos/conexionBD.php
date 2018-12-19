<?php
    session_start();
    $servidor = "localhost";
    $basededatos = "redsocial";
    $conn = mysqli_connect($servidor, "root", "", $basededatos) OR DIE ("No se ha podido conectar a la base de datos");
?>