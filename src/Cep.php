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

abstract class Cep
{


    /**
     * @param $cep
     * @return mixed
     * @throws GuzzleException
     */
    static public function find($cep)
    {
        if (!preg_match('/\d{8}|^\d{5}-\d{3}$/m', $cep) || empty($cep)) {
            throw new \Exception("CEP informado é inváldo");
        }

        $http     = new Client();
        $endpoint = sprintf('https://viacep.com.br/ws/%d/json', trim(str_replace("-", "", $cep)));
        $response = $http->request("GET", $endpoint, [
            'verify' => false,
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        } else {
            throw new \Exception("Serviço indisponível no momento");
        }
    }

}