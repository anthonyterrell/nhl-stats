<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertViewIs('welcome');
});

it('has team schedule and league standings data', function () {
    $this->get('/')->assertViewHasAll(['schedule', 'standings']);
});
