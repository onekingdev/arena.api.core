<?php

namespace App\Services\Music\Projects;

use App\Models\{
    Users\User,
    Music\Project\Project,
    Music\Mood as MoodModel,
    Music\Style as StyleModel,
    Music\Theme as ThemeModel,
    Music\Project\ProjectDraftVersion,
    Music\Genre as GenreModel,
    Music\Artist\Artist as ArtistModel,
    Music\Project\ProjectDraft as ProjectDraftModel,
};
use Carbon\Carbon;
use Util;
use App\Repositories\Music\{
    Mood,
    Style,
    Theme,
    Genre,
    Artists\Artist,
    Projects\Projects as ProjectsRepository,
    Projects\ProjectDraft as DraftRepository
};
use Illuminate\Http\UploadedFile;
use App\Contracts\Music\Projects\Draft as DraftContract;
use App\Contracts\Music\Projects\Projects as ProjectContract;

class Draft implements DraftContract {
    /**
     * @var ProjectsRepository
     */
    private ProjectsRepository $objProjectRepository;
    /**
     * @var DraftRepository
     */
    private DraftRepository $objProjectDraftRepository;
    /**
     * @var Theme
     */
    private Theme $objThemeRepository;
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
     * @var ProjectContract
     */
    private ProjectContract $objProject;

    /**
     * Projects constructor.
     * @param ProjectsRepository $objProjectRepository
     * @param DraftRepository $objProjectDraftRepository
     * @param Artist $objArtistRepository
     * @param Genre $objGenreRepository
     * @param Mood $objMoodRepository
     * @param Style $objStyleRepository
     * @param Theme $objThemeRepository
     * @param ProjectContract $objProject
     */
    public function __construct(ProjectsRepository $objProjectRepository, DraftRepository $objProjectDraftRepository,
                                Artist $objArtistRepository, Genre $objGenreRepository, Mood $objMoodRepository,
                                Style $objStyleRepository, Theme $objThemeRepository, ProjectContract $objProject) {
        $this->objProjectRepository = $objProjectRepository;
        $this->objProjectDraftRepository = $objProjectDraftRepository;
        $this->objArtistRepository = $objArtistRepository;
        $this->objGenreRepository = $objGenreRepository;
        $this->objMoodRepository = $objMoodRepository;
        $this->objStyleRepository = $objStyleRepository;
        $this->objThemeRepository = $objThemeRepository;
        $this->objProject = $objProject;
    }

    public function findDraft(string $strDraft) {
        return $this->objProjectDraftRepository->find($strDraft);
    }

    public function saveDraft(array $draftData, User $objUser): array {
        $arrDraft = [
            "user_id"   => $objUser->user_id,
            "user_uuid" => $objUser->user_uuid,
        ];

        $objDraft = $this->objProjectDraftRepository->create($arrDraft);
        $arrDraftInfo = $this->saveDraftVersion($objDraft, $draftData);

        return ["draft" => $arrDraftInfo["draft"], "version" => $arrDraftInfo["version"]];
    }

    public function saveDraftVersion(ProjectDraftModel $objDraft, array $draftData): array {
        $objVersion = $this->objProjectDraftRepository->saveVersion($objDraft, $draftData);

        return ["draft" => $objDraft->load("versions"), "version" => $objVersion];
    }

    public function getDrafts(?int $perPage = 10) {
        return $this->objProjectDraftRepository->getDrafts($perPage);
    }

    public function findDraftVersion(ProjectDraftModel $objDraft, ?string $strDraftVersion = null) {
        return $this->objProjectDraftRepository->findVersion($objDraft, $strDraftVersion);
    }

    /**
     * @param ProjectDraftModel $objDraft
     * @return bool
     * @throws \Exception
     */
    public function deleteDraft(ProjectDraftModel $objDraft): bool {
        $objDraft->versions()->delete();
        $objDraft->delete();

        return true;
    }

    public function saveDraftFile(ProjectDraftModel $objDraft, ProjectDraftVersion $objDraftVersion, UploadedFile $file): string {
        $strFileName = $objDraftVersion->version_uuid . "." . $file->clientExtension();

        return bucket_storage("music")->putFileAs(Util::music_project_draft_path($objDraft), $file, $strFileName);
    }

