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
        //consultar datos de post totales
        if(isset($_POST['siguiente'])){
            $_SESSION['contador'] += 5;
            $consulta = "Select Contenido,post.Fecha, Likes, post.IDUsuario, usuarios.nombre, IDPost from post, usuarios where (post.IDUsuario = '" 
            . $_SESSION['IDUsuario'] . "' OR post.IDUsuario IN (Select amigos.IDUsuarioAmigo from amigos where amigos.IDUsuario = '" . $_SESSION['IDUsuario'] . "')) 
            AND usuarios.IDUsuario = post.IDUsuario order by fecha desc LIMIT 5 OFFSET " . $_SESSION['contador'];
            $consultaDatos1 = mysqli_query($conn, $consulta);
        }else if (isset($_POST['anterior'])){
            $_SESSION['contador'] -= 5;
            $consulta = "Select Contenido,post.Fecha, Likes, post.IDUsuario, usuarios.nombre, IDPost from post, usuarios where (post.IDUsuario = '" 
            . $_SESSION['IDUsuario'] . "' OR post.IDUsuario IN (Select amigos.IDUsuarioAmigo from amigos where amigos.IDUsuario = '" . $_SESSION['IDUsuario'] . "')) 
            AND usuarios.IDUsuario = post.IDUsuario order by fecha desc LIMIT 5 OFFSET " . $_SESSION['contador'];
            $consultaDatos1 = mysqli_query($conn, $consulta);
        }
        else{
            $consulta = "Select Contenido,post.Fecha, Likes, post.IDUsuario, usuarios.nombre, IDPost from post, usuarios where (post.IDUsuario = '" 
            . $_SESSION['IDUsuario'] . "' OR post.IDUsuario IN (Select amigos.IDUsuarioAmigo from amigos where amigos.IDUsuario = '" . $_SESSION['IDUsuario'] . "')) 
            AND usuarios.IDUsuario = post.IDUsuario order by fecha desc LIMIT 5";
            $consultaDatos1 = mysqli_query($conn, $consulta);
            $_SESSION['contador'] = 0;
        }
        //Insertamos en la tabla post el nuevo post escrito por el usuario
        if(isset($_POST['escribirPost'])){
            $consultaPost = "Insert into post(Contenido,Fecha,Likes,IDUsuario) values ('" . nl2br($_POST['contenidoPost']) . "', sysdate(), 0, '" . $_SESSION['IDUsuario'] . "')";
            $consultaGuardarPost = mysqli_query($conn, $consultaPost);
            header ('Location: inicio.php');
        }
        //comprobar si el usuario es administrador
        $consulta = mysqli_query($conn,"Select tipoUsuario from usuarios where IDUsuario = " . $_SESSION['IDUsuario']);
        $consultaAdmin = mysqli_fetch_assoc($consulta);
        if($consultaAdmin['tipoUsuario'] == 1){
            $_SESSION['admin'] = true;
        }else{
            $_SESSION['admin'] = false;
        }
        //añadir post a reportado
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
        <div id=col>
            <!-- Columna izquierda/Escribir post -->
            <div id="escribirPost">
                <div style="padding: 12px;">
                    <form action="inicio.php" method="post">
                        <textarea style="resize:none" size="50" rows="7" cols="45" class="signin" name="contenidoPost"
                            placeholder="" required></textarea>
                        <div style="float: right; ">
                            <div><input type="submit" value="Escribir" id="botonEnviarPost" name="escribirPost"></div>
                        </div>
                    </form>
                </div>
            </div>  
            <!-- //Columna izquierda<>Escribir post -->
            <!-- Columna posts -->
            <div id="colCentralInicio">
                <div id="nuevosPost">Nuevos Post</div>
                <?php
                    while($registro = mysqli_fetch_array($consultaDatos1)){
                        $likedado = "Select * from likes where IDUsuario = " . $_SESSION['IDUsuario'] .  "&& IDPost = " . $registro['IDPost'];
                        $likedado1 = mysqli_query($conn, $likedado);
                        $likedado2 = mysqli_num_rows($likedado1);
                        print 
                        "<div id='post'>
                            <div class='nombrePost'>
                                $registro[nombre]
                            </div>
                            <div class='contenedorPost'>
                                $registro[Contenido]
                            </div>
                            <div class='overHid'>
                            <div style='float:left; overflow:hidden; width:150px;'>
                            ";
                            if($likedado2 == 0){
                                print "<div class='imagenLikes'>
                                    <form action='../comprobaciones/likes.php' method='post'>
                                        <button title='Like' type='submit' id='botonEnviarMensaje' name='like' value='$registro[IDPost]'>
                                        </button>
                                    </form>
                                </div>";
                            }else{
                                print "<div class='imagenLikesDado'>
                                    <form action='../comprobaciones/likes.php' method='post'>
                                        <button title='Like' type='submit' id='botonEnviarMensaje' name='like' value='$registro[IDPost]'>
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
                                    <div class='imagenBloquear'>
                                   <form action='reporte.php' method='post'>
                                        <button title='Reportar' type='submit' id='botonEnviarMensaje' name='reportar' value='$registro[IDPost]'>
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
                print "<form style='text-align:center' action='inicio.php' method='post'>";
                if($_SESSION['contador']>0){
                    print "<input class='botonNavegacion' type='submit' name='anterior' value='<'>";
                }if(mysqli_num_rows($consultaDatos1)==5){
                    print"
                    <input class='botonNavegacion' type='submit' name='siguiente' value='>'>
                    </form>";
                }
                ?>
            </div>
            <!-- //Columna posts -->
        </div>
    </div>
</body>

</html>