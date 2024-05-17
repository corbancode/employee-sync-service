<?php

namespace App\Jobs;

use App\Models\TrackTikEmployeeMapping;
use App\TrackTik\EmployeeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncEmployeeToTrackTik implements ShouldQueue, ShouldBeEncrypted
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     * @param array{
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
     * } $employeeData
     * @param string $provider
     */
    public function __construct(protected array $employeeData, protected string $provider)
    {
    }

    /**
     * Execute the job.
     * @param EmployeeService $employeeService
     */
    public function handle(EmployeeService $employeeService): void
    {
        try {
            $existingMapping = TrackTikEmployeeMapping::query()
                ->where('first_name', $this->employeeData['firstName'])
                ->where('last_name', $this->employeeData['lastName'])
                ->where('provider', $this->provider)
                ->first();
            if ($existingMapping) {
                $employeeService->update($existingMapping->tracktik_id, $this->employeeData);
            } else {
                $resp = $employeeService->create($this->employeeData);
                info('resp: ', $resp);
                TrackTikEmployeeMapping::query()->create([
                    'first_name' => $this->employeeData['firstName'],
                    'last_name' => $this->employeeData['lastName'],
                    'provider' => $this->provider,
                    'tracktik_id' => $resp['data']['id']
                ]);
            }
        } catch (\Throwable $th) {
            logs()->warning('[TrackTikEmployeeSync] Employee data failed to sync.', [
                'class' => self::class,
                'provider' => $this->provider,
                'data' => $this->employeeData,
                'error' => $th->getMessage(),
                'trace' => $th->getTrace()
            ]);
        }
    }
}
