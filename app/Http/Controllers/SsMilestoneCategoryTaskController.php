<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\SsMilestoneCategoryTask;
use App\Http\Requests\SsMilestoneCategoryTaskRequest;
use App\Http\Resources\SsMilestoneTaskResource;
use App\Services\FilterService;
use Illuminate\Http\Request;

class SsMilestoneCategoryTaskController extends Controller
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:external,internal',
        ]);

        $records = $this->filterService->filter(
            tableName: 'ss_milestone_category_tasks',
            modelName: SsMilestoneCategoryTask::class,
            allowedSorts: [
                'order',
                'name',
                'created_at',
            ],
            allowedFilters: [
                'ss_milestone_categories_id',
                'is_active',
            ],
            paginate: Helper::paginationCount(),
            extraQuery: function ($query) use ($request) {
                if ($request->filled('type')) {
                    $query->where('study_setup_type', $request->type);
                }
            }
        );

        return response()->ok(
            SsMilestoneTaskResource::collection($records)
        );
    }


    public function store(SsMilestoneCategoryTaskRequest $request)
    {
        $data = $request->validated();
        $task = SsMilestoneCategoryTask::create($data);

        return response()->ok(
            SsMilestoneTaskResource::make($task),
            'Task created successfully'
        );
    }

    public function show($id)
    {
        $ssMilestoneCategoryTask = SsMilestoneCategoryTask::findOrFail($id);

        return response()->ok(
            SsMilestoneTaskResource::make($ssMilestoneCategoryTask)
        );
    }

    public function update(SsMilestoneCategoryTaskRequest $request, $id)
    {
        $data = $request->validated();
        $ssMilestoneCategoryTask = SsMilestoneCategoryTask::findOrFail($id);
        $ssMilestoneCategoryTask->update($data);

        return response()->ok(
            SsMilestoneTaskResource::make($ssMilestoneCategoryTask),
            'Task updated successfully'
        );
    }

    public function destroy($id)
    {
        $ssMilestoneCategoryTask = SsMilestoneCategoryTask::findOrFail($id);
        $ssMilestoneCategoryTask->delete();

        return response()->ok(
            SsMilestoneTaskResource::make($ssMilestoneCategoryTask),
            'Task deleted successfully'
        );
    }
}
