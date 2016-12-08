<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class CampagneTest extends Orchestra\Testbench\TestCase
{
    use WithoutMiddleware;

    protected $mock;
    protected $worker;
    protected $mailjet;
    protected $campagne;
    protected $helper;

    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock('designpond\newsletter\Newsletter\Service\Mailjet');
        $this->app->instance('designpond\newsletter\Newsletter\Service\Mailjet', $this->mock);

        $this->mailjet = Mockery::mock('designpond\newsletter\Newsletter\Worker\MailjetServiceInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\MailjetServiceInterface', $this->mailjet);

        $this->worker = Mockery::mock('designpond\newsletter\Newsletter\Worker\CampagneInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\CampagneInterface', $this->worker);

        $this->campagne = Mockery::mock('designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface', $this->campagne);

        $this->helper = Mockery::mock('designpond\newsletter\Newsletter\Helper\Helper');

        $this->withFactories(dirname(__DIR__).'/newsletter/factories');

        //$user = factory(App\Droit\User\Entities\User::class,'admin')->create();
        //$this->actingAs($user);

        /**
         * Register views
         *
         * @return void
         */

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

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     *
     * @return void
     */
    public function testNewsletterCreationPage()
    {
        $this->mailjet->shouldReceive('getAllLists')->once()->andReturn([]);

        $this->visit('build/newsletter')->click('addNewsletter')->seePageIs('build/newsletter/create');

    }

    /**
     *
     * @return void
     */
    public function testSendCampagne()
    {

       $campagne = factory(designpond\newsletter\Newsletter\Entities\Newsletter_campagnes::class)->make();

        $this->campagne->shouldReceive('find')->once()->andReturn($campagne);
        $this->campagne->shouldReceive('update')->once();
        $this->worker->shouldReceive('html')->once()->andReturn('<html><header></header><body></body></html>');

        $this->mailjet->shouldReceive('setHtml')->once()->andReturn(true);
        $this->mailjet->shouldReceive('setList')->once()->andReturn(true);
        $this->mailjet->shouldReceive('sendCampagne')->once()->andReturn(['success' => true]);

        $response = $this->call('POST', 'build/send/campagne', ['id' => '1']);

        $this->assertRedirectedTo('build/newsletter');

    }

    /**
     * @expectedException designpond\newsletter\Exceptions\CampagneUpdateException
     */
    public function testSendCampagneFailedHtml()
    {

        $campagne = factory(designpond\newsletter\Newsletter\Entities\Newsletter_campagnes::class)->make();

        $this->campagne->shouldReceive('find')->once()->andReturn($campagne);
        $this->worker->shouldReceive('html')->once()->andReturn('<html><header></header><body></body></html>');

        $this->mailjet->shouldReceive('setList')->once()->andReturn(true);
        $this->mailjet->shouldReceive('setHtml')->once()->andReturn(false);

        $response = $this->call('POST', 'build/send/campagne', ['id' => '1']);

    }

    /**
     * @expectedException designpond\newsletter\Exceptions\CampagneSendException
     */
    public function testSendCampagneFailed()
    {
        $campagne = factory(designpond\newsletter\Newsletter\Entities\Newsletter_campagnes::class)->make();

        $result = [
            'success' => false,
            'info'    => ['ErrorMessage' => '','StatusCode' => '']
        ];

        $this->campagne->shouldReceive('find')->once()->andReturn($campagne);
        $this->worker->shouldReceive('html')->once()->andReturn('<html><header></header><body></body></html>');

        $this->mailjet->shouldReceive('setList')->once()->andReturn(true);
        $this->mailjet->shouldReceive('setHtml')->once()->andReturn(true);
        $this->mailjet->shouldReceive('sendCampagne')->once()->andReturn($result);

        $response = $this->call('POST', 'build/send/campagne', ['id' => '1']);

    }

    /**
     *
     * @return void
     */
    public function testSendTestCampagne()
    {
        $campagne = factory(designpond\newsletter\Newsletter\Entities\Newsletter_campagnes::class)->make();

        $this->campagne->shouldReceive('find')->once()->andReturn($campagne);
        $this->worker->shouldReceive('html')->once()->andReturn('<html><header></header><body></body></html>');
        $this->mailjet->shouldReceive('setHtml')->once()->andReturn(true);
        $this->mailjet->shouldReceive('sendTest')->once()->andReturn(['success' => true]);

        $response = $this->call('POST', 'build/send/test', ['id' => '1', 'email' => 'cindy.leschaud@gmail.com']);

        $this->assertRedirectedTo('build/campagne/'.$campagne->id);

    }

    /**
     * @expectedException designpond\newsletter\Exceptions\TestSendException
     */
    public function testSendTestFailed()
    {
        $campagne = factory(designpond\newsletter\Newsletter\Entities\Newsletter_campagnes::class)->make();

        $result = [
            'success' => false,
            'info'    => ['ErrorMessage' => '','StatusCode' => '']
        ];

        $this->campagne->shouldReceive('find')->once()->andReturn($campagne);
        $this->worker->shouldReceive('html')->once()->andReturn('<html><header></header><body></body></html>');
        $this->mailjet->shouldReceive('setHtml')->once()->andReturn(true);
        $this->mailjet->shouldReceive('sendTest')->once()->andReturn($result);

        $this->call('POST', 'build/send/test', ['id' => '1', 'email' => 'cindy.leschaud@gmail.com']);

    }

    /**
     *
     * @return void
     */
    public function testCreateCampagne()
    {
        $campagne   = factory(designpond\newsletter\Newsletter\Entities\Newsletter_campagnes::class)->make();
        $newsletter = factory(designpond\newsletter\Newsletter\Entities\Newsletter::class)->make();

        $campagne->newsletter = $newsletter;

        $this->campagne->shouldReceive('create')->once()->andReturn($campagne);
        $this->campagne->shouldReceive('update')->once()->andReturn($campagne);
        $this->mailjet->shouldReceive('setList')->once();
        $this->mailjet->shouldReceive('createCampagne')->once()->andReturn(1);

        $response = $this->call('POST', 'build/campagne', ['sujet' => 'Sujet', 'auteurs' => 'Cindy Leschaud', 'newsletter_id' => '3']);

        $this->assertRedirectedTo('build/campagne/'.$campagne->id);

    }

}
