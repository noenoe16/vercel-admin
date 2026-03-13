<?php

namespace App\Livewire\Messages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\CanMarkAsRead;
use App\Livewire\Traits\CanValidateFiles;
use App\Livewire\Traits\HasPollInterval;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use App\Models\Inbox as InboxModel;
use App\Filament\Pages\MessagesPage;

class Inbox extends Component implements HasActions, HasForms
{
    use CanMarkAsRead, CanValidateFiles, HasPollInterval, InteractsWithActions, InteractsWithForms;

    public $conversations;

    public $selectedConversation;

    public function mount(): void
    {
        $this->setPollInterval();
        $this->loadConversations();
    }

    public function unreadCount(): int
    {
        return InboxModel::whereJsonContains('user_ids', Auth::id())
            ->whereHas('messages', function ($query) {
                $query->whereJsonDoesntContain('read_by', Auth::id());
            })->get()->count();
    }

    #[On('refresh-inbox')]
    public function loadConversations(): void
    {
        $this->conversations = Auth::user()->allConversations()->get();
        $this->markAsRead();
    }

    public function createConversationAction(): Action
    {
        return Action::make('createConversation')
            ->icon('heroicon-o-plus')
            ->label(__('Create'))
            ->form([
                Forms\Components\Select::make('user_ids')
                    ->label(__('Select User(s)'))
                    ->options(fn () => User::all()->pluck('name', 'id'))
                    ->multiple()
                    ->preload(false)
                    ->searchable()
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('title')
                    ->label(__('Group Name'))
                    ->visible(function (Forms\Get $get) {
                        return collect($get('user_ids'))->count() > 1;
                    }),
                Forms\Components\Textarea::make('message')
                    ->placeholder(__('Write a message...'))
                    ->required()
                    ->autosize(),
            ])
            ->modalHeading(__('Create New Message'))
            ->modalSubmitActionLabel(__('Send'))
            ->modalWidth(MaxWidth::Large)
            ->action(function (array $data) {
                $userIds = collect($data['user_ids'])->push(Auth::id())->map(fn ($userId) => (int) $userId)->unique()->sort()->values();
                $totalUserIds = $userIds->count();

                /** @var InboxModel|null $inbox */
                $inbox = InboxModel::query()
                    ->whereJsonContains('user_ids', $userIds->toArray())
                    ->whereRaw('JSON_LENGTH(user_ids) = ?', [$totalUserIds])
                    ->when($data['title'] ?? null, function ($query, $title) {
                        return $query->where('title', $title);
                    })
                    ->when(! ($data['title'] ?? null), function ($query) {
                        return $query->whereNull('title');
                    })
                    ->first();

                $inboxId = null;
                if (! $inbox) {
                    $inbox = InboxModel::create([
                        'title' => $data['title'] ?? null,
                        'user_ids' => $userIds,
                    ]);
                    $inboxId = $inbox->getKey();
                } else {
                    /** @var InboxModel $inbox */
                    $inbox->updated_at = now();
                    $inbox->save();
                    $inboxId = $inbox->getKey();
                }
                $inbox->messages()->create([
                    'message' => $data['message'],
                    'user_id' => Auth::id(),
                    'read_by' => [Auth::id()],
                    'read_at' => [now()],
                    'notified' => [Auth::id()],
                ]);
                
                return redirect()->to(MessagesPage::getUrl(['id' => $inboxId]));
            })->extraAttributes([
                'class' => 'w-full',
            ]);
    }

    public function deleteConversation(int $id)
    {
        /** @var InboxModel|null $inbox */
        $inbox = InboxModel::find($id);

        if ($inbox && in_array(Auth::id(), $inbox->user_ids)) {
            $inbox->delete();

            \Filament\Notifications\Notification::make()
                ->title(__('Conversation deleted'))
                ->success()
                ->send();

            return $this->redirect(MessagesPage::getUrl());
        }
    }

    public function render(): Application|Factory|View|\Illuminate\View\View
    {
        return view('livewire.messages.inbox');
    }
}
