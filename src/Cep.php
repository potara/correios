<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/correios
 * @copyright Copyright (c) 2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/correios/blob/master/LICENSE (MIT License)
 */

namespace Potara\Correios;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Cep
{
    const ENDPOTIN = 'https://viacep.com.br/ws/%d/%s';

    /**
     * @param $cep
     * @param string $type
     * @return array
     * @throws GuzzleException
     */
    public function __invoke($cep, $type = 'json')
    {

        if (!preg_match('/\d{8}|^\d{5}-\d{3}$/m', $cep) || empty($cep)) {
            throw new \Exception("CEP informado é inváldo");
        }
        $cep = trim(str_replace("-", "", $cep));

        $http     = new Client();
        $response = $http->request("POST", sprintf(ENDPOTIN, $cep, $type));

        if ($response->getStatusCode() == 200) {
            return $response->getBody()->getContents();
        } else {
            throw new \Exception("Serviço indisponível no momento");
        }
    }

}