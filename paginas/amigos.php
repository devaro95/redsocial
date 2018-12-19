<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        include '../basededatos/conexionBD.php';
        //coger datos de los amigos
        if(isset($_POST['siguiente'])){
            $_SESSION['contador'] += 10;
            $consultaAmigos = "Select amigos.IDUsuario, amigos.IDUsuarioAmigo, nickname, nombre, apellidos, email from usuarios, amigos where amigos.IDUsuarioAmigo = 
            usuarios.IDUsuario and amigos.IDUsuario = '" . $_SESSION['IDUsuario'] . "' LIMIT 10 OFFSET " . $_SESSION['contador'];
            $result = mysqli_query($conn, $consultaAmigos);
        }else if (isset($_POST['anterior'])){
            $_SESSION['contador'] -= 10;
            $consultaAmigos = "Select amigos.IDUsuario, amigos.IDUsuarioAmigo, nickname, nombre, apellidos, email from usuarios, amigos where amigos.IDUsuarioAmigo = 
            usuarios.IDUsuario and amigos.IDUsuario = '" . $_SESSION['IDUsuario'] . "' LIMIT 10 OFFSET " . $_SESSION['contador'];
            $result = mysqli_query($conn, $consultaAmigos);
        }else{
            $consultaAmigos = "Select amigos.IDUsuario, amigos.IDUsuarioAmigo, nickname, nombre, apellidos, email from usuarios, amigos where amigos.IDUsuarioAmigo = 
            usuarios.IDUsuario and amigos.IDUsuario = '" . $_SESSION['IDUsuario'] . "' LIMIT 10";
            $result = mysqli_query($conn, $consultaAmigos);
            $_SESSION['contador'] = 0;
        }


        $consultaPeticiones = "Select * from peticionamistad where IDUsuarioAmigo = " . $_SESSION['IDUsuario'];
        $result2 = mysqli_query($conn, $consultaPeticiones);

        //cancelar solicitud de amistad
        if(isset($_POST['rechazarPeticion'])){
            $consultaRechazarPeticion = mysqli_query($conn, "Delete from peticionamistad where IDPeticionAmistad = '" . $_POST['rechazarPeticion'] . "'");
            header("Location: amigos.php");  
        //aceptar solicitud de amistad  
        }else if (isset($_POST['aceptarPeticion'])){
            $consultaIDAmigo = mysqli_query($conn, "Select * from peticionamistad where IDpeticionAmistad = '" . $_POST['aceptarPeticion'] . "'");
            $cogerIDAmigo = mysqli_fetch_assoc($consultaIDAmigo);
            $consultaAceptarPeticion = mysqli_query($conn, "Delete from peticionamistad where IDPeticionAmistad = '" . $_POST['aceptarPeticion'] . "'");
            $consultaAnadirAmigo = mysqli_query($conn, "Insert into amigos values ( " . $_SESSION['IDUsuario'] . "," . $cogerIDAmigo['IDUsuario'] . ")");
            $consultaAnadirAmigo = mysqli_query($conn, "Insert into amigos values ( " . $cogerIDAmigo['IDUsuario'] . "," . $_SESSION['IDUsuario'] . ")");
            header("Location: amigos.php");
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
    <!-- Columnas del body -->
    <div id="bodyUtilizable">
        <div id=col>
            <!-- Columna peticiones de amistad -->
            <div id="solicitudAmistad" style="border-right:solid 1px rgb(205,205,205);">
                <table style="margin: 0 auto; border-collapse: separate; border-spacing: 10px 10px; text-align: center;">
                    <?php
                    //consulta de las peticiones hacia el usuario
                    while($registro1 = mysqli_fetch_array($result2)){
                        $consultaDatosPeticion = "Select * from usuarios where IDUsuario = " . $registro1['IDUsuario'];
                        if($consulta1 = mysqli_query($conn, $consultaDatosPeticion)){
                            $nombreApellidos = mysqli_fetch_assoc($consulta1);
                            print "
                            <tr>
                                <td >
                                    <form action='perfilamigo.php' method='post'>
                                        <button id='inputMensajes' type='submit' value='$nombreApellidos[nickname]' name='search'>
                                        $nombreApellidos[Nombre]
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div style='background-image: url(../Imagenes/aceptar.png); width: 18px; height:18px; background-size: cover; margin-bottom: 12px;'>
                                        <form action='amigos.php' method='post'>
                                            <button title='Aceptar solicitud' type='submit' id='botonAceptarSolicitud' value='$registro1[IDPeticionAmistad]'name='aceptarPeticion'>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <div style='float:right; background-image: url(../Imagenes/borrar.png); width:16px; height: 16px; background-size:cover;margin-bottom: 12px; margin-left: 10px;'> 
                                        <form action='amigos.php' method='post'>
                                            <button title='Rechazar solicitud' type='submit' id='botonRechazarSolicitud' value='$registro1[IDPeticionAmistad]'name='rechazarPeticion'>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>";
                        }
                    }
                    ?>
                </table>
            </div>
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
                    <th style="border-bottom: 1px solid rgb(205,205,205);">
                        <h4>CORREO</h4>
                    </th>
                </tr>
                <?php
                    while($registro = mysqli_fetch_array($result)){
                ?>
                <tr>
                    <?php
                            echo "
                            <td><form action='perfilamigo.php' method='post'><input id='inputMensajes' type='submit' value='". $registro['nickname']."' name='search'></form></td>
                            <td>" . $registro['nombre'] . "</td>
                            <td>" . $registro['apellidos'] . "</td>
                            <td>" . $registro['email'] . "</td>
                            <tr>";
                        }
                    print "
                    </table>
                    <form style='text-align:center' action='perfil.php' method='post'>";
                    if($_SESSION['contador']>0){
                        print "<input class='botonNavegacion' type='submit' name='anterior' value='<'>";
                    }if(mysqli_num_rows($result)==10){
                        print"
                        <input class='botonNavegacion' type='submit' name='siguiente' value='>'>
                        </form>";
                }
                ?>
            <!-- //Tabla mostrar amigos -->
        </div>
    </div>
</body>

</html>