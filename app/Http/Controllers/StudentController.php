<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\ParentModel;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Student::query()->with('parent');
    
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            if(auth()->user()->hasRole('teacher')){
                                $editUrl = route('students.edit', $row->id);
                                $csrf = csrf_token();
                                return '
                                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="'.route('students.destroy', $row->id).'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                                        <input type="hidden" name="_token" value="'.$csrf.'">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                ';
                            } else {
                                return 'N/A';
                            }
                        })
                        ->addColumn('parent_name', function ($row) {
                            return ($row->parent) ? $row->parent->name : '';
                        })
                        ->editColumn('created_at', function ($user) {
                            return ($user->created_at) ? date('d-m-Y h:i:s', strtotime($user->created_at)) : '';
                        })
                        ->rawColumns(['action', 'parent_name'])
                        ->make(true);
            }
            return view('students.index');    
        } catch (\Exception $e) {
            Log::error('Failed to list students', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to list students. Please try again.');
        }
        
    }
    
    public function create()
    {
        try {
            $parents = ParentModel::all();
            return view('students.create', compact('parents'));    
        } catch (\Exception $e) {
            Log::error('Failed to create student', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to create student. Please try again.');
        }
        
    }
    
    public function store(Request $request) 
    {
        try {
            $rules = [
                'name'                  => 'required',
                'email'                 => 'required|email|unique:students',
                'parent_id'             => 'required|exists:parent_models,id',
            ];

            $messages = [
                'name.required'         => 'The name field is required.',
                'email.required'        => 'The email field is required.',
                'email.email'           => 'Please enter a valid email address.',
                'email.unique'          => 'Email already exists.',
                'parent_id.required'    => 'The parent field is required.',
                'parent_id.exists'      => 'Invalid parent selection.',

            ];
            $validator              = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
            Student::create($request->all());
            Log::info('Student saved successfully', ['email' => $request->email]);
            return redirect()->route('students.index')->with('success', 'Student created successfully');    
        } catch (\Exception $e) {
            Log::error('Failed to store student', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to store student. Please try again.');
        }
        
    }
    
    public function edit(Student $student)
    {   
        try {
            $parents = ParentModel::all();
            return view('students.edit', compact('student', 'parents'));    
        } catch (\Exception $e) {
            Log::error('Failed to edit student', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to edit student. Please try again.');
        }
        
    }
    
    public function update(Request $request, Student $student)
    {
        try {
            $rules = [
                'name'                  => 'required',
                'email'                 => 'required|email|unique:students,email,'.$student->id,
                'parent_id'             => 'required|exists:parent_models,id',
            ];

            $messages = [
                'name.required'         => 'The name field is required.',
                'email.required'        => 'The email field is required.',
                'email.email'           => 'Please enter a valid email address.',
            ];
            $validator              = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
        
            $student->update($request->all());
            Log::info('Teacher created successfully', ['email' => $request->email]);
            return redirect()->route('students.index')->with('success', 'Student updated successfully');

        }  catch (\Exception $e) {
            Log::error('Failed to update student', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to update student. Please try again.');
        }
        
    }
    
    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return redirect()->route('students.index')->with('success', 'Student deleted successfully');    
        } catch (\Exception $e) {
            Log::error('Failed to delete student', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to delete student. Please try again.');
        }
        
    }
}
