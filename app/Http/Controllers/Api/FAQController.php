<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class FAQController extends Controller
{
    protected $faqs = [
        ['id'=>1,'question'=>'What is Fursa?','answer'=>'Fursa is…'],
        // …
    ];

    // GET /ar/api/faqs
    public function index()
    {
        return response()->json(['data'=>$this->faqs]);
    }

    // GET /ar/api/faqs/{id}
    public function show($id)
    {
        $faq = collect($this->faqs)->firstWhere('id',(int)$id);
        return $faq
            ? response()->json(['data'=>$faq])
            : response()->json(['message'=>'Not Found'],404);
    }
}
