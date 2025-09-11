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

class FetchArticlesFromNewsData extends FetchFromSource implements ShouldQueue
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
        $news = Http::newsdata()->get('/latest', ['language' => 'en'])->json();

        foreach ($news['results'] as $new) {
            $category = $this->extractCategory($new['category'][0]);
            $category = Category::firstOrCreate(
                ['name' => $category],
                ['name' => $category]
            );
            $source = Source::firstOrCreate(
                [
                    'slug' => Str::slug($new['source_name']),
                ],
                [
                    'name' => $new['source_name'],
                    'slug' => Str::slug($new['source_name']),
                ]
            );

            $author = isset($new['creator']) && ! empty($new['creator'])
            ? Author::firstOrCreate(
                ['name' => $this->extractAuthor($new['creator'][0])],
                ['name' => $this->extractAuthor($new['creator'][0])]
            ) : null;

            try {
                $category->articles()->create([
                    'source_id' => $source['id'],
                    'author_id' => $author?->id,
                    'title' => $new['title'],
                    'slug' => Str::slug($new['title']),
                    'description' => $new['description'],
                    'url' => $new['link'],
                    'url_image' => $new['image_url'],
                    'published_at' => Carbon::parse($new['pubDate']),
                ]);
            } catch (PDOException) {
                Log::warning('Article already exists');
            }
        }

    }
}
