<?php
namespace App\Handlers\EmployeeProviders;

use App\Interfaces\EmployeeProviderInterface;

class Provider2 implements EmployeeProviderInterface {
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
            'job_title' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'tags' => ['sometimes', 'array'],
            'address' => ['nullable', 'array'],
            'address.address_line_1' => ['required_with:address', 'string', 'max:255'],
            'address.address_line_2' => ['nullable', 'string', 'max:255'],
            'address.city' => ['required_with:address', 'string', 'max:255'],
            'address.country' => ['required_with:address', 'string', 'size:2'],
            'address.state' => ['required_with:address', 'string', 'size:2'],
            'address.postal_code' => ['required_with:address', 'string', 'max:255']
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
     *     job_title?: string,
     *     email: string,
     *     tags?: array{string},
     *     address?: array{
     *      address_line_1: string,
     *      address_line_2?: string,
     *      city: string,
     *      state: string,
     *      country: string,
     *      postal_code: string
     *     }
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
            'firstName' => $payload['firstname'],
            'lastName' => $payload['lastname'],
            'jobTitle' => $payload['job_title'] ?? null,
            'email' => $payload['email'],
            'tags' => $payload['tags'] ?? null,
            'address' => !empty($payload['address']) ? [
                'addressLine1' => $payload['address']['address_line_1'] ?? null,
                'addressLine2' => $payload['address']['address_line_2'] ?? null,
                'city' => $payload['address']['city'] ?? null,
                'country' => $payload['address']['country'] ?? null,
                'state' => $payload['address']['state'] ?? null,
                'postalCode' => $payload['address']['postal_code'] ?? null,
            ] : null,
        ];
    }
}
