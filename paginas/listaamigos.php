<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion a la base de datos
        include '../basededatos/conexionBD.php';
        //consulta datos de los amigos
        $consultaAmigos = "Select nickname, Nombre, Apellidos 
                            from usuarios where concat_ws(' ',nickname, Nombre, Apellidos) Like '%" . $_POST['search'] . "%' && IDUsuario <> " . 
                            $_SESSION['IDUsuario'];
        $result = mysqli_query($conn, $consultaAmigos);
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
                <li class="nav-item">
                    <a class="nav-link" href="perfil.php">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mensajes.php">Mensajes</a>
                </li>
                <li class="nav-item active">
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
    <div id=bodyUtilizable>
        <!-- Tabla mostrar amigos -->
        <table style="margin: 20px auto; border-collapse: collapse; border-spacing: 20px 20px; text-align: center; width:960px;">
            <tr>
                <th style="border-bottom: 1px solid rgb(205,205,205);">
                    <h4>NICKNAME</h4>
                </th>
                <th style="border-bottom: 1px solid rgb(205,205,205);">
                    <h4>NOMBRE</h4>
                </th>
                <th style="border-bottom: 1px solid rgb(205,205,205);">
                    <h4>APELLIDOS</h4>
                </th>
            </tr>
            <?php
                while($registro = mysqli_fetch_array($result)){
                    print 
                    "<tr>
                        <td><form action='perfilamigo.php' method='post'><input id='inputMensajes' type='submit' value='". $registro['nickname']."' name='search'></form></td>
                        <td>" . $registro['Nombre'] . "</td>
                        <td>" . $registro['Apellidos'] . "</td>
                    <tr>";
                }
            ?>
        </table>
        <!-- //Tabla mostrar amigos -->
    </div>
</body>

</html>