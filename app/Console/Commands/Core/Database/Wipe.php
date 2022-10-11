<?php

namespace App\Console\Commands\Core\Database;

use Database\Seeders\{AccountingTypeRateSeeder,
    AccountingTypeSeeder,
    CoreAppSeeder,
    CoreAuthGroupsSeeder,
    CoreAuthPermissionsSeeder,
    CoreAuthSeeder,
    NotificationUserSettingPivotSeeder,
    SoundblockPlatformSeeder,
    SupportSeeder,
    TerritoriesSeeder,
    ThemeSeeder,
    UsersAuthAliasesSeeder,
    UserSeeder,
    UsersEmailsSeeder,
    VendorSeeder};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Wipe extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "reset-develop";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Command description";

    const SKIP_TABLES = [
        "core_laravel_migrations", "apparel", "oauth_clients", "core_social_instagram", "soundblock_data_codes_isrc",
        "soundblock_data_codes_upc"
    ];

    const SEEDERS = [
        CoreAppSeeder::class,
        CoreAuthSeeder::class,
        UserSeeder::class,
        UsersEmailsSeeder::class,
        UsersAuthAliasesSeeder::class,
        NotificationUserSettingPivotSeeder::class,
        SoundblockPlatformSeeder::class,
        CoreAuthPermissionsSeeder::class,
        CoreAuthGroupsSeeder::class,
        TerritoriesSeeder::class,
        AccountingTypeSeeder::class,
        AccountingTypeRateSeeder::class,
        VendorSeeder::class,
        ThemeSeeder::class,
        SupportSeeder::class,
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        if (strtolower(env("APP_ENV")) !== "develop") {
            throw new \Exception("This Command Available Only For Develop Environment.");
        }

        \Config::set("database.connections.mysql.database", "api.develop");
        \Config::set("database.connections.mysql.read.host", ["arena.cluster-ro-c1lbs4mi3kak.us-east-1.rds.amazonaws.com"]);
        \Config::set("database.connections.mysql.write.host", ["arena.cluster-c1lbs4mi3kak.us-east-1.rds.amazonaws.com"]);

        $arrTables = DB::connection()->setDatabaseName("api.develop")->getDoctrineSchemaManager()->listTableNames();

        foreach ($arrTables as $strTable) {
            if (Str::contains($strTable, self::SKIP_TABLES)) {
                continue;
            }

            DB::setDatabaseName("api.develop")->table($strTable)->truncate();
        }

        DB::setDatabaseName("api.develop")->table("soundblock_data_codes_isrc")->update(["flag_assigned" => false]);
        DB::setDatabaseName("api.develop")->table("soundblock_data_codes_upc")->update(["flag_assigned" => false]);

        foreach (self::SEEDERS as $strSeederClass) {
            $objSeeder = new $strSeederClass;
            $objSeeder->run();
        }

        $objSbs3Driver = Storage::createS3Driver([
            "driver" => "s3",
            "key" => env("AWS_ACCESS_KEY_ID"),
            "secret" => env("AWS_SECRET_ACCESS_KEY"),
            "region" => env("AWS_DEFAULT_REGION"),
            "bucket" => "arena-soundblock-develop"
        ]);

        $arrAttachmentsDirs = $objSbs3Driver->directories("attachments/accounts");

        foreach ($arrAttachmentsDirs as $strDir) {
            $objSbs3Driver->deleteDirectory($strDir);
        }

        $arrDeploymentsFiles = $objSbs3Driver->files("deployments");

        foreach ($arrDeploymentsFiles as $strFile) {
            $objSbs3Driver->delete($strFile);
        }

        $arrDownloadFiles = $objSbs3Driver->files("download");

        foreach ($arrDownloadFiles as $strFile) {
            $objSbs3Driver->delete($strFile);
        }

        $arrUploadedArtworkFiles = $objSbs3Driver->files("public/upload/artworks");

        foreach ($arrUploadedArtworkFiles as $strFile) {
            $objSbs3Driver->delete($strFile);
        }

        $arrAttachmentsDirs = $objSbs3Driver->directories("attachments/accounts");

        foreach ($arrAttachmentsDirs as $strDir) {
            $objSbs3Driver->deleteDirectory($strDir);
        }

        $arrUploadedFiles = $objSbs3Driver->files("public/uploads");

        foreach ($arrUploadedFiles as $strFile) {
            $objSbs3Driver->delete($strFile);
        }

        $arrUploadedZips = $objSbs3Driver->files("public/uploads/upload");

        foreach ($arrUploadedZips as $strFile) {
            $objSbs3Driver->delete($strFile);
        }

        $arrAccountDirs = $objSbs3Driver->directories("accounts");

        foreach ($arrAccountDirs as $strDir) {
            $objSbs3Driver->deleteDirectory($strDir);
        }

        $arrAccountDirs = $objSbs3Driver->directories("users");

        foreach ($arrAccountDirs as $strDir) {
            $objSbs3Driver->deleteDirectory($strDir);
        }

        $objAccounts3Driver = Storage::createS3Driver([
            "driver" => "s3",
            "key" => env("AWS_ACCESS_KEY_ID"),
            "secret" => env("AWS_SECRET_ACCESS_KEY"),
            "region" => env("AWS_DEFAULT_REGION"),
            "bucket" => "arena-account-develop"
        ]);


        $arrUsersDir = $objAccounts3Driver->directories("public/users");

        foreach ($arrUsersDir as $strDir) {
            $objAccounts3Driver->deleteDirectory($strDir);
        }

        return 0;
    }
}
