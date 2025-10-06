<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Validator;
use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\DB;
use View;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faq = Faq::all();
    	return view ('editor.faq.index', compact('faq'));
    }

    public function create()
    {
    	return view ('editor.faq.form');
    }

    public function store(Request $request)
    {
    	$faq = new Faq;
    	$faq->title = $request->input('title');
    	$faq->content = $request->input('content');
    	$faq->save();

    	return redirect()->action('Editor\FaqController@index');
    }

    public function edit($id)
    {
    	$faq = Faq::find($id);
    	return view ('editor.faq.form', compact('faq'));
    }

    public function update($id, Request $request)
    {
    	$faq = Faq::find($id);
    	$faq->title = $request->input('title');
    	$faq->content = $request->input('content');
    	$faq->save();
    	return redirect()->action('Editor\FaqController@index');
    }

    public function delete($id)
    {
    	Faq::find($id)->delete();
    	return redirect()->action('Editor\FaqController@index');
    }
}
