<?php

use App\Data\VendorData;
use App\Repositories\DataInterface\VendorRepositoryInterface;
use App\Models\User;
use App\Models\Vendor;
use App\Services\VendorService;

test('redirects guests to login page', function () {
    $this->get('/vendor/list')
        ->assertRedirect('/login');
});

test('vendor list can be rendered', function () {
    $this->authenticate();

    $response = $this->get('/vendor/list');
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


test('can not accept duplicate email for vendor', function () {
    $this->authenticate();
    $vendor = Vendor::factory()->create();
    $response = $this->post('/vendor', [
        'email' => $vendor['email'],
        'mobile' => 'password',
        'name' => 'test name',
        'address' => "Test suit @ 123 json"
    ], ['X-Inertia' => 'true']);

    $response->assertStatus(302);
    $response->assertSessionHasErrors(['email']);
});

test('vendor service create work fine or not', function () {
    $repo = Mockery::mock(VendorRepositoryInterface::class);
    $service = new VendorService($repo);

    $dto = new VendorData(name: 'John', email: 'john@test.com', mobile: 215487542145);

    $repo->shouldReceive('create')->once();

    $service->create($dto);
});
