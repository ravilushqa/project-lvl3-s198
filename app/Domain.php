<?php

namespace App;

use App\Jobs\ParseDomainData;
use Illuminate\Database\Eloquent\Model;

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

        static::created(function ($domain) {
            dispatch(new ParseDomainData($domain));
        });
    }
}
