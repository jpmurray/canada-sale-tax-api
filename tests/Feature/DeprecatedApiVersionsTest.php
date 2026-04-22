<?php

/**
 * Tests that v1 and v2 API routes are permanently blocked after their sunset
 * dates have passed, returning HTTP 410 Gone with the required RFC-aligned
 * headers (Deprecation, Sunset, Link).
 */

it('blocks v1 federal GST route with 410 Gone', function () {
    $response = $this->getJson('/v1/federal/gst');

    $response->assertStatus(410)
        ->assertJsonStructure(['message'])
        ->assertHeader('Deprecation')
        ->assertHeader('Sunset')
        ->assertHeader('Link');

    expect($response->json('message'))->toContain('permanently removed');
});

it('blocks v1 provincial PST route with 410 Gone', function () {
    $response = $this->getJson('/v1/provincial/pst/QC');

    $response->assertStatus(410)
        ->assertJsonStructure(['message'])
        ->assertHeader('Deprecation')
        ->assertHeader('Sunset')
        ->assertHeader('Link');
});

it('blocks v2 federal GST route with 410 Gone', function () {
    $response = $this->getJson('/v2/federal/gst');

    $response->assertStatus(410)
        ->assertJsonStructure(['message'])
        ->assertHeader('Deprecation')
        ->assertHeader('Sunset')
        ->assertHeader('Link');

    expect($response->json('message'))->toContain('permanently removed');
});

it('blocks v2 provincial route with 410 Gone', function () {
    $response = $this->getJson('/v2/province/QC');

    $response->assertStatus(410)
        ->assertJsonStructure(['message'])
        ->assertHeader('Deprecation')
        ->assertHeader('Sunset')
        ->assertHeader('Link');
});

it('includes a successor-version link relation pointing to the docs for v1', function () {
    $response = $this->getJson('/v1/federal/gst');

    $response->assertStatus(410);
    expect($response->headers->get('Link'))
        ->toContain('https://salestaxapi.ca/')
        ->toContain('successor-version');
});

it('includes a successor-version link relation pointing to the docs for v2', function () {
    $response = $this->getJson('/v2/federal/gst');

    $response->assertStatus(410);
    expect($response->headers->get('Link'))
        ->toContain('https://salestaxapi.ca/')
        ->toContain('successor-version');
});
