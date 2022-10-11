<?php

namespace App\Http\Requests\Common\Account;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Soundblock\Data\PlansTypes as PlansTypesRepository;

class UpdatePlan extends FormRequest {
    /**
     * @var PlansTypesRepository|mixed
     */
    private $planTypeRepo;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param PlansTypesRepository $plansTypesRepo
     * @return bool
     */
    public function authorize(PlansTypesRepository $plansTypesRepo) {
        $this->planTypeRepo = $plansTypesRepo;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \Exception
     */
    public function rules() {
        $arrValidate = [
            "type" => ["required", "string", "exists:soundblock_data_plans_types,data_uuid"],
        ];
        $arrParams = $this->validationData();

        if (isset($arrParams["type"])) {
            $objPlanType = $this->planTypeRepo->find($arrParams["type"]);

            if (!is_null($objPlanType) && $objPlanType->plan_level !== 1) {
                $arrValidate["payment_id"] = ["required" ,"string", "regex:/pm_.*/"];
            }
        }

        return $arrValidate;
    }
}
