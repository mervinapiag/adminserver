<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

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
        // Get unique users from the activity log
        $uniqueUsers = ActivityLog::select('user_id')
            ->distinct()
            ->get();

        $report = [];

        foreach ($uniqueUsers as $user) {
            $existingUser = User::find($user->user_id);
            if ($existingUser) {

                $userName = $user->user->name;

                $userActivityLogs = ActivityLog::where('user_id', $user->user_id)
                    ->orderBy('created_at')
                    ->get();
        
                $userReport = [
                    'user_name' => $userName,
                    'activity_logs' => []
                ];
        
                foreach ($userActivityLogs as $activityLog) {
                    $userReport['activity_logs'][] = [
                        'page_name' => $activityLog->page_name,
                        'visited_at' => $activityLog->created_at->format('F j, Y, g:i a'),
                    ];
                }
        
                $report[] = $userReport;
            }
        }

        return $report;
    }
}
