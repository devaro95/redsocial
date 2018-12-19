<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion con la base de datos
        include '../basededatos/conexionBD.php';
        if(isset($_POST['reportar'])){
        $_SESSION['PostReportado'] = $_POST['reportar'];
        }
        $consultaPost = mysqli_query($conn, "Select usuarios.Nombre, post.Contenido from usuarios,post where IDPost = " . $_SESSION['PostReportado'] . " and usuarios.IDUsuario = post.IDUsuario");
        $datosPost = mysqli_fetch_assoc($consultaPost);
        if(isset($_POST['enviar'])){
            mysqli_query($conn, "Insert into reportes(IDPost, Motivo, Fecha) values (" . $_SESSION['PostReportado'] . ",'" . $_POST['motivo'] . "', sysdate())");
            header ('location: inicio.php');
        }
    ?>
</head>

<body>
    <!-- Barra de navegacion -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="inicio.php">TWITNITE</a>
        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="inicio.php">Inicio</a>
                </li>
                <li class="nav-item">
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
        <div id='post' style="width:50%; margin:20px auto">
            <div class='nombrePost'>
                <?php echo $datosPost['Nombre'] ?>
            </div>
            <div class='contenedorPost'>
                <?php echo $datosPost['Contenido'] ?>
            </div>
            <div class='overHid'>
                <div style='float:left; overflow:hidden; width:150px;'>

                </div>
            </div>
        </div>
        <div style="text-align:center">
            <form action="reporte.php" method="post">
                <select name="motivo">
                    <option value="Contenido inapropiado"> Contenido inapropiado </option>
                    <option value="Contenido sexual"> Contenido sexual </option>
                    <option value="Este TwitNite es de caracter ofensivo"> Este TwitNite es de caracter ofensivo </option>
                    <option value="Spam"> Spam </option>
                    <option value="Incita a la violencia"> Incita a la violencia </option>
                    <option value="Humor Negro"> Humor Negro</option>
                </select>
                <input type="submit" name="enviar">
            </form>
        </div>
</body>

</html>