<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion con la base de datos
        include '../basededatos/conexionBD.php';
        //consulta de los datos del usuario conectado
        $consulta = "Select * from usuarios where nickname = '" . $_SESSION['usuarioActivo'] . "'";
        $consultaDatos = mysqli_query($conn, $consulta);
        $datosUsuario = mysqli_fetch_array($consultaDatos); 
        //Cambio de perfil al completar formulario datos personales
        if(isset($_POST['submit'])){
            $servidor = "localhost";
            $basededatos = "redsocial";
            $conn = mysqli_connect($servidor, "root", "", $basededatos) OR DIE ("No se ha podido conectar a la base de datos");
            //Declaracion de las consultas
            $actualizarUsuario = "Update usuarios set nombre = '" . $_POST['nuevoNombre'] . "' where IDUsuario = '" . $_SESSION['IDUsuario'] . "'";
            $actualizarEmail = "Update usuarios set email = '" . $_POST['nuevoEmail'] . "' where IDUsuario = '" . $_SESSION['IDUsuario'] . "'";
            $actualizarTelefono = "Update usuarios set telefono = '" . $_POST['nuevoTelefono'] . "' where IDUsuario = '" . $_SESSION['IDUsuario'] . "'";
            $actualizarPais = "Update usuarios set pais = '" . $_POST['nuevoPais'] . "' where IDUsuario = '" . $_SESSION['IDUsuario'] . "'";
            $actualizarCiudad = "Update usuarios set ciudad = '" . $_POST['nuevoCiudad'] . "' where IDUsuario = '" . $_SESSION['IDUsuario'] . "'";
            //Ejecucion de las consultas
            mysqli_query($conn, $actualizarUsuario);
            mysqli_query($conn, $actualizarEmail);
            mysqli_query($conn, $actualizarTelefono);
            mysqli_query($conn, $actualizarPais);
            mysqli_query($conn, $actualizarCiudad);
            $imagen = $_FILES['imagen']['tmp_name'];
            $imgContenido = addslashes(file_get_contents($imagen));
            $insertarImagen = "Update usuarios set FotoPerfil = '" . $imgContenido . "' where IDUsuario = '" . $_SESSION['IDUsuario'] . "'";
            mysqli_query($conn, $insertarImagen);
            header("Location: ../paginas/perfil.php");
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
    <div id="bodyUtilizable">
        <div style="height:70%;margin-top:10px;">
            <div style="width:600px; height:280px; float:right; margin-top: 10px; margin-right: 10px; border:solid;"></div>
            <!-- Formulario para los datos personales-->
            <div class="formDatosPersonales">
                <h3> Datos Personales </h3>
                <div>
                    <form action="modificarperfil.php" method="post" enctype="multipart/form-data">
                        <div id="flexForm">
                            <label>Nombre</label>
                            <div>
                                <input type="text" size="30" class="login" name="nuevoNombre" value="<?php echo $datosUsuario['Nombre']?>"
                                    required>
                            </div>
                        </div>
                        <div id="flexForm">
                            <label>Email</label>
                            <div>
                                <input type="text" size="30" class="login" name="nuevoEmail" value="<?php echo $datosUsuario['email']?>"
                                    required>
                            </div>
                        </div>
                        <div id="flexForm"">
                        <label>Telefono</label>
                        <div> 
                            <input type="
                            text" size="30" class="login" name="nuevoTelefono" value="<?php echo $datosUsuario['telefono']?>">
                        </div>
                        <div id="flexForm">
                            <label>Pais</label>
                            <div>
                                <select name="nuevoPais" class="login" style="width:297px; height: 28px; align-items: center;"
                                    value="<?php echo $datosUsuario['pais']?>">
                                    <option value="<?php echo $datosUsuario['pais']?>" selected>
                                        <?php echo $datosUsuario['pais']?>
                                    </option>
                                    <option value="Afganistán">Afganistán</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Alemania">Alemania</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antártida">Antártida</option>
                                    <option value="Antigua y Barbuda">Antigua y Barbuda</option>
                                    <option value="Antillas Holandesas">Antillas Holandesas</option>
                                    <option value="Arabia Saudí">Arabia Saudí</option>
                                    <option value="Argelia">Argelia</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermudas">Bermudas</option>
                                    <option value="Bielorrusia">Bielorrusia</option>
                                    <option value="Birmania">Birmania</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Brasil">Brasil</option>
                                    <option value="Brunei">Brunei</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Chipre">Chipre</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Croacia">Croacia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Dinamarca">Dinamarca</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Egipto">Egipto</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Emiratos Árabes Unidos">Emiratos Árabes Unidos</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Eslovenia">Eslovenia</option>
                                    <option value="España">España</option>
                                    <option value="Estados Unidos">Estados Unidos</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Irak">Irak</option>
                                    <option value="Irán">Irán</option>
                                    <option value="Italia">Italia</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japón">Japón</option>
                                    <option value="Jordania">Jordania</option>
                                    <option value="Kazajistán">Kazajistán</option>
                                    <option value="Kenia">Kenia</option>
                                    <option value="Kirguizistán">Kirguizistán</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Laos">Laos</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Letonia">Letonia</option>
                                    <option value="Líbano">Líbano</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libia">Libia</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lituania">Lituania</option>
                                    <option value="Luxemburgo">Luxemburgo</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malasia">Malasia</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Maldivas">Maldivas</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Níger">Níger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk">Norfolk</option>
                                    <option value="Noruega">Noruega</option>
                                    <option value="Nueva Caledonia">Nueva Caledonia</option>
                                    <option value="Nueva Zelanda">Nueva Zelanda</option>
                                    <option value="Omán">Omán</option>
                                    <option value="Países Bajos">Países Bajos</option>
                                    <option value="Panamá">Panamá</option>
                                    <option value="Paquistán">Paquistán</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Perú">Perú</option>
                                    <option value="Pitcairn">Pitcairn</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="Samoa Americana">Samoa Americana</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="San Vicente y Granadinas">San Vicente y Granadinas</option>
                                    <option value="Santa Helena">Santa Helena</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad y Tobago">Trinidad y Tobago</option>
                                    <option value="Túnez">Túnez</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Yugoslavia">Yugoslavia</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabue">Zimbabue</option>
                                </select>
                            </div>
                        </div>
                        <div id="flexForm">
                            <label>Ciudad</label>
                            <div>
                                <input type="text" size="30" class="login" name="nuevoCiudad" value="<?php echo $datosUsuario['ciudad']?>">
                            </div>
                        </div>
                        <div id="flexForm">
                            <label>Foto de perfil</label>
                            <input style="margin: 15px;" type="file" name="imagen" required>
                        </div>
                        <div>
                            <input style="margin: 15px;" type="submit" value="cambiar" name="submit">
                        </div>
                    </form>
                </div>
                <!-- //Formulario para los datos personales-->
            </div>
        </div>
</body>

</html>