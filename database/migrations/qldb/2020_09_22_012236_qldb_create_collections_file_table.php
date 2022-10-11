<?php

use App\Facades\Exceptions\Disaster;
use App\Contracts\Soundblock\Ledger;
use Illuminate\Database\Migrations\Migration;
use App\Exceptions\Core\Disaster\LedgerMicroserviceException;

class QldbCreateCollectionsFileTable extends Migration
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
            $this->ledgerContract->createTable("soundblock_files");
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
            $this->ledgerContract->deleteTable("soundblock_files");
        } catch(LedgerMicroserviceException $exception) {
            Disaster::handleDisaster($exception);
        } catch(\Exception $exception){
            dump($exception->getMessage());
        }
    }
}
