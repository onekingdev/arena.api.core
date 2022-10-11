<?php

namespace App\Observers\Soundblock;

use App\Models\Soundblock\Collections\Collection as CollectionModel;

class Collection
{
    public function updated(CollectionModel $objCollection){
        $objDeployments = $objCollection->project->deployments;

        if ($objCollection->flag_changed_music && !empty($objDeployments)) {
            foreach ($objDeployments as $objDeployment) {
                $objDeployment->update([
                    "flag_latest_collection" => false
                ]);
            }
        }
    }
}
