<?php
namespace Modules\Teams\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function createMeeting(Request $request)
    {
        // Get module configuration
        $app = \App\Models\ExternalApp::where('slug', 'teams')->first();
        
        if (!$app || !$app->is_enabled) {
            return response()->json(['error' => 'Module not available'], 403);
        }

        $service = new \Modules\Teams\Services\TeamsMeetingService();
        $meetingData = $service->createMeeting(
            $request->input('topic', 'Test Meeting'),
            $request->input('start_time', now()->addHour()->toIso8601String()),
            $request->input('duration', 60),
            $request->input('timezone', 'UTC')
        );

        if (!$meetingData) {
            return response()->json(['error' => 'Failed to create meeting'], 500);
        }

        return response()->json($meetingData);
    }

    public function testConnection(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $tenantId = $request->input('TEAMS_TENANT_ID');
        $clientId = $request->input('TEAMS_CLIENT_ID');
        $clientSecret = $request->input('TEAMS_CLIENT_SECRET');

        if (empty($tenantId) || empty($clientId) || empty($clientSecret)) {
            return response()->json(['success' => false, 'message' => 'Please provide Tenant ID, Client ID, and Client Secret.'], 400);
        }

        $service = new \Modules\Teams\Services\TeamsMeetingService();
        $success = $service->testConnection($tenantId, $clientId, $clientSecret);

        if ($success) {
            return response()->json(['success' => true, 'message' => 'Successfully connected to Microsoft Graph API!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to connect to Microsoft Graph API. Please check your credentials and try again.'], 400);
        }
    }
}
?>
