<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MailjetWorkerTest extends TestCase
{
    protected $mock;
    protected $interface;

    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock('designpond\newsletter\Newsletter\Service\Mailjet');
        $this->app->instance('designpond\newsletter\Newsletter\Service\Mailjet', $this->mock);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testSetList()
    {
        $worker = \App::make('designpond\newsletter\Newsletter\Worker\MailjetInterface');

        $worker->setList(1);

        $this->assertEquals(1, 1);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetNewsletters()
    {
        $worker = new \designpond\newsletter\Newsletter\Worker\MailjetWorker( $this->mock );
        $return = [
            'Count' => 1,
            'Data'  => [
                [
                    "Address"         => "g1mmsov99",
                    "CreatedAt"       => "2015-10-06T07:48:54Z",
                    "ID"              => 1499252,
                    "IsDeleted"       => false,
                    "Name"            => "Testing",
                    "SubscriberCount" => 3
                ]
            ],
            'Total' => 1,
        ];

        $this->mock->shouldReceive('contactslist')->once()->andReturn(json_encode($return));
        $this->mock->shouldReceive('getResponseCode')->once()->andReturn(200);

        $result = $worker->getSubscribers();

    }

    public function testGetAllSubscribers()
    {
        $worker = new \designpond\newsletter\Newsletter\Worker\MailjetWorker( $this->mock );

        $return = new stdClass();
        $return->Count = 1;
        $return->Total = 1;
        $return->Data  = [
            [ "Email"  => "cindy.leschaud@gmail.com" ],[ "Email"  => "cindy.leschaud@unine.ch"]
        ];

        $this->mock->shouldReceive('contact')->once()->andReturn($return);

        $result = $worker->getAllSubscribers();

    }
}
