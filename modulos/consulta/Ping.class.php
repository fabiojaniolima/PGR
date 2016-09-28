<?php

/**
 * Essa permite realizar requisições ICMP por meio do comando ping
 * 
 * @package     Módulos
 * @subpackage  Consulta
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class Ping
{
    /**
     * Realiza o disparo do ping via SO
     * 
     * @param string $destino
     * @param int    $totalPings
     * @return string|null
     */
    public function run($destino, $totalPings = 5)
    {
        exec("ping -n {$totalPings} {$destino}", $output, $status);
        
        return ($status == 0) ? $output : null;
    }
    
    /**
     * Converte o retorno do método run para string
     * 
     * @param array $pings
     * @return string
     */
    public function toString(Array $pings)
    {
        $var = "";
        foreach ($pings as $linha)
        {
            $var .= utf8_encode($linha) . "\n";
        }
        
        $dicionario = array(
                                "¡" => "í",
                                "£" => "ú",
                                "M ximo" => "Máximo",
                                "Mdia " => "Média"
                            );
        
        return "<pre>" . strtr($var, $dicionario) . "</pre>";
    }
}