<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DomainTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $table = 'domains';
    protected $testUrl = 'https://www.google.com/';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCheckValidDomain()
    {

        $this->post(route('domains.store'), [
            'domain' => $this->testUrl
        ]);

        $this->seeInDatabase($this->table, [
            'name' => $this->testUrl
        ]);

        $this->assertResponseStatus(302);
    }

    public function testListDomains()
    {
        factory(\App\Domain::class, 2)->create(['name' => $this->testUrl]);

        $this->get(route('domains.index'));

        $this->assertResponseOk();
    }
}
