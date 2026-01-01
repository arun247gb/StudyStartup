<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SsDepartmentRequest;
use App\Http\Resources\SsDepartmentResource;
use App\Models\SsDepartment;
use App\Services\FilterService;
use Illuminate\Http\Request;

class SsDepartmentController extends Controller
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        $records = $this->filterService->filter(
            tableName: 'ss_departments',
            modelName: SsDepartment::class,
            allowedSorts: [
                'name',
                'created_at',
                'is_active',
            ],
            allowedFilters: [
                'ss_organizations_id',
                'is_active',
                'name',
            ],
            paginate: Helper::paginationCount()
        );

        return response()->ok(
            SsDepartmentResource::collection($records)
        );
    }

    public function store(SsDepartmentRequest $request)
    {
        $department = SsDepartment::create(
            $request->validated()
        );

        return response()->ok(
            SsDepartmentResource::make($department),
            'Department created successfully'
        );
    }

    public function show($id)
    {
        $department = SsDepartment::with(['organization'])
            ->findOrFail($id);

        return response()->ok(
            SsDepartmentResource::make($department)
        );
    }

    public function update(SsDepartmentRequest $request, $id)
    {
        $department = SsDepartment::findOrFail($id);

        $department->update(
            $request->validated()
        );

        return response()->ok(
            SsDepartmentResource::make($department),
            'Department updated successfully'
        );
    }

    public function destroy($id)
    {
        $department = SsDepartment::findOrFail($id);
        $department->delete();

        return response()->ok(
            SsDepartmentResource::make($department),
            'Department deleted successfully'
        );
    }
}
