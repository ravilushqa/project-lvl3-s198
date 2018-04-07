<?php

namespace App\Jobs;

use App\Domain;
use DiDom\Document;
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

            $body = $response->getBody()->getContents();
            $document = new Document($body);
            $h1 = $document->first('h1');
            $h1Text = isset($h1) ?$h1->text() : null;
            $metaKeywords = $document->first('meta[name=keywords]');
            $metaKeywordsContent = isset($metaKeywords) ? $metaKeywords->getAttribute('content') : null;
            $metaDescription = $document->first('meta[name=description]');
            $metaDescriptionContent = isset($metaDescription) ? $metaDescription->getAttribute('content') : null;

            $this->domain->code = $response->getStatusCode();
            $this->domain->content_length = strlen($body);
            $this->domain->h1 = $h1Text;
            $this->domain->meta_keywords = $metaKeywordsContent;
            $this->domain->meta_description = $metaDescriptionContent;
            $this->domain->save();
        });
        $promise->wait();
    }

}
