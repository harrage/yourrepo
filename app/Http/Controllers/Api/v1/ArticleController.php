<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\ListArticlesRequest;
use App\Http\Requests\Api\V1\User\ShowArticlesInFeedRequest;
use App\Http\Resources\Api\V1\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(ListArticlesRequest $request)
    {
        $articles = Article::filter($request->filters())
            ->simplePaginate($request->input('per_page'));

        return ArticleResource::collection($articles);
    }

    /**
     * @param  \App\Http\Requests\Api\V1\User\ListArticlesRequest  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function feed(ShowArticlesInFeedRequest $request)
    {
        $user = $request->user();
        $articles = Article::with(['author', 'category', 'source'])
            ->when($user->authors->isNotEmpty(), fn ($q) => $q->whereIn('author_id', $user->authors->pluck('id'))
            )
            ->when($user->categories->isNotEmpty(), fn ($q) => $q->whereIn('category_id', $user->categories->pluck('id'))
            )
            ->when($user->sources->isNotEmpty(), fn ($q) => $q->whereIn('source_id', $user->sources->pluck('id'))
            )
            ->latest('published_at')
            ->simplePaginate($request->integer('per_page', 10));

        return ArticleResource::collection($articles);
    }
}
