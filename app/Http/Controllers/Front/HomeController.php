<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function register()
    {
        return view('front.register', ['title' => 'Register']);
    }
     public function store(Request $request)
    {
        // -------------------------
        // 1️⃣ VALIDATION
        // -------------------------
       
        // $validated = $request->validate([
        //     'accountType' => 'required|in:personal,organization',
        //     'fullName' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email',
        //     'phone' => 'required|string|max:20',
        //     'password' => 'required|min:6',
        //     'organization' => 'nullable|string|max:255',
        //     'idProof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB
        // ]);
//  echo 'hello';die;
        // -------------------------
        // 2️⃣ FILE UPLOAD
        // -------------------------
        $filePath = null;

        if ($request->hasFile('idProof')) {
            $file = $request->file('idProof');
            $filePath = $file->store('uploads/id_proofs', 'public');
        }

        // -------------------------
        // 3️⃣ ROLE BASED ON ACCOUNT TYPE
        // -------------------------
        $role = $request->accountType === 'organization' ? 'organisation' : 'customer';

        // -------------------------
        // 4️⃣ STORE USER
        // -------------------------
        $user = User::create([
            'name' => $request->fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'role' => $role,
            'phone_number' => $request->phone,
            'organisation_name' => $request->organization,

            // File path
            'aadhar_document' => $filePath,
        ]);
        // die('dd');
        echo $user;
        return response()->json([
            'status' => true,
            'message' => 'Account created successfully!',
            'redirect' => route('login'),
        ]);
    }
}
