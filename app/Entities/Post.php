<?php

namespace App\Entities;

use App\Presenters\PostPresenter;
use App\Presenters\Presentable;
use Corcel\Model\Post as Corcel;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Post extends Corcel
{

    use Presentable, Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $postType = 'post';

    protected $presenter = PostPresenter::class;


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function sluggable()
    {
        return ['slug' => ['source' => 'post_name']];
    }


    public function getRouteKeyName()
    {
        return 'post_name';
    }


    public function categories()
    {
        $categories = [];
        foreach ($this->taxonomies->where('taxonomy', 'category') as $category) {
            $categories[] = [
                'name' => $category->name,
                'slug' => $category->slug
            ];
        }
        return $categories;
    }

    public function thumbnailUrl()
    {
        $thumbnail = $this->thumbnail()->first();
        return $thumbnail ? $thumbnail->attachment->guid : null;
    }

    public function hasThumbnail()
    {
        return ! is_null($this->thumbnailUrl());
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
