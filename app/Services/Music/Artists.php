<?php

namespace App\Services\Music;

use Util;
use App\Contracts\Music\Artists\Artists as ArtistsContract;
use App\Models\Music\Artist\Artist;
use App\Repositories\Music\Artists\{
    Artist as ArtistRepository,
    ArtistGenre as ArtistGenreRepository,
    ArtistMember as ArtistMemberRepository,
    ArtistMood as ArtistMoodRepository,
    ArtistStyle as ArtistStyleRepository,
    ArtistTheme as ArtistThemeRepository
};
use App\Repositories\Music\{
    Mood,
    Style,
    Genre,
    Theme,
};
use Exception;
use Illuminate\Support\Facades\DB;

class Artists implements ArtistsContract {
    /**
     * @var ArtistRepository
     */
    private ArtistRepository $artistRepository;
    /**
     * @var ArtistGenreRepository
     */
    private ArtistGenreRepository $artistGenreRepository;
    /**
     * @var ArtistStyleRepository
     */
    private ArtistStyleRepository $artistStyleRepository;
    /**
     * @var ArtistThemeRepository
     */
    private ArtistThemeRepository $artistThemeRepository;
    /**
     * @var ArtistMoodRepository
     */
    private ArtistMoodRepository $artistMoodRepository;
    /**
     * @var ArtistMemberRepository
     */
    private ArtistMemberRepository $artistMemberRepository;
    /** @var Genre */
    private Genre $objGenreRepository;
    /** @var Mood */
    private Mood $objMoodRepository;
    /** @var Style */
    private Style $objStyleRepository;
    /** @var Theme */
    private Theme $objThemeRepository;

    /**
     * Artists constructor.
     * @param ArtistRepository $artistRepository
     * @param ArtistGenreRepository $artistGenreRepository
     * @param ArtistStyleRepository $artistStyleRepository
     * @param ArtistThemeRepository $artistThemeRepository
     * @param ArtistMoodRepository $artistMoodRepository
     * @param ArtistMemberRepository $artistMemberRepository
     * @param Genre $objGenreRepository
     * @param Mood $objMoodRepository
     * @param Style $objStyleRepository
     * @param Theme $objThemeRepository
     */
    public function __construct(ArtistRepository $artistRepository, ArtistGenreRepository $artistGenreRepository,
                                ArtistStyleRepository $artistStyleRepository, ArtistThemeRepository $artistThemeRepository,
                                ArtistMoodRepository $artistMoodRepository, ArtistMemberRepository $artistMemberRepository,
                                Genre $objGenreRepository, Mood $objMoodRepository, Style $objStyleRepository,
                                Theme $objThemeRepository) {
        $this->artistRepository = $artistRepository;
        $this->artistGenreRepository = $artistGenreRepository;
        $this->artistStyleRepository = $artistStyleRepository;
        $this->artistThemeRepository = $artistThemeRepository;
        $this->artistMoodRepository = $artistMoodRepository;
        $this->artistMemberRepository = $artistMemberRepository;

        $this->objGenreRepository = $objGenreRepository;
        $this->objMoodRepository = $objMoodRepository;
        $this->objStyleRepository = $objStyleRepository;
        $this->objThemeRepository = $objThemeRepository;
    }

    public function index(?int $perPage = 10, array $filter = []) {
        [$objArtists, $availableMetaData] = $this->artistRepository->findAll($perPage, $filter);

        return ([$objArtists, $availableMetaData]);
    }

    public function get(string $artist) {
        return $this->artistRepository->find($artist);
    }

    /**
     * @param array $artistData
     * @return Artist
     * @throws Exception
     */
    public function create(array $artistData): Artist {
        DB::connection("mysql-music")->beginTransaction();

        $objArtist = $this->artistRepository->create($artistData);

        if (isset($artistData["genres"]) && is_array($artistData["genres"])) {
            $this->artistGenreRepository->createMultiple($objArtist, $artistData["genres"]);
        }

        if (isset($artistData["styles"]) && is_array($artistData["styles"])) {
            $this->artistStyleRepository->createMultiple($objArtist, $artistData["styles"]);
        }

        if (isset($artistData["themes"]) && is_array($artistData["themes"])) {
            $this->artistThemeRepository->createMultiple($objArtist, $artistData["themes"]);
        }

        if (isset($artistData["moods"]) && is_array($artistData["moods"])) {
            $this->artistMoodRepository->createMultiple($objArtist, $artistData["moods"]);
        }

        if (isset($artistData["members"]) && is_array($artistData["members"])) {
            $this->artistMemberRepository->createMultiple($objArtist, $artistData["members"]);
        }

        DB::connection("mysql-music")->commit();

        $objArtist->load(["genres", "styles", "themes", "moods", "members"]);

        return $objArtist;
    }

