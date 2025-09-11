<?php

namespace App\Enums;

enum CategoryEnum: string
{
    case BUSINESS = 'business';
    case ENTERTAINMENT = 'entertainment';
    case GENERAL = 'general';
    case HEALTH = 'health';
    case SCIENCE = 'science';
    case SPORTS = 'sports';
    case TECHNOLOGY = 'technology';
    case POLITICS = 'politics';
}
