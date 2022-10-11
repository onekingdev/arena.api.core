<?php

namespace App\Http\Transformers\Soundblock;

use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Collections\CollectionHistory as CollectionHistoryModel;
use App\Traits\StampCache;

class CollectionHistory extends BaseTransformer
{

    use StampCache;

    public function transform(CollectionHistoryModel $objCollectionHistory)
    {
        $response = [
            "history_uuid" => $objCollectionHistory->history_uuid,
            "history_category" => $objCollectionHistory->history_category,
            "history_size" => $objCollectionHistory->history_size,
            "file_action" => $objCollectionHistory->file_action,
            "history_comment" => $objCollectionHistory->history_comment,
        ];

        return(array_merge($response, $this->stamp($objCollectionHistory)));
    }
}
