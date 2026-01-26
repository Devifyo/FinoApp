<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MediaUploadController extends Controller
{
    private $pagePassword = 'Shine@123'; // change this

    public function show()
    {
        if (!Session::get('media_auth')) {
            return view('media.password');
        }

        return view('media.upload');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if ($request->password == $this->pagePassword) {
            Session::put('media_auth', true);
            return redirect()->route('media.form');
        }

        return back()->withErrors(['password' => 'Wrong password']);
    }

    public function store(Request $request)
    {
        if (!Session::get('media_auth')) {
            abort(403);
        }

        $request->validate([
            'media' => 'required|file|max:81920' // 80MB
        ]);

        $path = $request->file('media')->store('uploads/media', 'public');

        // Generate public URL
        $url = asset('storage/' . $path);

        return back()->with([
            'success' => 'File uploaded successfully!',
            'file_url' => $url,
        ]);
    }
}