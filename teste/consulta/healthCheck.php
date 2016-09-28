<?php

require_once('../../modulos/consulta/HealthCheck.class.php');

$obj = new HealthCheck;

$obj->setURL("http://www.terra.com.br");
$obj->setAgent("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Safari/602.1.50");
$obj->setRedirect();
$statusHttp = $obj->run();
$contem = $obj->buscarString('esportes');

var_dump($statusHttp, $contem);


