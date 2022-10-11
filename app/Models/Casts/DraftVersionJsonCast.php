<?php

namespace App\Models\Casts;

use App\Models\Music\Artist\Artist;
use App\Models\Music\Genre;
use App\Models\Music\Mood;
use App\Models\Music\Style;
use App\Models\Music\Theme;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DraftVersionJsonCast implements CastsAttributes {
    public function get($model, $key, $value, $attributes) {
        /** @var Genre $objGenreModel */
        $objGenreModel = resolve(Genre::class);
        /** @var Mood $objMoodModel */
        $objMoodModel = resolve(Mood::class);
        /** @var Style $objStyleModel */
        $objStyleModel = resolve(Style::class);
        /** @var Theme $objStyleModel */
        $objThemeModel = resolve(Theme::class);
        /** @var Artist $objArtistModel */
        $objArtistModel = resolve(Artist::class);

        $arrDraftJson = json_decode($value, true);

        if (isset($arrDraftJson["genres"]) && is_array($arrDraftJson["genres"])) {
            $arrDraftJson["genres"] = $objGenreModel->whereIn("genre_uuid", $arrDraftJson["genres"])
                ->select("genre_id", "genre_uuid", "genre_name")->get();
        }

        if (isset($arrDraftJson["moods"]) && is_array($arrDraftJson["moods"])) {
            $arrDraftJson["moods"] = $objMoodModel->whereIn("mood_uuid", $arrDraftJson["moods"])
                  ->select("mood_id", "mood_uuid", "mood_name")->get();
        }

        if (isset($arrDraftJson["styles"]) && is_array($arrDraftJson["styles"])) {
            $arrDraftJson["styles"] = $objStyleModel->whereIn("style_uuid", $arrDraftJson["styles"])
                ->select("style_id", "style_uuid", "style_name")->get();
        }

        if (isset($arrDraftJson["themes"]) && is_array($arrDraftJson["themes"])) {
            $arrDraftJson["themes"] = $objThemeModel->whereIn("theme_uuid", $arrDraftJson["themes"])
                ->select("theme_id", "theme_uuid", "theme_name")->get();
        }

        if (isset($arrDraftJson["artist"]) && is_string($arrDraftJson["artist"])) {
            $arrDraftJson["artist"] = $objArtistModel->where("artist_uuid", $arrDraftJson["artist"])
                         ->select("artist_id", "artist_uuid", "artist_name")->first();
        }

        if (isset($arrDraftJson["tracks"]) && is_array($arrDraftJson["tracks"])) {
            foreach ($arrDraftJson["tracks"] as $intTrackKey => $arrTrack) {
                if (isset($arrTrack["composers"]) && is_array($arrTrack["composers"])) {
                    $arrDraftJson["tracks"][$intTrackKey]["composers"] = $objArtistModel->whereIn("artist_uuid", $arrTrack["composers"])
                        ->select("artist_id", "artist_uuid", "artist_name")->get();
                }

                if (isset($arrTrack["performers"]) && is_array($arrTrack["performers"])) {
                    $arrDraftJson["tracks"][$intTrackKey]["performers"] = $objArtistModel->whereIn("artist_uuid", $arrTrack["performers"])
                        ->select("artist_id", "artist_uuid", "artist_name")->get();
                }

                if (isset($arrTrack["features"]) && is_array($arrTrack["features"])) {
                    $arrDraftJson["tracks"][$intTrackKey]["features"] = $objArtistModel->whereIn("artist_uuid", $arrTrack["features"])
                        ->select("artist_id", "artist_uuid", "artist_name")->get();
                }
            }
        }

        return $arrDraftJson;
    }

    public function set($model, $key, $value, $attributes) {
        if (is_array($value)) {
            return json_encode($value);
        }

        return $value;
    }
}
