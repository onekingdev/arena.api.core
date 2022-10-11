<?php


namespace App\Traits\Soundblock;


use Util;
use App\Models\Soundblock\Track as TrackModel;
use App\Events\Soundblock\TrackVolumeNumber as TrackVolumeNumberEvent;
use App\Models\Soundblock\Collections\Collection as SoundblockCollection;

trait UpdateCollectionFiles
{
    private function updateTrackFileData(TrackModel $objTrack, array $itemFile, SoundblockCollection $objCollection, array $changes){
        $arrHistory = [];

        if (array_key_exists("track_artist", $itemFile) && ($objTrack->track_artist !== $itemFile["track_artist"])) {
            $changes["Track artist"] = [
                "Previous value" => $objTrack->track_artist,
                "Changed to" => $itemFile["track_artist"]
            ];
            $arrHistory["track_artist"] = [
                "old" => $objTrack->track_artist,
                "new" => $itemFile["track_artist"]
            ];

            $objTrack->track_artist = $itemFile["track_artist"];
        }

        if (array_key_exists("track_version", $itemFile) && ($objTrack->track_version !== $itemFile["track_version"])) {
            $changes["Track version"] = [
                "Previous value" => $objTrack->track_version,
                "Changed to" => $itemFile["track_version"]
            ];
            $arrHistory["track_version"] = [
                "old" => $objTrack->track_version,
                "new" => $itemFile["track_version"]
            ];

            $objTrack->track_version = $itemFile["track_version"];
        }

        if (array_key_exists("copyright_name", $itemFile) && ($objTrack->copyright_name !== $itemFile["copyright_name"])) {
            $changes["Copyright name"] = [
                "Previous value" => $objTrack->copyright_name,
                "Changed to" => $itemFile["copyright_name"]
            ];
            $arrHistory["copyright_name"] = [
                "old" => $objTrack->copyright_name,
                "new" => $itemFile["copyright_name"]
            ];

            $objTrack->copyright_name = $itemFile["copyright_name"];
        }

        if (array_key_exists("copyright_year", $itemFile) && ($objTrack->copyright_year !== $itemFile["copyright_year"])) {
            $changes["Copyright year"] = [
                "Previous value" => $objTrack->copyright_year,
                "Changed to" => $itemFile["copyright_year"]
            ];
            $arrHistory["copyright_year"] = [
                "old" => $objTrack->copyright_year,
                "new" => $itemFile["copyright_year"]
            ];

            $objTrack->copyright_year = $itemFile["copyright_year"];
        }

        if (array_key_exists("recording_location", $itemFile) && ($objTrack->recording_location !== $itemFile["recording_location"])) {
            $changes["Recording location"] = [
                "Previous value" => $objTrack->recording_location,
                "Changed to" => $itemFile["recording_location"]
            ];
            $arrHistory["recording_location"] = [
                "old" => $objTrack->recording_location,
                "new" => $itemFile["recording_location"]
            ];

            $objTrack->recording_location = $itemFile["recording_location"];
        }

        if (array_key_exists("recording_year", $itemFile) && ($objTrack->recording_year !== $itemFile["recording_year"])) {
            $changes["Recording year"] = [
                "Previous value" => $objTrack->recording_year,
                "Changed to" => $itemFile["recording_year"]
            ];
            $arrHistory["recording_year"] = [
                "old" => $objTrack->recording_year,
                "new" => $itemFile["recording_year"]
            ];

            $objTrack->recording_year = $itemFile["recording_year"];
        }

        if (array_key_exists("track_volume_number", $itemFile) && ($objTrack->track_volume_number != intval($itemFile["track_volume_number"]))) {
            $changes["Track volume number"] = [
                "Previous value" => $objTrack->track_volume_number,
                "Changed to" => $itemFile["track_volume_number"]
            ];
            $arrHistory["track_volume_number"] = [
                "old" => $objTrack->track_volume_number,
                "new" => $itemFile["track_volume_number"]
            ];

            event(new TrackVolumeNumberEvent($objTrack, $itemFile["track_volume_number"]));
        }

        if (array_key_exists("track_release_date", $itemFile) && ($objTrack->track_release_date !== $itemFile["track_release_date"])) {
            $changes["Track release date"] = [
                "Previous value" => $objTrack->track_release_date,
                "Changed to" => $itemFile["track_release_date"]
            ];
            $arrHistory["track_release_date"] = [
                "old" => $objTrack->track_release_date,
                "new" => $itemFile["track_release_date"]
            ];

            $objTrack->track_release_date = $itemFile["track_release_date"];
        }

        if (array_key_exists("country_recording", $itemFile) && ($objTrack->country_recording !== $itemFile["country_recording"])) {
            $changes["Country recording"] = [
                "Previous value" => $objTrack->country_recording,
                "Changed to" => $itemFile["country_recording"]
            ];
            $arrHistory["country_recording"] = [
                "old" => $objTrack->country_recording,
                "new" => $itemFile["country_recording"]
            ];

            $objTrack->country_recording = $itemFile["country_recording"];
        }

        if (array_key_exists("country_commissioning", $itemFile) && ($objTrack->country_commissioning !== $itemFile["country_commissioning"])) {
            $changes["Country commissioning"] = [
                "Previous value" => $objTrack->country_commissioning,
                "Changed to" => $itemFile["country_commissioning"]
            ];
            $arrHistory["country_commissioning"] = [
                "old" => $objTrack->country_commissioning,
                "new" => $itemFile["country_commissioning"]
            ];

            $objTrack->country_commissioning = $itemFile["country_commissioning"];
        }

        if (array_key_exists("rights_holder", $itemFile) && ($objTrack->rights_holder !== $itemFile["rights_holder"])) {
            $changes["Rights holder"] = [
                "Previous value" => $objTrack->rights_holder,
                "Changed to" => $itemFile["rights_holder"]
            ];
            $arrHistory["rights_holder"] = [
                "old" => $objTrack->rights_holder,
                "new" => $itemFile["rights_holder"]
            ];

            $objTrack->rights_holder = $itemFile["rights_holder"];
        }

        if (array_key_exists("rights_owner", $itemFile) && ($objTrack->rights_owner !== $itemFile["rights_owner"])) {
            $changes["Rights owner"] = [
                "Previous value" => $objTrack->rights_owner,
                "Changed to" => $itemFile["rights_owner"]
            ];
            $arrHistory["rights_owner"] = [
                "old" => $objTrack->rights_owner,
                "new" => $itemFile["rights_owner"]
            ];

            $objTrack->rights_owner = $itemFile["rights_owner"];
        }

        if (array_key_exists("rights_contract", $itemFile) && ($objTrack->rights_contract !== $itemFile["rights_contract"])) {
            $changes["Rights contract"] = [
                "Previous value" => $objTrack->rights_contract,
                "Changed to" => $itemFile["rights_contract"]
            ];
            $arrHistory["rights_contract"] = [
                "old" => $objTrack->rights_contract,
                "new" => $itemFile["rights_contract"]
            ];

            $objTrack->rights_contract = $itemFile["rights_contract"];
        }

        if (array_key_exists("flag_track_explicit", $itemFile) && ($objTrack->flag_track_explicit != $itemFile["flag_track_explicit"])) {
            $changes["Explicit"] = [
                "Previous value" => $objTrack->flag_track_explicit,
                "Changed to" => $itemFile["flag_track_explicit"]
            ];
            $arrHistory["flag_track_explicit"] = [
                "old" => $objTrack->flag_track_explicit,
                "new" => $itemFile["flag_track_explicit"]
            ];

            $objTrack->flag_track_explicit = $itemFile["flag_track_explicit"];
        }

        if (array_key_exists("flag_track_instrumental", $itemFile) && ($objTrack->flag_track_instrumental != $itemFile["flag_track_instrumental"])) {
            $changes["Instrumental"] = [
                "Previous value" => $objTrack->flag_track_instrumental,
                "Changed to" => $itemFile["flag_track_instrumental"]
            ];
            $arrHistory["flag_track_instrumental"] = [
                "old" => $objTrack->flag_track_instrumental,
                "new" => $itemFile["flag_track_instrumental"]
            ];

            $objTrack->flag_track_instrumental = $itemFile["flag_track_instrumental"];
        }

        if (array_key_exists("flag_allow_preorder", $itemFile) && ($objTrack->flag_allow_preorder != $itemFile["flag_allow_preorder"])) {
            $changes["Preorder"] = [
                "Previous value" => $objTrack->flag_allow_preorder,
                "Changed to" => $itemFile["flag_allow_preorder"]
            ];
            $arrHistory["flag_allow_preorder"] = [
                "old" => $objTrack->flag_allow_preorder,
                "new" => $itemFile["flag_allow_preorder"]
            ];

            $objTrack->flag_allow_preorder = $itemFile["flag_allow_preorder"];
        }

        if (array_key_exists("flag_allow_preorder_preview", $itemFile) && ($objTrack->flag_allow_preorder_preview != $itemFile["flag_allow_preorder_preview"])) {
            $changes["Allow preorder preview"] = [
                "Previous value" => $objTrack->flag_allow_preorder_preview,
                "Changed to" => $itemFile["flag_allow_preorder_preview"]
            ];
            $arrHistory["flag_allow_preorder_preview"] = [
                "old" => $objTrack->flag_allow_preorder_preview,
                "new" => $itemFile["flag_allow_preorder_preview"]
            ];

            $objTrack->flag_allow_preorder_preview = $itemFile["flag_allow_preorder_preview"];
        }

        if (array_key_exists("track_language", $itemFile)) {
            $objLang = $this->languagesRepo->find($itemFile["track_language"]);

            if (is_null($objLang)) {
                throw new \Exception("Invalid language.");
            }

            if (optional($objTrack->language)->data_language !== $objLang->data_language) {
                $changes["Language"] = [
                    "Previous value" => optional($objTrack->language)->data_language,
                    "Changed to" => $objLang->data_language
                ];
                $arrHistory["track_language"] = [
                    "old" => optional($objTrack->language)->data_language,
                    "new" => $objLang->data_language
                ];
            }

            $objTrack->track_language_id = $objLang->data_id;
            $objTrack->track_language_uuid = $objLang->data_uuid;
        }

        if (array_key_exists("track_language_vocals", $itemFile)) {
            $objLang = $this->languagesRepo->find($itemFile["track_language_vocals"]);

            if (optional($objTrack->languageVocals)->data_language !== optional($objLang)->data_language) {
                $changes["Language vocals"] = [
                    "Previous value" => optional($objTrack->languageVocals)->data_language,
                    "Changed to" => optional($objLang)->data_language
                ];
                $arrHistory["track_language_vocals"] = [
                    "old" => optional($objTrack->languageVocals)->data_language,
                    "new" => optional($objLang)->data_language
                ];
                $objTrack->track_language_vocals_id = optional($objLang)->data_id;
                $objTrack->track_language_vocals_uuid = optional($objLang)->data_uuid;
            }
        }

        if (array_key_exists("genre_primary", $itemFile)) {
            $objPrimaryGenre = $this->genresRepo->findByUuid($itemFile["genre_primary"], true, false);

            if (is_null($objPrimaryGenre)) {
                throw new \Exception("Genre is not primary.");
            }

            if ($objTrack->primaryGenre->data_genre !== $objPrimaryGenre->data_genre) {
                $changes["Primary genre"] = [
                    "Previous value" => $objTrack->primaryGenre->data_genre,
                    "Changed to" => $objPrimaryGenre->data_genre
                ];
                $arrHistory["primary_genre"] = [
                    "old" => $objTrack->primaryGenre->data_genre,
                    "new" => $objPrimaryGenre->data_genre
                ];
            }

            $objTrack->genre_primary_id = $objPrimaryGenre->data_id;
            $objTrack->genre_primary_uuid = $objPrimaryGenre->data_uuid;
        }

        if (array_key_exists("genre_secondary", $itemFile)) {
            $objSecondaryGenre = $this->genresRepo->findByUuid($itemFile["genre_secondary"], false, true);

            if (optional($objTrack->secondaryGenre)->data_genre !== optional($objSecondaryGenre)->data_genre) {
                $changes["Secondary genre"] = [
                    "Previous value" => optional($objTrack->secondaryGenre)->data_genre,
                    "Changed to" => optional($objSecondaryGenre)->data_genre
                ];
                $arrHistory["secondary_genre"] = [
                    "old" => optional($objTrack->secondaryGenre)->data_genre,
                    "new" => optional($objSecondaryGenre)->data_genre
                ];
            }

            $objTrack->genre_secondary_id = optional($objSecondaryGenre)->data_id;
            $objTrack->genre_secondary_uuid = optional($objSecondaryGenre)->data_uuid;
        }

        $objTrack->save();

        return ([$objTrack, $changes, $arrHistory]);
    }
}
