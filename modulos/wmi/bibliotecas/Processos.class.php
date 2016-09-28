<?php

/** 
 * Classe utilizada para recuperar, iniciar e finalizar processos no Sistema
 * Operacional
 * 
 * @package     Core
 * @subpackage  WMI
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class Processos
{
    /**
     * Contém uma lista dos processos ativos no sistema operacional
     *
     * @access private
     * @var object
     */
    private $instancia;
    
    /**
     * Essa variável é uma proteção para impedir que kill massivo seja aplicado 
     *
     * @access private
     * @var string|null
     */
    private $criterio;
    
    /**
     * Esse método consulta os processos ativos no SO, se um parâmetro do tipo
     * string for passado a consulta será por nome, se for um inteiro a consulta
     * será pelo pid do processo e caso não seja passado parâmetro a consulta 
     * será feita retornando todos os processos ativos no SO
     * 
     * @access public
     * @param string|int $filtro
     */
    function __construct($filtro = null)
    {
        if(is_string($filtro))
        {
            $this->criterio = "and Name='{$filtro}'";
        }
        elseif (is_int($filtro))
        {
            $this->criterio = "and ProcessID={$filtro}";
        }
        else
        {
            $this->criterio = null;
        }
        
        /*
         * Analisar troca de win32_process que passa uma visão de processo
         * para Win32_PerfFormattedData_PerfProc_Process ou ﻿Win32_PerfRawData_PerfProc_Process
         * que mostra uma visão de SO proxima ao task manager
         */
        $this->instancia = ConectorWmi::executar("select
                                                    Name,
                                                    ProcessID,
                                                    Priority,
                                                    WorkingSetSize,
                                                    CreationDate,
                                                    ExecutablePath
                                                  from Win32_Process
                                                  where processid <> 0 {$this->criterio}");
    }
    
    /**
     * Método: Retorna um array contendo o nome do processo e seu PID
     * 
     * @access public
     * @return array|null Em caso de sucesso retorna um array de processo, do contrário retorna null
     */
    public function listarProcessos()
    {
        foreach ($this->instancia as $s)
        {
            $processo[$s->ProcessId] = array("nome" => $s->Name,
                                             "Priority" => $s->Priority,
                                             "memoriaTotal" => Transformar::converterDeBytes($s->WorkingSetSize),
                                             "inicioDoProcesso" => Transformar::converterTimestampWindows($s->CreationDate),
                                             "path" => $s->ExecutablePath);
        }
        return (isset($processo)) ? $processo : null;
    }
    
    /**
     * Método: Retorna um array contendo um inteiro para cada kill bem sucedido
     * 
     * @access public
     * @return int|null Retorna um int representando o total de processos finalizado, do contrário retorna null
     */
    public function killProcesso()
    {
        if($this->criterio != null)
        {
            foreach ($this->instancia as $s)
            {
                $retorno[] = $s->Terminate();
            }
        }
        return (isset($retorno)) ? count($retorno) : null;
    }
}