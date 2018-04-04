<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DomainTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $table = 'domains';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCheckValidDomain()
    {
        $this->post('/domains', [
            'domain' => 'https://www.google.com/'
        ]);

        $this->seeInDatabase($this->table, [
            'name' => 'https://www.google.com/'
        ]);

        $this->assertResponseStatus(302);
    }

    public function testListDomains()
    {
        $this->get('/domains');

        $this->assertResponseOk();
    }
}
