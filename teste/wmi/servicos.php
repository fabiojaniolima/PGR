<?php

require_once('../../modulos/wmi/conectores/ConectorWmi.class.php');
require_once('../../modulos/wmi/bibliotecas/Servicos.class.php');

ConectorWmi::conectar('192.168.56.100', 'administrador', '1QAZxsw2');

if(ConectorWmi::status())
{
//    $obj = new Servicos('LanmanWorkstation');
//    echo $obj->StopServico();
//    echo "<pre>";
//    print_r($obj->statusServico());
//    echo "</pre>";
$obj = new Servicos("fdPHost"); //"fdPHost"
echo "<pre>";
var_dump($obj->stopServico());
echo "<hr>";
var_dump($obj->listarServicos());
echo "</pre>";
}
else
{
    echo ConectorWmi::mensagemErro();
}