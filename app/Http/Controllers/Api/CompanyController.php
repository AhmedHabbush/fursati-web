<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    protected $companies = [
        ['id'=>1,'name'=>'PURE for IT Solutions','logo'=>'','banner'=>'','business_type'=>'Web Development','employees'=>'1500+','country'=>'Kuwait','bio'=>'Company bio…'],
        // المزيد…
    ];

    // GET /ar/api/all-companies
    public function all()
    {
        return response()->json(['data'=>$this->companies]);
    }
}
