<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion a la base de datos
        include '../basededatos/conexionBD.php';
        //consulta datos de los mensajes
        $consulta = "Select * from mensajes where receptor = '" . $_SESSION['usuarioActivo'] . "'";
        $result = mysqli_query($conn, $consulta);
        if(isset($_POST['siguiente'])){
            $_SESSION['contador'] += 10;
            $consulta = "Select * from mensajes where receptor = '" . $_SESSION['usuarioActivo'] . "' LIMIT 10 OFFSET " . $_SESSION['contador'];
            $result = mysqli_query($conn, $consulta);
        }else if (isset($_POST['anterior'])){
            $_SESSION['contador'] -= 10;
            $consulta = "Select * from mensajes where receptor = '" . $_SESSION['usuarioActivo'] . "' LIMIT 10 OFFSET " . $_SESSION['contador'];
            $result = mysqli_query($conn, $consulta);
        }else{
            $consulta = "Select * from mensajes where receptor = '" . $_SESSION['usuarioActivo'] . "' LIMIT 10";
            $result = mysqli_query($conn, $consulta);
            $_SESSION['contador'] = 0;
        }
        //borrar mensaje
        if(isset($_POST['borrarMensaje'])){
            $consulta1 = "Delete from mensajes where ID=" . $_POST['borrarMensaje'];
            $consultaMensaje = mysqli_query($conn, $consulta1);
            header("Location: mensajes.php");
        //mostrar mensaje
        }else if (isset($_POST['verMensaje'])){
            header ("location: mostrarmensaje.php");
        }
        if(isset($_POST['search'])){
            $insertarmensaje = mysqli_query($conn, "Insert into mensajes (Emisor, Receptor, Asunto, Mensaje, Fecha) values ('" . $_SESSION['usuarioActivo'] . "','" . $_POST['receptor'] . "','"
            . $_POST['asunto'] . "','" . $_POST['contenido'] . "', sysdate())");
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
                <li class="nav-item active">
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
    <div id=bodyUtilizable>
        <!-- tabla mostrar mensajes -->
        <table style="margin:20px 0 0 ; border-collapse: collapse; border-spacing: 20px 20px; text-align: center; width:100%;">
            <tr style='border-bottom: 1px solid rgb(205,205,205);'>
                <th style='text-align:center;'>
                    <h4>USUARIO</h4>
                </th>
                <th style='text-align:center;'>
                    <h4>ASUNTO</h4>
                </th>
                <th style='text-align:center;'>
                    <h4>FECHA Y HORA</h4>
                </th>
                <th></th>
            <tr>
                <td></td>
            </tr>
            <?php
                while($registro = mysqli_fetch_array($result)){
                    print "
                    <td ><form action='perfilamigo.php' method='post'><input id='inputMensajes' type='submit' value='".$registro['Emisor']."' name='search'></input></form></td>
                    <td >".$registro['Mensaje']."</td>
                    <td >".$registro['Fecha']."</td>
                    <td style='width:150px;'>
                        <form style='display:flex; float:left;' action='mostrarmensaje.php' method='post' class='form-inline my-2 my-lg-0'>
                            <button id='botonAbrirMensaje' value='$registro[ID]' name='verMensaje' type='submit'>Mostrar</button>
                        </form>
                        <form action='mensajes.php' method='post' class='form-inline my-2 my-lg-0'>
                            <button id='botonAbrirMensaje' value='$registro[ID]' name='borrarMensaje' type=submit'>Borrar</button>
                        </form>
                    </td>
            </tr>";
          }
          print "<form style='text-align:center' action='perfil.php' method='post'>";
                if($_SESSION['contador']>0){
                    print "<input class='botonNavegacion' type='submit' name='anterior' value='<'>";
                }if(mysqli_num_rows($result)==10){
                    print"
                    <input class='botonNavegacion' type='submit' name='siguiente' value='>'>
                    </form>";
                }
        ?>
        </table>
        <!-- //tabla mostrar mensajes -->
    </div>
</body>

</html>