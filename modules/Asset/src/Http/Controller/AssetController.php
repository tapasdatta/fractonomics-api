<?php

namespace Modules\Asset\Http\Controller;

use Illuminate\Http\Request;
use Modules\Asset\Http\Requests\CreateAssetRequest;
use Modules\Asset\Actions\AssetAction;
use Modules\Asset\Response\WithResponse;

class AssetController
{
    use WithResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAssetRequest $request, AssetAction $asset)
    {
        // return $request->validated();
        $asset->createWithAttributes($request->validated());

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
