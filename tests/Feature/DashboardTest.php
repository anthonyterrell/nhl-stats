<?php

beforeEach(function () {
    $this->withoutVite();
});

it('renders the NHL dashboard', function () {
    fakeNHLSchedule();

    $response = $this->get('/nhl');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Dashboard')
            ->has('league')
            ->has('games')
            ->has('standings')
            ->where('league', 'nhl')
        );
});

it('renders the PWHL dashboard', function () {
    fakePWHLSchedule();

    $response = $this->get('/pwhl');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Dashboard')
            ->where('league', 'pwhl')
        );
});

it('defaults to NHL when visiting root', function () {
    fakeNHLSchedule();

    $response = $this->get('/');

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('league', 'nhl')
        );
});
