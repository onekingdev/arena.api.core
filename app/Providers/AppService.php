<?php

namespace App\Providers;

use App\Repositories\Music\Core\TranscoderJob;
use App\Repositories\Soundblock\AccountInvoice as AccountInvoiceRepository;
use App\Repositories\Soundblock\Reports\DiskSpace as DiskSpaceRepository;
use Aws\ElasticTranscoder\ElasticTranscoderClient;
use Blade;
use App\Services\{Core\Arena,
    Cache\Cache,
    Core\Notifications\Notifications as NotificationsService,
    Core\Slack as SlackService,
    Core\Sox as SoxService,
    Core\Webhooks\SimpleNotification,
    Files\Music\Transcoder as TranscoderService,
    Files\Zip as ZipService,
    Music\Artists as ArtistsService,
    Music\Genres,
    Music\Moods as MoodsService,
    Music\Projects\Draft as DraftService,
    Music\Projects\Projects as ProjectsService,
    Music\Projects\Tracks as TracksService,
    Music\Styles as StylesService,
    Music\Themes as ThemesService,
    Payment\Payment,
    Soundblock\Artist\Artist as ArtistService,
    Soundblock\Data\IsrcCodes as IsrcCodesService,
    Soundblock\Data\UpcCodes as UpcCodesService,
    Soundblock\Events as EventsService,
    Soundblock\Invite,
    Soundblock\Ledger,
    Common\AccountPlan,
    Ledger\LedgerCache,
    Accounting\Invoice,
    Exceptions\Disaster,
    Auth\Auth as AuthService,
    Soundblock\Contracts\Service,
    Soundblock\Accounting\Charge,
    Accounting\InvoiceTransaction,
    Soundblock\Accounting\Accounting,
    Core\Converter as ConverterService,
    Core\Auth\TwoFactor as TwoFactorService,
    Core\AppsPages as AppsPagesService,
    Core\PageStructure as PageStructureService,
    Core\ShoppingCart as ShoppingCartService,
    Accounting\TypeRate as TypeRateService,
    Core\Mailing as MailingService,
    Soundblock\Audit\Bandwidth as BandwidthService,
    Soundblock\Reports\Bandwidth as BandwidthReportService,
    Soundblock\Reports\DiskSpace as DiskSpaceReportService,
    Soundblock\Audit\DiskSpace as DiskspaceAuditService,
    Soundblock\Team as TeamService,
    Soundblock\Project as ProjectService,
    Soundblock\File as FileService,
    Soundblock\Collection as CollectionService,
    Soundblock\CollectionHistory as CollectionHistoryService,
    Soundblock\Deployment as DeploymentService,
    Soundblock\Directory as DirectoryService,
    Soundblock\Platform as PlatformService,
    Soundblock\Payment as SoundblockPaymentService,
    Soundblock\Reports as ReportsService};
