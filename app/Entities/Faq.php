<?php

namespace App\Entities;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Faq extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = ['faq_type_id', 'question', 'answer', 'question_de', 'answer_de'];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function type()
    {
        return $this->belongsTo(FaqType::class, 'faq_type_id');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


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

    public function getQuestionAttribute($value)
    {
        return (App::getLocale('de') && $this->question_de) ? $this->question_de : $value;
    }

    public function getAnswerAttribute($value)
    {
        return (App::getLocale('de') && $this->answer_de) ? $this->answer_de : $value;
    }

    public function getOriginalQuestionAttribute($value)
    {
        return $this->getOriginal('question');
    }

    public function getOriginalAnswerAttribute($value)
    {
        return $this->getOriginal('answer');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
