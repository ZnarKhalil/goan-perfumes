import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { createRequire } from 'node:module';
import { test } from 'node:test';
import { runInNewContext } from 'node:vm';
import { createElement } from 'react';
import { renderToStaticMarkup } from 'react-dom/server';
import ts from 'typescript';

function loadTypeScript(path) {
    const source = readFileSync(new URL(path, import.meta.url), 'utf8');
    const { outputText } = ts.transpileModule(source, {
        compilerOptions: {
            module: ts.ModuleKind.CommonJS,
            target: ts.ScriptTarget.ES2022,
            jsx: ts.JsxEmit.ReactJSX,
        },
    });
    const exports = {};
    runInNewContext(outputText, {
        exports,
        require: createRequire(import.meta.url),
    });
    return exports;
}

const StoreDetails = loadTypeScript(
    '../resources/js/components/public/store-details.tsx',
).default;
const { getPublicCopy } = loadTypeScript('../resources/js/lib/public-copy.ts');
const StoreMap = loadTypeScript(
    '../resources/js/components/public/store-map.tsx',
).default;

test('map uses the official keyless embed and renders an independent fallback link', () => {
    const html = renderToStaticMarkup(
        createElement(StoreMap, {
            copy: getPublicCopy({ current: 'en' }),
        }),
    );
    assert.match(html, /src="https:\/\/www.google.com\/maps\/embed\?pb=/);
    assert.ok(html.includes('0x479fbb001131c907%3A0xe678c0ef1c318bf9'));
    assert.ok(!html.includes('key='));
    assert.match(html, /loading="lazy"/);
    assert.match(html, /referrerPolicy="strict-origin-when-cross-origin"/i);
    const outsideFrame = html.split('</iframe>')[1];
    assert.ok(outsideFrame.includes('Ludwigplatz 11, 93309 Kelheim'));
    assert.ok(
        outsideFrame.includes('https://maps.app.goo.gl/iKsFCmr1CFUeqgqr9'),
    );
    assert.ok(outsideFrame.includes('Open in Google Maps'));
});

for (const [locale, weekdays, closed] of [
    ['de', 'Montag–Samstag', 'Geschlossen'],
    ['en', 'Monday–Saturday', 'Closed'],
    ['ar', 'الاثنين–السبت', 'مغلق'],
]) {
    test(`store details render the supplied address and weekly hours in ${locale}`, () => {
        const html = renderToStaticMarkup(
            createElement(StoreDetails, {
                copy: getPublicCopy({ current: locale }),
            }),
        );
        assert.match(
            html,
            /<address[^>]*><bdi dir="ltr">Ludwigplatz 11<\/bdi><br\/><bdi dir="ltr">93309 Kelheim<\/bdi><\/address>/,
        );
        assert.ok(html.includes(weekdays));
        assert.ok(html.includes('10:00–18:00'));
        assert.ok(html.includes(closed));
    });
}
