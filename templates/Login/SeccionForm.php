<?php
// Base de Datos
require './includes/config/database.php'; 
$db = conectarDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = mysqli_real_escape_string($db, $_POST['correoUsu']);
    $contrasena = mysqli_real_escape_string($db, $_POST['contrasenaUsu']);

    $query = "SELECT * FROM Usuarios WHERE correoUsu = ? AND contrasenaUsu = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ss", $correo, $contrasena);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado->num_rows === 1) {
        $usuario = mysqli_fetch_assoc($resultado);

        if ($usuario['rol'] === 'Usuario') {
            // Usuario normal
            session_start();
            $_SESSION['usuario'] = $usuario;
            header('Location: ./panelAdministrativo/dashboard.php');
        } elseif ($usuario['rol'] === 'Administrador') {
            // Administrador
            session_start();
            $_SESSION['usuario'] = $usuario;
            header('Location: ./panelAdministrativo/dashboard.php');
        }
    } else {
        $errores[] = 'El correo o la contraseña son incorrectos.';
    }
}
?>

<section class="vh-100">
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-6 text-black">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-6 px-0 w-25 mt-3 ms-3" id="logo">
            <img src="./assets/img/Logo.png" alt="Login image"  class="img-fluid">
          </div>

      <div class="col-12 col-md-6 d-flex align-items-center">

          <form id="form_Login" class="mt-10" role="form" method="POST">

            <h3 class="font-weight-bolder mb-3 pb-3" style="letter-spacing: 1px;" id="welcome">Bienvenido!</h3>
            <p class="mb-3">Ingresa los datos asociados a tu cuenta para acceder</p>

            <label for="correoUsu">Correo</label>
                <div class="mb-3">
                  <input type="email" name="correoUsu" id="correoUsu" class="form-control" aria-label="Email" aria-describedby="email-addon" 
                  autofocus/>
                </div>
                
                <label for="contrasenaUsu">Contraseña</label>
                <div class="mb-3">
                  <input type="password" name="contrasenaUsu" id="contrasenaUsu" class="form-control" aria-label="Password" 
                  aria-describedby="password-addon"/>
                </div>

            <div class="pt-1 mb-4">
              <button id="boton_Login" class="btn btn-info btn-lg btn-block" type="submit">Iniciar Sesion</button>
            </div>
            <div class="text-center">
            <p class="small mb-5 pb-lg-2"><a href="#!">¿Olvidaste tu contraseña?</a></p>
            </div>
            <p>¿No tienes una cuenta? <a href="#!" id="registroUsu">Registrate aqui</a></p>

          </form>

        </div>
      </div>
    </div>

      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
      <img src="./assets/img/imagen_Login.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
      </div>
    </div>
  </div>
</section>

