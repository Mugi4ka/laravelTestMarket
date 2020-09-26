<?php

namespace App\Http\Controllers;

use DiDom\Document;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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


}
