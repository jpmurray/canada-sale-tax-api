<?php

use App\Models\PendingRateUpdate;
use App\Models\Rate;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['is_admin' => false]);
    $this->admin = User::factory()->create(['is_admin' => true]);
});

test('authenticated user can view create pending rate update form', function () {
    $response = $this->actingAs($this->user)->get(route('pending-rate-updates.create'));

    $response->assertStatus(200);
});

test('authenticated user can submit a pending rate update', function () {
    $data = [
        'province' => 'ON',
        'start' => '2025-01-01',
        'pst' => 0.08,
        'gst' => 0.05,
        'hst' => 0.13,
        'applicable' => 0.13,
        'type' => 'HST',
        'source' => 'https://example.com/tax-info',
    ];

    $response = $this->actingAs($this->user)->post(route('pending-rate-updates.store'), $data);

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('pending_rate_updates', [
        'province' => 'ON',
        'user_id' => $this->user->id,
        'status' => 'pending',
    ]);
});

test('guest cannot submit pending rate updates', function () {
    $data = [
        'province' => 'ON',
        'start' => '2025-01-01',
        'pst' => 0.08,
        'gst' => 0.05,
        'hst' => 0.13,
        'applicable' => 0.13,
        'type' => 'HST',
        'source' => 'https://example.com/tax-info',
    ];

    $response = $this->post(route('pending-rate-updates.store'), $data);

    $response->assertRedirect(route('login'));
});

test('admin can view pending rate updates list', function () {
    PendingRateUpdate::factory()->count(3)->create();

    $response = $this->actingAs($this->admin)->get(route('pending-rate-updates.index'));

    $response->assertStatus(200);
});

test('non-admin cannot view pending rate updates list', function () {
    $response = $this->actingAs($this->user)->get(route('pending-rate-updates.index'));

    $response->assertStatus(403);
});

test('admin can view a pending rate update for review', function () {
    $pendingUpdate = PendingRateUpdate::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('pending-rate-updates.show', $pendingUpdate));

    $response->assertStatus(200);
});

test('non-admin cannot view pending rate update for review', function () {
    $pendingUpdate = PendingRateUpdate::factory()->create();

    $response = $this->actingAs($this->user)->get(route('pending-rate-updates.show', $pendingUpdate));

    $response->assertStatus(403);
});

test('admin can approve a pending rate update', function () {
    $pendingUpdate = PendingRateUpdate::factory()->create([
        'province' => 'BC',
        'pst' => 0.07,
        'gst' => 0.05,
        'hst' => 0,
        'applicable' => 0.12,
        'type' => 'GST+PST',
        'start' => '2025-06-01',
        'source' => 'https://example.com',
    ]);

    $response = $this->actingAs($this->admin)->post(route('pending-rate-updates.approve', $pendingUpdate), [
        'review_notes' => 'Verified source.',
    ]);

    $response->assertRedirect(route('pending-rate-updates.index'));

    $pendingUpdate->refresh();
    expect($pendingUpdate->status)->toBe('approved');
    expect($pendingUpdate->reviewed_by)->toBe($this->admin->id);
    expect($pendingUpdate->review_notes)->toBe('Verified source.');

    $this->assertDatabaseHas('rates', [
        'province' => 'BC',
        'pst' => 0.07,
        'gst' => 0.05,
    ]);
});

test('admin can reject a pending rate update', function () {
    $pendingUpdate = PendingRateUpdate::factory()->create();
    $initialRatesCount = Rate::count();

    $response = $this->actingAs($this->admin)->post(route('pending-rate-updates.reject', $pendingUpdate), [
        'review_notes' => 'Source not reliable.',
    ]);

    $response->assertRedirect(route('pending-rate-updates.index'));

    $pendingUpdate->refresh();
    expect($pendingUpdate->status)->toBe('rejected');
    expect($pendingUpdate->reviewed_by)->toBe($this->admin->id);
    expect($pendingUpdate->review_notes)->toBe('Source not reliable.');

    expect(Rate::count())->toBe($initialRatesCount);
});

test('reject requires review notes', function () {
    $pendingUpdate = PendingRateUpdate::factory()->create();

    $response = $this->actingAs($this->admin)->post(route('pending-rate-updates.reject', $pendingUpdate), [
        'review_notes' => '',
    ]);

    $response->assertSessionHasErrors('review_notes');
});

test('non-admin cannot approve a pending rate update', function () {
    $pendingUpdate = PendingRateUpdate::factory()->create();

    $response = $this->actingAs($this->user)->post(route('pending-rate-updates.approve', $pendingUpdate), [
        'review_notes' => 'Approved',
    ]);

    $response->assertStatus(403);
});

test('non-admin cannot reject a pending rate update', function () {
    $pendingUpdate = PendingRateUpdate::factory()->create();

    $response = $this->actingAs($this->user)->post(route('pending-rate-updates.reject', $pendingUpdate), [
        'review_notes' => 'Rejected',
    ]);

    $response->assertStatus(403);
});

test('cannot approve already reviewed pending rate update', function () {
    $pendingUpdate = PendingRateUpdate::factory()->approved()->create();

    $response = $this->actingAs($this->admin)->post(route('pending-rate-updates.approve', $pendingUpdate));

    $response->assertRedirect(route('pending-rate-updates.index'));
    $response->assertSessionHas('error');
});

test('cannot reject already reviewed pending rate update', function () {
    $pendingUpdate = PendingRateUpdate::factory()->rejected()->create();

    $response = $this->actingAs($this->admin)->post(route('pending-rate-updates.reject', $pendingUpdate), [
        'review_notes' => 'Double rejection',
    ]);

    $response->assertRedirect(route('pending-rate-updates.index'));
    $response->assertSessionHas('error');
});
