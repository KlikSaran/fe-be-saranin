<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Product::select('category', 'image')->get()->unique('category');

        $profiles = User::where('id', Auth::id())->first();

        return view('public.profile.index', compact('categories', 'profiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id !== Auth::id()) {
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'gender'   => 'nullable|in:Male,Female',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->fullname = $validatedData['fullname'];
        $user->email = $validatedData['email'];
        $user->gender = $validatedData['gender'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->back()->with('profileUpdateAlert', 'Biodata Anda berhasil diperbarui!');
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->avatar = $path;
        $user->save();

        return redirect()->back()->with('avatarUpdateAlert', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
