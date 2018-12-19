<html>

<head>
    <link rel="stylesheet" type="text/css" href="estilos/style1.css" media="screen" />
    <?php
        //iniciamos la base de datos
        session_start();
        $usuario = "root";
        $servidor = "localhost";
        $basededatos = "redsocial";
        $password = "";
        $conn = mysqli_connect($servidor, $usuario, "", $basededatos) OR DIE ("No se ha podido conectar a la base de datos");
        //Realizar la comprobacion del login de usuarios
        if(isset($_POST['submit'])){
            $consultaUsuarioConectado = "Select * from usuarios where nickname = '" . $_POST['usuario'] . "'";
            $IDUsuarioconsulta = mysqli_query($conn, $consultaUsuarioConectado);
            $IDUsuario = mysqli_fetch_assoc($IDUsuarioconsulta);
            $user = $_POST['usuario'];
            $password = $_POST['contrasenia'];
            $buscarUsuario = "Select * from usuarios";
            $consulta = mysqli_query($conn, $buscarUsuario);
            $existe = false;

            while($registro = mysqli_fetch_array($consulta)){
                    if($registro['nickname'] == $user && $registro['password'] == $password){
                    $existe = true;
                    break;
                    }
            }

            if($existe){
                    $_SESSION['usuarioActivo'] = $user;
                    $_SESSION['IDUsuario'] = $IDUsuario['IDUsuario'];
                    header("Location: paginas/inicio.php");
            }else{
                    header("Location: index.php");
            }
        }
    ?>
</head>
<!--Fondo de la página principal-->

<body style="background-image:url('Imagenes/fortnite3.png'); background-size: cover;">
    <!--Formulario para hacer Login-->
    <div id="menuLogin">
        <div id="formLogin">
            <form action="index.php" method="post">
                <div id="barra">
                    <input type="text" class="login" name="usuario" placeholder="Usuario">
                </div>
                <div id="barra">
                    <input type="password" class="login" name="contrasenia" placeholder="Contraseña">
                </div>
                <div>
                    <button type="submit" id="botonEnviar" value="Login" name="submit">Login</button>
                </div>
                <div style="margin-top:10px; color:black" ;>Si no estás registrado<br>
                    pulsa <a href="paginas/signin.php">aquí</a></div>
            </form>
        </div>
    </div>
</body>

</html>