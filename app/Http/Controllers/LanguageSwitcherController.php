<?php

namespace App\Http\Controllers;

use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\UserLanguage;

class LanguageSwitcherController
{
    public function index(Request $request): RedirectResponse
    {
        $request->validate([
            'lang' => 'required|string',
            'model' => 'required|string',
            'model_id' => 'required',
        ]);

        $lang = $request->get('lang');
        $modelClass = $request->get('model');
        $modelId = $request->get('model_id');

        // Menggunakan ORM untuk mencari model target secara dinamis
        $targetModel = $modelClass::findOrFail($modelId);

        // Jika tabel model memiliki kolom 'lang', update langsung (Eloquent Way)
        if (Schema::hasColumn($targetModel->getTable(), 'lang')) {
            $targetModel->update(['lang' => $lang]);
        } else {
            // Jika tidak, simpan ke tabel UserLanguage menggunakan updateOrCreate (Standard ORM)
            UserLanguage::updateOrCreate(
                [
                    'model_type' => $targetModel->getMorphClass(),
                    'model_id'   => $modelId,
                ],
                ['lang' => $lang]
            );
        }

        Notification::make()
            ->title(trans('filament-language-switcher::translation.notification', locale: $request->get('lang')))
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();

        if (config('filament-language-switcher.redirect') === 'next') {
            return back();
        }

        return redirect()->to(config('filament-language-switcher.redirect'));
    }
}

