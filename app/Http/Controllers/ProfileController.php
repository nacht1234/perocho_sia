<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Customer;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $customer = $user->customer;

        return view('profile.edit', [
            'user' => $user,
            'customer' => $customer,
        ]);
    }

    /**
     * Update user and customer profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validate input including customer fields
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],         // User name & Customer name
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', 'min:8'],    // optional password update
            'avatar' => ['nullable', 'image', 'max:2048'],

            // Customer fields
            'age' => ['required', 'integer', 'min:1'],
            'gender' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        // Update user fields
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update or create related customer info
        $customerData = [
            'name' => $validated['name'],  // Use same name for customer record
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'user_id' => $user->id,
        ];

        Customer::updateOrCreate(
            ['user_id' => $user->id],
            $customerData
        );

        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    /**
     * Delete user account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
