<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: Implement search functionality for users and products in the future.

        $comments = Comment::latest()->paginate(10);
        return view('admin.comments.index', compact('comments'));
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
    public function show(Comment $comment)
    {
        return view('admin.comments.show', compact('comment'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'دیدگاه با موفقیت حذف شد.');
    }

    /**
     * Change the approval status of a comment.
     *
     * This method toggles the approval status (approved or not approved) of a comment.
     * If the current status is approved, it updates to not approved and vice versa.
     * It also sets an appropriate approval message based on the new status to display a success message after the operation.
     *
     * @param Comment $comment The comment object whose approval status needs to be changed.
     * @return RedirectResponse Redirects back with a success message.
     */
    public function changeApprovalStatus(Comment $comment)
    {
        if ($comment->getRawOriginal('approved')) {
            $comment->update([
                'approved' => false
            ]);

            $approvalText = 'عدم تایید';
        } else {
            $comment->update([
                'approved' => true
            ]);

            $approvalText = 'تایید';
        }

        return redirect()->back()->with('success', "{$approvalText} دیدگاه با موفقیت انجام شد");
    }

}
