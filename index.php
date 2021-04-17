<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "config.php";
//criando o recurso cURL
$cr = curl_init();
//definindo a url de busca 
curl_setopt($cr, CURLOPT_URL, $url);
//definindo a url de busca 
curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
//definino que o método de envio, será POST
curl_setopt($cr, CURLOPT_POST, TRUE);
//definindo os dados que serão enviados
curl_setopt($cr, CURLOPT_POSTFIELDS, "email=$email&password=$pass");
//definindo uma variável para receber o conteúdo da página...
$records = explode('|', substr(curl_exec($cr), 0, -1));
//segunda consulta
curl_setopt($cr, CURLOPT_POSTFIELDS, "email=$email2&password=$pass2");
//definindo uma variável para receber o conteúdo da página...
$records2 = explode('|', substr(curl_exec($cr), 0, -1));
//fechando-o para liberação do sistema.
curl_close($cr); //fechamos o recurso e liberamos o sistema...
//mesclado arrays
$allRcords = array_merge($records, $records2);
//limpando as tabelas
$sql00 = "TRUNCATE TABLE radcheck";
mysqli_query($con, $sql00);
$sql10 = "TRUNCATE TABLE radusergroup";
mysqli_query($con, $sql10);
$sql20 = "TRUNCATE TABLE radgroupreply";
mysqli_query($con, $sql20);
$sql30 = "TRUNCATE TABLE radreply";
mysqli_query($con, $sql30);
//mostrando o conteúdo e registrando no banco de dados...
foreach ($allRcords as $record) {
    $json = json_decode($record, true);
    echo '<pre>';
    print_r($json);
    echo '</pre>';
    $expires = strtotime($json['expires']);
    $disable = strtotime('+5 days', $expires);
    if ($expires < strtotime(date('Y-m-d'))) {
        echo 'esse usuario expirou';
        if (strtotime(date('Y-m-d')) >= strtotime('+5 days', $expires)) {
            echo ', inadimplente por mais de 5 dias, conexão bloqueada';
        }
    } else {
        echo 'usuário esta ativo';
    }
    echo ' data de corte: ' . date('Y-m-d', strtotime('+5 days', strtotime($json['expires'])));
    // Insert record
    $sql01 = "INSERT INTO radcheck(id, username, attribute, op, value) VALUES('" . $json['id'] . "','" . $json['name'] . "','Cleartext-Password',':= ','" . $json['install_password'] . "')";


    if (isset($json['category_id']) == true) {
        $sql11 = "INSERT INTO radusergroup(username, groupname, priority) VALUES('" . $json['name'] . "','" . $json['category'] . "', '0')";
        $sql21 = "INSERT INTO radgroupreply(id, groupname, attribute, op, value) VALUES('" . $json['category_id'] . "','" . $json['category'] . "','Mikrotik-Rate-Limit',':= ','" . $json['rate'] . "')";
        if (strtotime(date('Y-m-d')) >= strtotime('+5 days', $expires)) {
            $sql41 = "INSERT INTO radreply(id, username, attribute, op, value) VALUES(NULL,'" . $json['name'] . "','Mikrotik-Address-List',':= ','block_notification')";
            mysqli_query($con, $sql41);
        } elseif (strtotime($json['expires']) < strtotime(date('Y-m-d'))) {
            $sql31 = "INSERT INTO radreply(id, username, attribute, op, value) VALUES(NULL,'" . $json['name'] . "','Mikrotik-Address-List',':= ','payment_reminder')";
            mysqli_query($con, $sql31);
        }

        mysqli_query($con, $sql11);
        mysqli_query($con, $sql21);
    }
    mysqli_query($con, $sql01);
}
mysqli_close($con);
