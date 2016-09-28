<?php

require_once('../../modulos/wmi/conectores/ConectorWmi.class.php');
require_once('../../modulos/wmi/bibliotecas/IpMac.class.php');

ConectorWmi::conectar('192.168.56.100', 'administrador', '1QAZxsw2');

if(ConectorWmi::status())
{
    $obj = new IpMac();
    echo "<pre>";
    print_r($obj->detalhes());
    echo "</pre>";
}
else
{
    echo ConectorWmi::mensagemErro();
}