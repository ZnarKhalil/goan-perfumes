import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { test } from 'node:test';
import { runInNewContext } from 'node:vm';
import ts from 'typescript';

function loadAnalytics(measurementId) {
    const cookies = [];
    let removedScripts = 0;
    const document = {
        getElementById: () => ({ remove: () => removedScripts++ }),
        set cookie(value) {
            cookies.push(value);
        },
    };
    const window = { location: { hostname: 'example.test' } };
    const exports = {};
    const source = readFileSync(
        new URL('../resources/js/lib/google-analytics.ts', import.meta.url),
        'utf8',
    ).replaceAll('import.meta.env', 'testEnv');
    const { outputText } = ts.transpileModule(source, {
        compilerOptions: {
            module: ts.ModuleKind.CommonJS,
            target: ts.ScriptTarget.ES2022,
        },
    });

    runInNewContext(outputText, {
        exports,
        require: () => ({ router: {} }),
        testEnv: { VITE_GOOGLE_ANALYTICS_MEASUREMENT_ID: measurementId },
        window,
        document,
    });

    return {
        analytics: exports,
        cookies,
        window,
        removedScripts: () => removedScripts,
    };
}

for (const measurementId of [undefined, '']) {
    test(`analytics cleanup works with ${String(measurementId)} configuration`, () => {
        const { analytics, cookies, removedScripts } =
            loadAnalytics(measurementId);
        assert.doesNotThrow(() => {
            analytics.scheduleGoogleAnalytics();
            analytics.initializeGoogleAnalytics();
            analytics.disableGoogleAnalytics();
            analytics.disableGoogleAnalytics();
        });
        assert.equal(removedScripts(), 2);
        assert.ok(cookies.every((cookie) => cookie.startsWith('_ga=;')));
    });
}

test('configured analytics cleanup disables tracking and clears both cookies', () => {
    const { analytics, cookies, window } = loadAnalytics('G-EXAMPLE');
    analytics.disableGoogleAnalytics();
    assert.equal(window['ga-disable-G-EXAMPLE'], true);
    assert.ok(cookies.some((cookie) => cookie.startsWith('_ga=;')));
    assert.ok(cookies.some((cookie) => cookie.startsWith('_ga_EXAMPLE=;')));
});
