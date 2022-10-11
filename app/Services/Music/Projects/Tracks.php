<?php

namespace App\Services\Music\Projects;

use Exception;
use App\Support\Files\Wav;
use wapmorgan\Mp3Info\Mp3Info;
use Illuminate\Support\Facades\DB;
use App\Jobs\Music\ProjectCompleteTracks;
use App\Models\Music\{Project\Project, Project\ProjectTrack};
use App\Repositories\Music\{
    Mood,
    Style,
    Genre,
    Theme,
    Artists\Artist,
    Projects\Projects as ProjectsRepository,
    Projects\ProjectTracks as ProjectTracksRepository
};
use Util;
use App\Helpers\Filesystem\Music;
use App\Contracts\Music\Projects\Tracks as TracksContract;

class Tracks implements TracksContract {
    /** @var ProjectsRepository */
    private ProjectsRepository $objProjectRepository;
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
    /** @var ProjectTracksRepository */
    private ProjectTracksRepository $objProjectTracksRepo;

    /**
     * Projects constructor.
     * @param ProjectsRepository $objProjectRepository
     * @param Artist $objArtistRepository
     * @param Genre $objGenreRepository
     * @param Mood $objMoodRepository
     * @param Style $objStyleRepository
     * @param Theme $objThemeRepository
     * @param ProjectTracksRepository $objProjectTracksRepo
     */
    public function __construct(ProjectsRepository $objProjectRepository,
                                Artist $objArtistRepository, Genre $objGenreRepository, Mood $objMoodRepository,
                                Style $objStyleRepository, Theme $objThemeRepository,
                                ProjectTracksRepository $objProjectTracksRepo) {
        $this->objProjectRepository = $objProjectRepository;
        $this->objArtistRepository = $objArtistRepository;
        $this->objGenreRepository = $objGenreRepository;
        $this->objMoodRepository = $objMoodRepository;
        $this->objStyleRepository = $objStyleRepository;
        $this->objThemeRepository = $objThemeRepository;
        $this->objProjectTracksRepo = $objProjectTracksRepo;
    }

    /**
     * @param string $track
     * @return ProjectTrack
     * @throws Exception
     */
    public function show(string $track): ProjectTrack{
        $objTrack = $this->objProjectTracksRepo->find($track);

        if (!$objTrack) {
            throw new Exception("Track not found", 400);
        }

        return ($objTrack->load(["genres", "styles", "themes", "moods", "composers", "features", "performers"]));
    }

