<?php
namespace MimSalehi\ActiveCampaign\Traits;

use GuzzleHttp\Client;

trait HttpRequest
{
    /**
     * @param string $method
     * @param string $path
     * @param array $body
     * @param array $headers
     * @param null $baseUri
     * @param null $urlEncoded
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    protected function make_request(string $method, string $path, array $body = [], array $headers = [], $baseUri = null, $urlEncoded = null)
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
                if($urlEncoded){
                    $response = $client->post($path, [
                        'form_params' => $body,
                    ]);
                }else{
                    $response = $client->post($path, [
                        'json' => $body,
                    ]);
                }
                break;
            case 'PUT':
                if($urlEncoded){
                    $response = $client->put($path, [
                        'form_params' => $body,
                    ]);
                }else{
                    $response = $client->put($path, [
                        'json' => $body,
                    ]);
                }
                break;
            case 'DELETE':
                $response = $client->delete($path);
                break;
        }

        return json_decode($response->getBody(), true);
    }
}
