<?php

namespace App\Http\Controllers;

use App\Models\ParentModel;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ParentModelController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = ParentModel::query()->select(['id', 'name', 'email', 'created_at']);
    
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            if(auth()->user()->hasRole('teacher')){
                                $editUrl = route('parents.edit', $row->id);
                                $csrf = csrf_token();
    
                                return '
                                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="'.route('parents.destroy', $row->id).'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                                        <input type="hidden" name="_token" value="'.$csrf.'">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                ';
                            } else {
                                return 'N/A';
                            }
                        })
                        ->editColumn('created_at', function ($user) {
                            return ($user->created_at) ? date('d-m-Y h:i:s', strtotime($user->created_at)) : '';
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
            return view('parents.index');    
        } catch (\Exception $e) {
            Log::error('Failed to list parent', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to list parent. Please try again.');
        }
        
    }
    
    public function create()
    {
        try {
            return view('parents.create');
        } catch (\Exception $e) {
            Log::error('Failed to create parent', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to create parent. Please try again.');
        }
    }
    
    public function store(Request $request)
    {
        try {
            $rules = [
                'name'                  => 'required',
                'email'                 => 'required|email|unique:parent_models,email',
            ];

            $messages = [
                'name.required'         => 'The name field is required.',
                'email.required'        => 'The email field is required.',
                'email.email'           => 'Please enter a valid email address.',
                'email.unique'          => 'Email is already exists.',

            ];
            $validator              = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
            
            ParentModel::create($request->all());
            Log::info('Teacher created successfully', ['email' => $request->email]);
            return redirect()->route('parents.index')->with('success', 'Parent created successfully');    
        }  catch (\Exception $e) {
            Log::error('Failed to save parent', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to save parent. Please try again.');
        }
        
    }
    
    public function edit(ParentModel $parent)
    {
        try {
            return view('parents.edit', compact('parent'));
        }catch (\Exception $e) {
            Log::error('Failed to edit parent', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to edit parent. Please try again.');
        }
    }
    
    public function update(Request $request, ParentModel $parent)
    {
        try {
            $rules = [
                'name'                  => 'required',
                'email'                 => 'required|email|unique:parent_models,email,'.$parent->id,
            ];

            $messages = [
                'name.required'         => 'The name field is required.',
                'email.required'        => 'The email field is required.',
                'email.email'           => 'Please enter a valid email address.',
                'email.unique'          => 'Email already exists.',
            ];
            $validator              = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
            $parent->update($request->all());
            Log::info('Parent updated successfully', ['parent_id' => $parent->id, 'email' => $request->email]);
            return redirect()->route('parents.index')->with('success', 'Parent updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to update parent', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to update parent. Please try again.');
        }

    }
    
    public function destroy(ParentModel $parent)
    {
        try {
            $parent->delete();
            return redirect()->route('parents.index')->with('success', 'Parent deleted successfully');
        } catch (\Throwable $th) {
            Log::error('Failed to delete parent', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to delete parent. Please try again.');
        }
    }
}
