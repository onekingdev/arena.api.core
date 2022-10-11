<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSoundblockServicesTablesToSoundblockAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_services", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
            $objTable->renameColumn("service_name", "account_name");
        });

        Schema::table("soundblock_artists", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
        });

        Schema::table("soundblock_artists_publisher", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
        });

        Schema::table("soundblock_projects", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
        });

        Schema::table("soundblock_projects_contracts", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
        });

        Schema::table("soundblock_projects_drafts", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
        });

        Schema::table("soundblock_services_notes", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
            $objTable->renameColumn("service_notes", "account_notes");
        });

        Schema::table("soundblock_services_plans", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
        });

        Schema::table("soundblock_services_transactions", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
        });

        Schema::table("soundblock_services_users", function (Blueprint $objTable) {
            $objTable->renameColumn("service_id", "account_id");
            $objTable->renameColumn("service_uuid", "account_uuid");
        });

        Schema::rename("soundblock_services", "soundblock_accounts");
        Schema::rename("soundblock_services_notes", "soundblock_accounts_notes");
        Schema::rename("soundblock_services_notes_attachments", "soundblock_accounts_notes_attachments");
        Schema::rename("soundblock_services_plans", "soundblock_accounts_plans");
        Schema::rename("soundblock_services_transactions", "soundblock_accounts_transactions");
        Schema::rename("soundblock_services_users", "soundblock_accounts_users");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_accounts", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
            $objTable->renameColumn("account_name", "service_name");
        });

        Schema::table("soundblock_artists", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
        });

        Schema::table("soundblock_artists_publisher", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
        });

        Schema::table("soundblock_projects", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
        });

        Schema::table("soundblock_projects_contracts", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
        });

        Schema::table("soundblock_projects_drafts", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
        });

        Schema::table("soundblock_accounts_notes", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
            $objTable->renameColumn("account_notes", "service_notes");
        });

        Schema::table("soundblock_accounts_plans", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
        });

        Schema::table("soundblock_accounts_transactions", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
        });

        Schema::table("soundblock_accounts_users", function (Blueprint $objTable) {
            $objTable->renameColumn("account_id", "service_id");
            $objTable->renameColumn("account_uuid", "service_uuid");
        });

        Schema::rename("soundblock_accounts", "soundblock_services");
        Schema::rename("soundblock_accounts_notes", "soundblock_services_notes");
        Schema::rename("soundblock_accounts_notes_attachments", "soundblock_services_notes_attachments");
        Schema::rename("soundblock_accounts_plans", "soundblock_services_plans");
        Schema::rename("soundblock_accounts_transactions", "soundblock_services_transactions");
        Schema::rename("soundblock_accounts_users", "soundblock_services_users");
    }
}
