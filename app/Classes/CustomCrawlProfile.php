<?php


namespace App\Classes;


use Spatie\Crawler\CrawlProfile;
use Psr\Http\Message\UriInterface;

class CustomCrawlProfile extends CrawlProfile
{
    public function shouldCrawl(UriInterface $url): bool
    {
        if ($url->getHost() !== 'https://belbagno.ru/') {
            return false;
        }

        return $url->getPath() === '/';
    }
}