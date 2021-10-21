<?php

namespace Underwear\LaravelTranslatableJsonResource;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TranslatableAnonymousResourceCollection extends AnonymousResourceCollection
{
    /**
     * @var string
     */
    public $locale;

    /**
     * Create a new anonymous resource collection.
     *
     * @param mixed  $resource
     * @param string $collects
     *
     * @return void
     */
    public function __construct($resource, $collects, $locale)
    {
        $this->locale = $locale;

        parent::__construct($resource, $collects);
    }

    /**
     * @param mixed $resource
     *
     * @return mixed
     * @throws \Exception
     */
    protected function collectResource($resource)
    {
        $collects = $this->collects();

        if ($resource instanceof \Traversable) {
            $wrappedItems = [];
            foreach ($resource as $item) {
                $wrappedItems[] = new $collects($item, $this->locale);
            }
        }

        return parent::collectResource($wrappedItems ?? $resource);
    }

}