use App\Repositories\Common\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use App\Contracts\{Auth\Auth as AuthContract,
    Core\Arena as ArenaContract,
    Cache\Cache as CacheContract,
    Core\Notifications\Notifications as NotificationsContract,
    Core\Slack as SlackContract,
    Core\Sox as SoxContract,
    Core\Webhooks\SimpleNotification as SimpleNotificationContract,
    File\Music\Transcoder as TranscoderContract,
    File\Zip as ZipContract,
    Music\Artists\Artists as ArtistsContract,
    Music\Genre,
    Music\Moods as MoodsContract,
    Music\Projects\Draft as DraftContract,
    Music\Projects\Projects as ProjectsContract,
    Music\Projects\Tracks as TracksContract,
    Music\Styles as StylesContract,
    Music\Themes as ThemesContract,
    Payment\Payment as PaymentContract,
    Soundblock\Artist\Artist as ArtistContract,
    Soundblock\Contracts\SmartContracts,
    Core\Converter as ConverterContract,
    Soundblock\Data\IsrcCodes as IsrcCodesContract,
    Soundblock\Data\UpcCodes as UpcCodesContract,
    Soundblock\Events as EventsContract,
    Soundblock\Ledger as LedgerContract,
    Core\AppsPages as AppsPagesContract,
    Core\ShoppingCart as ShoppingCartContract,
    Accounting\Invoice as InvoiceContract,
    Exceptions\Disaster as DisasterContract,
    Core\Auth\TwoFactor as TwoFactorContract,
    Soundblock\Invite\Invite as InviteContract,
    Core\PageStructure as PageStructureContract,
    Soundblock\Accounting\Charge as ChargeContract,
    Soundblock\Ledger\LedgerCache as LedgerCacheContract,
    Soundblock\Audit\Bandwidth as BandwidthContract,
    Soundblock\Reports\Bandwidth as BandwidthReportContract,
    Soundblock\Audit\Diskspace as DiskspaceAuditContract,
    Soundblock\Reports\DiskSpace as DiskSpaceReportContract,
    Soundblock\Account\AccountPlan as AccountPlanContract,
    Soundblock\Accounting\Accounting as AccountingContract,
    Accounting\InvoiceTransaction as InvoiceTransactionContract,
    Accounting\TypeRate as TypeRateContract,
    Core\Mailing as MailingContract,
    Soundblock\Projects\Team as TeamContract,
    Soundblock\Projects\Project as ProjectContract,
    Soundblock\Files\File as FileContract,
    Soundblock\Collection\Collection as CollectionContract,
    Soundblock\Collection\CollectionHistory as CollectionHistoryContract,
    Soundblock\Projects\Deployment as DeploymentContract,
    Soundblock\Files\Directory as DirectoryContract,
    Soundblock\Platform as PlatformContract,
    Soundblock\Payment as SoundblockPaymentContract,
    Soundblock\Reports as ReportsContract};
use Laravel\{Cashier\Cashier, Passport\Passport, Telescope\Telescope};
use App\Repositories\Accounting\{AccountingFailedPayments, AccountingInvoice as AccountingInvoiceRepository};
use App\Repositories\Soundblock\ProjectsBandwidth as ProjectsBandwidthRepository;
use App\Repositories\Common\Account as AccountRepository;

