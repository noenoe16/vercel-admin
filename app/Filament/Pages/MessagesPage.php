<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use App\Models\Inbox;

class MessagesPage extends Page
{
    protected static string $view = 'filament.pages.messages';

    public ?Inbox $selectedConversation;

    public static function getSlug(): string
    {
        return config('messages.slug', 'messages') . '/{id?}';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('messages.navigation.show_in_menu', true);
    }

    public static function getNavigationGroup(): ?string
    {
        return __(config('messages.navigation.navigation_group'));
    }

    public static function getNavigationLabel(): string
    {
        return __(config('messages.navigation.navigation_label', 'Messages'));
    }

    public static function getNavigationBadge(): ?string
    {
        if (config('messages.navigation.navigation_display_unread_messages_count')) {
            return Inbox::whereJsonContains('user_ids', Auth::id())
            ->whereHas('messages', function ($query) {
                $query->whereJsonDoesntContain('read_by', Auth::id());
            })->get()->count();
        }

        return parent::getNavigationBadge();
    }

    public static function getNavigationIcon(): string | Htmlable | null
    {
        return config('messages.navigation.navigation_icon', 'heroicon-o-chat-bubble-left-right');
    }

    public static function getNavigationSort(): ?int
    {
        return config('messages.navigation.navigation_sort');
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->selectedConversation = Inbox::findOrFail($id);
        }
    }

    public function getTitle(): string
    {
        return __(config('messages.navigation.navigation_label', 'Messages'));
    }

    public function getMaxContentWidth(): MaxWidth | string | null
    {
        return config('messages.max_content_width', MaxWidth::Full);
    }

    public function getHeading(): string | Htmlable
    {
        return __('Messages');
    }
}
