<?php

require_once('../../modulos/consulta/Socket.class.php');

$obj = new Socket;
echo $obj->teste('192.168.56.103', 22) ? 'Tudo ok ;)' : $obj->getMensagem();