<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index(){
        $students = Student::orderBy('id','DESC')->get();
        return view('students',['students'=>$students]);
    }

    public function addStudent(Request $req){
        // dd($req->all());
        $student=new Student();
        $student->firstname=$req->firstname;
        $student->lastname=$req->lastname;
        $student->email=$req->email;
        $student->phone=$req->phone;
        $student->save();
        return response()->json($student);
    }

    public function getStudent(){
        $students=Student::all();
        return response()->json($students);
    }

    public function getStudentById($id){
        $student=Student::find($id);
        return response()->json($student);
    }

    public function updateStudent(Request $req){
        $student=Student::find($req->id);
        $student->firstname=$req->firstname;
        $student->lastname=$req->lastname;
        $student->email=$req->email;
        $student->phone=$req->phone;
        $student->save();
        return response()->json($student);
    }

    public function deleteStudent($id){
        $student=Student::find($id);
        $student->delete();
        return response()->json(['success'=>'Record has been deleted']);
    }

    public function deleteCheckedStudents(Request $req){
        $ids=$req->ids;
        Student::whereIn('id',$ids)->delete();
        return response()->json(['success'=>'Students have been deleted!']);
    }
}
