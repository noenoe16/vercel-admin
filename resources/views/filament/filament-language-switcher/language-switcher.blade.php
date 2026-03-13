@php
    $currentLocale = app()->getLocale();
    $locals = config('filament-language-switcher.locals');
    $currentFlag = $locals[$currentLocale]['flag'] ?? 'us';
@endphp

<div x-data="{
        toggle: function (event) {
            $refs.panel.toggle(event)
        },
        open: function (event) {
            $refs.panel.open(event)
        },
        close: function (event) {
            $refs.panel.close(event)
        },
    }"
    class="relative"
>
    {{-- Trigger Button --}}
    <button
        type="button"
        id="filament-language-switcher"
        x-on:click="toggle"
        @class([
            'flex items-center justify-center rounded-lg transition hover:bg-gray-500/5 focus:bg-gray-500/5 dark:hover:bg-white/5 dark:focus:bg-white/5',
            'w-10 h-10',
        ])
        x-tooltip="{
            content: '{{ __('Change Language') }}',
            theme: $store.theme,
        }"
    >
        <div
            class="w-7 h-5 bg-cover bg-center rounded-sm shadow-sm border border-gray-200 dark:border-gray-700"
            style="background-image: url('https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{ $currentFlag }}.svg')"
        ></div>
    </button>

    {{-- Dropdown Panel --}}
    <div
        x-ref="panel"
        x-float.placement.bottom-end.flip.offset="{ offset: 8 }"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:leave-end="opacity-0 scale-95"
        class="ffi-dropdown-panel absolute z-9999 min-w-[200px] divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-gray-950/5 transition dark:divide-white/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden"
        style="display: none;"
    >
        <div class="filament-dropdown-list p-1 max-h-64 overflow-y-auto w-full scrollbar-thin">
            @foreach ($locals as $key => $language)
                @php $isCurrent = $currentLocale === $key; @endphp
                <a
                    @if (!$isCurrent)
                        href="{{ route('lang.switch', ['lang' => $key]) }}"
                    @else
                        href="javascript:void(0)"
                    @endif
                    @class([
                        'filament-dropdown-list-item filament-dropdown-item group flex items-center justify-between gap-3 whitespace-nowrap rounded-md p-2 text-sm outline-none',
                        'text-gray-500 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 focus:bg-gray-50 dark:focus:bg-white/5' => !$isCurrent,
                        'bg-gray-50 dark:bg-white/5 text-primary-600 dark:text-primary-400 font-semibold cursor-default' => $isCurrent,
                    ])
                >
                    {{-- Label --}}
                    <span class="truncate flex-1 text-start">
                        {{ __($language['label']) }}
                    </span>

                    {{-- Flag --}}
                    <div
                        class="w-6 h-4 shrink-0 bg-cover bg-center rounded-sm border border-gray-200 dark:border-gray-700 shadow-sm"
                        style="background-image: url('https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{ $language['flag'] }}.svg'); background-repeat: no-repeat"
                    ></div>
                </a>
            @endforeach
        </div>
    </div>
</div>
