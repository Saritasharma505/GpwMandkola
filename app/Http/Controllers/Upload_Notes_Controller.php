<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Department;
use App\Division;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Country;
use App\UploadNotes;
use App\update_task;
use Illuminate\Http\Request;

class Upload_Notes_Controller extends Controller {

    protected $redirectTo = '/task-mgmt';

    public function index() {

        $notes = DB::table('upload_notes')
                ->leftJoin('department', 'upload_notes.department_id', '=', 'department.id')
                ->leftJoin('division', 'upload_notes.division_id', '=', 'division.id')
                ->select('upload_notes.*', 'department.name as department_name', 'department.id as department_id', 'division.name as division_name', 'division.id as division_id')
                ->paginate(5);

        return view('task-mgmt/index', compact('notes' , $notes));
    }

    public function create() {
        $departments = Department::all();
        $divisions = Division::all();
        return view('task-mgmt/create', ['departments' => $departments, 'divisions' => $divisions]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'task_detail' => 'required',
            'department_id' => 'required',
            'division_id' => 'required',
            'file' => 'required',
        ]);
        // Upload image
        if ($request->hasFile('file')) {
            
        }
        $filename = $request->file->getClientOriginalName();

        $request->file->storeAs('public/download', $filename);

        $notes = new UploadNotes;

        $notes->title = $request->title;
        $notes->task_detail = $request->task_detail;
        $notes->department_id = $request->department_id;
        $notes->division_id = $request->division_id;
        $notes->file = $filename;
        $notes->save();
        return redirect()->intended('/task-management');
    }

    public function show($id) {
        
    }

    public function destroy($id) {
        UploadNotes::where('id', $id)->delete();
        return redirect()->intended('/task-management');
    }

    public function edit($id) {
        $update_task = UploadNotes::find($id);
        // Redirect to state list if updating state wasn't existed
        if ($update_task == null) {
            return redirect()->intended('/task-management');
        }

        $departments = Department::all();
        $divisions = Division::all();
        return view('task-mgmt/edit', ['update_task' => $update_task, 'departments' => $departments, 'divisions' => $divisions]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required',
            'task_detail' => 'required',
            'department_id' => 'required',
            'division_id' => 'required',
            'file' => 'required',
        ]);
        // Upload image
        if ($request->hasFile('file')) {
            
        }
        $filename = $request->file->getClientOriginalName();

        $request->file->storeAs('public/download', $filename);


        $update_task = UploadNotes::find($id);

        $update_task->title = $request->title;
        $update_task->task_detail = $request->task_detail;
        $update_task->department_id = $request->department_id;
        $update_task->division_id = $request->division_id;
        $update_task->file = $filename;
        $update_task->save();
        return redirect()->intended('/task-management');
    }

    public function search(Request $request) {
        $constraints = [
            'department.name' => $request['department_name'],
             'title' => $request['title'],
            ];
        $search_task = $this->doSearchingQuery($constraints);
        $constraints['department_name'] = $request['department_name'];
        return view('task-mgmt/index', ['upload_notes' => $search_task, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('upload_notes')
        ->leftJoin('department', 'upload_notes.department_id', '=', 'department.id')
        ->leftJoin('division', 'upload_notes.division_id', '=', 'division.id')
        ->select('upload_notes.title as notes_title', 'upload_notes.*','department.name as department_name', 'department.id as department_id', 'division.name as division_name', 'division.id as division_id');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }
            $index++;
        }
        return $query->paginate(5);
    }


    private function validateInput($request) {
        $this->validate($request, [
            'title' => 'required|max:60',
            'task_detail' => 'required|max:200',
            'department' => 'required|max:60',
            'department_id' => 'required',
            'division_id' => 'required'
        ]);
    }

}
