<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    protected $policies = [
        ['id'=>1,'title'=>'Privacy Policy','content'=>'Your privacy is…'],
    ];

    // GET /ar/api/policies
    public function index()
    {
        return response()->json(['data'=>$this->policies]);
    }
}
