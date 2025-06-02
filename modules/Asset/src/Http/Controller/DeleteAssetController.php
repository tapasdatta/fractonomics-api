<?php

namespace Modules\Asset\Http\Controller;

use Modules\Asset\Models\Asset;
use Modules\Asset\Response\WithResponse;

class DeleteAssetController
{
    use WithResponse;

    public function destroy(Asset $asset)
    {
        //apply policy
        $asset->delete();

        return $this->success("Successfully deleted.");
    }
}
