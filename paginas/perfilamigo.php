<html>
<!-- queda arreglar problema con perfil-->

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion a la base de datos
        include '../basededatos/conexionBD.php';
        $consultaBloqueado = mysqli_query($conn, "Select * from bloqueado where IDBloqueado = '" . $_SESSION['IDUsuario'] . "' && IDUsuario = (Select IDUsuario from usuarios where nickname
        = '" . $_POST['search'] . "')");
        if(mysqli_num_rows($consultaBloqueado) != 0 && $_SESSION['admin']==false){
            header ('location: bloqueado.php');
        }
        if(isset($_POST['search'])){
            //datos del usuario amigo en variables de sesion
            $consulta = "Select * from usuarios where nickname = '" . $_POST['search'] . "'";
            $consultaDatos = mysqli_query($conn, $consulta);
            $datosUsuario = mysqli_fetch_array($consultaDatos); 
            $_SESSION['IDAmigo'] = $datosUsuario['IDUsuario'];
            $_SESSION['nombreAmigo'] = $datosUsuario['Nombre'];
            $_SESSION['telefonoAmigo'] = $datosUsuario['telefono'];
            $_SESSION['correoAmigo'] = $datosUsuario['email'];
            $_SESSION['paisAmigo'] = $datosUsuario['pais'];
            $_SESSION['ciudadAmigo'] = $datosUsuario['ciudad'];
            $_SESSION['FotoAmigo'] = $datosUsuario['FotoPerfil'];
            $_SESSION['tipoAmigo']= $datosUsuario['tipoUsuario'];
        }
        //comprobar si el usuario es amigo o no
        $comprobarAmistad = "Select * from amigos where IDUsuario = " . $_SESSION['IDUsuario'] . "&& IDUsuarioAmigo = " . $_SESSION['IDAmigo'];
        $consultaAmistad = mysqli_query($conn, $comprobarAmistad);
        $amistad = mysqli_num_rows($consultaAmistad);
        //comprobar si hay solicitud desde el o hacia el
        $comprobarSolicitud = "Select * from peticionamistad where IDUsuario = " . $_SESSION['IDUsuario'] . "&& IDUsuarioAmigo = " . $_SESSION['IDAmigo'];
        $consultaSolicitud = mysqli_query($conn, $comprobarSolicitud);
        $solicitud = mysqli_num_rows($consultaSolicitud);
        $comprobarSolicitud2 = "Select * from peticionamistad where IDUsuario = " . $_SESSION['IDAmigo'] . "&& IDUsuarioAmigo = " . $_SESSION['IDUsuario'];
        $consultaSolicitud2 = mysqli_query($conn, $comprobarSolicitud2);
        $solicitud2 = mysqli_num_rows($consultaSolicitud2);
        //consultar post del usuario amigo
        if(isset($_POST['siguiente'])){
            $_SESSION['contador'] += 5;
            $consulta = "Select * from post where IDUsuario = '" . $_SESSION['IDAmigo'] . "' order by fecha desc LIMIT 5 OFFSET " . $_SESSION['contador'];
            $consultaDatos = mysqli_query($conn, $consulta);
        }else if (isset($_POST['anterior'])){
            $_SESSION['contador'] -= 5;
            $consulta = "Select * from post where IDUsuario = '" . $_SESSION['IDAmigo'] . "' order by fecha desc LIMIT 5 OFFSET " . $_SESSION['contador'];
            $consultaDatos = mysqli_query($conn, $consulta);
        }else{
            $consulta = "Select * from post where IDUsuario = '" . $_SESSION['IDAmigo'] . "' order by fecha desc LIMIT 5";
            $consultaDatos = mysqli_query($conn, $consulta);
            $_SESSION['contador'] = 0;
        }
        //añadir amigo
        if(isset($_POST['anadirAmigo'])){
            $consultaAñadirAmigo = "Insert into peticionamistad (IDUsuario, IDUsuarioAmigo) values ('" . $_SESSION['IDUsuario'] . "','" . $_SESSION['IDAmigo'] . "')"; 
            mysqli_query($conn, $consultaAñadirAmigo);
            header("Location: perfilamigo.php");
        }
        //borrar amigo
        if(isset($_POST['borrarAmigo'])){
            $consultaBorrarAmigo = "Delete from amigos where IDUsuario = " . $_SESSION['IDUsuario'] . "&& IDUsuarioAmigo = " . $_SESSION['IDAmigo']; 
            $consultaBorrarAmigo2 = "Delete from amigos where IDUsuario = " . $_SESSION['IDAmigo'] . "&& IDUsuarioAmigo = " . $_SESSION['IDUsuario']; 
            mysqli_query($conn, $consultaBorrarAmigo);
            mysqli_query($conn, $consultaBorrarAmigo2);
            header("Location: perfilamigo.php");
        }
    ?>
