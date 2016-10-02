<?php

/**
 * Essa classe fornece uma interface de conexão WMI com máquinas Windows,
 * possibilitando dessa forma a execução de comandos remotos de forma
 * rápida, eficiente e segura
 * 
 * @package     Core
 * @subpackage  WMI
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class ConectorWmi
{
    /**
     * Armazena um apontamento externo para um recurso de banco de dados
     * 
     * @access private
     * @var object
     */
    private static $conexao;
    
    /**
     * Armazena a(s) mensagens de erro
     * 
     * @access private
     * @var string
     */
    private static $mensagemErro;

    /**
     * Método de conexão para máquinas Windows
     * 
     * @access public
     * @param string $host
     * @param string $usuario
     * @param string $senha
     * @param int $porta
     * @param int $timeout
     * @return bool|string Conexão com sucesso retorna true, do contrario string de erro
     */
    public static function conectar($host, $usuario = null, $senha = null, $porta = 135, $timeout = 10)
    {
        try
        {
            /**
             * Método utilizado para testar conectividade com o host alvo
             * 
             * @param string $host
             * @param string $porta
             * @param int $errno valor de sistema
             * @param string $errstr mensagem de sistema
             * @param int $timeout tempo máximo a esperar por uma tentativa de conexão via socket
             */            
            if (!@fsockopen($host, $porta, $errno, $errstr, $timeout))
            {
                throw new Exception("Erro ({$errno}): Time Out ao chamar o host <b>{$host}</b>!");
            }

            $WbemLocator = new COM("WbemScripting.SWbemLocator");
            // @see https://msdn.microsoft.com/en-us/library/aa393720(v=vs.85).aspx
            self::$conexao = $WbemLocator->ConnectServer($host, 'root\cimv2', $usuario, $senha, 'MS_416');
            self::$conexao->Security_->ImpersonationLevel = 3;
        }
        catch (com_exception $e)
        {
            self::$mensagemErro = utf8_encode($e->getMessage());
        }
        catch (Exception $e)
        {
            self::$mensagemErro =  $e->getMessage();
        }
    }
    
    /**
     * Consulta o status da conexão
     * 
     * @return bool
     */
    public static function status()
    {
        return (self::$conexao != NULL) ? TRUE : FALSE;
    }
    
    /**
     * Retorna as mensagens de erro ocorridas no momento da conexão
     * 
     * @return string
     */
    public static function mensagemErro()
    {
        return self::$mensagemErro;
    }

    /**
     * Método responsável por executar a query WMI
     * 
     * @access public
     * @param string $query
     * @return object
     */
    public static function executar($query)
    {
        try
        {
            if (self::$conexao == NULL)
            {
                throw new Exception("Erro: É necessário abrir uma conexão antes de tentar executar qualquer comando!");
            }
             // @see http://php.net/manual/en/ref.com.php
            return self::$conexao->ExecQuery($query);
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }
}