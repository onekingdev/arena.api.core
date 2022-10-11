<?php

namespace App\Services\Music\Projects;

use App\Models\Music\{
    Project\Project,
    Project\ProjectTrack,
    Artist\Artist as ArtistModel,
};
use App\Repositories\Music\{
    Mood,
    Style,
    Genre,
    Theme,
    Artists\Artist,
    Projects\ProjectDraft,
    Projects\Projects as ProjectsRepository,
    Projects\ProjectTracks as ProjectTracksRepository
};
use Illuminate\Http\UploadedFile;
use Util;
use App\Helpers\Filesystem\Music;
use App\Contracts\Music\Projects\Projects as ProjectsContract;

class Projects implements ProjectsContract {
    /**
     * @var ProjectsRepository
     */
    private ProjectsRepository $objProjectRepository;
    /**
     * @var ProjectDraft
     */
    private ProjectDraft $objProjectDraftRepository;
    /**
     * @var Artist
     */
    private Artist $objArtistRepository;
    /**
     * @var Genre
     */
    private Genre $objGenreRepository;
    /**
     * @var Mood
     */
    private Mood $objMoodRepository;
    /**
     * @var Style
     */
    private Style $objStyleRepository;
    /**
     * @var Theme
     */
    private Theme $objThemeRepository;
    /**
     * @var ProjectTracksRepository
     */
    private ProjectTracksRepository $objProjectTracksRepo;

    /**
     * Projects constructor.
     * @param ProjectsRepository $objProjectRepository
     * @param ProjectDraft $objProjectDraftRepository
     * @param Artist $objArtistRepository
     * @param Genre $objGenreRepository
     * @param Mood $objMoodRepository
     * @param Style $objStyleRepository
     * @param Theme $objThemeRepository
     * @param ProjectTracksRepository $objProjectTracksRepo
     */
    public function __construct(ProjectsRepository $objProjectRepository, ProjectDraft $objProjectDraftRepository,
                                Artist $objArtistRepository, Genre $objGenreRepository, Mood $objMoodRepository,
                                Style $objStyleRepository, Theme $objThemeRepository,
                                ProjectTracksRepository $objProjectTracksRepo) {
        $this->objProjectRepository = $objProjectRepository;
        $this->objProjectDraftRepository = $objProjectDraftRepository;
        $this->objArtistRepository = $objArtistRepository;
        $this->objGenreRepository = $objGenreRepository;
        $this->objMoodRepository = $objMoodRepository;
        $this->objStyleRepository = $objStyleRepository;
        $this->objThemeRepository = $objThemeRepository;
        $this->objProjectTracksRepo = $objProjectTracksRepo;
    }

    public function findAll(?int $perPage = 10, ?array $arrFilters = []) {
        [$objData, $availableMetaData] = $this->objProjectRepository->findAll($perPage, $arrFilters);
        return ([$objData, $availableMetaData]);
    }

    public function find($id, bool $bnFailure = false) {
        return $this->objProjectRepository->find($id, $bnFailure);
    }

    public function getUploadTracksInfo(Project $objProject) {
        $objProject->tracks->map( function ($track) {
            $track->flag_uploaded = $track->uploaded;
            $track->makeHidden(["project"]);
        });

        return ($objProject);
    }

