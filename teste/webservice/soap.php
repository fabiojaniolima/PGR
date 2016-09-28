<?php

require_once('../../modulos/webservice/Soap.class.php');

$args = [
    'Ator' =>
    [
        'nomeSolicitante' => '',
        'sistema' => 'Cadastro TI',
        'senha' => ''
    ],
    'ddd' => '62',
    'msisdn' => '',
    'msisdnOi' => '',
    'numDocumento' => '',
    'acao' => '',
    'codigoPlano' => '',
];

$obj = new Soap;
$obj->setWsdl('http://host:6505/Usuario/ConsultarStatusProxySoap?WSDL');
$obj->consultar('ConsultarStatus', $args);
$var = $obj->getRequest();
echo '<script src="../../public/js/run_prettify.js"></script>';
echo "<pre class='prettyprint' >" . $obj->formatarXML($var) . "</pre>";