<?php

namespace App\Http\Controllers;

use App\Enums\StudyMilestoneStatus;
use App\Filters\SearchText;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SsStudyMilestoneRequest;
use App\Http\Resources\SsStudyMilestoneResource;
use App\Models\SsStudyMilestone;
use App\Models\SsStudyMilestoneCategory;
use App\Models\SsStudyMilestoneCategoryTask;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;

class SsStudyMilestoneController extends Controller
{

    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        $records = $this->filterService->filter(
            tableName: 'ss_study_milestones',
            modelName: SsStudyMilestone::class,
            allowedSorts: [
                'ss_study_milestones.name',
                'ss_study_milestones.order',
                'ss_study_milestones.start_date',
                'ss_study_milestones.planned_due_date',
                'ss_study_milestones.created_at',
            ],
            allowedFilters: [
                AllowedFilter::custom(
                    'search_text',
                    new SearchText(),
                    'ss_study_milestones'
                ),
                'name',
                'enum_status',
                'ss_milestone_id',
                'ss_site_id',
            ],
            with: [
                'categories.tasks',
            ],
            paginate: Helper::filterBoolean($request)
        );

        return response()->ok(
            SsStudyMilestoneResource::collection($records)
        );
    }

    public function store(SsStudyMilestoneRequest $request)
    {
        $data = $request->validated();

        foreach ($data['milestones'] as $milestoneData) {

            $studyMilestone = SsStudyMilestone::create([
                'ss_study_id'            => $request->ss_study_id,
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
                    'ss_study_id'                => $request->ss_study_id,
                    'ss_organisation_id'         => $request->ss_organisation_id,
                    'ss_study_milestones_id'     => $studyMilestone->id,
                    'ss_milestone_category_id'   => $categoryData['ss_milestone_category_id'],
                    'study_category_name'        => $categoryData['study_category_name'],
                    'order'                      => $categoryData['order'] ?? 1,
                    'is_active'                  => $categoryData['is_active'] ?? true,
                ]);

                foreach ($categoryData['tasks'] as $taskData) {

                    SsStudyMilestoneCategoryTask::create([
                        'ss_study_id'                         => $request->ss_study_id,
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

        $milestones = SsStudyMilestone::with(['categories.tasks'])
                        ->where('ss_study_id', $request->ss_study_id)
                        ->get();

        return response()->ok([
            'milestones' => SsStudyMilestoneResource::collection($milestones)
        ]);
    }

    public function update(SsStudyMilestoneRequest $request, $id)
    {
        $data = $request->validated();

        $ssStudy = SsStudyMilestone::findOrFail($id);
        $ssStudy->update($data);

        return response()->ok(
            SsStudyMilestoneResource::make($ssStudy),
            'Study updated successfully'
        );
    }

    public function show($id)
    {
        $studyMilestone = SsStudyMilestone::with('categories.tasks')
            ->findOrFail($id);

        return response()->ok(
            SsStudyMilestoneResource::make($studyMilestone)
        );
    }

    public function destroy($id)
    {
        $ssStudyMilestone = SsStudyMilestone::findOrFail($id);
        $ssStudyMilestone->delete();

        return response()->ok(
            null,
            'Study Milestone deleted successfully'
        );
    }

}
