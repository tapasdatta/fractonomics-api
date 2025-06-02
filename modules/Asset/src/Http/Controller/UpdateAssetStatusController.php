<?php

namespace Modules\Asset\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Asset\Actions\UpdateAssetStatusAction;
use Modules\Asset\Data\UpdateAssetStatusData;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Http\Requests\UpdateAssetStatusRequest;
use Modules\Asset\Models\Asset;
use Modules\Asset\Response\WithResponse;

class UpdateAssetStatusController
{
    use WithResponse;

    public function update(UpdateAssetStatusRequest $request, Asset $asset)
    {
        $assetData = UpdateAssetStatusData::from($request->validated());

        UpdateAssetStatusAction::execute($asset->uuid, $assetData);

        return $this->assetCreatedResponse();
    }
}