    public function saveTrackInfo(Project $objProject, array $tracksInfo) {
        $arrInsertedTracks = [];

        foreach ($tracksInfo as $track) {
            /** @var ProjectTrack $objTrack */
            $objTrack = $objProject->tracks()->create([
                "track_uuid"     => isset($track["uuid"]) ? $track["uuid"] : Util::uuid(),
                "project_uuid"   => $objProject->project_uuid,
                "disc_number"    => $track["disc_number"] ?? 1,
                "track_number"   => $track["track_number"],
                "track_name"     => $track["name"],
                "track_duration" => "00:00:00",
                "stamp_epoch"    => time(),
                "stamp_date"     => now(),
                "stamp_time"     => now(),
                "stamp_source"   => "",
                "url_allmusic"   => $track["url_allmusic"] ?? "",
                "url_amazon"     => $track["url_amazon"] ?? "",
                "url_spotify"    => $track["url_spotify"] ?? "",
            ]);

            if (isset($track["composers"]) && is_iterable($track["composers"])) {
                foreach ($track["composers"] as $objComposer) {
                    if ($objComposer instanceof ArtistModel === false) {
                        $objComposer = $this->objArtistRepository->find($objComposer);
                    }

                    $objTrack->composers()->attach($objComposer->artist_id, [
                        "composer_uuid" => Util::uuid(),
                        "project_id"    => $objProject->project_id,
                        "project_uuid"  => $objProject->project_uuid,
                        "track_uuid"    => $objTrack->track_uuid,
                        "admin_id"      => 0,
                        "artist_uuid"   => $objComposer->artist_uuid,
                        "stamp_epoch"   => time(),
                        "stamp_date"    => now(),
                        "stamp_time"    => now(),
                        "stamp_source"  => "",
                        "url_allmusic"  => "",
                    ]);
                }
            }

            if (isset($track["performers"]) && is_iterable($track["performers"])) {
                foreach ($track["performers"] as $objPerformer) {
                    if ($objPerformer instanceof ArtistModel === false) {
                        $objPerformer = $this->objArtistRepository->find($objPerformer);
                    }

                    $objTrack->performers()->attach($objPerformer->artist_id, [
                        "performer_uuid" => Util::uuid(),
                        "project_id"     => $objProject->project_id,
                        "project_uuid"   => $objProject->project_uuid,
                        "track_uuid"     => $objTrack->track_uuid,
                        "admin_id"       => 0,
                        "artist_uuid"    => $objPerformer->artist_uuid,
                        "stamp_epoch"    => time(),
                        "stamp_date"     => now(),
                        "stamp_time"     => now(),
                        "stamp_source"   => "",
                        "url_allmusic"   => "",
                    ]);
                }
            }

            if (isset($track["features"]) && is_iterable($track["features"])) {
                foreach ($track["features"] as $objFeature) {
                    if ($objFeature instanceof ArtistModel === false) {
                        $objFeature = $this->objArtistRepository->find($objFeature);
                    }

                    $objTrack->features()->attach($objFeature->artist_id, [
                        "featuring_uuid" => Util::uuid(),
                        "project_id"     => $objProject->project_id,
                        "project_uuid"   => $objProject->project_uuid,
                        "track_uuid"     => $objTrack->track_uuid,
                        "admin_id"       => 0,
                        "artist_uuid"    => $objFeature->artist_uuid,
                        "stamp_epoch"    => time(),
                        "stamp_date"     => now(),
                        "stamp_time"     => now(),
                        "stamp_source"   => "",
                        "url_allmusic"   => "",
                    ]);
                }
            }

            $arrInsertedTracks[] = [
                "name"          => $track["name"],
                "original_name" => $track["original_name"],
                "uuid"          => $objTrack->track_uuid,
            ];
        }

        return $arrInsertedTracks;
    }

    public function update(Project $objProject, array $arrData) {
        $arrProjectInfo = [
            "project_type"           => $arrData["type"] ?? $objProject->project_type,
            "project_date"           => $arrData["date"] ?? $objProject->project_date,
            "project_name"           => $arrData["name"] ?? $objProject->project_name,
            "project_label"          => $arrData["label"] ?? $objProject->project_label,
            "url_allmusic"           => $arrData["url_allmusic"] ?? $objProject->url_allmusic,
            "url_amazon"             => $arrData["url_amazon"] ?? $objProject->url_amazon,
            "url_itunes"             => $arrData["url_itunes"] ?? $objProject->url_itunes,
            "url_spotify"            => $arrData["url_spotify"] ?? $objProject->url_spotify,
            "flag_office_hide"       => $arrData["flag_office_hide"] ?? $objProject->flag_office_hide,
            "flag_office_complete"   => $arrData["flag_office_complete"] ?? $objProject->flag_office_complete,
            "flag_dead"              => $arrData["flag_dead"] ?? $objProject->flag_dead,
        ];

        /** @var Project $objProject */
        $objProject = $this->objProjectRepository->update($objProject, $arrProjectInfo);

        if (isset($arrData["artist"])) {
            $objArtist = $this->objArtistRepository->find($arrData["artist"]);

            if (is_null($objArtist)) {
                throw new \Exception("Artist Not Found.");
            }

            $objProject->artist()->associate($objArtist);
        }

        if (isset($arrData["genres"])) {
            $objProject->genres()->detach();
            foreach ($arrData["genres"] as $genre) {
                $objGenre = $this->objGenreRepository->find($genre);
                $objProject->genres()->attach($objGenre->genre_id, [
                    "row_uuid" => Util::uuid(),
                    "genre_uuid" => $objGenre->genre_uuid,
                    "project_id" => $objProject->project_id,
                    "project_uuid" => $objProject->project_uuid,
                    "stamp_epoch" => time(),
                    "stamp_date" => date("Y-m-d"),
                    "stamp_time" => date("G:i:s"),
                ]);
            }
        }

        if (isset($arrData["moods"])) {
            $objProject->moods()->detach();
            foreach ($arrData["moods"] as $mood) {
                $objMood = $this->objMoodRepository->find($mood);
                $objProject->moods()->attach($objMood->mood_id, [
                    "row_uuid" => Util::uuid(),
                    "mood_uuid" => $objMood->mood_uuid,
                    "project_id" => $objProject->project_id,
                    "project_uuid" => $objProject->project_uuid,
                    "stamp_epoch" => time(),
                    "stamp_date" => date("Y-m-d"),
                    "stamp_time" => date("G:i:s"),
                ]);
            }
        }

        if (isset($arrData["styles"])) {
            $objProject->styles()->detach();
            foreach ($arrData["styles"] as $style) {
                $objStyle = $this->objStyleRepository->find($style);
                $objProject->styles()->attach($objStyle->style_id, [
                    "row_uuid" => Util::uuid(),
                    "style_uuid" => $objStyle->style_uuid,
                    "project_id" => $objProject->project_id,
                    "project_uuid" => $objProject->project_uuid,
                    "stamp_epoch" => time(),
                    "stamp_date" => date("Y-m-d"),
                    "stamp_time" => date("G:i:s"),
                ]);
            }
        }

        if (isset($arrData["themes"])) {
            $objProject->themes()->detach();
            foreach ($arrData["themes"] as $theme) {
                $objTheme = $this->objThemeRepository->find($theme);
                $objProject->themes()->attach($objTheme->theme_id, [
                    "row_uuid" => Util::uuid(),
                    "theme_uuid" => $objTheme->theme_uuid,
                    "project_id" => $objProject->project_id,
                    "project_uuid" => $objProject->project_uuid,
                    "stamp_epoch" => time(),
                    "stamp_date" => date("Y-m-d"),
                    "stamp_time" => date("G:i:s"),
                ]);
            }
        }

        return $objProject;
    }

