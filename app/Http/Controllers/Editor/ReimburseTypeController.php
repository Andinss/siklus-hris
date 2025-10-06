<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReimburseType;
use Yajra\DataTables\DataTables;
use Validator;
use Auth;

class ReimburseTypeController extends Controller
{
    protected $rules =
    [
        'reimburse_type_name' => 'required'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('editor.reimburse_type.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $itemdata = ReimburseType::orderBy('reimburse_type_name', 'ASC')->get();

            return DataTables::of($itemdata)

                ->addColumn('action', function ($itemdata) {
                    return '<a href="#" onclick="edit(' . "'" . $itemdata->id . "'" . ')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id(' . "'" . $itemdata->id . "', '" . $itemdata->reimburse_type_name . "'" . ')"> <i class="fas fa-trash-alt"></i> Hapus</a>';
                })
                ->toJson();
        } else {
            exit("No data available");
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $post = new ReimburseType();
            $post->reimburse_type_name = $request->reimburse_type_name;
            $post->status = $request->status;
            $post->created_by = Auth::id();
            $post->save();

            return response()->json($post);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reimburse_type = ReimburseType::Find($id);
        echo json_encode($reimburse_type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $post = ReimburseType::Find($id);
            $post->reimburse_type_name = $request->reimburse_type_name;
            $post->status = $request->status;
            $post->updated_by = Auth::id();
            $post->save();

            return response()->json($post);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = ReimburseType::Find($id);
        $post->delete();

        return response()->json($post);
    }
}
