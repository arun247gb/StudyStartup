<?php

namespace App\Http\Controllers;

use App\Models\SsStudy;
use Illuminate\Http\Request;
use App\Services\FilterService;
use App\Http\Resources\SsStudyResource;
use Spatie\QueryBuilder\AllowedFilter;
use App\Filters\SearchText;
use App\Helpers\Helper;
use App\Http\Requests\SsStudyRequest;

class SsStudyController extends Controller
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        $records = $this->filterService->filter(
            tableName: 'ss_studies',
            modelName: SsStudy::class,
            allowedSorts: [
                'ss_studies.name',
                'ss_studies.protocol_number',
                'ss_studies.created_at',
            ],
            allowedFilters: [
                AllowedFilter::custom('search_text', new SearchText(), 'ss_studies'),
                'name',
                'protocol_number',
                'ss_site_id',
            ],
            with: ['organization', 'site'],
            paginate: Helper::filterBoolean($request)
        );

        return response()->ok(SsStudyResource::collection($records));
    }

    public function store(SsStudyRequest $request)
    {
        $data = $request->validated();

        $data['created_by'] = auth()->id();
        $study = SsStudy::create($data);

        return response()->ok(
            SsStudyResource::make($study->load(['organization', 'site'])),
            'Study created successfully'
        );
    }
    public function show(SsStudy $ssStudy)
    {
        return response()->ok(
            SsStudyResource::make($ssStudy->load(['organization','site']))
        );
    }

    public function update(SsStudyRequest $request, $id)
    {  
        $data = $request->validated();
        $ssStudy = SsStudy::findOrFail($id);
        $ssStudy->update($data);

        return response()->ok(
            SsStudyResource::make($ssStudy),
            'Study updated successfully'
        );
    }

    public function destroy(SsStudy $ssStudy)
    {
        $ssStudy->delete();

        return response()->ok(
            SsStudyResource::make($ssStudy),
            'Study deleted successfully'
        );
    }
}
