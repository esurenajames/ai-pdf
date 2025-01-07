<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('avatar')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }

            // Store new file
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->profile_picture = $avatarPath;
        }

        // Update name
        $user->name = $validated['name'];
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
