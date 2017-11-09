<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\Airport;

class AirportService extends BaseService
{
    /**
     * @param $icao
     */
    public function create($icao)
    {
        // lets request the airport identifier from the central database
        $client = new Client();
        $res    = $client->request('GET', 'http://fsvaos.net/api/data/airports', [
            'query' => [
                'icao' => $icao,
            ],
        ])->getBody();

        // Add the airport to the database
        $data = json_decode($res, true);

        Airport::create([
            'id'      => $data['airport']['id'],
            'name'    => $data['airport']['name'],
            'icao'    => $data['airport']['gps_code'],
            'iata'    => $data['airport']['iata_code'],
            'lat'     => $data['airport']['latitude_deg'],
            'lon'     => $data['airport']['longitude_deg'],
            'city'    => $data['airport']['municipality'],
            'country' => $data['airport']['iso_country'],
        ]);
    }
}
