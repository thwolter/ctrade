<?php

namespace App\Http\Controllers;

use App\Entities\FaqType;
use Illuminate\Http\Request;

class FaqController extends Controller
{
   public function index()
   {
       $types = FaqType::all();
       return view('faq.index', compact('types'));
   }
}
