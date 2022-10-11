<?php

namespace App\Http\Controllers\Core\Social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Core\Social\InstagramCollection;
use App\Repositories\Core\Social\Instagram as InstagramRepository;

/**
 * @group Core Social
 */
class Instagram extends Controller {
    const DEFAULT_COUNT = 20;

    /**
     * @var InstagramRepository
     */
    private InstagramRepository $instagram;

    /**
     * Instagram Controller constructor.
     * @param InstagramRepository $instagram
     */
    public function __construct(InstagramRepository $instagram) {
        $this->instagram = $instagram;
    }

    /**
     * Get Inst Images
     * @queryParam random Count of Random Images
     * @queryParam latest Count of Latest Images
     * @param Request $objRequest
     */
    public function getMedia(Request $objRequest) {
        $randomCount = $objRequest->input("random", 0);
        $latestCount = $objRequest->input("latest", 0);

        if ($randomCount > 0 && $latestCount > 0) {
            $objImages = $this->instagram->getMixed($latestCount, $randomCount);
        } else if ($randomCount > 0) {
            $objImages = $this->instagram->getRandom($randomCount);
        } else {
            $latestCount = $latestCount > 0 ? $latestCount : self::DEFAULT_COUNT;
            $objImages = $this->instagram->getLatest($latestCount);
        }

        return ($this->apiReply(new InstagramCollection($objImages)));
    }
}
