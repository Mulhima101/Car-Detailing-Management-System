<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;

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
        
        // Use the fill and save methods instead of update
        $user->fill($validated);
        $user->save();
        
        return redirect()->route('admin.settings.index')->with('success', 'Profile updated successfully.');
    }
    
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Set the password and save manually
        $user->password = Hash::make($validated['password']);
        $user->save();
        
        return redirect()->route('admin.settings.index')->with('success', 'Password changed successfully.');
    }
    
    public function updateNotifications(Request $request)
    {
        $settings = [
            'notification_status_updates' => $request->has('notification_status_updates') ? '1' : '0',
            'notification_completion_reminders' => $request->has('notification_completion_reminders') ? '1' : '0',
            'notification_marketing_emails' => $request->has('notification_marketing_emails') ? '1' : '0',
        ];
        
        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            } else {
                $setting = new Setting();
                $setting->key = $key;
                $setting->value = $value;
                $setting->save();
            }
        }
        
        return redirect()->route('admin.settings.index')->with('success', 'Notification settings updated successfully.');
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
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            } else {
                $setting = new Setting();
                $setting->key = $key;
                $setting->value = $value;
                $setting->save();
            }
        }
        
        // Update config values at runtime
        config(['autox.reminder_days' => $validated['reminder_days']]);
        
        return redirect()->route('admin.settings.index')->with('success', 'System settings updated successfully.');
    }
    
    public function updateEmailTemplates(Request $request)
    {
        $templateType = $request->input('template_type');
        $subject = $request->input('subject');
        $template = $request->input('template');
        
        if ($templateType) {
            // Update or create subject setting
            $subjectSetting = Setting::where('key', 'email_' . $templateType . '_subject')->first();
            
            if ($subjectSetting) {
                $subjectSetting->value = $subject;
                $subjectSetting->save();
            } else {
                $subjectSetting = new Setting();
                $subjectSetting->key = 'email_' . $templateType . '_subject';
                $subjectSetting->value = $subject;
                $subjectSetting->save();
            }
            
            // Update or create template setting
            $templateSetting = Setting::where('key', 'email_' . $templateType . '_template')->first();
            
            if ($templateSetting) {
                $templateSetting->value = $template;
                $templateSetting->save();
            } else {
                $templateSetting = new Setting();
                $templateSetting->key = 'email_' . $templateType . '_template';
                $templateSetting->value = $template;
                $templateSetting->save();
            }
        }
        
        return redirect()->route('admin.settings.index')->with('success', 'Email template updated successfully.');
    }
}