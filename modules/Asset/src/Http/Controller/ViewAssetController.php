<?php

namespace Modules\Asset\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Asset\Data\ViewAssetData;
use Modules\Asset\Models\Asset;
use Modules\Asset\Response\WithResponse;

class ViewAssetController
{
    use WithResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $assets = Asset::whereUserUuid($user->uuid)->latest()->get();

        return ViewAssetData::collect($assets);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        Gate::authorize("view", $asset);

        return ViewAssetData::from($asset);
    }
}
