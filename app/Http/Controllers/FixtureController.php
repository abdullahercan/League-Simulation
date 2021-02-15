<?php

namespace App\Http\Controllers;

use App\Repositories\FixtureRepository;

class FixtureController extends Controller
{
    private $fixtureRepository;

    public function __construct(FixtureRepository $fixtureRepository)
    {
        $this->fixtureRepository = $fixtureRepository;

        $this->fixtureRepository->createFixture();

    }

    public function index()
    {
    }

    public function getTable(): object
    {
        return response()->json([
            'status' => true,
            'data' => $this->fixtureRepository->getList()
        ]);
    }
}
