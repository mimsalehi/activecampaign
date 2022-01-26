<?php

namespace MimSalehi\ActiveCampaign\Classes;


use MimSalehi\ActiveCampaign\Traits\HttpRequest;

class Contact
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
     * Create or Update Contact.
     *
     * @return array
     */
    public function createOrUpdate($data): array
    {
        return $this->make_request(self::POST, 'contact/sync', $data, $this->headers, $this->baseUri);
    }

    /**
     * Retrieve Contact Lists.
     *
     * @return array
     */
    public function list(): array
    {
        return $this->make_request(self::GET, 'contacts', [], $this->headers, $this->baseUri);
    }

    /**
     * Retrieve a Contact.
     *
     * @param $email string
     * @return array
     */
    public function find(string $email): array
    {
        return $this->make_request(self::GET, "contacts?filters[email]={$email}", [], $this->headers, $this->baseUri);
    }
}
