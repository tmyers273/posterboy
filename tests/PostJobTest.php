<?php

use tmyers273\posterboy\Posterboy;
use Illuminate\Queue\InteractsWithQueue;
use tmyers273\posterboy\PosterboyPostJob;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//class PosterboyTest extends TestPackageCase
class PostJobTest extends TestCase
{
    /** @test */
    public function it_closes_on_success_200()
    {
        $guzzleMock = Mockery::mock('overload:' . GuzzleHttp\Client::class);
        $guzzleMock->shouldReceive('request')->once()->andReturnSelf();
        $guzzleMock->shouldReceive('getStatusCode')->andReturn(200);

        $job = new PosterboyPostJob(json_encode(['my array' => 'data']), 'http://www.website.com');

        $job->handle();
    }

    /** @test */
    public function it_closes_on_other_2xx()
    {
        $guzzleMock = Mockery::mock('overload:' . GuzzleHttp\Client::class);
        $guzzleMock->shouldReceive('request')->once()->andReturnSelf();
        $guzzleMock->shouldReceive('getStatusCode')->andReturn(200);

        $job = new PosterboyPostJob(json_encode(['my array' => 'data']), 'http://www.website.com');

        $job->handle();
    }

    public function proper_delay_provider()
    {
        $delays = [
            1,
            5,
            10,
            20,
            60,
            120,
            180
        ];

        $output = [];

        foreach($delays as $index => $value) {
            $output[] = [
                $index+1,
                $value,
                $delays
            ];
        }

        return $output;
    }

    /**
     * @test
     * @dataProvider proper_delay_provider
     * */
    public function it_gets_proper_delay($attempt, $expected, $delays)
    {
        $job = new PosterboyPostJob(json_encode(['my array' => 'data']), 'http://www.website.com');

        $delay = $job->getDelay($attempt, $delays);

        $this->assertEquals($expected, $delay);
    }

    /**
     * Here we should return the last delay if we don't have
     * an explicit delay set for that attempt number
     *
     * @test
     */
    public function it_gets_short_delay()
    {
        $job = new PosterboyPostJob(json_encode(['my array' => 'data']), 'http://www.website.com');

        $delays = [
            10,
            20
        ];

        $delay = $job->getDelay(10, $delays);

        $this->assertEquals(20, $delay);
    }

}