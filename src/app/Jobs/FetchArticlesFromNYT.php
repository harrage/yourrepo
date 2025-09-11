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

class FetchArticlesFromNYT extends FetchFromSource implements ShouldQueue
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
        $news = Http::nyt()->get('/articlesearch.json', [
            'api-key' => config('services.nyt.api_key'),
        ])->json();

        foreach ($news['response']['docs'] as $new) {
            $category = $this->extractCategory($new['news_desk']);
            $category = Category::firstOrCreate(
                ['name' => $category],
                ['name' => $category]
            );
            $source = Source::firstOrCreate(
                [
                    'slug' => Str::slug($new['source']),
                ],
                [
                    'name' => $new['source'],
                    'slug' => Str::slug($new['source']),
                ]
            );
            $author = Author::firstOrCreate(
                ['name' => $this->extractAuthor($new['byline']['original'])],
                ['name' => $this->extractAuthor($new['byline']['original'])]
            );

            try {
                $category->articles()->create([
                    'source_id' => $source['id'],
                    'author_id' => $author->id,
                    'title' => $new['headline']['main'],
                    'slug' => Str::slug($new['headline']['main']),
                    'description' => $new['snippet'],
                    'url' => $new['web_url'],
                    'url_image' => $new['multimedia']['default']['url'],
                    'published_at' => Carbon::parse($new['pub_date']),
                ]);
            } catch (PDOException) {
                Log::warning('Article already exists');
            }
        }
    }
}
