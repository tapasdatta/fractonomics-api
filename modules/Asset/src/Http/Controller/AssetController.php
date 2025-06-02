<?php

namespace Modules\Asset\Http\Controller;

use Illuminate\Http\Request;
use Modules\Asset\Actions\CreateAssetAction;
use Modules\Asset\Data\CreateAssetData;
use Modules\Asset\Http\Requests\CreateAssetRequest;
use Modules\Asset\Models\Asset;
use Modules\Asset\Response\WithResponse;

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

        return CreateAssetData::collect($assets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        CreateAssetRequest $request,
        CreateAssetAction $createAssetAction
    ) {
        $assetData = CreateAssetData::from($request->validated());

        $createAssetAction->execute($assetData);

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
    public function update(Request $request, Asset $asset)
    {
        // $request->validate([
        //     "status" => ["required", Rule::enum(AssetStatus::class)],
        // ]);

        // $status = AssetStatus::from($request->input("status"));

        // AssetService::updateAssetStatus($asset, $status);

        // return $this->assetCreatedResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
