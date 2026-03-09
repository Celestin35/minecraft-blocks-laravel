<?php

use App\Models\Block;
use App\Models\Inventory;
use App\Models\User;

it('redirects guests from inventories index', function () {
    $response = $this->get(route('inventories.index'));

    $response->assertRedirect('/login');
});

it('shows only the authenticated user inventories', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $ownInventory = Inventory::factory()->create([
        'user_id' => $user->id,
        'name' => 'My Inventory',
    ]);
    $otherInventory = Inventory::factory()->create([
        'user_id' => $otherUser->id,
        'name' => 'Other Inventory',
    ]);

    $this->actingAs($user);
    $response = $this->get(route('inventories.index'));

    $response->assertOk();
    $response->assertSee($ownInventory->name);
    $response->assertDontSee($otherInventory->name);
});

it('allows an authenticated user to create an inventory', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('inventories.store'), [
        'name' => 'Starter Inventory',
        'description' => 'My first inventory',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('inventories', [
        'user_id' => $user->id,
        'name' => 'Starter Inventory',
    ]);
});

it('allows an authenticated user to view their inventory', function () {
    $user = User::factory()->create();
    $inventory = Inventory::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);
    $response = $this->get(route('inventories.show', $inventory));

    $response->assertOk();
    $response->assertSee($inventory->name);
});

it('forbids viewing another user inventory', function () {
    $user = User::factory()->create();
    $otherInventory = Inventory::factory()->create();

    $this->actingAs($user);
    $response = $this->get(route('inventories.show', $otherInventory));

    $response->assertStatus(403);
});

it('allows an authenticated user to delete their inventory', function () {
    $user = User::factory()->create();
    $inventory = Inventory::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);
    $response = $this->delete(route('inventories.delete', $inventory));

    $response->assertRedirect();
    $this->assertDatabaseMissing('inventories', [
        'id' => $inventory->id,
    ]);
});

it('allows adding a block to an inventory with a quantity', function () {
    $user = User::factory()->create();
    $inventory = Inventory::factory()->create(['user_id' => $user->id]);
    $block = Block::factory()->create();

    $this->actingAs($user);
    $response = $this->post(route('inventories.blocks.add', $inventory), [
        'block_id' => $block->id,
        'quantity' => 3,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('block_inventory', [
        'inventory_id' => $inventory->id,
        'block_id' => $block->id,
        'quantity' => 3,
    ]);
});

it('increments quantity when adding the same block again', function () {
    $user = User::factory()->create();
    $inventory = Inventory::factory()->create(['user_id' => $user->id]);
    $block = Block::factory()->create();

    $this->actingAs($user);
    $this->post(route('inventories.blocks.add', $inventory), [
        'block_id' => $block->id,
        'quantity' => 2,
    ]);
    $this->post(route('inventories.blocks.add', $inventory), [
        'block_id' => $block->id,
        'quantity' => 1,
    ]);

    $this->assertDatabaseHas('block_inventory', [
        'inventory_id' => $inventory->id,
        'block_id' => $block->id,
        'quantity' => 3,
    ]);
});

it('allows updating a block quantity in an inventory', function () {
    $user = User::factory()->create();
    $inventory = Inventory::factory()->create(['user_id' => $user->id]);
    $block = Block::factory()->create();

    $inventory->blocks()->attach($block->id, ['quantity' => 2]);

    $this->actingAs($user);
    $response = $this->patch(route('inventories.blocks.update', [$inventory, $block]), [
        'quantity' => 5,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('block_inventory', [
        'inventory_id' => $inventory->id,
        'block_id' => $block->id,
        'quantity' => 5,
    ]);
});

it('allows removing a block from an inventory', function () {
    $user = User::factory()->create();
    $inventory = Inventory::factory()->create(['user_id' => $user->id]);
    $block = Block::factory()->create();

    $inventory->blocks()->attach($block->id, ['quantity' => 1]);

    $this->actingAs($user);
    $response = $this->delete(route('inventories.blocks.remove', [$inventory, $block]));

    $response->assertRedirect();
    $this->assertDatabaseMissing('block_inventory', [
        'inventory_id' => $inventory->id,
        'block_id' => $block->id,
    ]);
});
