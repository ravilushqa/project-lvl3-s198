<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\ResponseInterface;

class Domain extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'content_length'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        static::creating(function() {
            $this->setDomainData();
        });
    }

    protected function setDomainData()
    {
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', $this->name);

        $promise = $client->sendAsync($request)->then(function (ResponseInterface $response) {
            $this->code = $response->getStatusCode();
            $this->content_length = $response->getHeader('content-length')[0] ?? strlen($response->getBody()->getContents());
        });
        $promise->wait();
    }
}
