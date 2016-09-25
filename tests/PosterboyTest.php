<?php

use tmyers273\posterboy\Posterboy;
use tmyers273\posterboy\PosterboyPostJob;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//class PosterboyTest extends TestPackageCase
class PosterboyTest extends TestCase
{
    /** @test */
    public function it_fires_job()
    {
        $this->expectsJobs(PosterboyPostJob::class);
        \tmyers273\posterboy\Posterboy::post('test', 'test');
    }
}