<?php

require_once('../../modulos/wmi/conectores/ConectorWmi.class.php');
require_once('../../modulos/wmi/bibliotecas/Cpu.class.php');

$conexao = ConectorWmi::conectar('192.168.56.100', 'administrador', '1QAZxsw2');

if(ConectorWmi::status())
{
    $obj = new Cpu();

    echo "<pre>";
    print_r($obj->cpuDetalhes());
    echo "</pre>";
}
else
{
    echo ConectorWmi::mensagemErro();
}