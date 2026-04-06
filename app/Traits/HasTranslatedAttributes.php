<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasTranslatedAttributes
{

    public function toArray()
    {
        $attributes = parent::toArray();

        $locale = request()->header('Accept-Language') ?: App::getLocale();

        if (property_exists($this, 'translatable')) {
            foreach ($this->translatable as $field) {
                if (isset($attributes[$field])) {
                    $attributes[$field] = $this->getTranslation($field, $locale);
                }
            }
        }

        return $attributes;
    }
}
