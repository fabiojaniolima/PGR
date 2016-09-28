<?php

/**  
 * Classe utilizada para recuperar informações referentes ao disco rígido
 * da máquina
 * 
 * @package     Core
 * @subpackage  WMI
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class DiscoRigido
{
    /**
     * Contém uma lista das partições (Discos Lógicos) presentes no SO
     *
     * @access private
     * @var object
     */
    private $particoes;
    
    /**
     * Recupera no SO todas as unidades de disco rígido
     * 
     * @access public
     * @param string|null $particao
     */
    function __construct($particao = null)
    {
        $filtro = ($particao === null) ? "" : "and Caption='{$particao}:'";

        $this->particoes = ConectorWmi::executar("Select
                                                    FileSystem,
                                                    Caption,
                                                    Size,
                                                    FreeSpace
                                                from Win32_LogicalDisk
                                                where DriveType=3 {$filtro}"
                                                );
    }
    
    /**
     * Método responsável por recuperar a capacidade da partição
     * 
     * @access public
     * @return array
     */
    public function capacidade()
    {
        foreach ($this->particoes as $p)
        {
            $particao[$p->Caption] = Transformar::converterDeBytes($p->Size);
        }
        return $particao;
    }
    
    /**
     * Método responsável por recuperar o espaço livre em cada partição, o valor
     * pode ser recuperado em percentual ou em unidade de medida
     * 
     * @access public
     * @param boolean $porcentagem se for True exibe em percentual, senão exibe valor literal
     * @retun array
     */
    public function espacoLivre($porcentagem = false)
    {
        foreach ($this->particoes as $p)
       {
            if($porcentagem === false)
            {
                $particao[$p->Caption] = Transformar::converterDeBytes($p->FreeSpace);
            } else {
                $particao[$p->Caption] = sprintf("%0.2f%%", (100 * $p->FreeSpace / $p->Size));
            }
       }
       return $particao;
    }
    
    /**
     * Método responsável por recuperar o espaço utilizado em cada partição, o valor pode
     * ser recuperado em percentual ou em unidade de medida
     * 
     * @access public
     * @param boolean $porcentagem se for True exibe percentual, senão exibe valor literal
     * @return array
     */
    public function espacoUtilizado($porcentagem = false)
    {
        foreach ($this->particoes as $p)
       {
            if($porcentagem == false)
            {
                $particao[$p->Caption] = Transformar::converterDeBytes($p->Size - $p->FreeSpace);
            } else {
                $particao[$p->Caption] = sprintf("%0.2f%%", (100 * ($p->Size - $p->FreeSpace) / $p->Size));
            }
       }
       return $particao;
    }

    /**
     * Método responsável por mostrar uma visão detalhada de cada partição
     * 
     * @access public
     * @return array
     */
    public function detalhamento()
    {
        foreach ($this->particoes as $p)
        {
            $particao[$p->Caption] = array('capacidade' => Transformar::converterDeBytes($p->Size),
                                            'espacoLivre' =>  Transformar::converterDeBytes($p->FreeSpace),
                                            'percentualLivre' => sprintf("%0.2f%%", (100 * $p->FreeSpace / $p->Size)),
                                            'espacoUtilizado' => Transformar::converterDeBytes($p->Size - $p->FreeSpace),
                                            'percentualUtilizado' => sprintf("%0.2f%%", (100 * ($p->Size - $p->FreeSpace) / $p->Size)),
                                            'sistemaDeArquivo' => $p->FileSystem);
        }
        return $particao;
    }
}