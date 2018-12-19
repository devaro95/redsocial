<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../estilos/style1.css" media="screen" />
    <?php
        //conexion con la base de datos
        include '../basededatos/conexionBD.php';
        
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
    <body>
        <div id="bodyUtilizable">
            <div id=col>
                <!-- mostrar mensaje -->
                <div id="flechaBack" onclick="location.href='mensajes.php'"></div>
                <div class="divMensaje">
					<form action="mensajes.php" method="post">
						<div class="sombraAzul emisorMensaje">
							<input type="text" style="border:0; background: none; width:100%; text-align:center;" value='<?php echo $_POST['search']?>' name="receptor" readonly>
						</div>
						<div class="sombraAzul asuntoMensaje" style="text-align:center;">
							<input type="text" style="border:0; background: none; width:100%;" name="asunto">	
						</div>
						<div class="sombraAzul contenidoMensaje">
							<textarea style="width:100%; height:100%;" name="contenido"></textarea>
						</div>
						<div style="float:right; margin-right:90px">
							<button type="submit" name="search">Responder</button>
							<button>Borrar</button>
						</div>
					</form>
				</div>
                 <!-- //mostrar mensaje -->
            </div>
        </div>
    </body>

</html>