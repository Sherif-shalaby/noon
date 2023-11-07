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
        // $attendances = Attendance::leftjoin('employees', 'attendances.employee_id', 'employees.id')
        //     ->leftjoin('users', 'employees.user_id', 'users.id')
        //     ->leftjoin('users as created_by', 'attendances.created_by', 'created_by.id')
        //     ->select(
        //         'attendances.*',
        //         'users.name as employee_name',
        //         'created_by.name as created_by'
        //     )->orderBy('attendances.id', 'desc')
        //     ->get();

        return view('employees.attendance.index');
    }
    /* ++++++++++++++++++++ create() +++++++++++++++++++++ */
    public function create()
    {
        $employees = Employee::leftjoin('users', 'employees.user_id', 'users.id')->select('users.name', 'employees.id')->pluck('name', 'id');
        return view('employees.attendance.create')->with(compact(
            'employees'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
