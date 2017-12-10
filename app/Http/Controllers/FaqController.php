<?php

namespace App\Http\Controllers;

use App\Entities\Faq;
use Corcel\Model\Taxonomy;


class FaqController extends Controller
{
   public function index()
   {
       $categories = Taxonomy::where('taxonomy', 'faq-group')->with('posts')->get();

       return view('faq.index', compact('categories'));
   }
}
