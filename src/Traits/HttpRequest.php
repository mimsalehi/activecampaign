<?php
namespace MimSalehi\ActiveCampaign\Traits;

use GuzzleHttp\Client;

trait HttpRequest
{
    /**
     * @param string $method
     * @param string $path
     * @param string $baseUri
     * @param array $body
     * @param array $headers
     * @return array
     */

    protected function make_request(string $method, string $path, array $body = [], array $headers = [], $baseUri = null)
    {
        $client = new Client([
            'base_uri' => $baseUri,
            'headers' => $headers,
            'http_errors' => true,
        ]);

        $response = null;
        switch ($method) {
            case 'GET':
                $response = $client->get($path);
                break;
            case 'POST':
                $response = $client->post($path, [
                    'json' => $body,
                ]);
                break;
            case 'DELETE':
                $response = $client->delete($path);
                break;
        }

        return json_decode($response->getBody(), true);
    }
}
