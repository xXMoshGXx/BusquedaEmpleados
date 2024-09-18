<?php
session_start(); // Inicia la sesión (si no está ya iniciada)

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Elimina la cookie de sesión si existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirige al usuario a la página de inicio o login
header("Location: index.html");
exit();
?>