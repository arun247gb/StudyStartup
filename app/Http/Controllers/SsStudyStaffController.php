<?php

namespace App\Http\Controllers;

use App\Filters\SearchText;
use App\Helpers\Helper;
use App\Http\Requests\SsStudyStaffRequest;
use App\Http\Resources\SsStudyStaffResource;
use App\Models\SsStudyStaff;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class SsStudyStaffController extends Controller
{

    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        $staffRecords = $this->filterService->filter(
            tableName: 'ss_study_staffs',
            modelName: SsStudyStaff::class,
            allowedSorts: [
                'ss_study_staffs.name',
                'ss_study_staffs.enum_staff_type_id',
            ],
            allowedFilters: [
                AllowedFilter::custom('search_text', new SearchText(), 'ss_study_staffs'),
                'ss_study_id',
                'ss_user_id',
                'enum_staff_type_id',
            ],
            with: ['study', 'user', 'organization', 'creator'],
            paginate: Helper::filterBoolean($request)
        );

        return response()->ok(SsStudyStaffResource::collection($staffRecords));
    }

    public function store(SsStudyStaffRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $staff = SsStudyStaff::create($data);

        return response()->ok(
            SsStudyStaffResource::make($staff->load(['study','user','organization','creator'])),
            'Staff added successfully'
        );
    }

    public function show(SsStudyStaff $ssStudyStaff)
    {
        return response()->ok(
            SsStudyStaffResource::make($ssStudyStaff->load(['study','user','organization','creator']))
        );
    }

    public function update(SsStudyStaffRequest $request, SsStudyStaff $ssStudyStaff)
    {
        $data = $request->validated();
        $ssStudyStaff->update($data);

        return response()->ok(
            SsStudyStaffResource::make($ssStudyStaff->load(['study','user','organization','creator'])),
            'Staff updated successfully'
        );
    }

    public function destroy(SsStudyStaff $ssStudyStaff)
    {
        $ssStudyStaff->delete();

        return response()->ok(SsStudyStaffResource::make($ssStudyStaff), 'Staff removed successfully');
    }
}
