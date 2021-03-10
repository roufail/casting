<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Resources\Service\ServiceCollection;
use App\Http\Resources\Service\ServiceResource;

use App\Http\Requests\Api\ServiceRequest;
class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($search=null)
    {   
        $services = Service::query();
        if($search) {
            $services = $services->where('title','like','%'.$search.'%');
        }

        $services = $services->paginate(10);
        return $this->success(new ServiceCollection($services),'Services Retrived successfully');
    }


    public function myservices($search=null){
        $services = auth()->user()->services()->paginate(10);
        return $this->success(new ServiceCollection($services),'Services Retrived successfully');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $service = auth()->user()->services()->create($request->validated());
        if($service){
            return $this->success(new ServiceResource($service),'Service created successfully');
        } else {
            return $this->error([],'Something went wrong');
        }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
