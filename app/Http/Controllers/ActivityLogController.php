<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\User;

class ActivityLogController extends Controller
{
    public function logActivity(Request $request)
    {
        ActivityLog::create([
            'user_id' => $request->user_id,
            'page_name' => $request->page_name
        ]);

        return response()->json(null, 204);
    }

    public function getActivity()
    {
        $data = ActivityLog::all();

        return response()->json($data, 200);
    }

    public function generateCustomerBehaviorReport()
    {
        $uniqueUsers = ActivityLog::select('user_id')
            ->distinct()
            ->get();

        $report = [];

        foreach ($uniqueUsers as $user) {
            $existingUser = User::find($user->user_id);
            if ($existingUser) {

                $userName = $existingUser->name;

                $userActivityLogs = ActivityLog::where('user_id', $user->user_id)
                    ->orderBy('created_at')
                    ->get();

                $userReport = [
                    'user_name' => $userName,
                    'activity_logs' => []
                ];

                $pageCount = [];

                foreach ($userActivityLogs as $activityLog) {
                    $pageName = $activityLog->page_name;

                    if (!isset($pageCount[$pageName])) {
                        $pageCount[$pageName] = 1;
                    } else {
                        $pageCount[$pageName]++;
                    }
                }

                foreach ($pageCount as $pageName => $count) {
                    $userReport['activity_logs'][] = [
                        'page_name' => $pageName,
                        'count' => $count,
                    ];
                }

                $report[] = $userReport;
            }
        }

        return $report;
    }

}
