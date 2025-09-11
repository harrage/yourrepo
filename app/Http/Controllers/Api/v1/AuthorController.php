<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\FilterAuthorsRequest;
use App\Http\Resources\Api\V1\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthorController extends Controller
{
    public function index(FilterAuthorsRequest $request): ResourceCollection
    {
        $author = Author::where('name', 'like', $request->input('name').'%')->get();

        return AuthorResource::collection($author);
    }
}
