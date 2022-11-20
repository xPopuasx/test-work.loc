<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected array $headers;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->headers = [
            'Authorization' => 'Bearer 2|DO5m0zBFtcetCWemw2ye3UBSjpER33H3jEIoOzFH',
            'Content-Type' => 'application/json',
        ];
    }
}
