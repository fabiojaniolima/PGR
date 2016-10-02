<?php

/**
 * Essa classe fornece uma interface de conexão SSH com máquinas Unix-like,
 * possibilitando dessa forma a execução de comandos remotos de forma
 * rápida, eficiente e segura
 * 
 * @package     Core
 * @subpackage  SSH
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class ConectorSsh
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
     * @param string $maquina
     * @param string $usuario
     * @param string $senha
     * @return bool|string Conexão com sucesso retorna true, do contrario string de erro
     */
    public static function conectar($host, $usuario = null, $senha = null, $porta = 22, $timeout = 10)
    {
        try
        {
            require_once('Net/SSH2.php');

            self::$conexao = new Net_SSH2($host, $porta, $timeout);
            if (!self::$conexao->login($usuario, $senha)) {
                throw new Exception('A tentativa de login falhou!');
            }
        }
        catch (Exception $e)
        {
            self::$conexao = null;
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
    public static function executar($comando)
    {
        try
        {
            if (self::$conexao == NULL)
            {
                throw new Exception("Erro: É necessário abrir uma conexão antes de tentar executar qualquer comando!");
            }
            
            return self::$conexao->exec($comando);
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }
}