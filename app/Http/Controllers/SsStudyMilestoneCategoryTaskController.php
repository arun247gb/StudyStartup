<?php

namespace App\Http\Controllers;

use App\Enums\StudyMilestoneStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\SsStudyMilestoneCategoryTaskResource;
use App\Models\SsStudyMilestoneCategoryTask;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AssignStudyMilestoneTaskRequest;


class SsStudyMilestoneCategoryTaskController extends Controller
{   
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