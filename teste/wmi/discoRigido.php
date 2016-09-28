<?php

require_once('../../modulos/wmi/conectores/ConectorWmi.class.php');
require_once('../../modulos/wmi/bibliotecas/DiscoRigido.class.php');
require_once('../../modulos/wmi/auxiliares/Transformar.class.php');

$conexao = ConectorWmi::conectar('192.168.56.100', 'administrador', '1QAZxsw2');

if(ConectorWmi::status())
{
    $obj = new DiscoRigido("C");
    echo "<pre>";
    print_r($obj->detalhamento());
    echo "</pre>";
}
else
{
    echo ConectorWmi::mensagemErro();
}
/*
foreach ($obj->detalhamento() as $unidade => $itens)
{
    echo $unidade . "<br />";
    foreach ($itens as $item => $valor) {
        echo $item . ": " . $valor . "<br />";
    }
}
*/