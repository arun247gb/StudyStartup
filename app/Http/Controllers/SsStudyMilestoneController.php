<?php

namespace App\Http\Controllers;

use App\Enums\StudyMilestoneStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\SsStudyMilestoneResource;
use App\Models\{
    SsStudyMilestone,
    SsStudyMilestoneCategory,
    SsStudyMilestoneCategoryTask
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SsStudyMilestoneController extends Controller
{
    public function store(Request $request, $studyId)
    {
        DB::transaction(function () use ($request, $studyId) {

            foreach ($request->milestones as $milestoneData) {

                $studyMilestone = SsStudyMilestone::create([
                    'ss_study_id'            => $studyId,
                    'ss_organisation_id'     => $request->ss_organisation_id,
                    'ss_site_id'             => $request->ss_site_id,
                    'ss_milestone_owner_id'  => Auth::id(),
                    'ss_milestone_id'        => $milestoneData['ss_milestone_id'],
                    'name'                   => $milestoneData['name'],
                    'order'                  => $milestoneData['order'] ?? null,
                    'start_date'             => $milestoneData['start_date'] ?? null,
                    'planned_due_date'       => $milestoneData['planned_due_date'] ?? null,
                    'enum_status'            => StudyMilestoneStatus::notStarted()->value,
                ]);

                foreach ($milestoneData['categories'] as $categoryData) {

                    $studyCategory = SsStudyMilestoneCategory::create([
                        'ss_study_id'                => $studyId,
                        'ss_organisation_id'         => $request->ss_organisation_id,
                        'ss_study_milestones_id'     => $studyMilestone->id,
                        'ss_milestone_category_id'   => $categoryData['ss_milestone_category_id'],
                        'study_category_name'        => $categoryData['study_category_name'],
                        'order'                      => $categoryData['order'] ?? 1,
                        'is_active'                  => $categoryData['is_active'] ?? true,
                    ]);

                    foreach ($categoryData['tasks'] as $taskData) {

                        SsStudyMilestoneCategoryTask::create([
                            'ss_study_id'                         => $studyId,
                            'ss_organisation_id'                  => $request->ss_organisation_id,
                            'ss_study_milestone_category_id'      => $studyCategory->id,
                            'ss_milestone_category_tasks_id'      => $taskData['ss_milestone_category_tasks_id'],
                            'name'                                => $taskData['name'],
                            'required'                            => $taskData['required'] ?? true,
                            'planned_start_date'                  => $taskData['planned_start_date'] ?? null,
                            'planned_due_date'                    => $taskData['planned_due_date'] ?? null,
                            'enum_status'                         => StudyMilestoneStatus::notStarted()->value,
                            'study_setup_type'                    => $taskData['study_setup_type'] ?? null,
                            'completion_type'                     => $taskData['completion_type'] ?? null,
                        ]);
                    }
                }
            }
        });

        $milestones = SsStudyMilestone::with(['categories.tasks'])
                        ->where('ss_study_id', $studyId)
                        ->get();

        return response()->ok([
            'milestones' => SsStudyMilestoneResource::collection($milestones)
        ]);
    }
}