class AppService extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        Passport::ignoreMigrations();
        Cashier::ignoreMigrations();
        Telescope::ignoreMigrations();

        if(!$this->app->environment("local")) {
            \URL::forceScheme("https");
        }

        Passport::loadKeysFrom(storage_path("keys"));

        $this->app->bind(LedgerContract::class, function () {
            $token = config("ledger.token");

            if (is_null($token)) {
                abort(403, "Ledger Service Token did\"t set up");
            }
            return new Ledger(config("ledger.host"), $token);
        });

        $this->app->bind(PaymentContract::class, Payment::class);

        $this->app->bind(AccountingContract::class, function () {
            $chargeNotDefault = (bool) env("CHARGE_NOT_DEFAULT", false);

            return new Accounting(
                $chargeNotDefault,
                resolve(AccountingInvoiceRepository::class),
                resolve(AccountingFailedPayments::class),
                resolve(ProjectsBandwidthRepository::class),
                resolve(AccountRepository::class),
                resolve(AccountInvoiceRepository::class),
                resolve(DiskSpaceRepository::class)
            );
        });

        $this->app->bind(SmartContracts::class, Service::class);
        $this->app->bind(LedgerCacheContract::class, LedgerCache::class);
        $this->app->bind(DisasterContract::class, function () {
            return new Disaster(resolve(Log::class), resolve(SlackContract::class));
        });
        $this->app->bind(AccountPlanContract::class, AccountPlan::class);

        $this->app->bind("disaster", function () {
            return $this->app->make(DisasterContract::class);
        });

        $this->app->bind(InviteContract::class, Invite::class);

        $this->app->bind(ChargeContract::class, Charge::class);

        $this->app->bind("charge", function () {
            return $this->app->make(ChargeContract::class);
        });

        $this->app->bind(InvoiceContract::class, Invoice::class);
        $this->app->bind("invoice", function () {
            return $this->app->make(InvoiceContract::class);
        });

        $this->app->bind(InvoiceTransactionContract::class, InvoiceTransaction::class);

        $this->app->singleton(CacheContract::class, Cache::class);

        $this->app->singleton("app-cache", function () {
            return $this->app->make(CacheContract::class);
        });

        $this->app->singleton(ArenaContract::class, Arena::class);

        $this->app->singleton("arena", function () {
            return $this->app->make(ArenaContract::class);
        });

        $this->app->bind(AuthContract::class, AuthService::class);

        $this->app->bind("arena-auth", function () {
            return $this->app->make(AuthContract::class);
        });

        $this->app->bind(TwoFactorContract::class, TwoFactorService::class);

        $this->app->bind(ConverterContract::class, ConverterService::class);
        $this->app->bind("arena-converter", function () {
            return $this->app->make(ConverterContract::class);
        });

        $this->app->bind(PageStructureContract::class, PageStructureService::class);
        $this->app->bind(AppsPagesContract::class, AppsPagesService::class);
        $this->app->bind(ShoppingCartContract::class, ShoppingCartService::class);
        $this->app->bind(TypeRateContract::class, TypeRateService::class);
        $this->app->bind(MailingContract::class, MailingService::class);
        $this->app->bind(TeamContract::class, TeamService::class);
        $this->app->bind(ProjectContract::class, ProjectService::class);
        $this->app->bind(FileContract::class, FileService::class);
        $this->app->bind(CollectionContract::class, CollectionService::class);
        $this->app->bind(CollectionHistoryContract::class, CollectionHistoryService::class);
        $this->app->bind(DeploymentContract::class, DeploymentService::class);
        $this->app->bind(DirectoryContract::class, DirectoryService::class);
        $this->app->bind(PlatformContract::class, PlatformService::class);
        $this->app->bind(SlackContract::class, SlackService::class);
        $this->app->bind(EventsContract::class, EventsService::class);
        $this->app->bind(SoundblockPaymentContract::class, SoundblockPaymentService::class);
        $this->app->bind(ReportsContract::class, ReportsService::class);

        $this->app->bind("arena-soundblock-events", function () {
            return $this->app->make(EventsContract::class);
        });

        $this->app->bind(ArtistsContract::class, ArtistsService::class);
        $this->app->bind(ProjectsContract::class, ProjectsService::class);
        $this->app->bind(TracksContract::class, TracksService::class);

        $this->app->bind(ZipContract::class, function () {
            return new ZipService(bucket_storage("music"), Storage::disk("local"));
        });

        $this->app->bind(Genre::class, Genres::class);
        $this->app->bind(StylesContract::class, StylesService::class);
        $this->app->bind(MoodsContract::class, MoodsService::class);
        $this->app->bind(ThemesContract::class, ThemesService::class);

        $this->app->bind(SimpleNotificationContract::class, function () {
            return new SimpleNotification(new Client());
        });

        $this->app->bind(TranscoderContract::class, function () {
            $objAwsTranscoder = new ElasticTranscoderClient([
                "region"      => "us-east-1",
                "version"     => "2012-09-25",
                "credentials" => [
                    "key"    => env("AWS_ACCESS_KEY_ID"),
                    "secret" => env("AWS_SECRET_ACCESS_KEY"),
                ],
            ]);
            return new TranscoderService($objAwsTranscoder, resolve(TranscoderJob::class), env("TRANSCODER_PIPELINE"));
        });

        $this->app->bind(DraftContract::class, DraftService::class);
        $this->app->bind(BandwidthContract::class, BandwidthService::class);
        $this->app->bind(UpcCodesContract::class, UpcCodesService::class);
        $this->app->bind(IsrcCodesContract::class, IsrcCodesService::class);
        $this->app->bind(ArtistContract::class, ArtistService::class);

        $this->app->bind(DiskspaceAuditContract::class, DiskspaceAuditService::class);

        $this->app->bind(BandwidthReportContract::class, BandwidthReportService::class);
        $this->app->bind(DiskSpaceReportContract::class, DiskSpaceReportService::class);
        $this->app->bind(NotificationsContract::class, NotificationsService::class);

        $this->app->bind("arena-notifications", function () {
            return $this->app->make(NotificationsContract::class);
        });

        $this->app->bind(SoxContract::class, SoxService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Blade::component("mail.components.header", "header");
    }
}