    public function publishDraft(ProjectDraftModel $objDraft, ProjectDraftVersion $objDraftVersion): Project {
        $arrDraftData = $objDraftVersion->draft_json;

        if (!isset($arrDraftData["artist"])) {
            throw new \Exception("Artist Field Is Required.");
        }

        if (is_string($arrDraftData["artist"])) {
            /** @var ArtistModel $objArtist */
            $objArtist = $this->objArtistRepository->find($arrDraftData["artist"]);
        } elseif ($arrDraftData["artist"] instanceof ArtistModel) {
            $objArtist = $arrDraftData["artist"];
        } else {
            throw new \Exception("Invalid Artist Entry.");
        }

        \DB::connection("mysql-music")->beginTransaction();

        /** @var Project $objProject */
        $objProject = $objArtist->projects()->create([
            "project_uuid"     => Util::uuid(),
            "artist_uuid"      => $objArtist->artist_uuid,
            "project_type"     => $arrDraftData["type"] ?? "Album",
            "project_date"     => $arrDraftData["date"] ?? now(),
            "project_year"     => isset($arrDraftData["date"]) ? Carbon::parse($arrDraftData["date"])->year : now()->year,
            "project_name"     => $arrDraftData["name"],
            "project_label"    => $arrDraftData["label"] ?? "",
            "project_duration" => "00:00:00",
            "stamp_source"     => "",
            "url_allmusic"     => $arrDraftData["url_allmusic"] ?? "",
            "url_amazon"       => $arrDraftData["url_amazon"] ?? "",
            "url_itunes"       => $arrDraftData["url_itunes"] ?? "",
            "url_spotify"      => $arrDraftData["url_spotify"] ?? "",
            "stamp_epoch"      => time(),
            "stamp_date"       => now(),
            "stamp_time"       => now(),
        ]);

        if (isset($arrDraftData["tracks"])) {
            $this->objProject->saveTrackInfo($objProject, $arrDraftData["tracks"]);
        }

        if (isset($arrDraftData["genres"]) && is_iterable($arrDraftData["genres"])) {
            foreach ($arrDraftData["genres"] as $objGenre) {
                if ($objGenre instanceof GenreModel === false) {
                    $objGenre = $this->objGenreRepository->find($objGenre);
                }

                $objProject->genres()->attach($objGenre, [
                    "row_uuid"     => Util::uuid(),
                    "project_uuid" => $objProject->project_uuid,
                    "genre_uuid"   => $objGenre->genre_uuid,
                    "stamp_epoch"  => time(),
                    "stamp_date"   => now(),
                    "stamp_time"   => now(),
                    "stamp_source" => "",
                ]);
            }
        }

        if (isset($arrDraftData["moods"]) && is_iterable($arrDraftData["moods"])) {
            foreach ($arrDraftData["moods"] as $objMood) {
                if ($objMood instanceof MoodModel === false) {
                    $objMood = $this->objMoodRepository->find($objMood);
                }

                $objProject->moods()->attach($objMood->mood_id, [
                    "row_uuid"     => Util::uuid(),
                    "project_uuid" => $objProject->project_uuid,
                    "mood_uuid"    => $objMood->mood_uuid,
                    "stamp_epoch"  => time(),
                    "stamp_date"   => now(),
                    "stamp_time"   => now(),
                    "stamp_source" => "",
                ]);
            }
        }

        if (isset($arrDraftData["styles"]) && is_iterable($arrDraftData["styles"])) {
            foreach ($arrDraftData["styles"] as $objStyle) {
                if ($objStyle instanceof StyleModel === false) {
                    $objStyle = $this->objStyleRepository->find($objStyle);
                }

                $objProject->styles()->attach($objStyle->style_id, [
                    "row_uuid"     => Util::uuid(),
                    "project_uuid" => $objProject->project_uuid,
                    "style_uuid"   => $objStyle->style_id,
                    "stamp_epoch"  => time(),
                    "stamp_date"   => now(),
                    "stamp_time"   => now(),
                    "stamp_source" => "",
                ]);
            }
        }

        if (isset($arrDraftData["themes"]) && is_iterable($arrDraftData["themes"])) {
            foreach ($arrDraftData["themes"] as $objTheme) {
                if ($objTheme instanceof ThemeModel === false) {
                    $objTheme = $this->objThemeRepository->find($objTheme);
                }

                $objProject->themes()->attach($objTheme->theme_id, [
                    "row_uuid"     => Util::uuid(),
                    "project_uuid" => $objProject->project_uuid,
                    "theme_uuid"   => $objTheme->theme_id,
                    "stamp_epoch"  => time(),
                    "stamp_date"   => now(),
                    "stamp_time"   => now(),
                    "stamp_source" => "",
                ]);
            }
        }

        \DB::connection("mysql-music")->commit();

        return ($objProject->load("artist", "genres", "moods", "styles", "themes", "tracks",
            "tracks.composers", "tracks.features", "tracks.performers"));
    }
}