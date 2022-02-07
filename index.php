<?php

//SE CREA LA CONEXIÓN LDAP CON LOS PARÁMETROS ESPECIFICADOS
$ldap_conn = ldap_connect('server ip', '389');
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

$msg = ""; //SE DECLARA UN MENSAJE VACÍO

/*
SE COMPRUEBA QUE LOS CAMPOS ESTÉN INICIALIZADOS Y SI ES ASÍ, SE REALIZA
UN ldap_bind CON LOS VALORES OBTENIDOS.
SI EL RESULTADO ES CORRECTO, ALMACENAREMOS EL USUARIO EN LA SESIÓN E IREMOS A
LA PÁGINA registro.php. EN CASO CONTRARIO, SE MOSTRARÁ UN MENSAJE DE AVISO
*/
if(isset($_POST['user']) && isset($_POST['pass'])) {

    $user = $_POST['user'];
    $usuario = $user.'@nombre.local'; /*Cambiaremos nombre por el de la empresa*/
    $pass = $_POST['pass'];
    $bind = @ldap_bind($ldap_conn, $usuario, $pass);

    if($bind) {
        session_start();
        $_SESSION['usuarioLdap'] = $user;
        header('Location:php/registro.php');
    }
    else {
        $msg = "<img id='iAlert' src='images/alert.png'><p id='msg'>&nbsp;&nbsp;Revise usuario y contraseña</p></img>";
    }
}
?>

<html>
    <head>
        <link href="css/reset.css" rel="stylesheet" type="text/css">
        <link href="css/normalize.css" rel="stylesheet" type="text/css">
        <link href="css/estilos.css" rel="stylesheet" type="text/css">
    </head>

    <body id="cuerpoLogin">
        <div id="cPrincipal">
            <div id="cCabecera">
                <div id="cLogo"><img class="centrar" src="images/logo.png" alt=""></div>
            </div>
            <div id="cPLogin">
                <div id="cFLogin">
                    <div id="cTitulo"><p id="texto-cTitulo">Acceso registro CPD</p></div>
                        <form id="lForm" action="index.php" method="POST">
                            <label class="altura" for="user">Usuario</label>
                            <input class="altura" name="user" type="text" required/>
                            <label for="pass">Contraseña</label>
                            <input name="pass" type="password" required/>
                            <input id="enviar" type="submit" value="Enviar" name="enviar" />
                        </form>
                    </div>
                    <div id="cMsg">
                        <?php echo $msg; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