    public function saveProjectTrack(Project $objProject, UploadedFile $objFile, array $trackInfo) {
        $strFileName = Util::uuid() . "." . $objFile->clientExtension();

        $arrTracks = $this->saveTrackInfo($objProject, $trackInfo);
        $strPath = bucket_storage("music")->putFileAs(Music::project_zip_directory($objProject), $objFile, $strFileName);

        return ["tracks" => $arrTracks, "path" => $strPath];
    }

    public function deleteProject(Project $objProject): bool {
        \DB::connection("mysql-music")->beginTransaction();

        $arrGenres = $objProject->genres;

        foreach ($arrGenres as  $objGenre) {
            $objProject->genres()->updateExistingPivot($objGenre->genre_id, [
                "stamp_deleted_at" => now(),
            ]);
        }

        $arrMoods = $objProject->moods;

        foreach ($arrMoods as  $objMood) {
            $objProject->moods()->updateExistingPivot($objMood->mood_id, [
                "stamp_deleted_at" => now(),
            ]);
        }

        $arrStyles = $objProject->styles;

        foreach ($arrStyles as  $objStyle) {
            $objProject->styles()->updateExistingPivot($objStyle->style_id, [
                "stamp_deleted_at" => now(),
            ]);
        }

        $arrThemes = $objProject->themes;

        foreach ($arrThemes as $objTheme) {
            $objProject->themes()->updateExistingPivot($objTheme->theme_id, [
                "stamp_deleted_at" => now(),
            ]);
        }

        $arrTracks = $objProject->tracks;

        /** @var ProjectTrack $objTrack */
        foreach ($arrTracks as $objTrack) {
            $arrComposers = $objTrack->composers;

            foreach ($arrComposers as $objComposer) {
                $objTrack->composers()->updateExistingPivot($objComposer->artist_id, [
                    "stamp_deleted_at" => now(),
                ]);
            }

            $arrFeatures = $objTrack->features;

            foreach ($arrFeatures as $objFeature) {
                $objTrack->features()->updateExistingPivot($objFeature->artist_id, [
                    "stamp_deleted_at" => now(),
                ]);
            }

            $arrPerformers = $objTrack->performers;

            foreach ($arrPerformers as $objPerformer) {
                $objTrack->performers()->updateExistingPivot($objPerformer->artist_id, [
                    "stamp_deleted_at" => now(),
                ]);
            }

            $objTrack->delete();
        }

        $objProject->delete();

        \DB::connection("mysql-music")->commit();

        return true;
    }

    /**
     * @param string $track
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function tracksComposersAutocomplete(string $track, string $name) {
        $objTrack = $this->objProjectTracksRepo->find($track);

        return ($this->objProjectTracksRepo->tracksComposersAutocomplete($objTrack, $name));
    }

    /**
     * @param string $track
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function tracksPerformersAutocomplete(string $track, string $name){
        $objTrack = $this->objProjectTracksRepo->find($track);

        return ($this->objProjectTracksRepo->tracksPerformersAutocomplete($objTrack, $name));
    }
}
