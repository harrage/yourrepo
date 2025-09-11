<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\FilterSourcesRequest;
use App\Http\Resources\Api\V1\SourceResource;
use App\Models\Source;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SourceController extends Controller
{
    /**
     * @param  mixed  $request
     * @return SourceResource
     */
    public function index(FilterSourcesRequest $request): ResourceCollection
    {
        $source = Source::where('name', 'like', $request->input('name').'%')->get();

        return SourceResource::collection($source);
    }
}
