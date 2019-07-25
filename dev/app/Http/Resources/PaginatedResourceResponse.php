<?php

namespace App\Library\Http\Resources\Json;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse as BasePaginatedResourceResponse;

class PaginatedResourceResponse extends BasePaginatedResourceResponse
{
    /**
     * Add the pagination information to the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function paginationInformation($request)
    {
        $paginated = $this->resource->resource->toArray();
        return [
            'page_info' => $this->pageInfoLinks($paginated),
        ];
    }

    /**
     * Get the pagination links for the response.
     *
     * @param  array  $paginated
     * @return array
     */
    protected function pageInfoLinks($paginated)
    {
        return [
            'page' => $paginated['current_page'],
            'per_page' => $paginated['per_page'],
            'total_page' => $paginated['last_page'],
            'total_number' => $paginated['total'],
        ];
    }
}
