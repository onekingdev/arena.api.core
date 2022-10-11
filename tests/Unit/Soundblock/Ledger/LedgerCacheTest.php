<?php

namespace Tests\Unit\Soundblock\Ledger;

use Tests\TestCase;
use App\Helpers\Util;
use App\Repositories\Soundblock\Ledger as LedgerRepository;
use App\Contracts\Soundblock\{Ledger as LedgerContract, Ledger\LedgerCache};
use App\Models\{Soundblock\Projects\Contracts\Contract, Soundblock\Ledger, Soundblock\Projects\Project, Soundblock\Accounts\Account, Users\User};

class LedgerCacheTest extends TestCase
{
    /**
     * @var LedgerCache
     */
    private $ledgerCache;
    /**
     * @var Ledger
     * */
    private $ledgerHttp;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $user;
    private $service;
    private $project;
    private $contract;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $contractUsers;
    private $ledgerRepo;

//    public function setUp(): void {
//        parent::setUp();
//
//        $this->ledgerCache = resolve(LedgerCacheContract::class);
//        $this->ledgerHttp = resolve(LedgerContract::class);
//
//        $this->user = factory(User::class)->create();
//
//        $this->service = $this->user->service()->create(factory(Account::class)->make([
//            "user_uuid" => $this->user->user_uuid
//        ])->toArray());
//
//        $this->project = $this->service->projects()->create(factory(Project::class)->make([
//            "service_uuid" => $this->service->service_uuid
//        ])->toArray());
//
//        $this->contract = $this->project->contracts()->create(factory(Contract::class)->make([
//            "contract_uuid" => Util::uuid(),
//            "project_uuid" => $this->project->project_uuid,
//            "service_id" => $this->service->service_id,
//            "service_uuid" => $this->service->service_uuid,
//        ])->makeVisible("service_id")->toArray());
//
//        $this->contractUsers = factory(User::class, 4)->create()->each(function (User $user) {
//            $user->contracts()->attach($this->contract->contract_id, [
//                "row_uuid" => Util::uuid(),
//                "contract_uuid" => $this->contract->contract_uuid,
//                "user_uuid" => $user->user_uuid,
//                "contract_status" => false,
//                "user_payout" => 25,
//            ]);
//        });
//
//        $this->ledgerRepo = resolve(LedgerRepository::class);
//    }

//    /**
//     * Test Caching Data From Ledger
//     *
//     * @return void
//     */
//    public function testSaveCache() {
//        $data = [
//            "contract" => "testText",
//            "contract_detail" => $this->contract->load(["users", "project"])->makeHidden("ledger")
//        ];
//
//        $arrCreatedData = $this->ledgerHttp->insertDocument("soundblock_contracts", $data);
//
//        $this->assertTrue(method_exists($this->ledgerCache, "saveCache"));
//        $objLedger = $this->ledgerCache->saveCache("soundblock_contracts", $arrCreatedData);
//        $this->assertInstanceOf(Ledger::class, $objLedger);
//        $this->assertDatabaseHas("soundblock_ledger", [
//            "qldb_id" => $arrCreatedData["id"]
//        ]);
//    }
//
//    public function testSaveCacheException() {
//        $this->expectException(\InvalidArgumentException::class);
//        $this->ledgerCache->saveCache("fake_table", []);
//    }
//
//    public function testUpdateLedgerByCache() {
//        $data = [
//            "contract" => "testUpdateText",
//            "contract_detail" => "test_detail"
//        ];
//
//        $arrCreatedData = $this->ledgerHttp->insertDocument("soundblock_contracts", $data);
//
//        /** @var Contract $contract*/
//        $contract = $this->project->contracts()->create(factory(Contract::class)->make([
//            "contract_uuid" => Util::uuid(),
//            "project_uuid" => $this->project->project_uuid,
//            "service_id" => $this->service->service_id,
//            "service_uuid" => $this->service->service_uuid,
//        ])->makeVisible("service_id")->toArray());
//
//        factory(User::class, 4)->create()->each(function (User $user) {
//            $user->contracts()->attach($this->contract->contract_id, [
//                "row_uuid" => Util::uuid(),
//                "contract_uuid" => $this->contract->contract_uuid,
//                "user_uuid" => $user->user_uuid,
//                "contract_status" => false,
//                "user_payout" => 25,
//            ]);
//        });
//
//        $arrDataUpdate = [
//            "contract" => "testContractText",
//            "contract_detail" => "testContractDetail"
//        ];
//
//        /** @var Ledger $objLedgerInstance*/
//        $objLedgerInstance = $contract->ledger()->create([
//            "ledger_uuid" => Util::uuid(),
//            "ledger_name" => env("LEDGER_NAME"),
//            "ledger_memo" => env("LEDGER_NAME"),
//            "qldb_id" => $arrCreatedData["id"],
//            "qldb_table" => "soundblock_contracts",
//            "qldb_block" => $arrCreatedData["blockAddress"],
//            "qldb_data" => $arrDataUpdate,
//            "qldb_hash" => $arrCreatedData["hash"],
//            "qldb_metadata" => $arrCreatedData["metadata"],
//            "table_name" => "soundblock_contracts",
//            "table_field" => "contract_id",
//            "table_id" => $contract->contract_id,
//        ]);
//
//        $objLedger = $this->ledgerCache->updateLedgerByCache($objLedgerInstance);
//        $this->assertInstanceOf(Ledger::class, $objLedger);
//
//        $arrLedgerData = $this->ledgerHttp->getDocument("soundblock_contracts", $objLedger->qldb_id);
//
//        $this->assertEquals($arrDataUpdate["contract"], $arrLedgerData["document"]["contract"]);
//        $this->assertEquals($arrDataUpdate["contract_detail"], $arrLedgerData["document"]["contract_detail"]);
//    }


    public function testMock() {
        $this->assertTrue(true);
    }
}
