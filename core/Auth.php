<?php

class Auth {

    // Iniciar sesion
    public static function startSession() {
        session_start();
    }

    // Ver si hay sesion iniciada
    public static function checkSession() {
        return isset($_SESSION['user_id']);
    }

    // Iniciar sesion con usuario especifico
    public static function loginUser($user_id) {
        $_SESSION['user_id'] = $user_id;
    }

    // Obtener el id del usuario
    public static function getUserId() {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }

    // Cerrar sesion del usuario
    public static function logoutUser() {
        session_unset();
        session_destroy();
    }
}