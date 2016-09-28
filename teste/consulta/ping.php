<?php
ini_set("default_charset", "UTF-8");
require_once('../../modulos/consulta/Ping.class.php');

$obj = new Ping;
$output = $obj->run('www.google.com.br');
echo ($output) ? $obj->toString($output) : 'Destino não encontrado';