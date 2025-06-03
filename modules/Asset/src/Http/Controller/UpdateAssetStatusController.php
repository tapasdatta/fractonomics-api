<?php
namespace Modules\Asset\Http\Controller;

use Modules\Asset\Actions\UpdateAssetStatusAction;
use Modules\Asset\Data\UpdateAssetStatusData;
use Modules\Asset\Http\Requests\UpdateAssetStatusRequest;
use Modules\Asset\Models\Asset;
use Modules\Asset\Response\WithResponse;

class UpdateAssetStatusController
{
    use WithResponse;

    public function update(UpdateAssetStatusRequest $request, Asset $asset)
    {
        return $asset->status->canTransitionTo("voting");

        if (!$asset->status->canTransitionTo("voting")) {
            abort(422, "Invalid status transition.");
        }

        $assetData = UpdateAssetStatusData::from($request->validated());

        UpdateAssetStatusAction::execute($asset->uuid, $assetData);

        return $this->assetCreatedResponse();
    }
}
