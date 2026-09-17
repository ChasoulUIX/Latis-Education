<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return response('Profile Index');
    }

    public function update(Request $request)
    {
        return response('Update Profile');
    }
}
