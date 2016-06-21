<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListTest extends Orchestra\Testbench\TestCase
{
    protected $subscription;
    protected $newsletter;
    protected $upload;
    protected $list;

    //use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->subscription = Mockery::mock('designpond\newsletter\Newsletter\Repo\NewsletterUserInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Repo\NewsletterUserInterface', $this->subscription);

        $this->newsletter = Mockery::mock('designpond\newsletter\Newsletter\Repo\NewsletterInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Repo\NewsletterInterface', $this->newsletter);

        $this->upload = Mockery::mock('designpond\newsletter\Newsletter\Service\UploadInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Service\UploadInterface', $this->upload);

        $this->list = Mockery::mock('designpond\newsletter\Newsletter\Repo\NewsletterListInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Repo\NewsletterListInterface', $this->list);
        
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

    public function testIndexPage()
    {
        $this->list->shouldReceive('getAll')->once();

        $this->visit('build/liste')->see('Listes hors campagne');
        $this->assertViewHas('lists');
    }

    public function testListPage()
    {
        $this->list->shouldReceive('getAll')->once();
        $this->list->shouldReceive('find')->once();

        $this->visit('build/liste/1')->see('Listes hors campagne');
        $this->assertViewHas('lists');
        $this->assertViewHas('list');
    }

    public function testSendToList()
    {
        $mock = Mockery::mock('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface', $mock);
        $this->list->shouldReceive('find')->once();
        $mock->shouldReceive('send')->once();

        $response = $this->call('POST', 'build/liste/send', ['list_id' => 1, 'campagne_id' => 1]);

        $this->assertRedirectedTo('build/campagne/1');
    }

    public function testStoreListe()
    {
        $file   = dirname(__DIR__).'/excel/test.xlsx';
        $upload = $this->prepareFileUpload($file);
        
        $mock = Mockery::mock('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface', $mock);

        $email1     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'cindy.leschaud@gmail.com']);
        $email2     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'pruntrut@yahoo.fr']);
        $collection = new Maatwebsite\Excel\Collections\RowCollection([$email1,$email2]);

        $mock->shouldReceive('read')->once()->andReturn($collection);
        $this->list->shouldReceive('create')->once();
        $this->upload->shouldReceive('upload')->once()->andReturn(['name' => 'uploaded']);

        $response = $this->call('POST', 'build/liste', ['title' => 'Un titre' ,'list_id' => 1, 'campagne_id' => 1], [], ['file' => $upload]);

        $this->assertRedirectedTo('build/liste');
    }

    /**
     * @expectedException designpond\newsletter\Exceptions\FileUploadException
     */
    public function testStoreListeUploadFails()
    {
        $file   = dirname(__DIR__).'/excel/test.xlsx';
        $upload = $this->prepareFileUpload($file);

        $this->upload->shouldReceive('upload')->once()->andReturn(null);

        $response = $this->call('POST', 'build/liste', ['title' => 'Un titre' ,'list_id' => 1, 'campagne_id' => 1], [], ['file' => $upload]);
    }

    public function testStoreListeFormatFails()
    {
        $file   = dirname(__DIR__).'/excel/test-notok.xlsx';
        $upload = $this->prepareFileUpload($file);

        $mock = Mockery::mock('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface', $mock);

        $this->upload->shouldReceive('upload')->once()->andReturn(['name' => 'title']);

        $collection = new Maatwebsite\Excel\Collections\RowCollection([]);
        $mock->shouldReceive('read')->once()->andReturn($collection);

        $response = $this->call('POST', 'build/liste', ['title' => 'Un titre' ,'list_id' => 1, 'campagne_id' => 1], [], ['file' => $upload]);

        $this->assertSessionHas('status', 'danger');
    }

    /**
     *
     * @return void
     */
    public function testImport()
    {
        $worker  = App::make('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface');
        $file    = dirname(__DIR__).'/excel/test.xlsx';

        //$results = $worker->read($file);

        // Maatwebsite\Excel\Collections\RowCollection
       // $this->assertInstanceOf('Maatwebsite\Excel\Collections\RowCollection',$results);
    }
    
    // Put this function in a helpers.php or a class (can be called statically) or anywhere you like
    function prepareFileUpload($path)
    {
        return new \Symfony\Component\HttpFoundation\File\UploadedFile($path, null, \File::mimeType($path), null, null, true);
    }
}
