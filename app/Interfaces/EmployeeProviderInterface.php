<?php
namespace App\Interfaces;

interface EmployeeProviderInterface {
    /**
     * Provider validation rules
     *
     * @return array
     */
    public function validationRules(): array;

    /**
     * Provider validation data
     *
     * @return array
     */
    public function validationCustomMessages(): array;

    /**
     * Convert provider payload to TrackTik payload
     *
     * @param array $payload from provider
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
    public function toTrackTikPayload(array $payload): array;
}
