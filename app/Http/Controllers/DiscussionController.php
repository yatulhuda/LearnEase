<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    // --- List of banned words ---
    private $bannedWords = ['loser', 'nonsense', 'dummy', 'silly', 'annoying'];

    // ==============================
    // Display list of discussions
    // ==============================
    public function index()
    {
        $discussions = Discussion::with('user')
            ->withCount('comments')
            ->latest()
            ->paginate(10);

        return view('discussions.index', compact('discussions'));
    }

    // ==============================
    // Show create discussion page
    // ==============================
    public function create()
    {
        return view('discussions.create');
    }

    // ==============================
    // Store new discussion
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'required|string|min:10|max:1000',
        ]);

        $title   = strip_tags($request->title);
        $content = strip_tags($request->content);

        // --- Check for banned words ---
        if ($this->containsInappropriateContent($title) || $this->containsInappropriateContent($content)) {
            return back()->withInput()->with('error', 'Your discussion contains inappropriate language.');
        }

        // --- Check for malicious links ---
        if ($this->containsMaliciousLinks($title) || $this->containsMaliciousLinks($content)) {
            return back()->withInput()->with('error', 'Links or scripts are not allowed.');
        }

        // --- Save discussion ---
        Discussion::create([
            'title'   => $title,
            'content' => $content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('discussions.index')->with('success', 'Discussion created successfully!');
    }

    // ==============================
    // Show single discussion
    // ==============================
    public function show(Discussion $discussion)
    {
        $discussion->load('comments.user', 'user');
        return view('discussions.show', compact('discussion'));
    }

    // ==============================
    // Edit discussion
    // ==============================
    public function edit(Discussion $discussion)
    {
        return view('discussions.edit', compact('discussion'));
    }

    // ==============================
    // Update discussion
    // ==============================
    public function update(Request $request, Discussion $discussion)
    {
        $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'required|string|min:10|max:1000',
        ]);

        $title   = strip_tags($request->title);
        $content = strip_tags($request->content);

        if ($this->containsInappropriateContent($title) || $this->containsInappropriateContent($content)) {
            return back()->with('error', 'Your discussion contains inappropriate language.');
        }

        if ($this->containsMaliciousLinks($title) || $this->containsMaliciousLinks($content)) {
            return back()->with('error', 'Links or scripts are not allowed.');
        }

        $discussion->update([
            'title'   => $title,
            'content' => $content,
        ]);

        return redirect()->route('discussions.index')->with('success', 'Discussion updated successfully!');
    }

    // ==============================
    // Delete discussion
    // ==============================
    public function destroy(Discussion $discussion)
    {
        $discussion->delete();
        return redirect()->route('discussions.index')->with('success', 'Discussion deleted successfully!');
    }

    // ==============================
    // Helper: check banned words
    // ==============================
    private function containsInappropriateContent($text)
    {
        foreach ($this->bannedWords as $word) {
            if (stripos($text, $word) !== false) {
                return true;
            }
        }
        return false;
    }

    // ==============================
    // Helper: check malicious links
    // ==============================
    private function containsMaliciousLinks($text)
    {
        $patterns = [
            '/https?:\/\/\S+/i',   // any http/https link
            '/www\.\S+/i',          // www links
            '/<script>/i',          // inline scripts
            '/javascript:/i'        // javascript pseudo-protocol
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text)) {
                return true;
            }
        }

        return false;
    }
}
