<?php

namespace App\Jobs;

use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PDOException;

class FetchArticlesFromNewsAPI extends FetchFromSource implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            $news = Http::news()->get('/top-headlines', [
                'country' => 'us',
                'category' => $category->name,
                'pageSize' => 100,
            ])->json();
            if (! isset($news['articles'])) {
                continue;
            }
            foreach ($news['articles'] as $new) {
                $source = Source::firstOrCreate(
                    [
                        'slug' => $new['source']['id'] ?? Str::slug($new['source']['name']),
                    ],
                    [
                        'name' => $new['source']['name'],
                        'slug' => $new['source']['id'] ?? Str::slug($new['source']['name']),
                    ]
                );

                $author = Author::firstOrCreate(
                    ['name' => $this->extractAuthor($new['author'])],
                    ['name' => $this->extractAuthor($new['author'])]
                );

                try {
                    $category->articles()->create([
                        'source_id' => $source['id'],
                        'author_id' => $author->id,
                        'title' => $new['title'],
                        'slug' => Str::slug($new['title']),
                        'description' => $new['description'],
                        'url' => $new['url'],
                        'url_image' => $new['urlToImage'],
                        'published_at' => Carbon::parse($new['publishedAt']),
                    ]);
                } catch (PDOException) {
                    Log::warning('Article already exists');
                }
            }
        }
    }
}
