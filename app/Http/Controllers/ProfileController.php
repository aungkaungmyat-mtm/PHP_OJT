<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function register(ProfileRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'type'=> $request->type,
            'dob' => $request->dob,
            'address' => $request->address,
            'profile' => 'profile.svg',
            'create_user_id' => $request->create_user_id,
            'updated_user_id' => $request->updated_user_id,
        ]);

        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $ext = $image->extension();
            $fileName = $user->name . '_' . time() . '.' . $ext;
            $image->storeAs('public/profile_images', $fileName);
            $user->profile = $fileName;  
        }

        $user->save();

        return Redirect::route('dashboard')->with('status', 'Profile registered successfully.');
    }

    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): Response
    // {
    //     return Inertia::render('Profile/Edit', [
    //         'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
    //         'status' => session('status'),
    //         'profile' => $request->user()->profile,
    //     ]);
    // }

    // /**
    //  * Update the user's profile information.
    //  */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    
    //     $user = $request->user();
    
    //     if ($request->hasFile('profile')) {
    //         $image = $request->file('profile');
    //         $ext = $image->extension();
    //         $fileName = $user->name . '_' . time() . '.' . $ext;
    //         $image->storeAs('public/profile_images', $fileName);
    //         $user->profile = $fileName; 
    //         if (Storage::disk('public')->exists('profile_images/' . $request->input('old_image'))) {
	// 			// Delete the file
	// 			Storage::disk('public')->delete('profile_images/' . $request->input('old_image'));
	// 		}
    //     }
    
    //     if ($user->isDirty('email')) {
    //         $user->email_verified_at = null;
    //     }
    
    //     $user->save();
    
    //     return Redirect::route('profile.edit')->with('status', 'Profile updated successfully.');
    // }
    

    // /**
    //  * Delete the user's account.
    //  */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     if ($user->profile && Storage::disk('public')->exists('profile_images/' . $user->profile)) {
    //         Storage::disk('public')->delete('profile_images/' . $user->profile);
    //     }
    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
