<?php

declare(strict_types=1);

namespace App\Http\Livewire\Hostel;

use App\Models\Comment;
use App\Models\Hostel;
use Auth;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;

class Comments extends Component
{
    use AuthorizesRequests;

    public Hostel $hostel;
    public string $content = '';
    public ?string $reply = null;

    protected array $rules = [
        'content' => ['required', 'min:3'],
    ];

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
    }

    public function replyComment(int $id): void
    {
        $this->authorize('create', [Comment::class, $this->hostel]);

        $this->validate([
            'reply' => 'required|string',
        ]);
        Comment::create([
            'content' => $this->reply,
            'owner_id' => Auth::id(),
            'parent_id' => $id,
            'hostel_id' => $this->hostel->id,
        ]);
        $this->reply = '';
        $this->hostel->load('comments.children.owner');
    }

    public function submit(): void
    {
        $this->validate();
        $this->authorize('create', [Comment::class, $this->hostel]);

        Comment::create([
            'content' => $this->content,
            'hostel_id' => $this->hostel->id,
            'owner_id' => auth()->id(),
        ]);

        $this->content = '';
        Notification::make()
            ->success()
            ->title('Bình luận thành công')
            ->send()
        ;
        $this->hostel->load('comments.owner');
    }

    public function render(): View
    {
        $comments = Comment::with('owner', 'children.owner')
            ->where('hostel_id', $this->hostel->id)
            ->where('parent_id', null)
            ->orderBy('created_at', 'desc')
            ->paginate(6)
        ;

        return view('livewire.hostel.comments', [
            'comments' => $comments,
        ]);
    }
}
