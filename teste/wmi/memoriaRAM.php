<?php

require_once('../../modulos/wmi/conectores/ConectorWmi.class.php');
require_once('../../modulos/wmi/bibliotecas/MemoriaRam.class.php');
require_once('../../modulos/wmi/auxiliares/Transformar.class.php');

ConectorWmi::conectar('192.168.56.100', 'administrador', '1QAZxsw2');

if(ConectorWmi::status())
{
    $obj = new MemoriaRam();
    echo $obj->percentualUtilizado();
}
else
{
    echo ConectorWmi::mensagemErro();
}