<?php

/** 
 * Classe utilizada para recuperar informações referentes a memória física da
 * máquina
 * 
 * @package     Core
 * @subpackage  WMI
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class MemoriaRAM
{
    /**
     * Método responsável por retornar a quantidade de memória disponível em formato literal
     * 
     * @access public
     * @return string
     */
    public function memoriaLivre()
    {
        // Avaliar trocar Win32_PerfRawData_PerfOS_Memory por﻿Win32_PerfFormattedData_PerfOS_Memory
        $r = ConectorWmi::executar("select AvailableBytes from Win32_PerfRawData_PerfOS_Memory");

        foreach ($r as $m)
        {
            return Transformar::converterDeBytes($m->AvailableBytes);
        }
    }

    /**
     * Método responsável por retornar a quantidade total de memória em formato literal
     * 
     * @access public
     * @return string
     */
    public function memoriaTotal()
    {
        $r = ConectorWmi::executar("Select TotalPhysicalMemory from Win32_ComputerSystem");

        foreach ($r as $m)
        {
            return Transformar::converterDeBytes($m->TotalPhysicalMemory);
        }
    }
    
    /**
     * Método responsável por apresentar o percentual de memória disponível
     * 
     * @access public
     * @return string
     */
    public function percentualLivre()
    {
        $memoriaLivre = $this->memoriaLivre();
        $memoriaTotal = $this->memoriaTotal();
        return sprintf("%0.2f%%", (100 * $memoriaLivre / $memoriaTotal));
    }
    
    /**
     * Método responsável por apresentar o percentual de memória utilizada
     * 
     * @access public
     * @return string
     */
    public function percentualUtilizado()
    {
        $memoriaLivre = $this->memoriaLivre();
        $memoriaTotal = $this->memoriaTotal();
        return sprintf("%0.2f%%", (($memoriaTotal - $memoriaLivre) * 100 / $memoriaTotal));
    }
}