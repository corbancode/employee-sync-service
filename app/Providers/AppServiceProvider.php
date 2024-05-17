<?php

namespace App\Providers;

use App\Exceptions\NoHandlerFoundForEmployeeProvider;
use App\Interfaces\EmployeeProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EmployeeProviderInterface::class, function () {
            if ($provider = Route::current()->parameter('provider')) {
                $providerHandlers = config('app.employee_provider_handlers');
                if (is_array($providerHandlers) && isset($providerHandlers[$provider])) {
                    return app($providerHandlers[$provider]);
                }
                throw new NoHandlerFoundForEmployeeProvider("[EmployeeEvent] No event handler was found for $provider.");
            } else {
                throw new NoHandlerFoundForEmployeeProvider("[EmployeeEvent] No provider param found in request.");
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('tracktik', function () {
            return Http::retry(3, 100)->acceptJson()->withHeaders([
                'Content-Type' => 'application/json',
            ])->baseUrl(config('services.tracktik.base_url'));
        });
    }
}
