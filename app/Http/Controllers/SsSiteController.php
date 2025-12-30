<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\SsSiteRequest;
use App\Http\Resources\SsSiteResource;
use App\Models\SsSite;
use App\Services\FilterService;
use Illuminate\Http\Request;

class SsSiteController extends Controller
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        $siteRecords = $this->filterService->filter(
            tableName: 'ss_sites',
            modelName: SsSite::class,
            allowedSorts: [
                'ss_sites.name', 
                'ss_sites.site_number'
            ],
            allowedFilters: [
                'name', 
                'site_number'
            ],
            with: ['organization'],
            paginate: Helper::filterBoolean($request)
        );

        return response()->ok(SsSiteResource::collection($siteRecords));
    }

    public function show($id)
    {
        $site = SsSite::findOrFail($id);
        return response()->ok(SsSiteResource::make($site));
    }

    public function store(SsSiteRequest $request)
    {
        $site = SsSite::create($request->validated());
        return response()->ok(SsSiteResource::make($site), 'Site created successfully');
    }

    public function update(SsSiteRequest $request, $id)
    {
        $site = SsSite::findOrFail($id);
        $site->update($request->validated());
        return response()->ok(SsSiteResource::make($site), 'Site updated successfully');
    }

    public function destroy($id)
    {
        $site = SsSite::findOrFail($id);
        $site->delete();
        return response()->ok(message: 'Site deleted successfully');
    }
}
