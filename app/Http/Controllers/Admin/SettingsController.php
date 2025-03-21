<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);
        
        // Direct update using query builder to avoid model method issues
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'updated_at' => now()
            ]);
        
        return redirect()->route('admin.settings')->with('success', 'Profile updated successfully.');
    }
    
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Direct update using query builder
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($validated['password']),
                'updated_at' => now()
            ]);
        
        return redirect()->route('admin.settings')->with('success', 'Password changed successfully.');
    }
    
    public function updateNotifications(Request $request)
    {
        $settings = [
            'notification_status_updates' => $request->has('notification_status_updates') ? '1' : '0',
            'notification_completion_reminders' => $request->has('notification_completion_reminders') ? '1' : '0',
            'notification_marketing_emails' => $request->has('notification_marketing_emails') ? '1' : '0',
        ];
        
        foreach ($settings as $key => $value) {
            // Check if setting exists
            $exists = DB::table('settings')->where('key', $key)->exists();
            
            if ($exists) {
                // Update
                DB::table('settings')
                    ->where('key', $key)
                    ->update(['value' => $value, 'updated_at' => now()]);
            } else {
                // Insert
                DB::table('settings')->insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        
        return redirect()->route('admin.settings')->with('success', 'Notification settings updated successfully.');
    }
    
    public function updateSystem(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'required|string|max:20',
            'reminder_days' => 'required|integer|min:1|max:14',
        ]);
        
        foreach ($validated as $key => $value) {
            // Check if setting exists
            $exists = DB::table('settings')->where('key', $key)->exists();
            
            if ($exists) {
                // Update
                DB::table('settings')
                    ->where('key', $key)
                    ->update(['value' => $value, 'updated_at' => now()]);
            } else {
                // Insert
                DB::table('settings')->insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        
        // Update config values at runtime
        config(['autox.reminder_days' => $validated['reminder_days']]);
        
        return redirect()->route('admin.settings')->with('success', 'System settings updated successfully.');
    }
    
    public function updateEmailTemplates(Request $request)
    {
        $templateType = $request->input('template_type');
        $subject = $request->input('subject');
        $template = $request->input('template');
        
        if ($templateType) {
            // Subject setting - check and update/insert
            $subjectKey = 'email_' . $templateType . '_subject';
            $exists = DB::table('settings')->where('key', $subjectKey)->exists();
            
            if ($exists) {
                DB::table('settings')
                    ->where('key', $subjectKey)
                    ->update(['value' => $subject, 'updated_at' => now()]);
            } else {
                DB::table('settings')->insert([
                    'key' => $subjectKey,
                    'value' => $subject,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            // Template setting - check and update/insert
            $templateKey = 'email_' . $templateType . '_template';
            $exists = DB::table('settings')->where('key', $templateKey)->exists();
            
            if ($exists) {
                DB::table('settings')
                    ->where('key', $templateKey)
                    ->update(['value' => $template, 'updated_at' => now()]);
            } else {
                DB::table('settings')->insert([
                    'key' => $templateKey,
                    'value' => $template,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        
        return redirect()->route('admin.settings')->with('success', 'Email template updated successfully.');
    }
}