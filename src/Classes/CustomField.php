<?php

namespace MimSalehi\ActiveCampaign\Classes;


use MimSalehi\ActiveCampaign\Traits\HttpRequest;

class CustomField
{
    use HttpRequest;

    /**
     * ActiveCampaign Configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * ActiveCampaign Api URI.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * Http Requests Headers.
     *
     * @var array
     */
    protected $headers;


    const GET = 'GET';
    const POST = 'POST';
    const DELETE = 'DELETE';

    public function __construct(array $config = [])
    {
        $this->config = empty($config) ? $this->loadDefaultConfig() : $config;
        $this->baseUri = $this->config['api_url'] . '/api/3/';
        $this->headers = [
            'Api-Token' => $this->config['api_key']
        ];

    }

    /**
     * Get Config Path.
     *
     * @return string
     */
    public static function getDefaultConfigPath(): string
    {
        return dirname(__DIR__, 2).'/config/activecampaign.php';
    }

    /**
     * Retrieve default config.
     *
     * @return array
     */
    protected function loadDefaultConfig(): array
    {
        return require(static::getDefaultConfigPath());
    }

    /**
     * Retrieve custom fields lists.
     * @param $limit
     * @return array
     */
    public function list($limit = null): array
    {
        if(!isset($limit)){
            $limit = 100;
        }
        $limit = strval($limit);
        return $this->make_request(self::GET, `fields?limit={$limit}`, [], $this->headers, $this->baseUri);
    }
}
