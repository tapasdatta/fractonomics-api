<?php
namespace Modules\Asset\Http\Controller;

use Modules\Asset\Actions\UpdateAssetStateAction;
use Modules\Asset\Data\StateAssetData;
use Modules\Asset\Http\Requests\UpdateAssetStateRequest;
use Modules\Asset\Models\Asset;
use Modules\Asset\Response\WithResponse;

class UpdateAssetStateController
{
    use WithResponse;

    public function update(UpdateAssetStateRequest $request, Asset $asset)
    {
        $assetData = StateAssetData::from($request->validated());

        UpdateAssetStateAction::execute($asset->uuid, $assetData);

        return $this->assetCreatedResponse();
    }
}
