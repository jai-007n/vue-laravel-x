<?php

use App\Models\User;
use App\Models\Vendor;


test('redirects guests to login page', function () {
    $this->get('/product/list')
        ->assertRedirect('/login');
});

test('product list can be rendered', function () {
    $this->authenticate();

    $response = $this->get('/product/list');
    $response->assertStatus(200);
});

test('vendor store successfully', function () {
    $this->authenticate();
    $response = $this->post('/vendor', [
        'email' => 'test@yopmail.com',
        'mobile' => 'password',
        'name' => 'Test Vendor',
        'address' => "Test suit @ 123 json"
    ]);
    $response->assertStatus(302);
    $response->assertRedirect(route('vendor.list', absolute: false));
});
