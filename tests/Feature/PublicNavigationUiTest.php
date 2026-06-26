<?php

test('public mobile navigation keeps language switching in the header and scrolls the drawer', function () {
    $drawer = file_get_contents(resource_path('js/components/public/site-drawer.tsx'));
    $header = file_get_contents(resource_path('js/components/public/site-header.tsx'));
    $switcher = file_get_contents(resource_path('js/components/public/locale-switcher.tsx'));

    expect($drawer)
        ->not->toContain('LocaleSwitcher')
        ->toContain('onOpenAutoFocus={(event) => event.preventDefault()}')
        ->toContain('min-h-0 flex-1 overflow-y-auto overscroll-contain')
        ->and($header)
        ->toContain('<LocaleSwitcher')
        ->toContain('<div className="block">')
        ->and($switcher)
        ->toContain('currentLocale.code.toUpperCase()')
        ->toContain('item.code.toUpperCase()')
        ->toContain('min-w-[3.75rem]')
        ->not->toContain('<span>{currentLocale.native_label}</span>')
        ->not->toContain('<span>{item.native_label}</span>');
});
