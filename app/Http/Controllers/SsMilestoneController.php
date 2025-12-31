<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SsMilestone;
use Illuminate\Http\Request;

class SsMilestoneController extends Controller
{
    /**
     * Get milestones → categories → tasks
     * Filtered by study_setup_type (external | internal)
     */
    public function getMilestonesTemplate(Request $request)
    {
        $type = $request->query('type');

        if (!in_array($type, ['external', 'internal'])) {
            return response()->json([
                'message' => 'Invalid type. Allowed values: external, internal'
            ], 422);
        }

        $milestones = SsMilestone::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->with([
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
            ])
            ->get();

        return response()->json([
            'type' => $type,
            'data' => $milestones
        ]);
    }
}
