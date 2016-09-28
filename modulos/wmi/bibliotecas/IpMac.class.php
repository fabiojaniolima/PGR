<?php

/** 
 * Classe utilizada para recuperar informações referentes ao adaptador de rede
 * 
 * @package     Core
 * @subpackage  WMI
 * @access      public
 * @author      Fábio J L Ferreira <contato@fabiojanio.com>
 * @license     MIT (arquivo LICENSE disponibilizado com este pacote)
 * @copyright   (c) 2016, Fábio J L Ferreira
 */
class IpMac
{  
    /**
     * Esse método retorna informações referentes ao adaptador de rede
     * 
     * @access public
     * @return array
     */
    public function detalhes()
    {
        $resultado = ConectorWmi::executar("select
                                                Description,
                                                DNSHostName,
                                                IPAddress,
                                                DNSDomain,
                                                InterfaceIndex,
                                                IPSubnet
                                            from Win32_NetworkAdapterConfiguration
                                            where IPEnabled=1");
               

        foreach ($resultado as $ipMac)
        {
            foreach ($ipMac->IPAddress as $key => $value)
            {
                $ip[] = $value;
            }

            $interface[$ipMac->InterfaceIndex] = array(
                                'interfaceDeRede' => $ipMac->Description,
                                'hostName' => $ipMac->DNSHostName,
                                'ipv4' => $ip[0],
                                'ipv6' => $ip[1],
                                'dominio' => $ipMac->DNSDomain
                             );
            unset($ip);
        }
        return $interface;
    }
}