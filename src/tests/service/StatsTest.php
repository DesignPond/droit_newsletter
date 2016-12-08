<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatsTest extends Orchestra\Testbench\TestCase
{
    protected $charts;
    
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->charts = new \designpond\newsletter\Newsletter\Worker\Charts();
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCompileStat()
    {
        $stats['DeliveredCount'] = 5;
        $stats['ClickedCount']   = 2;
        $stats['OpenedCount']    = 3;
        $stats['BouncedCount']   = 1;

        $data['total']     = 5;
        $data['clicked']   = 40.0;
        $data['opened']    = 60.0;
        $data['bounced']   = 20.0;
        $data['nonopened'] = 20.0;

        $actual = $this->charts->compileStats($stats);

        $this->assertEquals($data, $actual);

    }
}
