<?php

namespace Underwear\LaravelTranslatableJsonResource;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Translatable\HasTranslations;

abstract class TranslatableJsonResource extends JsonResource
{
    /**
     * @var string
     */
    public $locale;

    public function __construct($resource, $locale = null)
    {
        $this->locale = $locale ?? config('app.locale');

        $resource->locale = $this->locale;

        parent::__construct($resource);
    }

    /**
     * Create a new anonymous resource collection.
     *
     * @param mixed       $resource
     * @param string|null $locale
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource, $locale = null)
    {
        if (!$locale) {
            $locale = config('app.locale');
        }

        return new TranslatableAnonymousResourceCollection($resource, static::class, $locale);
    }

    public function __get($key)
    {
        if (in_array(HasTranslations::class, class_uses_recursive($this->resource))
            && in_array($key, $this->resource->getTranslatableAttributes())) {
            return $this->resource->getTranslation($key, $this->locale);
        }

        return parent::__get($key);
    }
}