</head>
<body>
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
                if($_SESSION['tipoAmigo'] == 1){
                    echo '<img 
                    style="
                    max-width: 200px; max-height: 200px;
                    min-width: 200px; min-height: 200px;
                    background-size: cover;
                    border: solid rgb(234, 190, 63);
                    border-radius: 100px;
                    margin: auto;
                    box-shadow: 0px 0px 20px 1px rgb(234, 190, 63);" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['FotoAmigo'] ).'"/>';
                }else{
                    echo '<img 
                    style="
                    max-width: 200px; max-height: 200px;
                    min-width: 200px; min-height: 200px;
                    background-size: cover;
                    border: solid black;
                    border-radius: 100px;
                    margin: auto;
                    box-shadow: 0px 0px 20px 1px rgb(4, 56, 133);" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['FotoAmigo'] ).'"/>';
                }
                ?>
                    <div id="nombrePerfil">
                        <?php echo $_SESSION['nombreAmigo'] ?>
                    </div>
                    <div style="overflow:hidden; margin-bottom: -25px;">
                        <?php if($solicitud > 0 || $solicitud2 > 0){ ?>
                       
                        <?php }else if($amistad > 0){ ?>
                        <div id="divAñadirAmigo" style="float:left;background-image: url('../Imagenes/borrarAmigoIcono.png'); background-size: cover; width: 25px; height: 25px;">
                            <form action="perfilamigo.php" method="post">
                                <button title="Borrar amigo" type="submit" id="botonEnviarMensaje" name="borrarAmigo"
                                    value="<?php echo $_SESSION['usuarioAmigo']?>">
                                </button>
                            </form>
                        </div>   
                        <?php }else{?> 
                        <div id="divAñadirAmigo" style="float:left;background-image: url('../Imagenes/anadirAmigoIcono.png'); background-size: cover; width: 25px; height: 25px;">
                            <form action="perfilamigo.php" method="post">
                                <button title="Añadir amigo" type="submit" id="botonEnviarMensaje" name="anadirAmigo"
                                    value="<?php echo $_SESSION['usuarioAmigo']?>">
                                </button>
                            </form>
                        </div>
                        <?php }?> 
                        <?php if($amistad > 0){ ?>    
                        <div id="divEnviarMensaje" style="background-image: url('../Imagenes/enviarmensaje.png'); background-size: cover; width: 25px; height: 25px;">
                            <form action="enviarMensaje.php" method="post">
                                <button title="Enviar mensaje" type="submit" id="botonEnviarMensaje" name="search"
                                    value="<?php echo $_POST['search']?>">
                                </button>
                            </form>
                        </div>
                        <?php } ?> 
                    </div>
                    <?php
                    print "
                    <div id='perfilInfoPersonal'> 
                        <div id='telefonoPerfil'> Telefono:";
                            echo $_SESSION['telefonoAmigo'];
                        print "
                        </div>
                        <div id='correoElectronicoPerfil'> E-mail:";
                            echo $_SESSION['correoAmigo'];
                        print "
                        </div>
                        <div id='paisPerfil'> Pais:";
                            echo $_SESSION['paisAmigo'];
                        print "
                        </div>
                        <div id='ciudadPerfil'> Ciudad:";
                            echo $_SESSION['ciudadAmigo'];
                        print "
                        </div>
                    </div>";
                    ?>
                </div>
                <!--Columna donde se mostraran los mensajes de los usuarios amigos-->
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
                                $_SESSION[nombreAmigo] 
                                </div>";
                                if($_SESSION['admin'] == true){
                                    print "
                                <div style='float:right; background-image: url(../Imagenes/borrar.png); width:14px; height: 14px; background-size:cover; margin:10px 10px'> 
                                    <form action='perfil.php' method='post'> 
                                        <button title='Borrar post' type='submit' id='botonBorrarPost' value='$registro[IDPost]'name='borrarPost'>
                                        </button>
                                    </form>
                                </div>";
                                }
                            print "
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
                                        <button title='Like' type='submit' id='botonEnviarMensaje' name='like3' value='$registro[IDPost]'>
                                        </button>
                                    </form>
                                </div>";
                            }else{
                                print "<div class='imagenLikesDado'>
                                    <form action='../comprobaciones/likes.php' method='post'>
                                        <button title='Like' type='submit' id='botonEnviarMensaje' name='like3' value='$registro[IDPost]'>
                                        </button>
                                    </form>
                                </div>";
                            } 
                            
                            print "<div class='likesPost'>$registro[Likes]</div>";
                            if($amistad > 0){

                            print "<div class='imagenResponder'>
                                   <form action='comentarpost.php' method='post'>
                                        <button title='Comentar' type='submit' id='botonEnviarMensaje' name='comentar' value='$registro[IDPost]'>
                                        </button>
                                    </form>
                                    </div>";
                                }
                            print "</div>     
                            </div>
                        </div>";
                    }
                    print "
                    <form style='text-align:center' action='perfilamigo.php' method='post'>";
                if($_SESSION['contador']>0){
                    print "<input class='botonNavegacion' type='submit' name='anterior' value='<'>";
                }if(mysqli_num_rows($consultaDatos)==5){
                    print"
                    <input class='botonNavegacion' type='submit' name='siguiente' value='>'>
                    </form>";
                }
            ?>
                </div>
            </div>
        </div>
    </body>

</html>