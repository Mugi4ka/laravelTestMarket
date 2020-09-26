<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DiDom\Document;
use GuzzleHttp\Client;
use phpDocumentor\Reflection\Types\False_;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class ParserController extends Controller
{
    public $result;

    public function parserIndex()
    {
        $client = new Client(['cookies' => true]);

        $url = 'https://belbagno.ru/product/unitaz-podvesnoy-bezobodkovyy-belbagno-genova-bb1102ch/';

        $filePath = basename($url);

        $response = $client->request('GET', $url, [
            'sink' => storage_path('app/' . $filePath),
        ]);
    }

    public function parseHtml()
    {
        $url = 'https://belbagno.ru/product/unitaz-podvesnoy-bezobodkovyy-belbagno-genova-bb1102ch/';

        $filePath = basename($url);

        $document = new Document(storage_path('app/' . $filePath), true);

        $propertiesTable = $document->find('.product-item-detail-properties-block')[1];

        $propertiesRows = $propertiesTable->find('.product-item-detail-properties');

        foreach ($propertiesRows as $propertiesRow) {
            $propertyName = $propertiesRow->child(1)->text();
            $propertyValue = $propertiesRow->child(3)->text();

            $result[$propertyName] = $propertyValue;
        }

        $fp = fopen(storage_path('app/test.csv'), 'a+');


        $a = array_keys($result);
        fputcsv($fp, $a, ';');

        $b = array_values($result);
        fputcsv($fp, $b, ';');


        fclose($fp);
    }

    public function sitemapGenerator()
    {
        $path = storage_path('app/sitemap.xml');
//        SitemapGenerator:: create('https://belbagno.ru/')
//            ->configureCrawler(function (Crawler $crawler) {
//                $crawler->setMaximumDepth(3);
//            })
//            ->writeToFile($path);

        SitemapGenerator::create('https://belbagno.ru')
            ->hasCrawled(function (Url $url) {

                if ($url->segment(1) == 'product') {
                    $url->setPriority(1.0);
                    return $url;
                }
                else {
                    return "";
                }


            })
            ->writeToFile($path);
    }


}
