<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InscriptionTest extends Orchestra\Testbench\TestCase
{
    protected $mock;
    protected $subscription;
    protected $worker;

    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock('designpond\newsletter\Newsletter\Service\Mailjet');
        $this->app->instance('designpond\newsletter\Newsletter\Service\Mailjet', $this->mock);

        $this->worker = Mockery::mock('designpond\newsletter\Newsletter\Worker\MailjetServiceInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\MailjetServiceInterface', $this->worker);

        $this->subscription = Mockery::mock('designpond\newsletter\Newsletter\Repo\NewsletterUserInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Repo\NewsletterUserInterface', $this->subscription);

        $this->withFactories(dirname(__DIR__).'/newsletter/factories');

    }

    public function tearDown()
    {
        Mockery::close();
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
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'dev',
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
     *
     * @return void
     */
    public function testSubscription()
    {
        $user = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make();
        $user->subscriptions = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make();

        $this->subscription->shouldReceive('findByEmail')->once()->andReturn(null);
        $this->subscription->shouldReceive('create')->once()->andReturn($user);

        \Mail::shouldReceive('send')->once();

        $response = $this->call('POST', 'subscribe', ['email' => 'info@leschaud.ch']);

        $this->assertRedirectedTo('/');
    }

    /**
     *
     * @return void
     */
    public function testRemoveSubscription()
    {
        $user = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make();
        $sub1 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 1]);
        $sub2 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 2]);

        $user->subscriptions = collect([$sub1,$sub2]);

        $this->subscription->shouldReceive('findByEmail')->once()->andReturn($user);
        //$this->subscription->shouldReceive('delete')->once();
        $this->worker->shouldReceive('setList')->once();
        $this->worker->shouldReceive('removeContact')->once()->andReturn(true);

        $response = $this->call('POST', 'unsubscribe', ['newsletter_id' => 1, 'email' => 'info@leschaud.ch']);

        $this->assertRedirectedTo('/');
    }

    public function testRemoveAllSubscription()
    {
        $user = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make();

        $user->subscriptions = collect([]);
        $this->subscription->shouldReceive('findByEmail')->once()->andReturn($user);
        $this->worker->shouldReceive('setList')->once();
        $this->worker->shouldReceive('removeContact')->once()->andReturn(true);
        $this->subscription->shouldReceive('delete')->once();
        
        $response = $this->call('POST', 'unsubscribe', ['newsletter_id' => 1, 'email' => 'info@leschaud.ch']);

        $this->assertRedirectedTo('/');
    }

    /**
     *
     * @return void
     */
    public function testActivateSubscription()
    {

        $user = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make();
        $user->subscriptions = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make();

        $this->subscription->shouldReceive('activate')->once()->andReturn($user);
        $this->worker->shouldReceive('setList')->once();
        $this->worker->shouldReceive('subscribeEmailToList')->once()->andReturn(true);

        $response = $this->call('GET', 'activation/1234/1');

        $this->assertRedirectedTo('/');

    }

}
