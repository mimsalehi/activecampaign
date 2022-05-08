<?php

namespace MimSalehi\ActiveCampaign\Classes;


use JetBrains\PhpStorm\NoReturn;
use MimSalehi\ActiveCampaign\Traits\HttpRequest;

class EventTracking
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
     * ActiveCampaign Account Id.
     *
     * @var integer
     */
    protected $actid;

    /**
     * Http Requests Headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * ActiveCampaign Event Tracking Key.
     *
     * @var string
     */
    protected $eventKey;

    const GET = 'GET';
    const POST = 'POST';
    const DELETE = 'DELETE';

    public function __construct(array $config = [])
    {
        $configurations = config('activecampaign');

        $this->config = empty($configurations) ? $this->loadDefaultConfig() : $configurations;
 
        $this->baseUri = 'https://trackcmp.net/';
        $this->headers = [
            'Api-Token' => $this->config['api_key']
        ];
        $this->actid = $this->config['account_id'];
        $this->eventKey = $this->config['event_key'];
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
     * Event tracking by name.
     *
     * @return array
     */
    public function tracking($email, $eventName, $extra = null): array
    {
        $data = [
            'actid' => $this->actid,
            'key' => $this->eventKey,
            'event' => $eventName,
            'eventData' => $extra,
            "visit" => json_encode([
                'email' => $email
            ])
        ];
        return $this->make_request(self::POST, 'event', $data, $this->headers, $this->baseUri, true);
    }

}
