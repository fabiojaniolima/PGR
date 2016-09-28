<?php

require_once('../../modulos/wmi/conectores/ConectorWmi.class.php');
require_once('../../modulos/wmi/bibliotecas/Processos.class.php');
require_once('../../modulos/wmi/auxiliares/Transformar.class.php');

ConectorWmi::conectar('192.168.56.100', 'administrador', '1QAZxsw2');

if(ConectorWmi::status())
{
    $obj = new Processos();
    echo "<pre>";
    print_r($obj->listarProcessos());
    //var_dump($obj->listarProcessos());
    //print_r($obj->killProcesso());
    echo "</pre>";
}
else
{
    echo ConectorWmi::mensagemErro();
}