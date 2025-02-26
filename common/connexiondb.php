<?php
    // Initialisation des variables de connexion bdd
    $db_host="localhost";
    $db_name="shopping";
    $db_user="root";
    $db_password="";


    //creation de mon objet pdo 

    $pdo=new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8",$db_user,$db_password);

    //option d'erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    
    ?>