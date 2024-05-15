<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Support\Facades\Bus;
use Exception;
use App\Jobs\ProcessCSV;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("employee.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $message= "CSV Uploaded/ imported...";
        //File chunk data import into db
        if($request->has('csvfile')){
            $csvdata = file($request->csvfile);
            // dd(count($csvdata)); Actual data validation inside excel/csv
            if(is_array($csvdata) && count($csvdata)>0){
                $chuncklength=count($csvdata);
                $chunks = array_chunk($csvdata, (($chuncklength>500)? 500: $chuncklength) );
                $header = [];
                $batch = Bus::batch([])->dispatch();
                foreach ($chunks as $key => $chunk) {
                    $data = array_map('str_getcsv', $chunk);
                    if($key==0){
                        $header = $data[0];
                        unset($data[0]);
                    }
                    $batch->add(new ProcessCSV($data, $header));
                }
            }
            
            //File Upload
            $path=$request->file('csvfile')->store('Employee');            
        }
        return redirect()->route('employee.create')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
