<?php
namespace App\TrackTik;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class EmployeeService
{
    /**
     * @param array $data
     * @return array{data: array{}, meta: array{}}
     * @throws RequestException
     */
    public function create(array $data): array
    {
        return Http::tracktik()->withToken(Oauth2Token::getToken())->post('rest/v1/employees', $data)->throw()->json();
    }

    /**
     * @param int $id
     * @param array $data
     * @return array{data: array{}, meta: array{}}
     * @throws RequestException
     */
    public function update(int $id, array $data): array
    {
        return Http::tracktik()->withToken(Oauth2Token::getToken())->patch("rest/v1/employees/$id", $data)->throw()->json();
    }
}
