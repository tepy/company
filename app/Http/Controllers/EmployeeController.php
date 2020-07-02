<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::with('company')->paginate(5);
        return view('employee.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::select(['id', 'name'])->get();
        return view('employee.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $this->validate($req, [
            'company_id' => 'required|integer',
            'name'=> 'required|string',
            'email'=> 'required|email',
        ]);
        

        $data = new Employee;
        $data->company_id = $req->company_id;
        $data->name = $req->name;
        $data->email = $req->email;
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();
        return redirect()->route('employee.index')->with('success','data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $company = Company::select(['id', 'name'])->get();
        return view('employee.edit', compact('employee','company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'company_id' => 'required|integer',
            'name'=> 'required|string',
            'email'=> 'required|email',
        ]);

        $data = Employee::find($id);
        $data->company_id = $req->company_id;
        $data->name = $req->name;
        $data->email = $req->email;
        $data->updated_at = now();
        $data->save();

        return redirect()->route('employee.index')->with('success', 'data berhasil di simpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::find($id)->delete();
        return redirect()->route('employee.index')->with('success','data berhasil dihapus');
    }
}
