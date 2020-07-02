<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::orderBy('created_at', 'desc')->paginate(5);
        return view("company.index", compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("company.create");
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
            'name'      => 'required|string',
            'email'     => 'required|string|email',
            'website'   => 'required|string',
            'logo'      => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:min_width=100,min_height=100'
        ]);

        $rndmName = $this->uploadImage($req);

        $data = new Company;
        $data->name = $req->name;
        $data->email = $req->email;
        $data->website = $req->website;
        $data->file = $rndmName;
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();
        return redirect()->route('company.index')->with('success', 'Data berhasil disimpan');
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

    private function uploadImage(Request $req)
    {
        $file = $req->file('logo');
        $ext = $file->getClientOriginalExtension();
        $rndmName = md5(now()).'.'.$ext;
        Storage::disk('company')->put($rndmName, File::get($file));
        return $rndmName;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Company::find($id);
        return view("company.edit", compact('data'));//
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
            'name'      => 'required|string',
            'email'     => 'required|string|email',
            'website'   => 'required|string',
            'logo'      => 'nullable|mimes:jpeg,jpg,png|max:2048|dimensions:min_width=100,min_height=100'
        ]);

        $data = Company::find($id);

        if ($req->hasFile('logo')) {
            $file = $req->file('logo');
            Storage::disk('company')->delete($data->file);
            $old = explode(".", $data->file);
            $newNameFile = $old[0].".".$file->getClientOriginalExtension();
            Storage::disk('company')->put($newNameFile, File::get($file));
            $data->file = $newNameFile;
        }

        $data->name = $req->name;
        $data->email = $req->email;
        $data->website = $req->website;
        $data->updated_at = now();
        $data->save();
        return redirect()->route('company.index')->with('success', 'Data berhasil diubah');
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Company::find($id);
        Storage::disk('company')->delete($data->file);
        $data->delete();
        return redirect()->route('company.index')->with('success', 'Data berhasil dihapus');
    }
}
