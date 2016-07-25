<?php

class MailjetWorkerTest extends TestCase
{
    protected $mailjet;
    protected $resources;

    public function setUp()
    {
        parent::setUp();

        $this->mailjet = Mockery::mock('\Mailjet\Client');
        $this->app->instance('\Mailjet\Client', $this->mailjet);

        $this->resources = Mockery::mock('\Mailjet\Resources');
        $this->app->instance('\Mailjet\Resources', $this->resources);
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
        $worker = \App::make('designpond\newsletter\Newsletter\Worker\MailjetServiceInterface');

        $worker->setList(1);

        $this->assertEquals(1, 1);
    }

    /**
     * @expectedException designpond\newsletter\Exceptions\ListNotSetException
     */
    public function testNoListException()
    {
        $worker = new \designpond\newsletter\Newsletter\Worker\MailjetService($this->mailjet,$this->resources);
        $result = $worker->getSubscribers();
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetNewsletters()
    {
        $worker = new \designpond\newsletter\Newsletter\Worker\MailjetService($this->mailjet,$this->resources);
        $worker->setList(1);

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

        $response = Mockery::mock('\Mailjet\Response');

        $this->mailjet->shouldReceive('get')->once()->andReturn($response);
        $response->shouldReceive('success')->once()->andReturn(true);
        $response->shouldReceive('getData')->once()->andReturn(json_encode($return));

        $result = $worker->getSubscribers();

    }


     public function testGetAllSubscribers()
     {
         $worker = new \designpond\newsletter\Newsletter\Worker\MailjetService($this->mailjet,$this->resources);
         $worker->setList(1);
         
         $return = new stdClass();
         $return->Count = 1;
         $return->Total = 1;
         $return->Data  = [
             [ "Email"  => "cindy.leschaud@gmail.com" ],[ "Email"  => "cindy.leschaud@unine.ch"]
         ];

        $response = Mockery::mock('\Mailjet\Response');

        $this->mailjet->shouldReceive('get')->once()->andReturn($response);
        $response->shouldReceive('success')->once()->andReturn(true);
        $response->shouldReceive('getData')->once()->andReturn(json_encode($return));

        $result = $worker->getSubscribers();

     }
}
