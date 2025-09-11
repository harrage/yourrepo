<?php

use App\Jobs\FetchArticlesFromNewsAPI;
use App\Jobs\FetchArticlesFromNewsData;
use App\Jobs\FetchArticlesFromNYT;

Schedule::job(FetchArticlesFromNewsAPI::class)->everyFiveMinutes();
Schedule::job(FetchArticlesFromNYT::class)->everyFiveMinutes();
Schedule::job(FetchArticlesFromNewsData::class)->everyTenMinutes();
