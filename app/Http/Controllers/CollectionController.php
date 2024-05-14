<?php

namespace App\Http\Controllers;
use App\Services\CollectionService;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    //
    private $service;

    public function __construct(CollectionService $service)
    {
        $this->service = $service;
    }

    public function filter()
    {
        return $this->service->filter();
    }

    public function pluck()
    {
        return $this->service->pluck();
    }

    public function contains()
    {
        return $this->service->contains();
    }

    public function groupby()
    {
        return $this->service->groupby();
    }

    public function sortby()
    {
        return $this->service->sortby();
    }

    public function partition()
    {
        return $this->service->partition();
    }

    public function reject()
    {
        return $this->service->reject();
    }

    public function where()
    {
        return $this->service->where();
    }

    public function wherein()
    {
        return $this->service->whereIn();
    }

    public function chunk()
    {
        return $this->service->chunk();
    }
    
    public function count()
    {
        return $this->service->count();
    }

    public function first()
    {
        return $this->service->first();
    }

    public function firstWhere()
    {
        return $this->service->firstWhere();
    }
}
