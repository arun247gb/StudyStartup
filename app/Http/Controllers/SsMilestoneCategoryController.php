<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\SsMilestoneCategoryRequest;
use App\Http\Resources\SsMilestoneCategoryResource;
use App\Models\SsMilestoneCategory;
use App\Services\FilterService;
use Illuminate\Http\Request;

class SsMilestoneCategoryController extends Controller
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {

        $type = $request->query('type');
        $records = $this->filterService->filter(
            tableName: 'ss_milestone_categories',
            modelName: SsMilestoneCategory::class,
            allowedSorts: [
                'order', 
                'category_name', 
                'created_at'
            ],
            allowedFilters: [
                'ss_milestone_id', 
                'category_name', 
                'is_active'],
            with: [
                'tasks', 
                'milestone'
            ],
            paginate: Helper::paginationCount()
        );

        return response()->ok([
            'type' => $type, 
            'data' => SsMilestoneCategoryResource::collection($records)
        ]);
    }


    public function store(SsMilestoneCategoryRequest $request)
    {
        $data = $request->validated();

        $category = SsMilestoneCategory::create($data);

        return response()->ok(
            SsMilestoneCategoryResource::make($category),
            'Category created successfully.'
        );
    }

    public function show(Request $request, $id)
    {
        $type = $request->query('type');
        $categories = SsMilestoneCategory::with('tasks', 'milestone')->findOrFail($id);

        return response()->ok([
            'type' => $type,
            'data' => SsMilestoneCategoryResource::make($categories)
        ]);
    }

    public function update(SsMilestoneCategoryRequest $request, $id)
    {
        $ssMilestoneCategory = SsMilestoneCategory::findOrFail($id);
        $ssMilestoneCategory->update($request->validated());

        $ssMilestoneCategory->load('tasks', 'milestone');

        return response()->ok(
            SsMilestoneCategoryResource::make($ssMilestoneCategory),
            'Category updated successfully.'
        );
    }

    public function destroy($id)
    {
        $ssMilestoneCategory = SsMilestoneCategory::findOrFail($id);
        $ssMilestoneCategory->delete();

        return response()->ok(null, 'Category deleted successfully.');
    }
}
