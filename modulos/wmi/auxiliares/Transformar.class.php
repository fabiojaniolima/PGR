<?php

/** 
 * Classe utilizada para formatar valores, tais como unidades de medida, data,
 * hora, etc
 * 
 * @package     Core
 * @subpackage  Auxiliar
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class Transformar
{
    /**
     * Método responsável por converter capacidade de Byte para um formato humano
     * 
     * @access public
     * @param string $valor
     * @return string
     */
    public static function converterDeBytes($valor)
    {
        $capacidade = (float) $valor;
        if ($capacidade >= 1099511627776)
        {
                $terabytes = $capacidade / 1099511627776;
                $capacidade = sprintf('%.2f TB', $terabytes);
        }
        elseif ($capacidade >= 1073741824)
        {
                $gigabytes = $capacidade / 1073741824;
                $capacidade = sprintf('%.2f GB', $gigabytes);
        }
        elseif ($capacidade >= 1048576)
        {
                $megabytes = $capacidade / 1048576;
                $capacidade = sprintf('%.2f MB', $megabytes);
        }
        elseif ($capacidade >= 1024)
        {
                $kilobytes = $capacidade / 1024;
                $capacidade = sprintf('%.2f KB', $kilobytes);
        }
        else
        {
                $capacidade = sprintf('%.2f B', $capacidade);
        }
        return $capacidade;
    }
    
    /**
     * Método responsável por converter capacidade de KiloByte para um formato humano
     * 
     * @access public
     * @param string $valor
     * @return string
     */
    public static function converterDeKilobyte($valor)
    {
        $capacidade = (float) $valor;
        if ($capacidade >= 1073741824)
        {
                $terabytes = $capacidade / 1073741824;
                $capacidade = sprintf('%.2f TB', $terabytes);
        }
        elseif ($capacidade >= 1048576)
        {
                $gigabytes = $capacidade / 1048576;
                $capacidade = sprintf('%.2f GB', $gigabytes);
        }
        elseif ($capacidade >= 1024)
        {
                $megabytes = $capacidade / 1024;
                $capacidade = sprintf('%.2f MB', $megabytes);
        }
        else
        {
                $capacidade = sprintf('%.2f KB', $capacidade);
        }
        return $capacidade;
    }
    
    /**
     * Método responsável por realizar a conversão do timestamp para um formato
     * de data/hora compreensivo
     * 
     * @access public
     * @param string $timestamp
     * @return string
     */
    public static function converterTimestampWindows($timestamp)
    {
        $posicao = strpos( $timestamp, '.' );
        $timestamp = substr($timestamp, 0, $posicao);
        $dataHora = substr($timestamp, 6,2) ."/". substr($timestamp, 4,2) ."/". substr($timestamp, 0,4) ." - ". substr($timestamp, 8,2) .":". substr($timestamp, 10,2) .":". substr($timestamp, 12,2);
        return $dataHora;
    }
}