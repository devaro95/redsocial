<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion con la base de datos
        include '../basededatos/conexionBD.php';
            if(isset($_POST['comentarPost'])){
                $consultaComentario = "Insert into comentariospost (IDPost,Comentario,Fecha,IDUsuario) values (" . $_POST['comentarPost'] . ",'" . nl2br($_POST['contenidoComentario']) . "', sysdate(), ". $_SESSION['IDUsuario'] . ")";
                mysqli_query($conn, $consultaComentario);
                header ('Location: inicio.php');
            }
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
    <!-- Colunmas del body -->
    <div id="bodyUtilizable">
        <div id=col>
            <!-- Columna comentar post -->
            <div id="escribirPost">
                <div style="padding: 12px;">
                    <form action="comentarpost.php" method="post">
                        <textarea style="resize:none" size="50" rows="7" cols="45" class="signin" name="contenidoComentario"
                            placeholder="" required></textarea>
                        <div style="float: right; ">
                            <div><button type="submit" value="<?php echo $_POST['comentar']?>" id="botonEnviarPost" name="comentarPost">Comentar</button></div>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>
</body>

</html>