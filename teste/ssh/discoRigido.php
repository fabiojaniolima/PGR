<?php
// gabi temporaria
set_include_path(get_include_path() . PATH_SEPARATOR . '..\..\modulos\ssh\vendor\phpseclib');

require_once('../../modulos/ssh/conectores/ConectorSsh.class.php');
require_once('../../modulos/ssh/bibliotecas/DiscoRigido.class.php');
ConectorSsh::conectar("192.168.56.102", "root", "1QAZxsw2");

if(ConectorSsh::status())
{
    $obj = new DiscoRigido(true);
    echo "<pre>";
    echo $obj->capacidade();
    echo "</pre>";
    
}
else
{
    echo ConectorSsh::mensagemErro();
}

