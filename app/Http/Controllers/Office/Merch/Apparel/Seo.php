<?php

namespace App\Http\Controllers\Office\Merch\Apparel;

use App\Traits\Cacheable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Facades\Cache\AppCache;
use App\Models\Apparel\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Apparel\Category as CategoryRepository;
use App\Http\Requests\Apparel\{UpdateCategory, UpdateCategories};

/**
 * @group Office Merch
 *
 */
class Seo extends Controller {
    use Cacheable;

    /** @var CategoryRepository */
    private CategoryRepository $categoryRepository;
    /** @var Category */
    private Category $category;

    /**
     * Seo constructor.
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(Category $category, CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
        $this->category = $category;
    }

    /**
     * @param UpdateCategory $request
     * @param string $categoryUUID
     * @return mixed
     */
    public function updateCategory(UpdateCategory $request, string $categoryUUID) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->categoryRepository->updateCategory(
            $categoryUUID, $request->only(["category_meta_keywords", "category_meta_description"])
        );

        if ($boolResult) {
            return ($this->apiReply(null, "Category updated successfully!", 200));
        }

        return ($this->apiReject(null, "Category haven't updated.", 400));
    }

    /**
     * @param UpdateCategories $request
     * @return mixed
     */
    public function updateCategories(UpdateCategories $request) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->categoryRepository->updateCategories($request->all());

        if ($boolResult) {
            return ($this->apiReply(null, "Categories updated successfully!", 200));
        }

        return ($this->apiReject(null, "Categories haven't updated.", 400));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getCategories(Request $request) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        AppCache::setRequestOptions($request->path(), []);
        AppCache::setClassOptions(self::class, "get");
        AppCache::setQueryString($this->category->toSql());

        if (AppCache::isCached()) {
            return response()->json(AppCache::getCache());
        }

        return ($this->sendCacheResponse($this->apiReply($this->category->all())));
    }
}
