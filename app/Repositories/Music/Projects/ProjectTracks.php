<?php

namespace App\Repositories\Music\Projects;

use Exception;
use Util;
use App\Repositories\BaseRepository;
use App\Models\Music\Project\ProjectTrack;
use App\Repositories\Music\Artists\Artist;
use App\Repositories\Music\Genre;
use App\Repositories\Music\Mood;
use App\Repositories\Music\Style;
use App\Repositories\Music\Theme;
use Carbon\Carbon;

class ProjectTracks extends BaseRepository {
    /** @var Artist */
    private Artist $objArtistRepository;
    /** @var Genre */
    private Genre $objGenreRepository;
    /** @var Mood */
    private Mood $objMoodRepository;
    /** @var Style */
    private Style $objStyleRepository;
    /** @var Theme */
    private Theme $objThemeRepository;

    /**
     * Projects constructor.
     * @param ProjectTrack $model
     * @param Artist $objArtistRepository
     * @param Genre $objGenreRepository
     * @param Mood $objMoodRepository
     * @param Style $objStyleRepository
     * @param Theme $objThemeRepository
     */
    public function __construct(ProjectTrack $model, Artist $objArtistRepository, Genre $objGenreRepository,
                                Mood $objMoodRepository, Style $objStyleRepository, Theme $objThemeRepository) {
        $this->model = $model;
        $this->objArtistRepository = $objArtistRepository;
        $this->objGenreRepository  = $objGenreRepository;
        $this->objMoodRepository   = $objMoodRepository;
        $this->objStyleRepository  = $objStyleRepository;
        $this->objThemeRepository  = $objThemeRepository;
    }

    /**
     * @param $objTrack
     * @param string $name
     * @return mixed
     */
    public function tracksComposersAutocomplete($objTrack, string $name){
        return ($objTrack->composers()->whereRaw("lower(artists.artist_name) like (?)", "%" . strtolower($name) . "%")->get());
    }

    /**
     * @param $objTrack
     * @param string $name
     * @return mixed
     */
    public function tracksPerformersAutocomplete($objTrack, string $name){
        return ($objTrack->performers()->whereRaw("lower(artists.artist_name) like (?)", "%" . strtolower($name) . "%")->get());
    }

    /**
     * @param $objTrack
     * @param int $duration
     * @return mixed
     */
    public function updateDuration($objTrack, int $duration){
        return ($objTrack->update(["track_duration" => Carbon::createFromTimestamp($duration)->toTimeString()]));
    }

    /**
     * @param $objTrack
     * @param array $composers
     * @return mixed
     * @throws \Exception
     */
    public function attachComposers($objTrack, array $composers){
        $objProject = $objTrack->project;

        foreach ($composers as $composer) {
            $objComposer = $this->objArtistRepository->find($composer);
            if (empty($objComposer)) {
                throw new Exception("Composer artist not found", 400);
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

        return ($objTrack);
    }

    public function attachFeatures($objTrack, array $features){
        $objProject = $objTrack->project;

        foreach ($features as $feature) {
            $objFeature = $this->objArtistRepository->find($feature);
            if (empty($objFeature)) {
                throw new Exception("Feature artist not found", 400);
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

        return ($objTrack);
    }

    public function attachPerformers($objTrack, array $performers){
        $objProject = $objTrack->project;

        foreach ($performers as $performer) {
            $objPerformer = $this->objArtistRepository->find($performer);
            if (empty($objPerformer)) {
                throw new Exception("Performer artist not found", 400);
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

        return ($objTrack);
    }

    public function attachGenres($objTrack, array $genres){
        foreach ($genres as $genre) {
            $objGenre = $this->objGenreRepository->find($genre);
            if (empty($objGenre)) {
                throw new Exception("Genre not found", 400);
            }

            $objTrack->genres()->attach($objGenre->genre_id, [
                "row_uuid" => Util::uuid(),
                "genre_uuid" => $objGenre->genre_uuid,
                "track_id" => $objTrack->track_id,
                "track_uuid" => $objTrack->track_uuid,
                "stamp_epoch" => time(),
                "stamp_date" => date("Y-m-d"),
                "stamp_time" => date("G:i:s"),
            ]);
        }

        return ($objTrack);
    }

    public function attachMoods($objTrack, array $moods){
        foreach ($moods as $mood) {
            $objMood = $this->objMoodRepository->find($mood);
            if (empty($objMood)) {
                throw new Exception("Mood not found", 400);
            }

            $objTrack->moods()->attach($objMood->mood_id, [
                "row_uuid" => Util::uuid(),
                "mood_uuid" => $objMood->mood_uuid,
                "track_id" => $objTrack->track_id,
                "track_uuid" => $objTrack->track_uuid,
                "stamp_epoch" => time(),
                "stamp_date" => date("Y-m-d"),
                "stamp_time" => date("G:i:s"),
            ]);
        }

        return ($objTrack);
    }

    public function attachStyles($objTrack, array $styles){
        foreach ($styles as $style) {
            $objStyle = $this->objStyleRepository->find($style);
            if (empty($objStyle)) {
                throw new Exception("Style not found", 400);
            }

            $objTrack->styles()->attach($objStyle->style_id, [
                "row_uuid" => Util::uuid(),
                "style_uuid" => $objStyle->style_uuid,
                "track_id" => $objTrack->track_id,
                "track_uuid" => $objTrack->track_uuid,
                "stamp_epoch" => time(),
                "stamp_date" => date("Y-m-d"),
                "stamp_time" => date("G:i:s"),
            ]);
        }

        return ($objTrack);
    }

    public function attachThemes($objTrack, array $themes){
        foreach ($themes as $theme) {
            $objTheme = $this->objThemeRepository->find($theme);
            if (empty($objTheme)) {
                throw new Exception("Theme not found", 400);
            }

            $objTrack->themes()->attach($objTheme->theme_id, [
                "row_uuid" => Util::uuid(),
                "theme_uuid" => $objTheme->theme_uuid,
                "track_id" => $objTrack->track_id,
                "track_uuid" => $objTrack->track_uuid,
                "stamp_epoch" => time(),
                "stamp_date" => date("Y-m-d"),
                "stamp_time" => date("G:i:s"),
            ]);
        }

        return ($objTrack);
    }
}
