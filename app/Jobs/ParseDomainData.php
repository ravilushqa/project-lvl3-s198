<?php

namespace App\Jobs;

use App\Domain;
use App\Events\DomainCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Request;

class ParseDomainData implements ShouldQueue
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 10;

    protected $domain;

    /**
     * Create the event listener.
     *
     * @param Domain $domain
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $this->setDomainData();
    }

    protected function setDomainData()
    {
        $client = new Client();

        $request = new Request('GET', $this->domain->name);

        $promise = $client->sendAsync($request)->then(function (ResponseInterface $response) {
            $this->domain->code = $response->getStatusCode();
            $this->domain->content_length = $response->getHeader('content-length')[0] ?? strlen($response->getBody()->getContents());
            $this->domain->save();
        });
        $promise->wait();
    }

}
