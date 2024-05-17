<?php

namespace App\Http\Controllers;

use App\Enums\ResponseStatus;
use App\Interfaces\EmployeeProviderInterface;
use App\Jobs\SyncEmployeeToTrackTik;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Pangaea\S4\Interfaces\EventHandlerContract;

class EmployeeController extends Controller
{
    /**
     * @param EmployeeProviderInterface $employeeProvider
     * @param Request $request
     * @return JsonResponse
     */
    public function store(EmployeeProviderInterface $employeeProvider, Request $request): JsonResponse
    {
        try {
            $provider = Route::current()->parameter('provider');
            $validator = Validator::make($request->all(), $employeeProvider->validationRules(), $employeeProvider->validationCustomMessages());
            if ($validator->fails()) {
                return response()->json([
                    'status' => ResponseStatus::FAILED,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }
            $trackTikPayload = $employeeProvider->toTrackTikPayload($request->input());
            dispatch(new SyncEmployeeToTrackTik($trackTikPayload, $provider));
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                'status' => ResponseStatus::FAILED,
                'message' => 'An unexpected error occured'
            ], 500);
        }
        return response()->json([
            'status' => ResponseStatus::OK,
            'message' => 'Successful'
        ]);
    }

    /**
     * @param EmployeeProviderInterface $employeeProvider
     * @param Request $request
     * @return JsonResponse
     */
    public function update(EmployeeProviderInterface $employeeProvider, Request $request): JsonResponse
    {
        try {
            $provider = Route::current()->parameter('provider');
            $validator = Validator::make($request->all(), $employeeProvider->validationRules(), $employeeProvider->validationCustomMessages());
            if ($validator->fails()) {
                return response()->json([
                    'status' => ResponseStatus::FAILED,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }
            $trackTikPayload = $employeeProvider->toTrackTikPayload();
            dispatch(new SyncEmployeeToTrackTik($trackTikPayload, $provider));
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                'status' => ResponseStatus::FAILED,
                'message' => 'An unexpected error occured'
            ], 500);
        }
        return response()->json([
            'status' => ResponseStatus::OK,
            'message' => 'Successful'
        ]);
    }
}
