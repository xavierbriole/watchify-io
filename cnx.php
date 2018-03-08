<?php

$serveur = 'localhost';
$user = 'watchifydb';
$pass = 'Pa5wpFJfAt8XXHHc4xHg5hbQgZwauQJy4FXp9HfJns9XwQcHVS3WtKuBrcevct8BsTmazu';
$bdd = 'watchify';

try {
  $cnx = new PDO('mysql:host='.$serveur.';dbname='.$bdd, $user, $pass);
} catch (PDOException $e) {
  echo $e->getMessage();
}

?>