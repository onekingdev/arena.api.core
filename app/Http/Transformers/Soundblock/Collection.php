<?php

namespace App\Http\Transformers\Soundblock;

use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Collections\Collection as CollectionModel;
use App\Repositories\Soundblock\Collection as CollectionRepository;
use App\Traits\StampCache;

class Collection extends BaseTransformer {

    use StampCache;

    public function transform(CollectionModel $objCollection) {
        /** @var CollectionRepository $objCollectionRepo */
        $objCollectionRepo = resolve(CollectionRepository::class);
        $objLatestCollection = $objCollectionRepo->findLatestByProject($objCollection->project);

        $response = [
            "collection_uuid"            => $objCollection->collection_uuid,
            "project_uuid"               => $objCollection->project_uuid,
            "collection_comment"         => $objCollection->collection_comment,
            "flag_changed_merchandising" => $objCollection->flag_changed_merchandising,
            "flag_changed_music"         => $objCollection->flag_changed_music,
            "flag_changed_other"         => $objCollection->flag_changed_other,
            "flag_changed_video"         => $objCollection->flag_changed_video,
            "is_old"                     => $objCollection->collection_id !== $objLatestCollection->collection_id
        ];

        return (array_merge($response, $this->stamp($objCollection)));
    }
}
