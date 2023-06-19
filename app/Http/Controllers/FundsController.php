<?php

namespace App\Http\Controllers;

use App\Http\Requests\FundFindRequest;
use App\Http\Requests\FundUpdateRequest;
use App\Http\Resources\FundResource;
use App\Models\Fund;
use App\Services\FundService;
use Illuminate\Http\Request;

class FundsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FundFindRequest $request, FundService $fundService)
    {
        // Get funds
        $filters = $request->validated();

        $funds = $fundService->find($filters);

        // Return resource
        return FundResource::collection($funds);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FundUpdateRequest $request, Fund $fund, FundService $fundService)
    {
        $data = $request->validated();

        try {
            $fund = $fundService->update($fund, $data);

            return FundResource::make($fund);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