    /**
     * @param Project $objProject
     * @param array $arrData
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function store(Project $objProject, array $arrData): ProjectTrack {
        DB::connection("mysql-music")->beginTransaction();

        $objTrack = $objProject->tracks()->create([
            "track_uuid"     => Util::uuid(),
            "project_uuid"   => $objProject->project_uuid,
            "disc_number"    => $arrData["disc_number"] ?? 1,
            "track_number"   => $objProject->tracks->count() + 1,
            "track_name"     => $arrData["track_name"],
            "track_duration" => "00:00:00",
            "stamp_epoch"    => time(),
            "stamp_date"     => now(),
            "stamp_time"     => now(),
            "stamp_source"   => "",
            "url_allmusic"   => $arrData["url_allmusic"] ?? "",
            "url_amazon"     => $arrData["url_amazon"] ?? "",
            "url_spotify"    => $arrData["url_spotify"] ?? "",
        ]);

        if (!empty($arrData["composers"])) {
            $this->objProjectTracksRepo->attachComposers($objTrack, $arrData["composers"]);
        }

        if (!empty($arrData["performers"])) {
            $this->objProjectTracksRepo->attachPerformers($objTrack, $arrData["performers"]);
        }

        if (!empty($arrData["features"])) {
            $this->objProjectTracksRepo->attachFeatures($objTrack, $arrData["features"]);
        }

        if (!empty($arrData["genres"])) {
            $this->objProjectTracksRepo->attachGenres($objTrack, $arrData["genres"]);
        }

        if (!empty($arrData["moods"])) {
            $this->objProjectTracksRepo->attachMoods($objTrack, $arrData["moods"]);
        }

        if (!empty($arrData["styles"])) {
            $this->objProjectTracksRepo->attachStyles($objTrack, $arrData["styles"]);
        }

        if (!empty($arrData["themes"])) {
            $this->objProjectTracksRepo->attachThemes($objTrack, $arrData["themes"]);
        }

        DB::connection("mysql-music")->commit();

        $fileExt = $arrData["file"]->getClientOriginalExtension();
        $strPath = bucket_storage("music")->putFileAs(Music::project_track_path($objProject, $objTrack->track_uuid), $arrData["file"], $objTrack->track_name . "." . $fileExt);

        if ($fileExt == "wav") {
            $wavFile = Wav::factory($strPath, bucket_storage("music"));
            $arrJobData = $wavFile->transcode(Music::project_track_path($objProject, $objTrack->track_uuid) . "/");
            $objProject->transcoderJobs()->create([
                "job_uuid"     => Util::uuid(),
                "project_uuid" => $objProject->project_uuid,
                "aws_job_id"   => $arrJobData["Job"]["Id"],
                "job_input"    => $arrJobData["Job"]["Inputs"],
                "job_output"   => $arrJobData["Job"]["Outputs"],
                "job_status"   => strtolower($arrJobData["Job"]["Status"]),
            ]);
        } else {
            $audio = new Mp3Info($arrData["file"]->getPathName(), true);
            $this->objProjectTracksRepo->updateDuration($objTrack, intval($audio->duration));
        }

        dispatch(new ProjectCompleteTracks($objProject));

        return ($objTrack->load(["genres", "styles", "themes", "moods", "composers", "features", "performers"]));
    }

    /**
     * @param string $project
     * @param string $track
     * @param $file
     * @return bool
     * @throws Exception
     */
    public function uploadProjectTrackFile(string $project, string $track, $file): bool{
        $objProject = $this->objProjectRepository->find($project, true);
        $objTrack = $objProject->tracks()->where("projects_tracks.track_uuid", $track)->orWhere("projects_tracks.track_id", $track)->first();

        if (empty($objTrack)) {
            throw new Exception("Track not found.", 400);
        }

        $fileExt = $file->getClientOriginalExtension();
        $strPath = bucket_storage("music")->putFileAs(Music::project_track_path($objProject, $objTrack->track_uuid), $file, $objTrack->track_name . "." . $fileExt);

        if ($fileExt == "wav") {
            $wavFile = Wav::factory($strPath, bucket_storage("music"));
            $arrJobData = $wavFile->transcode(Music::project_track_path($objProject, $objTrack->track_uuid) . "/");
            $objProject->transcoderJobs()->create([
                "job_uuid"     => Util::uuid(),
                "project_uuid" => $objProject->project_uuid,
                "aws_job_id"   => $arrJobData["Job"]["Id"],
                "job_input"    => $arrJobData["Job"]["Inputs"],
                "job_output"   => $arrJobData["Job"]["Outputs"],
                "job_status"   => strtolower($arrJobData["Job"]["Status"]),
            ]);
        } else {
            $audio = new Mp3Info($file->getPathName(), true);
            $this->objProjectTracksRepo->updateDuration($objTrack, intval($audio->duration));
        }

        dispatch(new ProjectCompleteTracks($objProject));

        return (true);
    }

    /**
     * @param ProjectTrack $objTrack
     * @param array $arrTrackInfo
     * @param array $arrTrackMetaData
     * @return ProjectTrack
     * @throws Exception
     */
    public function update(ProjectTrack $objTrack, array $arrTrackInfo, array $arrTrackMetaData): ProjectTrack{
        $objTrack->update($arrTrackInfo);

        if (!empty($arrTrackMetaData["composers"])) {
            $objTrack->composers()->detach();
            $this->objProjectTracksRepo->attachComposers($objTrack, $arrTrackMetaData["composers"]);
        }

        if (!empty($arrTrackMetaData["performers"])) {
            $objTrack->performers()->detach();
            $this->objProjectTracksRepo->attachPerformers($objTrack, $arrTrackMetaData["performers"]);
        }

        if (!empty($arrTrackMetaData["features"])) {
            $objTrack->features()->detach();
            $this->objProjectTracksRepo->attachFeatures($objTrack, $arrTrackMetaData["features"]);
        }

        if (!empty($arrTrackMetaData["genres"])) {
            $objTrack->genres()->detach();
            $this->objProjectTracksRepo->attachGenres($objTrack, $arrTrackMetaData["genres"]);
        }

        if (!empty($arrTrackMetaData["moods"])) {
            $objTrack->moods()->detach();
            $this->objProjectTracksRepo->attachMoods($objTrack, $arrTrackMetaData["moods"]);
        }

        if (!empty($arrTrackMetaData["styles"])) {
            $objTrack->styles()->detach();
            $this->objProjectTracksRepo->attachStyles($objTrack, $arrTrackMetaData["styles"]);
        }

        if (!empty($arrTrackMetaData["themes"])) {
            $objTrack->themes()->detach();
            $this->objProjectTracksRepo->attachThemes($objTrack, $arrTrackMetaData["themes"]);
        }

        return ($objTrack->load(["genres", "styles", "themes", "moods", "composers", "features", "performers"]));
    }

    /**
     * @param string $project
     * @param string $track
     * @return array
     * @throws Exception
     */
    public function delete(string $project, string $track): array{
        $objTrack = $this->objProjectTracksRepo->find($track);
        if ($objTrack->project_uuid !== $project) {
            return ([false, "Project doesn't have this track."]);
        }

        $objTrack->delete();

        return ([true, "Track deleted successfully."]);
    }
}
