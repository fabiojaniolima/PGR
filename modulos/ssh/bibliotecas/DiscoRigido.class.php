<?php

/**  
 * Classe utilizada para recuperar informações referentes ao disco rígido
 * da máquina
 * 
 * @package     Core
 * @subpackage  SSH
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class DiscoRigido
{   
    function capacidade($opcoes = '-h  --output=source,fstype,size,avail,used')
    {
        return ConectorSsh::executar("df {$opcoes}");
    }
    
    function espacoLivre($opcoes = '-h --output=source,avail')
    {
        return ConectorSsh::executar("df {$opcoes}");
    }
    
    function espacoUtilizado($opcoes = '-h --output=source,used')
    {
        return ConectorSsh::executar("df {$opcoes}");
    }
    
    /* em faze de desenvolvimento
    function toArray($string)
    {
        $string = '1K-blocos     Disp.     Usado Tipo     Sist. Arq.
                    19620732  16936748   1664236 ext4     /dev/sda1
                       10240     10240         0 devtmpfs udev
                      101232     96740      4492 tmpfs    tmpfs
                      253080    253080         0 tmpfs    tmpfs
                        5120      5120         0 tmpfs    tmpfs
                      253080    253080         0 tmpfs    tmpfs
                   487350400 349892492 137457908 vboxsf   var_www';
        
        $output = trim(preg_replace('/^.+\n/', '', $string));
        $output = explode("\n", $output);
        $output = preg_replace('/[ ]{1,}/', ' == ' ,$output);
        //$output = preg_replace('/([ ]{2,})|([ ][0-9][^a-zA-Z])/', ' == ' ,$output);
        
        
        
        for ($i = 0; $i < sizeof($output); $i++)
        {
            $campos = explode(" == ", $output[$i]);
            
            $arr[$i] = array(
                        'sistArq' => $campos[0],
                        'tipo' => $campos[1],
                        'tamanho' => Transformar::converterDeKilobyte($campos[2]),
                        'disponivel' => Transformar::converterDeKilobyte($campos[3]),
                        'usado' => Transformar::converterDeKilobyte($campos[4])
                        );
//            for ($y = 0; $y < sizeof($campos); $y++)
//            {
//                $arr[$i][$y] = $campos[$y];
//            }
        }
        
        return $arr;
    }
      */
     
}