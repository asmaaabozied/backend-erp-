<?php

namespace App\Http\Controllers\API\Localization;


use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Localization\District;
use App\Http\Requests\Localization\DistrictRequest;
use App\Http\Resources\API\Localization\DistrictResource;
use App\Repositories\IRepositories\Localization\IDistrictRepository;

class DistrictController extends Controller
{
    private $districtRepository;

    public function __construct(IDistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function index()
    {
        try {
            $all_districts = DistrictResource::collection($this->districtRepository->all());
            return $all_districts->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function store(DistrictRequest $request)
    {
        try {
            $model = $this->districtRepository->create($request->validated());
            $district = new DistrictResource($model);
            return $district->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param District $district
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function show(District $district)
    {
        try {
            $district = new DistrictResource($district);
            return $district->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Example $district
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function update(District $district, DistrictRequest $request)
    {
        try {
            $this->districtRepository->update($request->validated(), $district->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Example $district
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public
    function destroy(District $district)
    {
        try {
            $this->districtRepository->delete($district->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * navigation.
     *
     * @param District $district , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, District $district)
    {
        try {
            $district = new DistrictResource($this->districtRepository->navigate($district->id, $request->case, 'type', $request->type));
            return $district->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function getCode()
    {
        $code = District::orderBy('id', 'DESC')->pluck('code')->first();
        $nextCode = getAutoGeneratedNextCode($code);
        $newCode = District::where('code', $nextCode)->pluck('code')->first();
        while ($newCode != null) {
            $nextCode = getAutoGeneratedNextCode($newCode);
            $newCode = District::where('code', $nextCode)->pluck('code')->first();
        }
        return JsonResponse::respondSuccess('success', $nextCode);
    }
}
