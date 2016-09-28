<?php

require_once('../../modulos/wmi/conectores/ConectorWmi.class.php');
require_once('../../modulos/wmi/bibliotecas/ResumoSistema.class.php');
require_once('../../modulos/wmi/auxiliares/Transformar.class.php');

$conexao = ConectorWmi::conectar('192.168.56.100', 'administrador', '1QAZxsw2');

if(ConectorWmi::status())
{
$obj = new ResumoSistema();
echo "<pre>";
print_r($obj->detalhesSistema());
echo "</pre>";
}
else
{
    echo ConectorWmi::mensagemErro();
}