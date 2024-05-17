<?php
namespace App\TrackTik;

/**
 * @TODO: Access token should be generated via API and cached for the expiry period
 */
class Oauth2Token
{
    public static function getToken(): string
    {
        return config('services.tracktik.access_token');
    }
}
