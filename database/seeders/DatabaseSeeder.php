<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Office\ContactSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ApparelCategories::class);
        $this->call(ApparelDataAttributes::class);
        $this->call(ApparelFiles::class);
        $this->call(ApparelProductsAttributes::class);
        $this->call(ApparelProductsPrices::class);
        $this->call(ApparelProductsSizes::class);
        $this->call(ApparelProductsStyles::class);
        $this->call(ApparelProductsFiles::class);
        $this->call(ApparelProducts::class);
        $this->call(ApparelRelatedProducts::class);

        $this->call(CoreAppSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(CoreAuthSeeder::class);
        $this->call(CoreAuthPermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(NotificationUserPivotSeeder::class);
        $this->call(NotificationUserSettingPivotSeeder::class);
        $this->call(UsersEmailsSeeder::class);
        $this->call(AccountingTypeSeeder::class);
        $this->call(AccountingTypeRateSeeder::class);

        $this->call(UsersAuthAliasesSeeder::class);
        $this->call(CoreAuthGroupsSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(SoundblockProjectsSeeder::class);
        $this->call(SoundblockProjectDraftSeeder::class);
        $this->call(ThemeSeeder::class);
        $this->call(SoundblockPlatformSeeder::class);
        $this->call(VendorSeeder::class);

        // $this->call(RoleSeeder::class);

        $this->call(SoundblockCollectionsSeeder::class);
        $this->call(SoundblockDirectorySeeder::class);
        $this->call(SoundblockFilesSeeder::class);
        // $this->call(SoundblockFilesMusicSeeder::class);
        $this->call(SoundblockFilesVideoSeeder::class);
        // $this->call(SoundblockFilesMerchendiseSeeder::class);
        // $this->call(SoundblockFilesOtherSeeder::class);
        $this->call(SoundblockTeamsSeeder::class);

        $this->call(SoundblockDeploySeeder::class);
        $this->call(SoundblockDeploymentStatusSeeder::class);

        $this->call(SoundblockServicesTransactionSeeder::class);
        $this->call(SoundblockServicePlanSeeder::class);
        $this->call(SoundblockContractSeeder::class);

        $this->call(UserAccountingBankingSeeder::class);
        $this->call(UserAccountingPaypalSeeder::class);
        $this->call(UserContactPhoneSeeder::class);
        $this->call(UserContactPostalSeeder::class);
        $this->call(SupportSeeder::class);
        $this->call(SupportTicketSeeder::class);
        $this->call(SupportTicketMessageSeeder::class);

        $this->call(SoundblockProjectNoteSeeder::class);
        $this->call(SoundblockProjectNoteAttachmentSeeder::class);
        $this->call(SoundblockServiceNoteSeeder::class);
        $this->call(SoundblockServiceNoteAttachSeeder::class);
        $this->call(UserNoteSeeder::class);
        $this->call(UserNoteAttachmentSeeder::class);
        $this->call(AccountingTransactionSeeder::class);
        $this->call(AccountingInvoiceTypeSeeder::class);
        $this->call(AccountingInvoiceSeeder::class);
        $this->call(AccountingTransactionTypeSeeder::class);

        $this->call(CoreSocialInstagramSeeder::class);
        $this->call(AppStructureSeeder::class);
    }
}
