<?php

namespace App\Http\Controllers;

use App\Enums\StudyMilestoneStatus;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\SsStudyMilestoneCategoryTaskResource;
use App\Models\SsStudyMilestoneCategoryTask;
use App\Http\Requests\AssignStudyMilestoneTaskRequest;
use App\Http\Requests\SsStudyMilestoneCategoryTaskRequest;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SsStudyMilestoneCategoryTaskController extends Controller
{   

    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        $request->validate([
            'study_setup_type' => 'nullable|in:external,internal',
        ]);

        $records = $this->filterService->filter(
            tableName: 'ss_study_milestone_category_tasks',
            modelName: SsStudyMilestoneCategoryTask::class,
            allowedSorts: [
                'order',
                'name',
                'planned_due_date',
                'created_at',
            ],
            allowedFilters: [
                'ss_study_id',
                'ss_study_milestone_category_id',
                'assigned_to',
                'enum_status',
                'required',
            ],
            paginate: Helper::paginationCount(),
            extraQuery: function ($query) use ($request) {
                if ($request->filled('study_setup_type')) {
                    $query->where('study_setup_type', $request->study_setup_type);
                }
            }
        );

        return response()->ok(
            SsStudyMilestoneCategoryTaskResource::collection($records)
        );
    }

    public function store(SsStudyMilestoneCategoryTaskRequest $request)
    {
        $data = $request->validated();
        $task = SsStudyMilestoneCategoryTask::create($data);

        return response()->ok(
            SsStudyMilestoneCategoryTaskResource::make($task),
            'Study milestone task created successfully'
        );
    }

    public function show($id)
    {
        $task = SsStudyMilestoneCategoryTask::with([
            'category',
            'masterTask',
            'updatedBy',
        ])->findOrFail($id);

        return response()->ok(
            SsStudyMilestoneCategoryTaskResource::make($task)
        );
    }

    public function update(SsStudyMilestoneCategoryTaskRequest $request, $id)
    {
        $task = SsStudyMilestoneCategoryTask::findOrFail($id);

        $data = $request->validated();
        $task->update($data);

        return response()->ok(
            SsStudyMilestoneCategoryTaskResource::make($task),
            'Study milestone task updated successfully'
        );
    }

    public function destroy($id)
    {
        $task = SsStudyMilestoneCategoryTask::findOrFail($id);
        $task->delete();

        return response()->ok(
            SsStudyMilestoneCategoryTaskResource::make($task),
            'Study milestone task deleted successfully'
        );
    }

    public function assignTasks(AssignStudyMilestoneTaskRequest $request, $studyId)
    {
        $task = SsStudyMilestoneCategoryTask::where('id', $request->study_milestone_category_task_id)
                    ->where('ss_study_id', $studyId)
                    ->firstOrFail();

        $task->update([
            'assigned_to' => $request->assigned_to,
            'enum_status'  => StudyMilestoneStatus::inProgress()->value,
        ]);

        return response()->ok([
            'message' => 'Task assigned successfully',
            'task'    =>  SsStudyMilestoneCategoryTaskResource::make($task)
        ]);
    }

}