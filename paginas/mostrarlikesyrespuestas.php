<?php

?>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion con la base de datos
        //conexion a la base de datos
        include '../basededatos/conexionBD.php';
        //consulta de los likes de cada post
        $consulta1 = "Select IDUsuario from likes where IDPost = " . $_POST['mostrarlikes'];
        $select = mysqli_query($conn, $consulta1);
        //saber idusuario de ese post
        $consulta4 = "Select IDUsuario from post where IDPost = " . $_POST['mostrarlikes'];
        $select2 = mysqli_query($conn, $consulta4);
        //consultar datos del post
        $post = "Select * from post where IDPost = " . $_POST['mostrarlikes'];
        $post1 = mysqli_query($conn, $post);
        $post2 = mysqli_fetch_assoc($post1);
        $comentarios = "Select * from comentariospost where IDPost = " . $_POST['mostrarlikes'];
        $comentarios2 = mysqli_query($conn, $comentarios);
    ?>
</head>

<body>
    <!-- Barra de navegacion -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="inicio.php">TWITNITE</a>
        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="inicio.php">Inicio</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="perfil.php">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mensajes.php">Mensajes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="amigos.php">Amigos</a>
                </li>
                <?php
                    if($_SESSION['admin']){
                        print "
                        <li>
                            <a class='nav-link' href='administrador.php'>Admin</a>
                        </li>";
                    }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="../comprobaciones/cerrarsesion.php">Cerrar Sesion</a>
                </li>

            </ul>
            <form action="listaamigos.php" class="form-inline my-2 my-lg-0" method="post">
                <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search">
                <input type="submit" class="btn btn-secondary my-2 my-sm-0" value="Buscar" name="submit">
            </form>
        </div>
    </nav>
    <!-- //Barra de navegacion -->
    <!--Colunmas del body-->
    <div id="bodyUtilizable">
            <div style="width:50%; margin: auto auto;">
                    <?php
                        $registro1 = mysqli_fetch_array($select2);
                        $consulta3 = "Select nickname from usuarios where IDUsuario = " . $registro1['IDUsuario'];
                        $select3 = mysqli_query($conn, $consulta3);
                        $select4 = mysqli_fetch_assoc($select3);
                        print 
                        "<div id='post'>
                            <div class='nombrePost'>
                                $select4[nickname]
                            </div>
                            <div class='contenedorPost'>
                                $post2[Contenido]
                            </div>
                            <div class='overHid'>
                            <div style='float:left; overflow:hidden; width:80px;'>
                            ";
                            print "<div class='imagenLikes'>
                                </div>";
                        
                             print "<div class='likesPost'>$post2[Likes]</div>
                            </div>
                            <div style='float:right;'>
                                    <form action='mostrarlikesyrespuestas.php' method='post'>
                                          <button id='inputMensajes' name='mostrarlikes' value='$post2[IDPost]'>$post2[Fecha]</button>
                                    </form>
                            </div>
                            </div>
                        </div>";
                    ?>
            </div>
            <div style="width:40%; float:left; text-align: center;">
            <h4> USUARIOS QUE LE HAN DADO LIKE </h4>
            <?php
                while($registro = mysqli_fetch_array($select)){
                    $consulta2 = "Select nickname, nombre, apellidos from usuarios where IDUsuario = " . $registro['IDUsuario'];
                    $select1 = mysqli_query($conn, $consulta2);
                    $select2 = mysqli_fetch_assoc($select1);
                    echo $select2['nickname'] . " - " . $select2['nombre'] . " " . $select2['apellidos'];
                }
            ?>
            </div>
            <div style="width:60%; float:right; text-align: center;">
            <h4> RESPUESTAS </h4>
            <?php
                while($registro2 = mysqli_fetch_array($comentarios2)){
                    $nombreComentarios = "Select nickname from usuarios where IDUsuario = " . $registro2['IDUsuario'];
                    $nombreComentarios2 = mysqli_query($conn, $nombreComentarios);
                    $nombreComentarios3 = mysqli_fetch_assoc($nombreComentarios2);
                    print 
                        "<div id='post'>
                            <div class='nombrePost'>
                                $nombreComentarios3[nickname]
                            </div>
                            <div class='contenedorPost'>
                                $registro2[Comentario]
                            </div>
                            <div class='overHid'>
                            <div style='float:right;'>
                                $registro2[Fecha]
                            </div>
                            </div>
                        </div>";
                }
            ?>
            </div>
    </div>
</body>

</html>