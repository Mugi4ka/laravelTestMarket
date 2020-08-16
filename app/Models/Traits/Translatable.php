<?php


namespace App\Models\Traits;


use Illuminate\Support\Facades\App;

trait Translatable
{
    public $defaultLocale = 'ru';

    public function __($fieldName)
    {

        $locale = App::getLocale() ?? $this->defaultLocale;
        if ($locale === 'en') {
            $fieldName .= '_en';
        }


    }

}