<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\FarmProfile;
use App\Models\LastProductionDatas;
use App\Models\PersonalInformations;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
   
    // Method to get unread notifications for the authenticated user
    public function getNotifications()
    {
        $notifications = Auth::user()->notifications()->latest()->limit(5)->get();
    
        // Map the notifications to a custom format if needed
        $notifications = $notifications->map(function ($notification) {
            return [
                'message' => $notification->data['message'] ?? 'Notification message not found',
                'timeAgo' => $notification->created_at->diffForHumans(),
            ];
        });
        return response()->json($notifications);
    }

    // Method to mark a specific notification as read
    public function markAsReads($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read']);
        }

        return response()->json(['message' => 'Notification not found'], 404);
    }

public function markNotificationAsRead($id)
{
    $notification = Notification::where('id', $id)->where('users_id', Auth::id())->first();
    if ($notification) {
        $notification->is_read = true;
        $notification->save();
        return response()->json(['message' => 'Notification marked as read']);
    }
    return response()->json(['message' => 'Notification not found'], 404);
}

    public function clearNotification(Request $request)
    {
        // Clear notifications for the logged-in user
        Notification::where('users_id', Auth::id())->delete();
        
        return response()->json(['message' => 'Notifications cleared']);
    }
    public function markAsRead(Request $request)
    {
        $userId = auth()->id();
        $notifications = Notification::where('users_id', $userId)
                                      ->where('is_read', false)
                                      ->get();
    
        foreach ($notifications as $notification) {
            $notification->is_read = true;
            $notification->save();
        }
    
        return response()->json(['message' => 'Notifications marked as read.']);
    }
    

    // View notifications for the authenticated user
    public function index()
    {
        // Fetch the latest 5 notifications for the authenticated user
        $notifications = Auth::user()->notifications()->latest()->limit(5)->get();
    
        // Map the notifications to a custom format if needed
        $notifications = $notifications->map(function ($notification) {
            return [
                'message' => $notification->data['message'] ?? 'Notification message not found',
                'extend' => $notification->data['extend'] ?? 'Notification message not found',
                'Agri_District' => $notification->data['Agri-District'] ?? 'Notification Agri-District not found',
                'timeAgo' => $notification->created_at->diffForHumans(),
            ];
        });
    
        return response()->json([
            'notifications' => $notifications,
        ]);
    }
    

    // Clear notifications by marking them as read
    public function clearNotifications(Request $request)
    {
        // Assuming you have a Notification model
        // You can modify this to delete only unread notifications or all notifications
        $notifications = auth()->user()->notifications(); // or use a specific method to fetch notifications
        $notifications->delete(); // Delete all notifications for the logged-in user
        
        return response()->json(['success' => true]);
    }
    // Display the notification list view for admin with necessary data
    public function addNotification()
    {
        if (!Auth::check()) return redirect()->route('login');

        $userId = Auth::id();
        $admin = User::find($userId);
        
        if (!$admin) return redirect()->route('login')->with('error', 'User not found.');

        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
        $farmId = Auth::user()->farm_id;
        $farmProfile = FarmProfile::find($farmId);
        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        $notif = Notification::orderBy('id', 'asc')->paginate(5);

        return view('admin.notification.view_notif', compact('userId', 'admin', 'profile', 'farmProfile', 'totalRiceProduction', 'notif'));
    }

    // Display the form to add a notification with user data
    public function message()
    {
        if (!Auth::check()) return redirect()->route('login');

        $userId = Auth::id();
        $admin = User::find($userId);

        if (!$admin) return redirect()->route('login')->with('error', 'User not found.');

        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
        $farmId = Auth::user()->farm_id;
        $farmProfile = FarmProfile::find($farmId);
        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        $userRole = Auth::user()->role;
        $agents = User::where('role', 'agent')->get();
        $regularUsers = User::where('role', 'user')->get();
        $admins = User::where('role', 'admin')->get();

        return view('admin.notification.add_notif', compact(
            'userId', 'admin', 'profile', 'farmProfile', 'totalRiceProduction', 'userRole', 'agents', 'regularUsers', 'admins'
        ));
    }

    // Update a specific notification
    public function messageUpdate(Request $request, $id)
    {
        try {
            $notification = Notification::find($id);
            $notification->fill($request->only(['users_id', 'sender_id', 'receiver_id', 'message']));
            $notification->save();

            return redirect('/admin-view-notification')->with('message', 'Notification updated successfully');
        } catch (\Exception $ex) {
            return redirect('/admin-add-notification')->with('error', 'Something went wrong');
        }
    }

    // Delete a specific notification
    public function deleteNotif($id)
    {
        try {
            $notification = Notification::find($id);
            if (!$notification) return redirect()->back()->with('error', 'Notification not found');
            
            $notification->delete();
            return redirect()->back()->with('message', 'Notification deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting Notification: ' . $e->getMessage());
        }
    }
}
