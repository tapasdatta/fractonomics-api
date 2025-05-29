<?php

namespace Modules\Asset\Http\Controller;

use Illuminate\Http\Request;
use Modules\Asset\Http\Requests\CreateAssetRequest;
use Modules\Asset\Data\AssetData;
use Modules\Asset\Models\Asset;
use Modules\Asset\Response\WithResponse;
use Modules\Asset\Services\AssetService;

class AssetController
{
    use WithResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $assets = Asset::whereUserUuid($user->uuid)->latest()->get();

        return AssetData::collect($assets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAssetRequest $request)
    {
        $assetData = AssetData::from([
            "user_uuid" => $request->user()?->uuid,
            "title" => $request->input("title"),
            "description" => $request->input("description"),
            "initial_value" => $request->input("initial_value"),
            "target_funding" => $request->input("target_funding"),
        ]);

        AssetService::createWithAttributes($assetData);

        return $this->assetCreatedResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
