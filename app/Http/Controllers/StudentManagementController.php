<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Students;
use App\City;
use App\State;
use App\Country;
use App\Department;
use App\Division;
use App\emailId;
use Mail;
use App\POST;
//use App\Mail\EmailVerification;

class StudentManagementController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $students = DB::table('students')
                ->leftJoin('city', 'students.city_id', '=', 'city.id')
                ->leftJoin('department', 'students.department_id', '=', 'department.id')
                ->leftJoin('state', 'students.state_id', '=', 'state.id')
                ->leftJoin('country', 'students.country_id', '=', 'country.id')
                ->leftJoin('division', 'students.division_id', '=', 'division.id')
                //->leftJoin('emailId', 'employees.emailId', '=','emailId')
                ->select('students.*', 'department.name as department_name', 'department.id as department_id', 'division.name as division_name', 'division.id as division_id')
                ->paginate(5);

        return view('student-mgmt/index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // $cities = City::all();
         //$states = State::all();
        $countries = Country::all();
        $departments = Department::all();
        $divisions = Division::all();
        return view('student-mgmt/create', ['countries' => $countries,
            'departments' => $departments, 'divisions' => $divisions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request) {
//        $this->validateInput($request);
//        // Upload image
//      // $path = $request->file('picture')->store('avatars');
//        $keys = ['lastname', 'firstname', 'mobile', 'address', 'city_id', 'state_id', 'country_id', 'zip',
//            'age', 'birthdate', 'admission_date', 'department_id', 'division_id', 'emailId'];
//        //print_r($keys);
//       // $input = $this->createQueryInput($keys, $request);
//        $input['picture'] = $path;
//        // Not implement yet
//        // $input['company_id'] = 0;
//        
//        Students::create($input);
//
//        return redirect()->intended('/student-management');
//    }
        
    public function store(Request $req){
        
        $firstname = $req->input('firstname');
        $lastname = $req->input('lastname');
        $mobile = $req->input('mobile');
        $emailId = $req->input('emailId');
        $rollno = $req->input('rollno');
        $address = $req->input('address');
        $country_id = $req->input('country_id');
        $state_id = $req->input('state_id');
        $city_id = $req->input('city_id');
        $zip = $req->input('zip');
        $age = $req->input('age');
        $birthdate = $req->input('birthdate');
        $admission_date = $req->input('admission_date');
        $department_id = $req->input('department_id');
        $division_id = $req->input('division_id');
        
        $data = array("firstname"=>$firstname, "lastname"=>$lastname, "mobile"=>$mobile,"rollno"=>$rollno, "emailId"=>$emailId, "address"=>$address, "country_id"=>$country_id,"state_id"=>$state_id, "city_id"=>$city_id, "zip"=>$zip, "age"=>$age,
            "birthdate"=>$birthdate, "admission_date"=>$admission_date, "department_id"=>$department_id,"division_id" =>$division_id);
       
        DB::table('students')->insert($data);
        return redirect()->intended('/student-management');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $students = Students::find($id);
        
        // Redirect to state list if updating state wasn't existed
        if ($students == null || count($students) == 0) {
            return redirect()->intended('/student-management');
        }
        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
        $departments = Department::all();
        $divisions = Division::all();
        return view('student-mgmt/edit', ['students' => $students, 'cities' => $cities, 'states' => $states, 'countries' => $countries,
            'departments' => $departments, 'divisions' => $divisions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
      public function update(Request $request, $id)
    {
        $students = Students::findOrFail($id);
         $this->validate($request, [
        'firstname' => 'required|max:60',
         'lastname' => 'required|max:60',
             'mobile' => 'required|max:60',
             'rollno' => 'required|max:60',
             'emailId' => 'required|max:60',
             'address' => 'required|max:60',
             'country_id' => 'required|max:60',
             'state_id' => 'required|max:60',
             'city_id' => 'required|max:60',
             'zip' => 'required|max:60',
             'age' => 'required|max:60',
             'birthdate' => 'required|max:60',
             'admission_date' => 'required|max:60',
             'department_id' => 'required|max:60',
             'division_id' => 'required|max:60',
        ]);
        $input = [
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'mobile' => $request['mobile'],
            'rollno' => $request['rollno'],
            'emailId' => $request['emailId'],
            'address' => $request['address'],
            'country_id' => $request['country_id'],
            'state_id' => $request['state_id'],
            'city_id' => $request['city_id'],
            'zip' => $request['zip'],
            'age' => $request['age'],
            'birthdate' => $request['birthdate'],
            'admission_date' => $request['admission_date'],
            'department_id' => $request['department_id'],
            'division_id' => $request['division_id']
        ];
        Students::where('id', $id)
            ->update($input);
        
        return redirect()->intended('student-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Students::where('id', $id)->delete();
        return redirect()->intended('/student-management');
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'firstname' => $request['firstname'],
            'department.name' => $request['department_name']
        ];
        $students = $this->doSearchingQuery($constraints);
        $constraints['department_name'] = $request['department_name'];
        return view('student-mgmt/index', ['students' => $students, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('students')
                ->leftJoin('city', 'students.city_id', '=', 'city.id')
                ->leftJoin('department', 'students.department_id', '=', 'department.id')
                ->leftJoin('state', 'students.state_id', '=', 'state.id')
                ->leftJoin('country', 'students.country_id', '=', 'country.id')
                ->leftJoin('division', 'students.division_id', '=', 'division.id')
                //->leftJoin('emailId', 'employees.emailId', '=', 'emailId')
                ->select('students.firstname as students_name', 'students.*', 'department.name as department_name', 'department.id as department_id', 'division.name as division_name', 'division.id as division_id');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%' . $constraint . '%');
            }

            $index++;
        }
        return $query->paginate(5);
    }

    /**
     * Load image resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function load($name) {
        $path = storage_path() . '/app/avatars/' . $name;
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    private function validateInput($request) {
        $this->validate($request, [
            'lastname' => 'required|max:60',
            'firstname' => 'required|max:60',
            'middlename' => 'required|max:60',
            'address' => 'required|max:120',
            'rollno' => 'required|max:120',
            'country_id' => 'required',
            'zip' => 'required|max:10',
            'age' => 'required',
            'birthdate' => 'required',
            'admission_date' => 'required',
            'department_id' => 'required',
            'division_id' => 'required',
            'emailId' => 'required'
        ]);
    }

    private function createQueryInput($keys, $request) {
        $queryInput = [];
        for ($i = 0; $i < sizeof($keys); $i++) {
            $key = $keys[$i];
            $queryInput[$key] = $request[$key];
        }

        return $queryInput;
    }

}
