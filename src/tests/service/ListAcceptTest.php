<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListAcceptTest extends Orchestra\Testbench\TestCase
{

    use DatabaseTransactions;
    
    public function setUp()
    {
        parent::setUp();

        DB::beginTransaction();
        $this->withFactories(dirname(__DIR__).'/newsletter/factories');

        $user = factory(App\Droit\User\Entities\User::class,'admin')->create();
        $this->actingAs($user);
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

    public function testIndexPage()
    {
        $this->visit('build/liste')->see('Listes hors campagne');
        $this->assertViewHas('lists');
    }

    public function testListPage()
    {
        $liste = factory(designpond\newsletter\Newsletter\Entities\Newsletter_lists::class)->create([
            'title' => 'One Title'
        ]);

        $email1 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_emails::class)->create();
        $email2 = factory(designpond\newsletter\Newsletter\Entities\Newsletter_emails::class)->create();

        $liste->emails()->saveMany([$email1,$email2]);

        $this->visit('build/liste/'.$liste->id)->see('Listes hors campagne');
        $this->assertViewHas('lists');
        $this->assertViewHas('list');
        $this->see('One Title');
    }

    public function testSendToList()
    {
        $mock = Mockery::mock('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface', $mock);

        $mock->shouldReceive('send')->once();

        $liste = factory(designpond\newsletter\Newsletter\Entities\Newsletter_lists::class)->create();

        $response = $this->call('POST', 'build/liste/send', ['list_id' => $liste->id, 'campagne_id' => 1]);

        $this->followRedirects()->seePageIs('build/newsletter');
    }
    
    function prepareFileUpload($path)
    {
        return new \Symfony\Component\HttpFoundation\File\UploadedFile($path, null, \File::mimeType($path), null, null, true);
    }
}
