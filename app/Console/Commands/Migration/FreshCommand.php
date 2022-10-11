<?php

namespace App\Console\Commands\Migration;

use App\Contracts\Soundblock\Ledger;
use App\Facades\Exceptions\Disaster;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Exceptions\Core\Disaster\LedgerMicroserviceException;
use Illuminate\Database\Console\Migrations\FreshCommand as BaseFreshCommand;

class FreshCommand extends BaseFreshCommand {
    /**
     * @var Ledger
     */
    private Ledger $ledger;

    private array $musicMigrations = [
        "2020_11_13_001428_create_genres_table_in_music_db",
        "2020_11_13_051523_add_genre_fields_to_projects_genres_table",
        "2020_11_13_054342_add_genre_fields_to_artists_genres_table",
        "2020_11_13_061108_create_moods_table",
        "2020_11_13_061436_add_moods_field_to_artists_and_projects_tables",
        "2020_11_14_014122_create_styles_table",
        "2020_11_14_014343_add_style_field_to_artists_and_projects_tables",
        "2020_11_14_022714_create_themes_table",
        "2020_11_14_023034_add_themes_field_to_artists_and_projects_tables",
        "2020_11_15_162226_create_projects_drafts_table",
        "2020_11_17_004120_create_project_draft_versions_table",
        "2020_12_10_034340_create_transcoder_jobs_table.php",
        "2020_12_12_005711_remove_genres_fields_from_project_and_artists_tables.php",
        "2020_12_13_035113_rename_genre_and_moods_name_fields.php",
        "2020_12_13_194852_remove_moods_fields_from_project_and_artists_tables.php",
        "2020_12_13_195239_remove_styles_fields_from_project_and_artists_tables.php",
        "2020_12_13_195641_remove_themes_fields_from_project_and_artists_tables.php",
        "2020_12_29_075525_update_music_projects_table.php",
        "2021_01_08_133929_update_project_tracks_table.php",
        "2021_01_27_092905_change_flag_office_hide_in_music_projects_table.php"
    ];

    /**
     * Create a new command instance.
     *
     * @param Ledger $ledger
     */
    public function __construct(Ledger $ledger) {
        $this->ledger = $ledger;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        /** @var Migrator $objMigrator */
        $objMigrator = resolve(Migrator::class, [
            "repository" => app()->get("migration.repository"),
            "resolver"   => app()->get("db"),
            "files"      => app()->get("files"),
            "dispatcher" => app()->get("events"),
        ]);

        $arrMigrationPath = [database_path("migrations")];

        $objMigrator->requireFiles($files = $objMigrator->getMigrationFiles($arrMigrationPath));

        foreach ($this->musicMigrations as $migrationFile) {
            try {
                $instance = $objMigrator->resolve(
                    $name = $objMigrator->getMigrationName($migrationFile)
                );

                $instance->down();
            } catch (\Exception $exception) {
                $this->error($exception);
                continue;
            }
        }

        try {
            $this->ledger->deleteAllTables();
        } catch (LedgerMicroserviceException $exception) {
            Disaster::handleDisaster($exception);
        }

        return parent::handle();
    }
}
