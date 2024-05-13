<?php 
namespace App\Controllers;

class EmployeeController extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }
    public function add_list(){
        return view('employee_view');
    }
}