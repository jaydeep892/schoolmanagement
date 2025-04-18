<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use DataTables;

class TeacherUserController extends Controller
{
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $data = User::query()->role('teacher')->select(['id', 'name', 'email', 'created_at']);
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $editUrl = route('teachers.edit', $row->id);
                            $csrf = csrf_token();
    
                            return '
                                <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                                <form action="'.route('teachers.destroy', $row->id).'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                                    <input type="hidden" name="_token" value="'.$csrf.'">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            ';
                        })
                        ->editColumn('created_at', function ($user) {
                            return ($user->created_at) ? date('d-m-Y h:i:s', strtotime($user->created_at)) : '';
                        })
                        ->rawColumns(['action'])
                        ->make(true);

            }
        
            return view('teachers.index');
        }catch (\Exception $e) {
            Log::error('Failed to list teacher', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to list teacher. Please try again.');
        }
        
    }

    public function create()
    {
        try{
            return view('teachers.create');
        } catch (\Exception $e) {
            Log::error('Failed to create teacher', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to create teacher. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'name'                  => 'required',
                'email'                 => 'required|email|unique:users',
                'password'              => 'required|string|confirmed|min:6',
            ];

            $messages = [
                'name.required'         => 'The name field is required.',
                'email.required'        => 'The email field is required.',
                'email.email'           => 'Please enter a valid email address.',
                'password.required'     => 'The Password field is required.',
            ];
            $validator              = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('teacher');
            Log::info('Teacher created successfully', ['user_id' => $user->id, 'email' => $user->email]);

            return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to save teacher', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to save teacher. Please try again.');
        }
    }

    public function edit(User $teacher)
    {
        try{
            return view('teachers.edit', compact('teacher'));
        } catch (\Exception $e) {
            Log::error('Failed to edit teacher', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to edit teacher. Please try again.');
        }
    }

    public function update(Request $request, User $teacher)
    {
        try{

            $rules = [
                'name'                  => 'required',
                'email'                 => 'required|email|unique:users,email,' . $teacher->id,
            ];

            $messages = [
                'name.required'         => 'The name field is required.',
                'email.required'        => 'The email field is required.',
                'email.email'           => 'Please enter a valid email address.',
                'password.required'     => 'The Password field is required.',
            ];
            $validator              = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }

            $teacher->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            Log::info('Teacher updated successfully', ['user_id' => $teacher->id, 'email' => $teacher->email]);
            return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update teacher', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to update teacher. Please try again.');
        }
    }

    public function destroy(User $teacher)
    {
        try{
            $teacher->delete();
            return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete teacher', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to delete teacher. Please try again.');
        }
        
    }
}
