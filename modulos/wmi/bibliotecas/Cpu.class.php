<?php

/** 
 * Classe utilizada para recuperar informações referentes a CPU da máquina
 * 
 * @package     Core
 * @subpackage  WMI
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class Cpu
{
    /**
     * Armazena uma instância de Win32_Processor
     *
     * @access private
     * @var object
     */
    private $cpu;
    
    /**
     * Captura as informações referentes a CPU
     * 
     * @access public
     */
    function __construct()
    {
        $this->cpu = ConectorWmi::executar("SELECT
                                                Caption,
                                                DeviceID,
                                                LoadPercentage,
                                                CurrentClockSpeed,
                                                Name,
                                                NumberOfCores,
                                                DataWidth,
                                                NumberOfLogicalProcessors
                                            FROM Win32_Processor");
    }
    
    /**
     * Retorna informações referentes a CPU
     * 
     * @access public
     * @return array
     */
    public function cpuDetalhes()
    {
        foreach ($this->cpu as $c)
        {
            $cpu[$c->DeviceID] = array('nome' => $c->Name,
                                       'arquitetura' => $c->DataWidth,
                                       'mhz' => $c->CurrentClockSpeed,
                                       'nucleos' => $c->NumberOfCores,
                                       'processadoresLogicos' => $c->NumberOfLogicalProcessors,
                                       'cargaDoProcessador' => $c->LoadPercentage);
        }
        return $cpu;
    }
}