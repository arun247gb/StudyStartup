<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SsMilestoneIndexRequest;
use App\Http\Resources\SsMilestoneResource;
use App\Models\SsMilestone;
use App\Services\FilterService;
use Illuminate\Http\Request;
use App\Http\Requests\SsMilestoneRequest;
use App\Http\Resources\SsStudyMilestoneResource;

class SsMilestoneController extends Controller
{

    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(SsMilestoneIndexRequest $request)
    {

        $type = $request->validated('study_setup_type');
        $records = $this->filterService->filter(
            tableName: 'ss_milestones',
            modelName: SsMilestone::class,
            allowedSorts: [
                'ss_milestones.order',
                'ss_milestones.name',
                'ss_milestones.created_at',
            ],
            allowedFilters: [
                'is_active',
            ],
            with: [
                'categories' => function ($categoryQuery) use ($type) {
                    $categoryQuery
                        ->orderBy('order')
                        ->with([
                            'tasks' => function ($taskQuery) use ($type) {
                                $taskQuery
                                    ->where('study_setup_type', $type)
                                    ->where('is_active', 1)
                                    ->orderBy('order');
                            }
                        ]);
                }
            ],
            paginate: Helper::paginationCount(),
        );

        return response()->ok(
            SsMilestoneResource::collection($records)
        );
    }

    public function store(SsMilestoneRequest $request) {
        $data = $request->validated();
        $task = SsMilestone::create($data);

        return response()->ok(
            SsStudyMilestoneResource::make($task),
            'Study milestone task created successfully'
        );
    }

    public function show($id, Request $request)
    {
        $type = $request->query('study_setup_type');
        $milestones = SsMilestone::with(['categories' => function ($categoryQuery) use ($type) {
            $categoryQuery->with(['tasks' => function ($taskQuery) use ($type) {
                if ($type) {
                    $taskQuery->where('study_setup_type', $type);
                }
                $taskQuery->where('is_active', 1)->orderBy('order');
            }])->orderBy('order');
        }])->findOrFail($id);

        return response()->ok(
            SsMilestoneResource::make($milestones)
        );
    }

    public function update(SsMilestoneRequest $request, $id) {
        $data = $request->validated();
        $ssMilestone = SsMilestone::findOrFail($id);
        $ssMilestone->update($data);

        return response()->ok(
            SsStudyMilestoneResource::make($ssMilestone),
            'Study milestone updated successfully'
        );
    }   

    public function destroy($id) {
        $ssMilestone = SsMilestone::findOrFail($id);
        $ssMilestone->delete();
        return response()->ok(
            SsStudyMilestoneResource::make($ssMilestone),
            'Study milestone deleted successfully'
        );
    }
}