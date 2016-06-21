<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class SubscriptionTest extends Orchestra\Testbench\TestCase
{
    protected $mock;
    protected $subscription;
    protected $worker;
    protected $newsletter;

    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock('designpond\newsletter\Newsletter\Service\Mailjet');
        $this->app->instance('designpond\newsletter\Newsletter\Service\Mailjet', $this->mock);

        $this->worker = Mockery::mock('designpond\newsletter\Newsletter\Worker\MailjetInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\MailjetInterface', $this->worker);

        $this->subscription = Mockery::mock('designpond\newsletter\Newsletter\Repo\NewsletterUserInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Repo\NewsletterUserInterface', $this->subscription);

        $this->newsletter = Mockery::mock('designpond\newsletter\Newsletter\Repo\NewsletterInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Repo\NewsletterInterface', $this->newsletter);

        $this->withFactories(__DIR__.'/factories');

    }

    public function tearDown()
    {
        Mockery::close();
    }

    protected function getPackageProviders($app)
    {
        return ['designpond\newsletter\newsletterServiceProvider'];
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
    public function testAddSubscriptionFromAdmin()
    {
        $newsletter = factory(designpond\newsletter\Newsletter\Entities\Newsletter::class)->make(['list_id' => 1]);
        $user = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make(['id' => 1]);

        $subscription1 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 1]);
        $subscription3 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 2]);

        $user->subscriptions = new \Illuminate\Support\Collection([$subscription1,$subscription3]);

        $this->subscription->shouldReceive('create')->once()->andReturn($user);
        $this->newsletter->shouldReceive('find')->once()->andReturn($newsletter);
        $this->worker->shouldReceive('setList')->once();
        $this->worker->shouldReceive('subscribeEmailToList')->once()->andReturn(true);

        $response = $this->call('POST', 'build/subscriber', ['email' => $user->email, 'newsletter_id' => [3]]);

        $this->assertRedirectedTo('build/subscriber');

    }
    
    /**
     *
     * @return void
     */
    public function testRemoveAndDeleteSubscription()
    {
        $user = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make(['id' => 1, 'email' => 'cindy.leschaud@gmail.com']);

        $subscription1 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 1]);
        $subscription3 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 2]);

        $user->subscriptions = new \Illuminate\Support\Collection([$subscription1,$subscription3]);

        $newsletter1 = factory(designpond\newsletter\Newsletter\Entities\Newsletter::class)->make(['list_id' => 1]);
        $newsletter2 = factory(designpond\newsletter\Newsletter\Entities\Newsletter::class)->make(['list_id' => 2]);

        $newsletters = new \Illuminate\Support\Collection([$newsletter1,$newsletter2]);

        $this->newsletter->shouldReceive('getAll')->andReturn($newsletters);
        $this->subscription->shouldReceive('findByEmail')->once()->andReturn($user);
        $this->worker->shouldReceive('setList')->twice();
        $this->worker->shouldReceive('removeContact')->twice()->andReturn(true);
        $this->subscription->shouldReceive('delete')->once();

        $response = $this->call('DELETE', 'build/subscriber/'.$user->id, ['email' => $user->email]);

        $this->assertRedirectedTo('build/subscriber');

    }

    /**
     *
     * @return void
     */
    public function testUpdateSubscriptions()
    {
        $newsletter1 = factory(designpond\newsletter\Newsletter\Entities\Newsletter::class)->make(['list_id' => 1]);
        $newsletter2 = factory(designpond\newsletter\Newsletter\Entities\Newsletter::class)->make(['list_id' => 2]);

        $user = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make(['id' => 1]);

        $subscription1 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 1]);
        $subscription3 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 2]);

        $user->subscriptions = new \Illuminate\Support\Collection([$subscription1,$subscription3]);

        $this->subscription->shouldReceive('update')->once()->andReturn($user);

        $this->newsletter->shouldReceive('find')->once()->andReturn($newsletter1);
        $this->newsletter->shouldReceive('find')->once()->andReturn($newsletter2);
        $this->worker->shouldReceive('setList')->twice();
        $this->worker->shouldReceive('subscribeEmailToList')->once()->andReturn(true);
        $this->worker->shouldReceive('removeContact')->once()->andReturn(true);

        $response = $this->call('PUT', 'build/subscriber/1', ['id' => 1 , 'email' => 'cindy.leschaud@gmail.com', 'newsletter_id' => [1,3], 'activation' => 1]);

        $this->assertRedirectedTo('build/subscriber/1');
    }

}
