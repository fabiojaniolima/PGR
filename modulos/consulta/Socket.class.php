<?php

/**
 * Classe genérica para teste de conectividade
 * 
 * @package     Módulos
 * @subpackage  Consulta
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class Socket
{
    /**
     * Armazena a(s) mensagens de erro
     * 
     * @var string 
     */
    private $mensagem;
    
    /**
     * Dispara o teste de conexão
     * 
     * @param string $host
     * @param int $porta
     * @param int $timeout
     * @return boolean
     */
    public function teste($host, $porta, $timeout = 10)
    {
        /**
         * @see https://msdn.microsoft.com/en-us/library/windows/desktop/ms740668(v=vs.85).aspx
         */
        $dicionario = [
            '10060' => "Time Out ao tentar se conectar ao destino: {$host}",
            '10061' => "Conexão recusada pelo destino: {$host}",
        ];
        
        if(@fsockopen($host, $porta, $errno, $errstr, $timeout)) { return true; }

        $this->mensagem = array_key_exists($errno, $dicionario) ? strtr($errno, $dicionario) : $errstr;
        return false;
    }
    
    /**
     * Retorna a mensagem de erro de conexão caso exista
     * 
     * @return mixed
     */
    public function getMensagem()
    {
        if($this->mensagem) { return $this->mensagem; }
    }
}