<?php

use App\Contracts\Soundblock\Ledger;
use App\Exceptions\Core\Disaster\LedgerMicroserviceException;
use App\Facades\Exceptions\Disaster;
use Illuminate\Database\Migrations\Migration;

class QldbCreateCollectionsTable extends Migration
{
    /**
     * @var Ledger
     */
    private $ledgerContract;

    /**
     * QldbCreateContractsTable constructor.
     */
    public function __construct() {
        $this->ledgerContract = resolve(Ledger::class);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            $this->ledgerContract->createTable("soundblock_collections");
        } catch(LedgerMicroserviceException $exception) {
            Disaster::handleDisaster($exception);
        } catch(\Exception $exception){
            dump($exception->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try{
            $this->ledgerContract->deleteTable("soundblock_collections");
        } catch(LedgerMicroserviceException $exception) {
            Disaster::handleDisaster($exception);
        } catch(\Exception $exception){
            dump($exception->getMessage());
        }
    }
}
