<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DataTables;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $data = Announcement::query()->select(['id', 'announcement', 'announcement_type', 'created_at']);
    
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            // $editUrl = route('announcements.edit', $row->id);
                            // $csrf = csrf_token();
    
                            // return '
                            //     <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                            //     <form action="'.route('announcements.destroy', $row->id).'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                            //         <input type="hidden" name="_token" value="'.$csrf.'">
                            //         <input type="hidden" name="_method" value="DELETE">
                            //         <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            //     </form>
                            // ';
                            $editUrl = route('announcements.edit', $row->id);
    
                            return '
                                <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>';
                        })
                        ->addColumn('announcement_type_label', function($announcement) {
                            return $announcement->announcement_type_label;
                        })
                        ->editColumn('created_at', function ($user) {
                            return ($user->created_at) ? date('d-m-Y h:i:s', strtotime($user->created_at)) : '';
                        })
                        ->rawColumns(['action','announcement_type_label'])
                        ->make(true);
            }
            return view('announcements.index');
        }  catch (\Exception $e) {
            Log::error('Failed to list announcement', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to list announcement. Please try again.');
        }
        
    }

    public function create()
    {
        try{
            return view('announcements.create');
        } catch (\Exception $e) {
            Log::error('Failed to create announcement', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to create announcement. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try{
            $rules = [
                'announcement'                  => 'required',
                'announcement_type'             => 'required|in:0,1,2,3',
            ];

            $messages = [
                'announcement.required'         => 'The name field is required.',
                'announcement_type.required'    => 'The email field is required.',
                'announcement_type.in'          => 'Please select a valid type.',
            ];
            $validator              = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
    
            Announcement::create($request->all());
            Log::info('Announcement created successfully', ['announcement' => $request->announcement]);

            return redirect()->route('announcements.index')->with('success', 'Announcement created successfully.');
        } catch(\Exception $e){
            Log::error('Failed to create announcement', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to create announcement. Please try again.');
        }
        
    }

    // public function edit(Announcement $announcement)
    // {
    //     return view('announcements.edit', compact('announcement'));
    // }

    // public function update(Request $request, Announcement $announcement)
    // {
    //     try{
    //         $request->validate([
    //             'announcement' => 'required|string',
    //             'announcement_type' => 'required|in:0,1,2,3',
    //         ]);
    
    //         $announcement->update($request->all());
    
    //         return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully.');
    //     } catch(\Exception $e){
    //         dd( $e );
    //     }
        
    // }

    public function destroy(Announcement $announcement)
    {
        try{
            $announcement->delete();
            return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete announcement', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to delete announcement. Please try again.');
        }
        
    }
}
