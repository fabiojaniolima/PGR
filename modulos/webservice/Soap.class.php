<?php

/**
 * Classe de interação com interface soap
 * 
 * @package     Módulos
 * @subpackage  webservice
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class Soap
{
    /**
     * Armazena uma instância de SoapClient
     *
     * @var string 
     */
    private $client;

    /**
     * Define o WSDL e alguns atributos opcionais
     * 
     * @param string $wsdl
     * @param array $opcoes
     */
    public function setWsdl($wsdl, array $opcoes = null)
    {
        if (!$opcoes)
        {
            $opcoes = array(
                'cache_wsdl' => WSDL_CACHE_NONE,
                'soap_version' => SOAP_1_1,
                'trace' => 1,
                'encoding' => 'UTF-8'
            );
        }

        $this->client = new SoapClient($wsdl, $opcoes);
    }

    /**
     * Dispara a consulta contra o webservice
     * 
     * @param string $acao
     * @param array $argumentos
     * @return object
     */
    public function consultar($acao, array $argumentos)
    {
        return $this->client->__soapCall($acao, array($argumentos));
    }

    /**
     * Retorna o XML enviado
     * 
     * @return string
     */
    public function getRequest()
    {
        return $this->client->__getLastRequest();
    }

    /**
     * Retorna o XML recebido
     * 
     * @return string
     */
    public function getResponse()
    {
        return $this->client->__getLastResponse();
    }

    /**
     * Converte string para o formato XML
     * 
     * @param string $soap
     * @return string
     */
    public function formatarXML($soap)
    {
        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($soap);
        return htmlentities($dom->saveXML());
    }

}
