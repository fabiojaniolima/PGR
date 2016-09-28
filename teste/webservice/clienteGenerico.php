<?php

require_once('../../modulos/webservice/ClienteGenerico.class.php');

$post = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.webserviceX.NET/"><SOAP-ENV:Body><ns1:ConvertTemp><ns1:Temperature>31</ns1:Temperature><ns1:FromUnit>degreeCelsius</ns1:FromUnit><ns1:ToUnit>degreeFahrenheit</ns1:ToUnit></ns1:ConvertTemp></SOAP-ENV:Body></SOAP-ENV:Envelope>

';

$obj = new ClienteGenerico;
$obj->setURL('http://www.webservicex.net/ConvertTemperature.asmx');
$obj->setPost($post);
$obj->run();

echo '<script src="../../public/js/run_prettify.js"></script>';
echo "<pre class='prettyprint' >" . $obj->formatarXML() . "</pre>";