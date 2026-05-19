<?php

test('returns a successful response', function () {
    $response = $this->get('/de');

    $response->assertOk();
});
