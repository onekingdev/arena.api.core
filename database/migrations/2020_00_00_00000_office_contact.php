<?php

use App\Models\Office\Contact;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OfficeContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("office_contact", function (Blueprint $objTable) {
            $objTable->bigIncrements("contact_id");
            $objTable->uuid("contact_uuid")->unique("uidx_contact-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id")->nullable()->default(null);
            $objTable->uuid("user_uuid")->index("idx_user-uuid")->nullable()->default(null);
            $objTable->string("contact_name_first", 175);
            $objTable->string("contact_name_last", 175);
            $objTable->string("contact_business", 175)->nullable();
            $objTable->string("contact_subject", 175)->nullable();
            $objTable->string("contact_email", 175);
            $objTable->string("contact_phone", 175)->nullable();
            $objTable->ipAddress("contact_host")->nullable();
            $objTable->string("contact_agent", 250)->nullable();
            $objTable->text("contact_memo");
            $objTable->json("contact_json")->nullable();

            $objTable->timestamp(Contact::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(Contact::STAMP_CREATED)->index(Contact::IDX_STAMP_CREATED)->nullable();
            $objTable->unsignedBigInteger(Contact::STAMP_CREATED_BY)->nullable();

            $objTable->timestamp(Contact::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(Contact::STAMP_UPDATED)->index(Contact::IDX_STAMP_UPDATED)->nullable();
            $objTable->unsignedBigInteger(Contact::STAMP_UPDATED_BY)->nullable();

            $objTable->timestamp(Contact::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(Contact::STAMP_DELETED)->index(Contact::IDX_STAMP_DELETED)->nullable();
            $objTable->unsignedBigInteger(Contact::STAMP_DELETED_BY)->nullable();

            $objTable->unique("contact_id", "uidx_contact-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("office_contact");
    }
}
