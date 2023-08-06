<?php

    session_start();

    if (!isset($_SESSION['idfconta'])) {
        header("Location: login.php");
        die();
    } else {
        $tipoUsuario = $_SESSION['idfconta'];

        if ($tipoUsuario === 'u') {
            require_once 'C:/xampp/htdocs/cursophp/YARN/YARN/PGSCOMP/headeru.php';
        }
        if ($tipoUsuario === 'a') {
            require_once 'C:/xampp/htdocs/cursophp/YARN/YARN/PGSCOMP/headera.php';
        }
        if ($tipoUsuario === 'm') {
            require_once 'C:/xampp/htdocs/cursophp/YARN/YARN/PGSCOMP/headerm.php';
        }
    }
?>