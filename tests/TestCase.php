<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // The seller-rating helpers memoise per request; in a shared phpunit process
        // that state would leak across tests, so reset it before each test.
        \App\Model\SellerReview::flushSummaryCache();
        \App\User::flushNameCache();
    }
}
