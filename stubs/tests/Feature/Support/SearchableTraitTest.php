<?php

use Modules\Support\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

uses(Searchable::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'doe@gmail.com',
        'password' => 'secret',
    ]);
});

afterEach(function () {
    $this->user->delete();
});

it('returns empty collection if no result is found', function () {
    $result = User::search('name,email', 'Jane')->get();

    expect($result)->toHaveCount(0);
});

it('can search a single database column', function () {
    $stringToSearch = 'John';

    $result = User::search('name', $stringToSearch)->get();

    expect($result)->toHaveCount(1);
    expect($result->first()->name)->toBe('John Doe');
});

it('can search multiple database columns', function () {
    $stringToSearch = 'doe';

    $result = User::search('name,email', $stringToSearch)->get();

    expect($result)->toHaveCount(1);
    expect($result->first()->name)->toBe('John Doe');
});