    /**
     * @param string $artist
     * @param array $arrParams
     * @return mixed
     * @throws Exception
     */
    public function update(string $artist, array $arrParams): Artist{
        $objArtist = $this->artistRepository->find($artist);

        $arrArtistInfo = [
            "artist_name" => $arrParams["artist_name"] ?? $artist->artist_name,
            "artist_active" => $arrParams["artist_active"] ?? $artist->artist_active,
            "artist_born" => $arrParams["artist_born"] ?? $artist->artist_born,
            "url_allmusic" => $arrParams["url_allmusic"] ?? $artist->url_allmusic,
            "url_amazon" => $arrParams["url_amazon"] ?? $artist->url_amazon,
            "url_itunes" => $arrParams["url_itunes"] ?? $artist->url_itunes,
            "url_lastfm" => $arrParams["url_lastfm"] ?? $artist->url_lastfm,
            "url_spotify" => $arrParams["url_spotify"] ?? $artist->url_spotify,
            "url_wikipedia" => $arrParams["url_wikipedia"] ?? $artist->url_wikipedia,
        ];

        $objArtist->update($arrArtistInfo);

        if (isset($arrParams["genres"])) {
            $objArtist->genres()->detach();
            foreach ($arrParams["genres"] as $genre) {
                $objGenre = $this->objGenreRepository->find($genre);
                $objArtist->genres()->attach($objGenre->genre_id, [
                    "row_uuid" => Util::uuid(),
                    "genre_uuid" => $objGenre->genre_uuid,
                    "artist_id" => $objArtist->artist_id,
                    "artist_uuid" => $objArtist->artist_uuid,
                    "stamp_epoch" => time(),
                    "stamp_date" => date("Y-m-d"),
                    "stamp_time" => date("G:i:s"),
                ]);
            }
        }

        if (isset($arrParams["moods"])) {
            $objArtist->moods()->detach();
            foreach ($arrParams["moods"] as $mood) {
                $objMood = $this->objMoodRepository->find($mood);
                $objArtist->moods()->attach($objMood->mood_id, [
                    "row_uuid" => Util::uuid(),
                    "mood_uuid" => $objMood->mood_uuid,
                    "artist_id" => $objArtist->artist_id,
                    "artist_uuid" => $objArtist->artist_uuid,
                    "stamp_epoch" => time(),
                    "stamp_date" => date("Y-m-d"),
                    "stamp_time" => date("G:i:s"),
                ]);
            }
        }

        if (isset($arrParams["styles"])) {
            $objArtist->styles()->detach();
            foreach ($arrParams["styles"] as $style) {
                $objStyle = $this->objStyleRepository->find($style);
                $objArtist->styles()->attach($objStyle->style_id, [
                    "row_uuid" => Util::uuid(),
                    "style_uuid" => $objStyle->style_uuid,
                    "artist_id" => $objArtist->artist_id,
                    "artist_uuid" => $objArtist->artist_uuid,
                    "stamp_epoch" => time(),
                    "stamp_date" => date("Y-m-d"),
                    "stamp_time" => date("G:i:s"),
                ]);
            }
        }

        if (isset($arrParams["themes"])) {
            $objArtist->themes()->detach();
            foreach ($arrParams["themes"] as $theme) {
                $objTheme = $this->objThemeRepository->find($theme);
                $objArtist->themes()->attach($objTheme->theme_id, [
                    "row_uuid" => Util::uuid(),
                    "theme_uuid" => $objTheme->theme_uuid,
                    "artist_id" => $objArtist->artist_id,
                    "artist_uuid" => $objArtist->artist_uuid,
                    "stamp_epoch" => time(),
                    "stamp_date" => date("Y-m-d"),
                    "stamp_time" => date("G:i:s"),
                ]);
            }
        }

        if (isset($arrParams["members"])) {
            $objArtist->members()->detach();
            foreach ($arrParams["members"] as $member) {
                $objArtistMember = $this->artistRepository->find($member);
                $objArtist->members()->attach($objArtistMember->artist_id, [
                    "row_uuid" => Util::uuid(),
                    "artist_uuid" => $objArtistMember->artist_uuid,
                    "artist_member" => $objArtistMember->artist_name,
                    "url_allmusic" => $objArtistMember->url_allmusic,
                    "stamp_epoch" => time(),
                    "stamp_date" => date("Y-m-d"),
                    "stamp_time" => date("G:i:s"),
                ]);
            }
        }

        return ($objArtist);
    }

    public function autocomplete(string $name, int $perPage = 10) {
        return $this->artistRepository->autocomplete($name, $perPage);
    }

    public function membersAutocomplete(string $artist, string $name, int $perPage = 10) {
        return $this->artistMemberRepository->membersAutocomplete($artist, $name, $perPage);
    }
}
