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
