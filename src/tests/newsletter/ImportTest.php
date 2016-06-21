<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class ImportTest extends Orchestra\Testbench\TestCase
{
    protected $mock;
    protected $subscription;
    protected $worker;
    protected $newsletter;
    protected $import;
    protected $campagne;
    protected $camp;
    protected $upload;
    protected $excel;

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

        $this->campagne = Mockery::mock('designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface', $this->campagne);

        $this->camp = Mockery::mock('designpond\newsletter\Newsletter\Worker\CampagneInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\CampagneInterface', $this->camp);

        $this->upload = Mockery::mock('designpond\newsletter\Newsletter\Service\UploadInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Service\UploadInterface', $this->upload);

        $this->excel = Mockery::mock('Maatwebsite\Excel\Excel');
        $this->app->instance('Maatwebsite\Excel\Excel', $this->excel);

        $this->import = new \designpond\newsletter\Newsletter\Worker\ImportWorker(
            $this->worker,
            $this->subscription,
            $this->newsletter,
            $this->excel,
            $this->campagne,
            $this->camp,
            $this->upload
        );
        
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

        $app['path.base'] = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
    }

    protected function getBasePath()
    {
        return dirname(__DIR__).'/fixture';
    }

    /**
     *
     * @return void
     */
    public function testImport()
    {
        $file    = dirname(__DIR__).'/excel/test.xlsx';

        $email1     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'cindy.leschaud@gmail.com']);
        $email2     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'pruntrut@yahoo.fr']);
        $collection = new Maatwebsite\Excel\Collections\RowCollection([$email1,$email2]);

        $this->excel->shouldReceive('load->get')->andReturn($collection);

        $results = $this->import->read($file);
        // Maatwebsite\Excel\Collections\RowCollection
        $this->assertInstanceOf('Maatwebsite\Excel\Collections\RowCollection',$results);
    }

    /**
     *
     * @return void
     */
    public function testSubscribeExist()
    {
        $file = dirname(__DIR__).'/excel/test.xlsx';
        $user = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make();

        $email1     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'cindy.leschaud@gmail.com']);
        $email2     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'pruntrut@yahoo.fr']);
        $collection = new Maatwebsite\Excel\Collections\RowCollection([$email1,$email2]);

        $this->excel->shouldReceive('load->get')->andReturn($collection);

        $this->subscription->shouldReceive('findByEmail')->twice()->andReturn($user);
        $this->subscription->shouldReceive('subscribe')->twice();

        $results = $this->import->read($file);

        $this->import->subscribe($results);
    }

    /**
     *
     * @return void
     */
    public function testSubscribeDontExist()
    {
        $file = dirname(__DIR__).'/excel/test.xlsx';
        $user = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make();

        $email1     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'cindy.leschaud@gmail.com']);
        $email2     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'pruntrut@yahoo.fr']);
        $collection = new Maatwebsite\Excel\Collections\RowCollection([$email1,$email2]);

        $this->excel->shouldReceive('load->get')->andReturn($collection);

        $this->subscription->shouldReceive('findByEmail')->twice()->andReturn(null);
        $this->subscription->shouldReceive('create')->twice()->andReturn($user);
        $this->subscription->shouldReceive('subscribe')->twice();

        $results = $this->import->read($file);
        $this->import->subscribe($results);
    }

    /**
     *
     * @return void
     */
    public function testSyncToMailjet()
    {
        $newsletter = factory(designpond\newsletter\Newsletter\Entities\Newsletter::class)->make(['list_id' => 1]);

        $this->newsletter->shouldReceive('find')->once()->andReturn($newsletter);
        $this->worker->shouldReceive('setList')->with(1)->once()->andReturn(true);

        $dataID     = new stdClass();
        $dataID->ID = 1;

        $this->worker->shouldReceive('uploadCSVContactslistData')->once()->andReturn($dataID);
        $this->worker->shouldReceive('importCSVContactslistData')->once();

        $this->import->sync('test.xlsx',1);

    }

    public function testImportListNewsletter()
    {
        $file   = dirname(__DIR__).'/excel/test.xlsx';
        $upload = $this->prepareFileUpload($file);

        $mock = Mockery::mock('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface');
        $this->app->instance('designpond\newsletter\Newsletter\Worker\ImportWorkerInterface', $mock);

        $mock->shouldReceive('import')->once();

        $response = $this->call('POST', 'build/import', ['title' => 'Titre', 'newsletter_id' => 1], [], ['file' => $upload]);

        $this->assertRedirectedTo('build/import');
    }

    /**
     * @expectedException designpond\newsletter\Exceptions\BadFormatException
     */
    public function testImportListFormatFails()
    {
        $file       = dirname(__DIR__).'/excel/test-notok.xlsx';
        $upload     = $this->prepareFileUpload($file);
        $collection = new Maatwebsite\Excel\Collections\RowCollection([]);

        $this->upload->shouldReceive('upload')->once()->andReturn(['name' => 'test.xlsx']);
        $this->excel->shouldReceive('load->get')->andReturn($collection);

        $results = $this->import->import(['title' => 'Titre', 'newsletter_id' => 3],$upload);
    }

    /**
     *
     * @return void
     */
    public function testImportWithNewsletterId()
    {
        $file       = dirname(__DIR__).'/excel/test.xlsx';
        $upload     = $this->prepareFileUpload($file);
        $file       = ['name' => 'test.xlsx'];

        $dataID     = new stdClass();
        $dataID->ID = 1;

        $user       = factory(designpond\newsletter\Newsletter\Entities\Newsletter_users::class)->make();
        $newsletter = factory(designpond\newsletter\Newsletter\Entities\Newsletter::class)->make(['list_id' => 1]);

        $email1     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'cindy.leschaud@gmail.com']);
        $email2     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'pruntrut@yahoo.fr']);
        $collection = new Maatwebsite\Excel\Collections\RowCollection([$email1,$email2]);

        $this->excel->shouldReceive('load->get')->andReturn($collection);
        $this->excel->shouldReceive('load->store');

        $this->upload->shouldReceive('upload')->once()->andReturn($file);
        $this->subscription->shouldReceive('findByEmail')->twice()->andReturn(null);
        $this->subscription->shouldReceive('create')->twice()->andReturn($user);
        $this->subscription->shouldReceive('subscribe')->twice();
        $this->newsletter->shouldReceive('find')->once()->andReturn($newsletter);
        $this->worker->shouldReceive('setList')->with(1)->once()->andReturn(true);
        $this->worker->shouldReceive('uploadCSVContactslistData')->once()->andReturn($dataID);
        $this->worker->shouldReceive('importCSVContactslistData')->once();

        $results = $this->import->import(['title' => 'Titre', 'newsletter_id' => 3],$upload);
    }

    /**
     *
     * @return void
     */
    public function testImportWithoutNewsletterId()
    {
        $file       = dirname(__DIR__).'/excel/test.xlsx';
        $upload     = $this->prepareFileUpload($file);
        $file       = ['name' => 'test.xlsx'];

        $email1     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'cindy.leschaud@gmail.com']);
        $email2     = new Maatwebsite\Excel\Collections\CellCollection(['email' => 'pruntrut@yahoo.fr']);
        $collection = new Maatwebsite\Excel\Collections\RowCollection([$email1,$email2]);

        $this->excel->shouldReceive('load->get')->andReturn($collection);
        $this->upload->shouldReceive('upload')->once()->andReturn($file);

        $results = $this->import->import(['title' => 'Titre'],$upload);
    }

    function prepareFileUpload($path)
    {
        return new \Symfony\Component\HttpFoundation\File\UploadedFile($path, null, \File::mimeType($path), null, null, true);
    }
}
