<?php

namespace App\Http\Controllers\Editor;

use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Repository\RoleRepository;

class RoleController extends Controller
{
    //
	protected $RoleRepository;

	public function __construct(RoleRepository $role_repository)
	{
		$this->RoleRepository = $role_repository;
	}

    public function index()
    {
    	$roles = $this->RoleRepository->get_all();
    	return view ('editor.role.index', compact('roles'));
    }

   	public function create()
   	{
   		return view ('editor.role.form');
   	}

   	public function store(RoleRequest $request)
   	{
      $role = $this->RoleRepository->store($request->input());
      return redirect()->action('Editor\RoleController@index');
   	}

    public function show($id)
    {
      $role = $this->RoleRepository->get_one($id);
      return view ('editor.role.detail', compact('role'));
    }
}
