<?php

/** 
 * Essa classe disponibiliza um meio capaz de listar os serviços disponíveis no
 * Sistema Operacional e consequentemente uma forma de manipular tais serviços
 * 
 * @package     Core
 * @subpackage  WMI
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class Servicos
{
    /**
     * O valor armazenado nesta variável representa um possível nome de serviço,
     * desta forma a consulta realizada no sistema será direcionada para este filtro
     *
     * @access private
     * @var string|null 
     */
    private $filtro;
    
    /**
     * Armazena uma instância de Win32_Service
     *
     * @access private
     * @var object
     */
    private $servico;
    
    /**
     * Recupera do SO o serviço passado como parâmetro ou toda a lista de serviços
     * caso nenhuma parâmetro seja passado 
     * 
     * @access public
     * @param string|null $servico
     */
    function __construct($servico = null)
    {
        $this->filtro = $servico;
        $where = ($servico != null) ? "WHERE Name='{$servico}'" : "";
        $this->servico = ConectorWmi::executar("SELECT
                                                    Name,
                                                    Caption,
                                                    State
                                                FROM Win32_Service {$where}");
    }
    
    /**
     * Traduz o status dos serviços e cria um array contendo a listagem dos serviços
     * 
     * @access public
     * @return array|null Retorna um array com a lista de serviços, se o serviço não for encontrado retorna null
     */
    public function listarServicos()
    {
        $idioma = array('Stopped' => 'Parado',
                        'Start Pending' => 'Iniciando',
                        'Stop Pending' => 'Parando',
                        'Running' => 'Iniciado',
                        'Continue Pending' => 'Ação Pendente',
                        'Pause Pending' => 'Pendente',
                        'Paused' => 'Em Pausa',
                        'Unknown' => 'Desconhecido');
        $i = 0;
        foreach ($this->servico as $s)
        {
            $status = (!array_key_exists($s->State, $idioma)) ? 'Desconhecido' : $idioma[$s->State];
            $servico[$i++] = array('nomeDoServico' => utf8_encode($s->Name),
                                   'nomeParaExibicao' => utf8_encode($s->Caption),
                                   'status' => $status);
        }
        return (isset($servico)) ? $servico : null;
    }
    /* em desenvolvimento
    public function listarServicoDependente()
    {
        if($this->filtro == null)
        {
            return null;
        }
        foreach ($this->servico as $s)
        {
            $pai[$s->Name] = array('nomeParaExibicao' => utf8_encode($s->Name),
                                'nomeDoServico' => utf8_encode($s->Caption));
            
            foreach (Windows::executar("Associators of {Win32_Service.Name='$s->Name'} WHERE Role = Antecedent") as $sf)
            {
                $dependente[$sf->Name] = array('nomeParaExibicao' => utf8_encode($sf->Name),
                                                'nomeDoServico' => utf8_encode($sf->Caption));
            
            $pai[$s->Name]['dependente'] = $dependente;
            }
        }
    }
     */
    
    /**
     * Retorna o código da operação e mensagem correspondente
     * 
     * @access public
     * @return array|null Retorna um array com status do comando ou null caso não exista o serviço(s)
     */
    public function stopServico()
    {
        $code = array('0' => 'Comando enviado',
                      '2' => 'O usuário não tem o acesso necessário',
                      '3' => 'O serviço não pode ser interrompido porque outros serviços que estão sendo executados são dependentes dela',
                      '5' => 'O serviço já está parado');
        
        foreach ($this->servico as $s)
        {
            $retorno = $s->StopService();
	}

        return (isset($retorno)) ? array($code[$retorno]) : null;
    }
    
    /**
     * Retorna código de operação e mensagem correspondente
     * 
     * @access public
     * @return array|null Retorna um array com status do comando ou null caso não exista o serviço(s)
     */
    public function startServico()
    {
        $code = array('0' => 'Comando enviado',
                      '2' => 'O usuário não tem o acesso necessário',
                      '6' => 'Não foi possível iniciar o serviço',
                      '8' => 'Falha desconhecida ao iniciar o serviço',
                      '10' => 'O serviço já está iniciado');
        
        foreach ($this->servico as $s)
        {
            $retorno = $s->StartService();
	}
        
        return (isset($retorno)) ? array($code[$retorno]) : null;
    }
}