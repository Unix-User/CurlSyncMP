<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* configurações */


/* dados de conexão ao site */
$url = 'https://unixlocal.tk/user/service';
$email = 'teste2@unix.local';
$pass = '1234';
$blockedusers = true;
$id = '2';

/* dados de conexão ao banco de dados */
$host = "localhost"; 
$user = "root";
$password = "senha";
$dbname = "radius";

$con = mysqli_connect($host, $user, $password,$dbname);

if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
