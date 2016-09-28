<?php

require_once('../../modulos/consulta/Traceroute.class.php');

$obj = new Traceroute;
$output = $obj->run("www.google.com.br", 3);
echo ($output) ? $obj->toString($output) : 'Destino não encontrado';