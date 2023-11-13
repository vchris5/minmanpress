<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Resume;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResumeSubmitted;

class ResumeController extends Controller
{
    public function index()
    {
        return inertia('Resume/ResumeForm');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'resume' => 'required|mimes:pdf|max:2048',
        ]);

        $resumePath = $request->file('resume')->store('resumes');

        // URL for the resume
        $resumeUrl = Storage::url($resumePath);

        Resume::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'resume_path' => $resumePath,
        ]);

        // sending email to admin
        // replace with your admin email
        $adminEmail = 'admin@example.com';
        Mail::to($adminEmail)->send(new ResumeSubmitted($request->input('name'), $resumeUrl));

        return redirect()->route('resume.create')->with('success', 'Thank you for your submission!');
    }
}
