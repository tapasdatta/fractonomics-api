<?php

namespace Modules\Asset\Http\Controller;

use Modules\Asset\Actions\CreateAssetAction;
use Modules\Asset\Data\CreateAssetData;
use Modules\Asset\Http\Requests\CreateAssetRequest;
use Modules\Asset\Response\WithResponse;

class CreateAssetController
{
    use WithResponse;

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
}
