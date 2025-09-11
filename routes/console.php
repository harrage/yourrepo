<?php

use App\Jobs\FetchArticlesFromNewsAPI;
use App\Jobs\FetchArticlesFromNewsData;
use App\Jobs\FetchArticlesFromNYT;

Schedule::job(FetchArticlesFromNewsAPI::class)->everyMinute();
Schedule::job(FetchArticlesFromNYT::class)->everyMinute();
Schedule::job(FetchArticlesFromNewsData::class)->everyMinute();
