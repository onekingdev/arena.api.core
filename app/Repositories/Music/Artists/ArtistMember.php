<?php

namespace App\Repositories\Music\Artists;

use Util;
use Constant;
use App\Repositories\BaseRepository;
use App\Models\Music\Artist\Artist as ArtistModel;
use App\Repositories\Music\Artists\Artist as ArtistRepository;
use App\Models\Music\Artist\ArtistMember as ArtistMemberModel;

class ArtistMember extends BaseRepository {
    /** @var ArtistRepository */
    private ArtistRepository $artistsRepo;

    /**
     * ArtistMember constructor.
     * @param ArtistMemberModel $model
     * @param ArtistRepository $artistsRepo
     */
    public function __construct(ArtistMemberModel $model, ArtistRepository $artistsRepo) {
        $this->model = $model;
        $this->artistsRepo = $artistsRepo;
    }

    /**
     * @param ArtistModel $artist
     * @param array $arrMembers
     * @return ArtistModel
     * @throws \Exception
     */
    public function createMultiple(ArtistModel $artist, array $arrMembers) {
        foreach ($arrMembers as $arrMember) {
            $this->create([
                "row_uuid"      => Util::uuid(),
                "artist_uuid"   => $artist->artist_uuid,
                "artist_member" => $arrMember["member"],
                "url_allmusic"  => $arrMember["url_allmusic"],
                "stamp_epoch"   => time(),
                "stamp_date"    => time(),
                "stamp_time"    => time(),
                "stamp_source"  => Constant::ARENA_SOURCE,
            ]);
        }

        return $artist;
    }

    public function membersAutocomplete(string $artist, string $name, int $perPage = 10) {
        return (
            $this->model->where("artist_uuid", $artist)
                ->whereRaw("lower(artist_member) like (?)", "%" . Util::lowerLabel($name) . "%")
                ->paginate($perPage)
        );
    }
}
