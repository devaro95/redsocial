<?php
session_start();
$servidor = "localhost";
$basededatos = "redsocial";
$conn = mysqli_connect($servidor, "root", "", $basededatos) OR DIE ("No se ha podido conectar a la base de datos");
if(isset($_POST['like'])){
    $consulta = "Select * from likes where IDPost = " . $_POST['like'] . " && IDUsuario = " . $_SESSION['IDUsuario'];
    $select = mysqli_query($conn, $consulta);
    $var = mysqli_num_rows($select);
    if($var==0){
        $consultaLikes = "Update post set Likes = Likes + 1 where IDPost = " . $_POST['like'];
        $insertarLikes = "Insert into likes values (" . $_POST['like'] . "," . $_SESSION['IDUsuario'] . ")";
        mysqli_query($conn, $consultaLikes);
        mysqli_query($conn, $insertarLikes);
        header ('Location: ../paginas/inicio.php');
    }else{  
        $consultaLikes = "Update post set Likes = Likes - 1 where IDPost = " . $_POST['like'];
        $insertarLikes = "Delete from likes where IDPost = " . $_POST['like'];
        mysqli_query($conn, $consultaLikes);
        mysqli_query($conn, $insertarLikes);
        header ('Location: ../paginas/inicio.php');
    }
}
if(isset($_POST['like2'])){
    $consulta = "Select * from likes where IDPost = " . $_POST['like2'] . " && IDUsuario = " . $_SESSION['IDUsuario'];
    $select = mysqli_query($conn, $consulta);
    $var = mysqli_num_rows($select);
    if($var==0){
        $consultaLikes = "Update post set Likes = Likes + 1 where IDPost = " . $_POST['like2'];
        $insertarLikes = "Insert into likes values (" . $_POST['like2'] . "," . $_SESSION['IDUsuario'] . ")";
        mysqli_query($conn, $consultaLikes);
        mysqli_query($conn, $insertarLikes);
        header ('Location: ../paginas/perfil.php');
    }else{
        $consultaLikes = "Update post set Likes = Likes - 1 where IDPost = " . $_POST['like2'];
        $insertarLikes = "Delete from likes where IDPost = " . $_POST['like2'];
        mysqli_query($conn, $consultaLikes);
        mysqli_query($conn, $insertarLikes);
        header ('Location: ../paginas/perfil.php');
    }
}
if(isset($_POST['like3'])){
    $consulta = "Select * from likes where IDPost = " . $_POST['like3'] . " && IDUsuario = " . $_SESSION['IDUsuario'];
    $select = mysqli_query($conn, $consulta);
    $var = mysqli_num_rows($select);
    if($var==0){
        $consultaLikes = "Update post set Likes = Likes + 1 where IDPost = " . $_POST['like3'];
        $insertarLikes = "Insert into likes values (" . $_POST['like3'] . "," . $_SESSION['IDUsuario'] . ")";
        mysqli_query($conn, $consultaLikes);
        mysqli_query($conn, $insertarLikes);
        header ('Location: ../paginas/perfilamigo.php');
    }else{
        $consultaLikes = "Update post set Likes = Likes - 1 where IDPost = " . $_POST['like3'];
        $insertarLikes = "Delete from likes where IDPost = " . $_POST['like3'];
        mysqli_query($conn, $consultaLikes);
        mysqli_query($conn, $insertarLikes);
        header ('Location: ../paginas/perfilamigo.php');
    }
}


?>