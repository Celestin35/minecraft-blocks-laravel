<?php

use App\Models\Block;
use App\Models\User;

it('allows guests to view the blocks list', function () {
    Block::factory()->count(3)->create();

    $response = $this->get(route('block.index'));

    $response->assertOk();
});

it('allows guests to filter blocks by category', function () {
    $stone = Block::factory()->create(['block_name' => 'Stone Block', 'category' => 'Stone']);
    $wood = Block::factory()->create(['block_name' => 'Wood Block', 'category' => 'Wood']);

    $response = $this->get(route('block.index', ['category' => 'Stone']));

    $response->assertOk();
    $response->assertSee($stone->block_name);
    $response->assertDontSee($wood->block_name);
});

it('allows guests to view a block detail', function () {
    $block = Block::factory()->create();

    $response = $this->get(route('block.show', $block));

    $response->assertOk();
    $response->assertSee($block->block_name);
});

it('allows an authenticated user to create a block', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $payload = [
        'file_name' => 'stone_block',
        'block_name' => 'Stone Block',
        'variant' => null,
        'avg_color_srgb' => null,
        'avg_color_linear' => null,
        'category' => 'Stone',
        'family' => 'Stone',
        'material' => 'Stone',
        'is_transparent' => false,
        'is_solid' => true,
        'detail_form' => null,
        'detail_flammable' => false,
        'detail_interactive' => false,
    ];

    $response = $this->post(route('block.store'), $payload);

    $response->assertRedirect();
    $this->assertDatabaseHas('blocks', [
        'block_name' => 'Stone Block',
        'file_name' => 'stone_block',
    ]);
});

it('allows an authenticated user to update a block', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $block = Block::factory()->create(['block_name' => 'Old Name']);

    $response = $this->patch(route('block.update', $block), [
        'block_name' => 'New Name',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('blocks', [
        'id' => $block->id,
        'block_name' => 'New Name',
    ]);
});

it('allows an authenticated user to delete a block', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $block = Block::factory()->create();

    $response = $this->delete(route('block.destroy', $block));

    $response->assertRedirect();
    $this->assertDatabaseMissing('blocks', [
        'id' => $block->id,
    ]);
});
