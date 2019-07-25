<?php

namespace App\Library\Http\Resources\Json;

use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;

class ResourceCollection extends BaseResourceCollection
{
    const WITH_DATA = [
        'code' => 0,
        'message' => 'OK',
    ];

    /**
     * The name of the resource being collected.
     *
     * @var string
     */
    public $collects;

    /**
     * Create a new anonymous resource collection.
     *
     * @param  mixed  $resource
     * @param  string  $collects
     * @return void
     */
    public function __construct($resource, $collects)
    {
        $this->collects = $collects;
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return ['data' => $this->collection] + self::WITH_DATA;
    }

    public function toResponse($request)
    {
        return $this->resource instanceof AbstractPaginator
            ? (new PaginatedResourceResponse($this))->toResponse($request)
            : parent::toResponse($request);
    }
}
