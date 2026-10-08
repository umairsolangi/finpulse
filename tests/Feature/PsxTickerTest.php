<?php

test('home page renders psx live stock ticker bar with key indices and stocks', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('id="psx-ticker-bar"', false);
    $response->assertSee('PSX LIVE');
    $response->assertSee('KSE-100');
    $response->assertSee('KMI-30');
    $response->assertSee('OGDC');
    $response->assertSee('ENGRO');
    $response->assertSee('MCB');
    $response->assertSee('psx-ticker-track');
});
