<html>

<head>
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        session_start();
        $usuario = "root";
        $servidor = "localhost";
        $basededatos = "redsocial";
        $password = "";
        $_SESSION['conexion'] = mysqli_connect($servidor, $usuario, "", $basededatos) OR DIE ("No se ha podido conectar a la base de datos");

        if(isset($_POST['submit'])){
            $conn = mysqli_connect($servidor, "root", "", $basededatos) OR DIE ("No se ha podido conectar a la base de datos");
            $error = false;

            if(strlen($_POST['nombre']) > 20 || strlen($_POST['apellidos']) > 20 || strlen($_POST['nickname']) > 20 || strlen($_POST['correo']) > 30 || strlen($_POST['contrasenia']) > 15 || strlen($_POST['contrasenia']) < 4){
                $error = true;
            } 

            if($error){
                header("Location: ../paginas/signin.php");
            }else{
                $imagen = "../Imagenes/fotodefault.jpg";
                $imgContenido = addslashes(file_get_contents($imagen));
                $insertarUsuario = "Insert into usuarios(Nombre, Apellidos, nickname, email, password, telefono, ciudad, pais, tipoUsuario, FotoPerfil) values('" . $_POST['nombre'] . "','" . $_POST['apellidos'] . "','" . $_POST['nickname'] . "','" . $_POST['correo'] . "','" . $_POST['contrasenia'] . "' , '" . $_POST['telefono'] . "','" . $_POST['ciudad'] . "','" . $_POST['pais'] . "', 1, '" . $imgContenido . "')";
                mysqli_query($conn, $insertarUsuario);
                $imagen = "../Imagenes/fotodefault.jpg";
                //$imgContenido = addslashes(file_get_contents($imagen));
                //$insertarImagen = "Update usuarios set FotoPerfil = '" . $imgContenido . "' where nickname = ' ". $_POST['nickname'] . "'";
                //mysqli_query($conn, $insertarImagen);
                header("Location: ../index.php");
            }
        }
    ?>
</head>
<!--Fondo de la página principal-->

<body style="background-image:url('../Imagenes/fortnite3.png'); background-size: cover;">
    <!--Formulario para hacer Login-->
    <div id="menuSignin">
        <form action="signin.php" method="post">
            <div id="formSignin" style="margin-top:20px;">
                <label class="labelSignin">Nombre: </label>
                <input type="text" size="30" class="signin" name="nombre" placeholder="Nombre" required>
            </div>
            <div id="formSignin">
                <label class="labelSignin">Apellidos: </label>
                <input type="text" size="30" class="signin" name="apellidos" placeholder="Apellido" required>
            </div>
            <div id="formSignin">
                <label class="labelSignin">Nickname: </label>
                <input type="text" size="30" class="signin" name="nickname" placeholder="Nickname" required>
            </div>
            <div id="formSignin">
                <label class="labelSignin">Correo: </label>
                <input type="text" size="30" class="signin" name="correo" placeholder="Correo" required>
            </div>
            <div id="formSignin">
                <label class="labelSignin">Contraseña: </label>
                <input type="password" size="30" class="signin" name="contrasenia" placeholder="Password" required>
            </div>
            <div id="formSignin">
                <label class="labelSignin">Teléfono: </label>
                <input type="text" size="30" class="signin" name="telefono" placeholder="Telefono" required>
            </div>
            <div id="formSignin">
                <label class="labelSignin">Ciudad</label>
                <div> <input type="text" size="30" class="signin" name="ciudad" placeholder="Ciudad"></div>
            </div>
            <div id="formSignin">
                <label class="labelSignin">Pais</label>
                    <div>
                        <select name="pais" class="signin">
                                <option value="-" selected>
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
            <div style="text-align: center; margin-top: 10px;">
                <input id="botonRegistrar" type="submit" value="Registrar" name="submit">
                <button id="botonVolver" onclick="location.href='../index.php'">Volver</button>
            </div>
        </form>
    </div>
</body>

</html>