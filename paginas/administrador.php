<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion con la base de datos
        include '../basededatos/conexionBD.php';
        //consultar usuarios
        if(isset($_POST['siguiente'])){
            $_SESSION['contador'] += 5;
            $consulta = "Select * from usuarios LIMIT 5 OFFSET " . $_SESSION['contador'];
            $usuarios = mysqli_query($conn, $consulta);
        }else if (isset($_POST['anterior'])){
            $_SESSION['contador'] -= 5;
            $consulta = "Select * from usuarios LIMIT 5 OFFSET " . $_SESSION['contador'];
            $usuarios = mysqli_query($conn, $consulta);
        }else{
            $consulta = "Select * from usuarios LIMIT 5";
            $usuarios = mysqli_query($conn, $consulta);
            $_SESSION['contador'] = 0;
        }
        //consultar post denunciados
        if(isset($_POST['siguientePost'])){
            $_SESSION['contadorPost'] += 5;
            $consultaPost = "Select * from reportes order by Fecha asc LIMIT 5 OFFSET " . $_SESSION['contadorPost'];
            $reportes = mysqli_query($conn, $consultaPost);
        }else if (isset($_POST['anteriorPost'])){
            $_SESSION['contadorPost'] -= 5;
            $consultaPost = "Select * from reportes order by Fecha asc LIMIT 5 OFFSET " . $_SESSION['contadorPost'];
            $reportes = mysqli_query($conn, $consultaPost);
        }else{
            $consultaPost = "Select * from reportes order by Fecha asc LIMIT 5";
            $reportes = mysqli_query($conn, $consultaPost);
            $_SESSION['contadorPost'] = 0;
        }
        //dar de baja usuario
        if(isset($_POST['DarDeBaja'])){
            mysqli_query($conn, "Delete from usuarios where IDUsuario = " . $_POST['DarDeBaja']);
            header ('location: administrador.php');
        }
        //borrar post reportado
        if(isset($_POST['borrarPost'])){
            mysqli_query($conn, "Delete from reportes where IDPost = " . $_POST['borrarPost']);
            header ('location: administrador.php');
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
                            <a class='nav-link active' href='administrador.php'>Admin</a>
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
                <table style="margin:20px 0 0 ; border-collapse: collapse; border-spacing: 20px 20px; text-align: center; width:100%;">
                <tr style='border-bottom: 1px solid rgb(205,205,205);'>
                    <th style='text-align:center;width:33%'>
                        <h4>ID</h4>
                    </th>
                    <th style='text-align:center;'>
                        <h4>Nickname</h4>
                    </th>
                    <th></th>
                <tr>
                    <td></td>
                </tr>
                <?php
                    while($registro = mysqli_fetch_array($usuarios)){
                        print "
                        <td >$registro[IDUsuario]</td>
                        <td ><form action='perfilamigo.php' method='post'><input id='inputMensajes' type='submit' value='$registro[nickname]' name='search'></form></td>
                        <form action='administrador.php' method='post'>
                            <td><button id='botonAbrirMensaje' value='$registro[IDUsuario]' name='DarDeBaja'> Dar de baja </button></td>
                        </form>
                    </tr>";
                    } 
                print "
                </table>
                <form style='text-align:center' action='administrador.php' method='post'>";
                    if($_SESSION['contador']>0){
                        print "<input class='botonNavegacion' type='submit' name='anterior' value='<'>";
                    }if(mysqli_num_rows($usuarios)==5){
                        print"
                        <input class='botonNavegacion' type='submit' name='siguiente' value='>'>
                </form>";
                }
                ?>
                <table style="margin:20px 0 0 ; border-collapse: collapse; border-spacing: 20px 20px; text-align: center; width:100%;">
                <tr style='border-bottom: 1px solid rgb(205,205,205);'>
                    <th style='text-align:center;width:33%'>
                        <h4>ID</h4>
                    </th>
                    <th style='text-align:center;'>
                        <h4>Nickname</h4>
                    </th>
                    <th style='text-align:center;'>
                        <h4>Fecha</h4>
                    </th>
                <tr>
                    <td></td>
                </tr>
                <?php
                    while($registro = mysqli_fetch_array($reportes)){
                        print "
                        <td>$registro[IDPost]</td>
                        <td>$registro[Motivo]</td>
                        <td>$registro[Fecha]</td>
                        <form action='administrador.php' method='post'>
                            <td><button id='botonAbrirMensaje' value='$registro[IDPost]' name='borrarPost'> Eliminar </button></td>
                        </form>
                    </tr>";
                    } 
                    print "
                    </table>
                    <form style='text-align:center' action='administrador.php' method='post'>";
                        if($_SESSION['contadorPost']>0){
                            print "<input class='botonNavegacion' type='submit' name='anteriorPost' value='<'>";
                        }if(mysqli_num_rows($reportes)==5){
                            print"
                            <input class='botonNavegacion' type='submit' name='siguientePost' value='>'>
                    </form>";
                    }
                ?>
        </div>
</body>
</html>