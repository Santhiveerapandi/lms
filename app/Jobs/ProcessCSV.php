<?php

namespace App\Jobs;


use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;

class ProcessCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $header;
    public $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $header)
    {
        //Excel model
        $this->data=$data;
        $this->header=$header;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // read the file from uploaded location
        foreach($this->data as $employee) {
            $employeeInput = array_combine($this->header,$employee);
            Employee::create($employeeInput);
        }
    }
}
