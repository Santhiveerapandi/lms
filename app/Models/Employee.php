<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable =[
        'Name','Country','Department','Selected','Grade','InterviewDate','EmployeeID',
        'JoinDate',	'Level','PerHourRate', 'PerDayRate', 'AnnualCTC', 'Expenses', 'TakeHomeSalary'
    ];
}
