<?php

/**
 *  Classe genérica de interação com webservice
 * 
 * @package     Módulos
 * @subpackage  webservice
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class ClienteGenerico
{
    /**
     * Apontamento para uma instância de Curl
     * 
     * @access private
     * @var object
     */
    private $curl;
    
    /**
     * Armazena o xml retornado pela consulta
     *
     * @var string
     */
    private $xml;

    /**
     * Atribui alguns valores considerados padrão
     * 
     * @access public
     */
    public function __construct()
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 2);
    }

    /**
     * Atribui a URL alvo e o tempo máximo de espera
     * 
     * @param string $url
     * @param int $timeout
     */
    public function setURL($url, $timeout = 30)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeout);
    }

    /**
     * Define o agente a ser utilizado
     * 
     * @param string $agente
     */
    public function setAgent($agente = "PHP ClienteGenerico")
    {
        curl_setopt($this->curl, CURLOPT_USERAGENT, $agente);
    }

    /**
     * Adiciona o conteúdo e atribui um cabeçalho a requisição
     * 
     * @param string $post
     * @param array $header
     */
    public function setPost($post = null, array $header = null)
    {
        if (!$header)
        {
            $header = array(
                "Content-type: text/xml;charset=UTF-8",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "Content-length: " . strlen($post),
            );
        }

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post);
    }

    /**
     * Define regras de redirecionamento de URL
     * 
     * @param bool  $redirect
     * @param int   $numRedirect
     * @param bool  $refresh
     */
    public function setRedirect($redirect = true, $numRedirect = 5, $refresh = true)
    {
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $redirect);
        curl_setopt($this->curl, CURLOPT_MAXREDIRS, $numRedirect);
        curl_setopt($this->curl, CURLOPT_AUTOREFERER, $refresh);
    }

    /**
     * Executa a consulta a URL alvo
     * 
     * @return int
     */
    public function run()
    {
        $this->xml = curl_exec($this->curl);
        $code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        curl_close($this->curl);
        return $code;
    }

    /**
     * Retorna o output devolvido pelo servidor alvo
     * 
     * @return string
     */
    public function getResponse()
    {
        return $this->xml;
    }

    /**
     * Formata o retorno do método getResponse
     * 
     * @return string
     */
    public function formatarXML()
    {
        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->getResponse());
        return htmlentities($dom->saveXML());
    }
}
