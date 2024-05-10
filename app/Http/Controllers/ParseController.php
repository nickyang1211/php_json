<?php

namespace App\Http\Controllers;
use App\Services\ParseService;
use Illuminate\Http\Request;

class ParseController extends Controller
{
    //
    private $service;

    public function __construct(ParseService $service)
    {
        $this->service = $service;
    }

    public function parse()
    {
        return $this->service->parse();
    }
}
