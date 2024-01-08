<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    /* ++++++++++++++++++++ index() +++++++++++++++++++++ */
    public function index()
    {
        $attendances = Attendance::leftjoin('employees', 'attendances.employee_id', 'employees.id')
            ->leftjoin('users', 'employees.user_id', 'users.id')
            ->leftjoin('users as created_by', 'attendances.created_by', 'created_by.id')
            ->select(
                'attendances.*',
                'users.name as employee_name',
                'created_by.name as created_by'
            )->orderBy('attendances.id', 'desc')
            ->get();

        return view('employees.attendance.index',compact('attendances'));
    }
    /* ++++++++++++++++++++ create() +++++++++++++++++++++ */
    public function create()
    {
        // Get "All Employees"
        $employees = Employee::leftjoin('users', 'employees.user_id', 'users.id')->select('users.name', 'employees.id')->pluck('name', 'id');
        return view('employees.attendance.create')->with(compact('employees'));
    }
    /* ++++++++++++++++++++ store() ++++++++++++++++++++ */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'date'      => 'required|date',
            'employees' => 'required', // Assuming 'employees' is the name of the select input
            'check_in'  => 'required|date_format:H:i',
            'check_out' => 'required|date_format:H:i',
            'status'    => 'required|in:present,late,on_leave',
        ]);
        // Create a new Attendance instance
        $attendance = new Attendance();
        // Set the attributes based on the form data
        $attendance->date        = $request->input('date');
        $attendance->employee_id = $request->input('employees'); // Assuming 'employee_id' is the correct column name
        $attendance->check_in    = $request->input('check_in');
        $attendance->check_out   = $request->input('check_out');
        $attendance->status      = $request->input('status');
        $attendance->created_by  = auth()->user()->id;
        // Save the attendance record
        $attendance->save();
        $output = [
            'success' => true,
            'msg' => __('lang.add_employee')
        ];
        // You can redirect to a success page or perform other actions here
        return redirect()->route('attendance.index')->with('status', $output);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
    // +++++++++++++++++++ "add_new_row" for "create attendance" +++++++++++++++++++
    public function getAttendanceRow($row_index)
    {
        $employees = Employee::leftjoin('users', 'employees.user_id', 'users.id')->select('users.name', 'employees.id')->pluck('name', 'id');

        return view('employees.attendance.partials.attendance_row')->with(compact(
            'employees',
            'row_index'
        ));
    }
}
