<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Comment as ModelsComment;
use App\Models\Hostel;
use App\Models\Vote;
use Auth;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Comment extends Component
{
    use WithPagination;
    public Hostel $hostel;
    public mixed $count_comment = null;
    public mixed $data = null;
    public ?string $comment = null;
    public ?string $reply = null;

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
    }

    public function createComment(): void
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
        $this->reloadHostel();
    }

    public function createVote(int $score): void
    {
        $score = $score / 5;
        Vote::create([
            'score' => $score,
            'owner_id' => Auth::id(),
            'hostel_id' => $this->hostel->id,
        ]);
        Notification::make()
            ->title('Đánh giá thành công')
            ->success()
            ->body('Cảm ơn bạn đã đánh giá')
            ->send()
        ;
        $this->reloadHostel();
    }

    public function replyComment(int $id): void
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
        $this->reloadHostel();
    }

    public function reloadHostel(): void
    {
        $this->hostel = Hostel::find($this->hostel->id);
        $this->hostel->loadAggregate('votes', 'score', 'avg')->loadCount('votes', 'comments');
        $comments = ModelsComment::with('owner', 'children.owner')
            ->where('hostel_id', $this->hostel->id)
            ->where('parent_id', null)
            ->orderBy('created_at', 'desc')
            ->paginate(6)
        ;
    }

    public function render(): View
    {
        $comments = ModelsComment::with('owner', 'children.owner')
            ->where('hostel_id', $this->hostel->id)
            ->where('parent_id', null)
            ->orderBy('created_at', 'desc')
            ->paginate(6)
        ;

        return view('livewire.comment', [
            'comments' => $comments,
        ]);
    }
}
