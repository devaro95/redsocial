<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion con la base de datos
        include '../basededatos/conexionBD.php';
        //consultar datos de perfil
        $consulta = "Select * from usuarios where nickname = '" . $_SESSION['usuarioActivo'] . "'";
        $consultaDatos = mysqli_query($conn, $consulta);
        $datosUsuario = mysqli_fetch_array($consultaDatos);
        //consultar datos de post usuario
         //consultar post del usuario amigo
         if(isset($_POST['siguiente'])){
            $_SESSION['contador'] += 5;
            $consulta = "Select * from post where IDUsuario = '" . $_SESSION['IDUsuario'] . "' order by fecha desc LIMIT 5 OFFSET " . $_SESSION['contador'];
        $consultaDatos = mysqli_query($conn, $consulta);
        }else if (isset($_POST['anterior'])){
            $_SESSION['contador'] -= 5;
            $consulta = "Select * from post where IDUsuario = '" . $_SESSION['IDUsuario'] . "' order by fecha desc LIMIT 5 OFFSET " . $_SESSION['contador'];
        $consultaDatos = mysqli_query($conn, $consulta);
        }else{
            $consulta = "Select * from post where IDUsuario = '" . $_SESSION['IDUsuario'] . "' order by fecha desc LIMIT 5";
            $consultaDatos = mysqli_query($conn, $consulta);
            $_SESSION['contador'] = 0;
        }
        //borrar posts
        if(isset($_POST['borrarPost'])){
            mysqli_query($conn, "Delete from post where IDPost = " . $_POST['borrarPost']);
            mysqli_query($conn, "Delete from likes where IDPost = " . $_POST['borrarPost']);
            header('Location: perfil.php');
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
    <!--Colunmas del body-->
    <div id="bodyUtilizable">
        <div id=col>
            <!--Columna para la zona de informacion personal, imagen, etc-->
            <div id="perfilInfo">
                 <?php
                    if($_SESSION['admin']){
                        echo '<img 
                        style="
                        max-width: 200px; max-height: 200px;
                        min-width: 200px; min-height: 200px;
                        background-size: cover;
                        border: solid rgb(234, 190, 63);
                        border-radius: 100px;
                        margin: auto;
                        box-shadow: 0px 0px 20px 1px rgb(234, 190, 63);" src="data:image/jpeg;base64,'.base64_encode( $datosUsuario['FotoPerfil'] ).'"/>';
                    }else{
                        echo '<img 
                        style="
                        max-width: 200px; max-height: 200px;
                        min-width: 200px; min-height: 200px;
                        background-size: cover;
                        border: solid black;
                        border-radius: 100px;
                        margin: auto;
                        box-shadow: 0px 0px 20px 1px rgb(4, 56, 133);" src="data:image/jpeg;base64,'.base64_encode( $datosUsuario['FotoPerfil'] ).'"/>';
                    }
                ?>
                <div id="nombrePerfil">
                    <?php echo $datosUsuario['Nombre'] ?>
                </div>
                <div><button id="botonCambiarPerfil" onclick="location.href='modificarperfil.php'">Editar Perfil</button></div>
                <div id="perfilInfoPersonal">
                    <div id="telefonoPerfil"> Telefono:
                        <?php echo $datosUsuario['telefono'] ?>
                    </div>
                    <div id="correoElectronicoPerfil"> E-mail:
                        <?php echo $datosUsuario['email'] ?>
                    </div>
                    <div id="paisPerfil"> Pais:
                        <?php echo $datosUsuario['pais'] ?>
                    </div>
                    <div id="ciudadPerfil"> Ciudad:
                        <?php echo $datosUsuario['ciudad'] ?>
                    </div>
                </div>
            </div>
            <!-- Columna posts amigos -->
            <div id="colCentral">
                <div style="text-align:center; margin-top:20px; font-size:30px;">Nuevos Post</div>
                <?php
                    while($registro = mysqli_fetch_array($consultaDatos)){ 
                        $likedado = "Select * from likes where IDUsuario = " . $_SESSION['IDUsuario'] .  "&& IDPost = " . $registro['IDPost'];
                        $likedado1 = mysqli_query($conn, $likedado);
                        $likedado2 = mysqli_num_rows($likedado1);
                        print 
                            "<div id='post'>
                            <div class='overHid'>
                                <div style='float:left;font-weight:bold;font-size:17px; margin-left:10px; margin-top:10px;'>
                                $datosUsuario[Nombre]
                                </div>
                                <div style='float:right; background-image: url(../Imagenes/borrar.png); width:14px; height: 14px; background-size:cover; margin:10px 10px'> 
                                    <form action='perfil.php' method='post'> 
                                        <button title='Borrar post' type='submit' id='botonBorrarPost' value='$registro[IDPost]'name='borrarPost'>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div id='contenedor'>
                            $registro[Contenido]
                            </div>
                            <div class='overHid'>
                            <div style='float:left; overflow:hidden; width:120px;'>
                            ";
                            if($likedado2 == 0){
                                print "<div class='imagenLikes'>
                                    <form action='../comprobaciones/likes.php' method='post'>
                                        <button title='Like' type='submit' id='botonEnviarMensaje' name='like2' value='$registro[IDPost]'>
                                        </button>
                                    </form>
                                </div>";
                            }else{
                                print "<div class='imagenLikesDado'>
                                    <form action='../comprobaciones/likes.php' method='post'>
                                        <button title='Like' type='submit' id='botonEnviarMensaje' name='like2' value='$registro[IDPost]'>
                                        </button>
                                    </form>
                                </div>";
                            } 
                            print "<div class='likesPost'>$registro[Likes]</div>
                                   <div class='imagenResponder'>
                                   <form action='comentarpost.php' method='post'>
                                        <button title='Comentar' type='submit' id='botonEnviarMensaje' name='comentar' value='$registro[IDPost]'>
                                        </button>
                                    </form>
                                    </div>
                            </div>
                            <div style='float:right;'>
                                    <form action='mostrarlikesyrespuestas.php' method='post'>
                                          <button id='inputMensajes' name='mostrarlikes' value='$registro[IDPost]'>$registro[Fecha]</button>
                                    </form>
                            </div>
                            </div>
                        </div>";
                    }
                    print "
                    <form style='text-align:center' action='perfil.php' method='post'>";
                if($_SESSION['contador']>0){
                    print "<input class='botonNavegacion' type='submit' name='anterior' value='<'>";
                }if(mysqli_num_rows($consultaDatos)==5){
                    print"
                    <input class='botonNavegacion' type='submit' name='siguiente' value='>'>
                    </form>";
                }
                ?>
            </div>
            <!-- //Columna posts amigos -->
        </div>
    </div>
</body>

</html>