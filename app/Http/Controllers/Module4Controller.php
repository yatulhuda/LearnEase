<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage; // Needed for file operations

// Import Models
use App\Models\Announcement;
use App\Models\CourseMaterial;

class Module4Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // =========================================================
    // SECTION A: TEACHER PORTAL FUNCTIONS (Blue View)
    // =========================================================

    public function dashboard()
    {
        $announcements = Announcement::latest()->get();
        // Loads: resources/views/teacherView/dashboard.blade.php
        return view('teacherView.dashboard', compact('announcements'));
    }

    public function subjects()
    {
        $subjects = [
            ['id' => 'MATH-101', 'name' => 'Mathematics', 'color' => '#3b82f6'],
            ['id' => 'SCI-202',  'name' => 'Science',     'color' => '#10b981'],
            ['id' => 'ENG-303',  'name' => 'English',     'color' => '#f59e0b'],
        ];
        // Loads: resources/views/teacherView/subject.blade.php
        return view('teacherView.subject', compact('subjects'));
    }

    public function mathematics()
    {
        $materials = CourseMaterial::where('subject_code', 'MATH-101')
                                   ->get()
                                   ->groupBy('week_title');

        // Loads: resources/views/teacherView/mathematic.blade.php
        return view('teacherView.mathematic', compact('materials'));
    }

    // --- TEACHER ACTIONS (Add/Edit/Delete) ---

    public function storeAnnouncement(Request $request)
    {
        $request->validate(['content' => 'required|string|min:5|max:200']);
        Announcement::create(['content' => strip_tags($request->input('content'))]);
        return redirect()->back()->with('success', 'Announcement posted.');
    }

    public function deleteAnnouncement($id)
    {
        Announcement::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Announcement deleted.');
    }

    public function storeMaterial(Request $request)
    {
        $request->validate([
            'week_title' => 'required|string|max:50',
            'title'      => 'required|string|min:3|max:100',
            'description'=> 'nullable|string|max:255',
            'file_upload'=> 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240', 
        ]);

        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $filePath = $request->file('file_upload')->store('materials', 'public');
        }

        CourseMaterial::create([
            'subject_code' => 'MATH-101',
            'week_title'   => strip_tags($request->week_title),
            'title'        => strip_tags($request->title),
            'description'  => strip_tags($request->description),
            'type'         => 'file',
            'file_path'    => $filePath
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function updateMaterial(Request $request, $id)
    {
        $request->validate([
            'week_title' => 'required|string|max:50',
            'title'      => 'required|string|min:3|max:100',
            'description'=> 'nullable|string|max:255',
        ]);

        CourseMaterial::findOrFail($id)->update([
            'week_title'  => strip_tags($request->week_title),
            'title'       => strip_tags($request->title),
            'description' => strip_tags($request->description),
        ]);

        return redirect()->back()->with('success', 'Material updated.');
    }

    public function deleteMaterial($id)
    {
        $material = CourseMaterial::findOrFail($id);
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        return redirect()->back()->with('success', 'Material removed.');
    }

    // =========================================================
    // SECTION B: STUDENT PORTAL FUNCTIONS (Green "Stud" View)
    // =========================================================

    public function studentDashboard()
    {
        // Students see the same announcements as teachers
        $announcements = Announcement::latest()->get();
        
        // Loads: resources/views/studView/dashboardStud.blade.php
        return view('studView.dashboardStud', compact('announcements'));
    }

    public function studentSubjects()
    {
        $subjects = [
            ['id' => 'MATH-101', 'name' => 'Mathematics', 'color' => '#3b82f6'],
            ['id' => 'SCI-202',  'name' => 'Science',     'color' => '#10b981'],
            ['id' => 'ENG-303',  'name' => 'English',     'color' => '#f59e0b'],
        ];

        // Loads: resources/views/studView/subjectStud.blade.php
        return view('studView.subjectStud', compact('subjects'));
    }

    public function studentMath()
    {
        // Fetch materials (Read-Only for students)
        $materials = CourseMaterial::where('subject_code', 'MATH-101')
                                   ->get()
                                   ->groupBy('week_title');

        // Loads: resources/views/studView/mathematicStud.blade.php
        return view('studView.mathematicStud', compact('materials'));
    }

    // =========================================================
    // SECTION C: SHARED FUNCTIONS
    // =========================================================

    public function downloadMaterial($id)
    {
        $material = CourseMaterial::findOrFail($id);
        
        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            return redirect()->back()->with('error', 'File not found on server.');
        }

        $extension = pathinfo($material->file_path, PATHINFO_EXTENSION);
        $downloadName = $material->title . '.' . $extension;

        return Storage::disk('public')->download($material->file_path, $downloadName);
    }
}