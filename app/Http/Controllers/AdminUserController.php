<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Leader;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leaders = Leader::all();
        $categories = Category::all();
        $countries = Country::all();
        return view('admin.users.create', compact('leaders', 'categories', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|in:citizen,leader,admin',
            'country_id' => 'nullable',
            'region_id' => 'nullable',
            'district_id' => 'nullable',
            'ward_id' => 'nullable',
            'street_id' => 'nullable',
            'leader_id' => 'nullable|exists:leaders,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'street_id' => $request->street_id,
            'leader_id' => $request->leader_id, 
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        $user = User::with(['country', 'region', 'district', 'ward', 'street'])->find($userId);

        if (!$user) {
            abort(404); 
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $leaders = Leader::all();
        $categories = Category::all();
        $countries = Country::all();
        $regions = Region::all();
        $districts = District::all();
    
        return view('admin.users.edit', compact('user', 'leaders', 'categories', 'countries', 'regions', 'districts'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed',
            'role' => 'required|in:citizen,leader,admin',
            'country_id' => 'nullable',
            'region_id' => 'nullable',
            'district_id' => 'nullable',
            'ward_id' => 'nullable',
            'street_id' => 'nullable',
            'leader_id' => 'nullable|exists:leaders,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Filter out empty values
        $data = array_filter($request->only([
            'name', 'email', 'password', 'role',
            'country_id', 'region_id', 'district_id',
            'ward_id', 'street_id', 'leader_id', 'category_id'
        ]), function ($value) {
            return $value !== null && $value !== '';
        });

        // Hash the password if it's provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
