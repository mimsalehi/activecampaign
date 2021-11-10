<?php

namespace MimSalehi\ActiveCampaign\Facades;

use Illuminate\Support\Facades\Facade;

class ActiveCampaign extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'activecampaign';
    }
}
