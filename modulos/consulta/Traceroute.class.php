<?php

/**
 * Está classe permite rastear o caminho até um host
 * 
 * @package     Módulos
 * @subpackage  Consulta
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class Traceroute
{
    /**
     * Realiza o disparo do tracert via SO
     * 
     * @param string $destino
     * @param int    $totalSaltos
     * @return string|null
     */
    public function run($destino, $totalSaltos = 15)
    {
        exec("tracert -h {$totalSaltos} {$destino}", $output, $status);
         
        return ($status == 0) ? $output : null;
    }
    
    /**
     * Converte o retorno do método run para string
     * 
     * @param array $tracert
     * @return string
     */
    public function toString(Array $tracert)
    {
        $var = "";
        foreach ($tracert as $linha)
        {
            $var .= utf8_encode($linha) . "\n";
        }
        
        $dicionario = array(
                                "¡" => "í",
                                "m ximo" => "máximo",
                            );
        
        return "<pre>" . strtr($var, $dicionario) . "</pre>";
    }
}