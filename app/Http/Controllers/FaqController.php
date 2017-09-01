<?php

namespace App\Http\Controllers;

use App\Entities\FaqType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


class FaqController extends Controller
{
   public function index()
   {
       $categories = FaqType::all();
       $mail = Config::get('settings.contact_email');
       return view('faq.index', compact('categories', 'mail'));
   }
}
