<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SsStudyMilestoneCategoryRequest;
use App\Http\Resources\SsStudyMilestoneCategoryResource;
use App\Models\SsStudyMilestoneCategory;
use App\Services\FilterService;
use Illuminate\Http\Request;

class SsStudyMilestoneCategoryController extends Controller
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    /**
     * List categories
     */
    public function index(Request $request)
    {
        $records = $this->filterService->filter(
            tableName: 'ss_study_milestone_categories',
            modelName: SsStudyMilestoneCategory::class,
            allowedSorts: [
                'order',
                'study_category_name',
                'created_at',
            ],
            allowedFilters: [
                'ss_study_id',
                'ss_study_milestones_id',
                'ss_milestone_category_id',
                'is_active',
            ],
            with: [
                'studyMilestone',
                'masterCategory',
                'tasks',
            ],
            paginate: Helper::paginationCount()
        );

        return response()->ok(
            SsStudyMilestoneCategoryResource::collection($records)
        );
    }

    public function store(SsStudyMilestoneCategoryRequest $request)
    {
        $category = SsStudyMilestoneCategory::create(
            $request->validated()
        );

        return response()->ok(
            SsStudyMilestoneCategoryResource::make($category),
            'Study milestone category created successfully'
        );
    }

    public function show($id)
    {
        $category = SsStudyMilestoneCategory::with([
            'studyMilestone',
            'masterCategory',
            'tasks',
        ])->findOrFail($id);

        return response()->ok(
            SsStudyMilestoneCategoryResource::make($category)
        );
    }

    public function update(SsStudyMilestoneCategoryRequest $request, $id)
    {
        $category = SsStudyMilestoneCategory::findOrFail($id);
        $category->update($request->validated());

        return response()->ok(
            SsStudyMilestoneCategoryResource::make($category),
            'Study milestone category updated successfully'
        );
    }

    public function destroy($id)
    {
        $category = SsStudyMilestoneCategory::findOrFail($id);
        $category->delete();

        return response()->ok(
            SsStudyMilestoneCategoryResource::make($category),
            'Study milestone category deleted successfully'
        );
    }
}
