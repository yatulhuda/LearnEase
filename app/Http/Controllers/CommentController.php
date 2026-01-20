<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // --- List of banned words ---
    private $bannedWords = ['loser', 'nonsense', 'dummy', 'silly', 'annoying'];

    /**
     * Store a new comment or reply
     */
    public function store(Request $request, Discussion $discussion)
    {
        $request->validate([
            'comment' => 'required|max:500',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $commentText = $request->comment;

        // 1. Content filtering: banned words
        foreach ($this->bannedWords as $word) {
            if (stripos($commentText, $word) !== false) {
                return redirect()->back()->with('error', 'Your comment contains inappropriate language.');
            }
        }

        // 2. Content filtering: block any URL
        if (preg_match('/\b((https?:\/\/)|(www\.))\S+/i', $commentText)) {
            return redirect()->back()->with('error', 'Links are not allowed in comments.');
        }

        // 3. Escape HTML to prevent XSS
        $commentText = e($commentText);

        // 4. Save comment
        Comment::create([
            'discussion_id' => $discussion->id,
            'user_id'       => Auth::id(),
            'comment'       => $commentText,
            'parent_id'     => $request->parent_id
        ]);

        return redirect()->route('discussions.show', $discussion->id)
                         ->with('success', 'Comment posted successfully!');
    }

    /**
     * Show edit comment page
     */
    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update a comment
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required|max:500',
        ]);

        $commentText = $request->comment;

        // 1. Content filtering: banned words
        foreach ($this->bannedWords as $word) {
            if (stripos($commentText, $word) !== false) {
                return redirect()->back()->with('error', 'Your comment contains inappropriate language.');
            }
        }

        // 2. Content filtering: block any URL
        if (preg_match('/\b((https?:\/\/)|(www\.))\S+/i', $commentText)) {
            return redirect()->back()->with('error', 'Links are not allowed in comments.');
        }

        // 3. Escape HTML
        $commentText = e($commentText);

        // 4. Update comment
        $comment->update([
            'comment' => $commentText,
        ]);

        return redirect()->route('discussions.show', $comment->discussion_id)
                         ->with('success', 'Comment updated successfully!');
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment)
    {
        $discussionId = $comment->discussion_id;
        $comment->delete();

        return redirect()->route('discussions.show', $discussionId)
                         ->with('success', 'Comment deleted successfully!');
    }
}
