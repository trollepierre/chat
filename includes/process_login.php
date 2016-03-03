<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start(); // Notre façon personnalisée de démarrer la session PHP
 
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // Le mot de passe hashé.
 
    if (login($email, $password, $mysqli) == true) {
        // Connecté 
        header('Location: ../index.php');
    } else {
        // Pas connecté 
        header('Location: ../login.php?error=1');
    }
} else {
    // Les variables POST correctes n’ont pas été envoyées à cette page
    echo 'Invalid Request';
}