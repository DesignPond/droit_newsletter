<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatsTest extends Orchestra\Testbench\TestCase
{
    protected $charts;
    
    use WithoutMiddleware, DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->withFactories(dirname(__DIR__).'/newsletter/factories');

        DB::beginTransaction();

        $user = factory(App\Droit\User\Entities\User::class,'admin')->create();
        $this->actingAs($user);
        
        $this->charts = new \designpond\newsletter\Newsletter\Worker\Charts();
    }

    public function tearDown()
    {
        Mockery::close();
        DB::rollBack();
        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return [
            designpond\newsletter\newsletterServiceProvider::class,
            Vinkla\Alert\AlertServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'newdev',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'unix_socket' => '/Applications/MAMP/tmp/mysql/mysql.sock',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);

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
