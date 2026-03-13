<?php

namespace App\Translators;

use App\Services\AutoTranslationService;
use Illuminate\Translation\Translator;

class AutoTranslator extends Translator
{
    protected ?AutoTranslationService $autoService = null;

    public function setAutoTranslationService(AutoTranslationService $service): void
    {
        $this->autoService = $service;
    }

    /**
     * Override get() — jika terjemahan tidak ditemukan, otomatis terjemahkan.
     */
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $result = parent::get($key, $replace, $locale, $fallback);

        $targetLocale = $locale ?? $this->getLocale();
        if ($this->autoService === null) {
            return $result;
        }

        /**
         * SKENARIO 1: Key tidak ditemukan di locale saat ini (result === key)
         */
        if (is_string($result) && $result === $key && !empty(trim($key))) {
            $enValue = parent::get($key, [], 'en');
            $textToTranslate = ($enValue !== $key) ? $enValue : $key;

            $translated = $this->autoService->translate($textToTranslate, $targetLocale);
            if ($translated !== $textToTranslate) {
                return $this->makeReplacements($translated, $replace);
            }
        }

        /**
         * SKENARIO 2: Terjemahan ditemukan tapi via Fallback English (isinya masih bahasa Inggris)
         * Sekarang mendung semua bahasa tanpa kecuali.
         */
        if (is_string($result)) {
            $translated = $this->autoService->translate($result, $targetLocale);
            if ($translated !== $result) {
                return $this->makeReplacements($translated, $replace);
            }
        }

        return $result;
    }
}
