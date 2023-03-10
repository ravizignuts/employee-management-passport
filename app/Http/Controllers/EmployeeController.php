<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    /**
     * API For add Employee
     * @param Request $request
     * @return json data
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required|string',
            'age'    => 'required|string',
            'job'    => 'required|string',
            'salary' => 'required|string'
        ]);
        $employee = Employee::create($request->only('name', 'age', 'job', 'salary'));
        return response()->json([
            'data'    => $employee,
            'message' => 'Employee Added Successfully'
        ]);
    }
    /**
     * API For edit Employee
     * @param Request $request,$id
     * @return json data
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'name'   => 'required|string',
            'age'    => 'required|string',
            'job'    => 'required|string',
            'salary' => 'required|string'
        ]);
        $employee = Employee::findOrFail($id);
        $employee->update($request->only('name', 'age', 'job', 'salary'));
        return response()->json([
            'data'    => $employee,
            'message' => 'Employee Updated Successfully'
        ]);
    }
    /**
     * API For delete Employee
     * @param Request $request,$id
     * @return json data
     */
    public function delete($request,$id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete;
        return response()->json([
            'data'    => $employee,
            'message' => 'Employee Deleted Successfully'
        ]);
    }
    /**
     * API For delete Employee
     * @param $id
     * @return json data
     */
    public function restore($id)
    {
    }
    /**
     * API For view Employee
     * @param $id
     * @return json data
     */
    public function view($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json([
            'data'    => $employee,
            'message' => 'Employee Record'
        ]);
    }
    /**
     * API For list Employee
     * @param Request $request
     * @return json data
     */
    public function list()
    {
        $employee = Employee::get();
        return response()->json([
            'data'    => $employee,
            'message' => 'Employee Record'
        ]);
    }
}
