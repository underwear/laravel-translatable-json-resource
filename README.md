# laravel-translatable-json-resource
Spatie laravel translatable package + Laravel JsonResource

* [spatie/laravel-translatable package github repo](https://github.com/spatie/laravel-translatable)
* [Eloquent API JSON Resources documentation](https://laravel.com/docs/8.x/eloquent-resources)

## Installation

```bash
composer require underwear/laravel-translatable-json-resource
```

## Usage

You don't need to worry about things, just keep using JsonResource as you're used to.

Have a look:

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Underwear\LaravelTranslatableJsonResource\TranslatableJsonResource;

class ArticleResource extends TranslatableJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title, // translatable field,
            'body' => $this->body, // translatable field
            'created_at' => $this->created_at
        ];
    }
}
```

You only need to pass one additional argument `locale`:
```php
use App\Http\Resources\ArticleResource;
use App\Models\Articles;

Route::get('/article/{id}', function ($id) {
    $article = Article::findOrFail($id);
    $locale = 'en';
    return new ArticleResource($article, $locale);
});
```

It also works with anonymous collections:
```php
use App\Http\Resources\ArticleResource;
use App\Models\Articles;

Route::get('/articles', function () {
    $articles = Article::all();
    $locale = 'ru';
    return ArticleResource::collection($articles, $locale);
});
```

If you don't pass locale argument, it will use default locale from `config('app.locale')`
