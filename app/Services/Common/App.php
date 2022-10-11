<?php

namespace App\Services\Common;

use Illuminate\Support\Collection;
use App\Models\Core\App as AppModel;
use App\Repositories\Common\App as AppRepository;

class App {
    /** @var AppRepository */
    protected AppRepository $appRepo;

    /**
     * @param AppRepository $appRepo
     */
    public function __construct(AppRepository $appRepo) {
        $this->appRepo = $appRepo;
    }

    /**
     * @param mixed $id
     * @param bool $bnFailure
     * @return AppModel|null
     * @throws \Exception
     */
    public function find($id, ?bool $bnFailure = true): ?AppModel {
        return ($this->appRepo->find($id, $bnFailure));
    }

    /**
     * @param string $strAppName
     * @return AppModel
     */
    public function findOneByName(string $strAppName): AppModel {
        return ($this->appRepo->findOneByName($strAppName));
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection {
        return ($this->appRepo->findAll());
    }
}
