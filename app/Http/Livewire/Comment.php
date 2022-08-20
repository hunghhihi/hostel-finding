<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Comment as ModelsComment;
use App\Models\Hostel;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Comment extends Component
{
    use WithPagination;
    public Hostel $hostel;
    public $data;
    public $comment;
    public $reply;

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
    }

    public function create_comment(): void
    {
        $this->validate([
            'comment' => 'required|string',
        ]);
        ModelsComment::create([
            'content' => $this->comment,
            'owner_id' => Auth::id(),
            'hostel_id' => $this->hostel->id,
        ]);
        $this->comment = '';
        $this->reload_hostel();
    }

    public function reply_comment($id): void
    {
        $this->validate([
            'reply' => 'required|string',
        ]);
        ModelsComment::create([
            'content' => $this->reply,
            'owner_id' => Auth::id(),
            'parent_id' => $id,
            'hostel_id' => $this->hostel->id,
        ]);
        $this->reply = '';
        $this->reload_hostel();
    }

    public function reload_hostel(): void
    {
        $this->hostel = Hostel::find($this->hostel->id);
        $comments = ModelsComment::where('hostel_id', $this->hostel->id)->where('parent_id', null)->orderBy('created_at', 'desc')->with('owner', 'parent', 'children')->paginate(6);
        foreach ($comments as $comment) {
            $comment->children->load('owner', 'parent', 'children');
        }
    }

    public function render()
    {
        $comments = ModelsComment::where('hostel_id', $this->hostel->id)->where('parent_id', null)->orderBy('created_at', 'desc')->with('owner', 'parent', 'children')->paginate(6);
        foreach ($comments as $comment) {
            $comment->children->load('owner', 'parent', 'children');
        }

        return view('livewire.comment', [
            'comments' => $comments,
        ]);
    }
}
