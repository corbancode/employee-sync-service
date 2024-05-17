<?php
namespace App\Handlers\EmployeeProviders;

use App\Interfaces\EmployeeProviderInterface;

class Provider1 implements EmployeeProviderInterface {
    /**
     * Provider validation rules
     *
     * @return array
     */
    public function validationRules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'jobTitle' => ['required', 'string', 'max:255'],
            'fax' => ['nullable', 'string', 'max:20'],
            'primaryPhone' => ['nullable', 'string', 'max:20'],
            'secondaryPhone' => ['nullable', 'string', 'max:20'],
            'username' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
        ];
    }

    /**
     * Provider validation data
     *
     * @return array
     */
    public function validationCustomMessages(): array
    {
        return [];
    }

    /**
     * Convert provider payload to TrackTik payload
     *
     * @param array{
     *     firstname: string,
     *     lastname: string,
     *     jobTitle: string,
     *     birthday: string,
     *     fax?: string,
     *     primaryPhone?: string,
     *     secondaryPhone?: string,
     *     username: string
     * } $payload from provider
     * @return array{
     *     firstName: string,
     *     lastName: string,
     *     password?: string,
     *     jobTitle?: string,
     *     region?: string,
     *     gender?: string,
     *     birthday?: string,
     *     externalIdObject?: array,
     *     address?: array{
     *      addressLine1: string,
     *      addressLine2?: string,
     *      city: string,
     *      country: string,
     *      state: string,
     *      postalCode: string
     *     },
     *     language?: string,
     *     fax?: string,
     *     customId?: string,
     *     primaryPhone?: string,
     *     secondaryPhone?: string,
     *     username?: string,
     *     email?: string,
     *     tags?: array{string}
     * }
     */
    public function toTrackTikPayload(array $payload): array
    {
        return [
            'username' => $payload['username'],
            'firstName' => $payload['firstname'],
            'lastName' => $payload['lastname'],
            'jobTitle' => $payload['jobTitle'],
            'birthday' => $payload['birthday'],
            'fax' => $payload['fax'] ?? null,
            'primaryPhone' => $payload['primaryPhone'] ?? null,
            'secondaryPhone' => $payload['secondaryPhone'] ?? null
        ];
    }
}
