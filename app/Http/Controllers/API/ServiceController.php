<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\UserService;
use App\Http\Resources\Service\ServiceCollection;
use App\Http\Resources\Service\ServiceResource;


use App\Http\Resources\MainService\MainServiceCollection;
use App\Http\Resources\MainService\MainServiceResource;


use App\Http\Requests\Api\ServiceRequest;
use App\Http\Requests\Api\MainServiceRequest;
class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($search=null)
    {   
        $services = UserService::query();
        if($search) {
            $services = $services->whereHas('service',function($service)use($search){
                $service->where('title','like','%'.$search.'%');
            });
        }

        $services = $services->paginate(10);
        return $this->success(new ServiceCollection($services),'Services Retrived successfully');
    }


    public function myservices($search=null){
        $services = auth()->user()->services()->paginate(10);
        return $this->success(new ServiceCollection($services),'Services Retrived successfully');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $validated = $request->validated();
        $validated['active'] = 0;
        if($request->exists('active')){
            $validated['active'] = 1;
        }

        $service = auth()->user()->services()->create($validated);
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
        $service = auth()->user()->services()->find($id);
        if($service){
            return $this->success(new ServiceResource($service),'Service created successfully');
        } else {
            return $this->error([],'Something went wrong');
        }
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
        $service = auth()->user()->services()->find($id);

        $validated = $request->validated();
        $validated['active'] = 0;
        if($request->exists('active')){
            $validated['active'] = 1;
        }

        if($service->update($validated)){
            return $this->success(new ServiceResource($service),'Service updated successfully');
        } else {
            return $this->error([],'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = auth()->user()->services()->find($id);
        if($service->delete()){
            return $this->success([],'Service deleted successfully');
        } else {
            return $this->error([],'Something went wrong');
        }
    }


    public function create_main_service(MainServiceRequest $request)
    {
        $service = Service::create($request->all());
        if($service){
            return $this->success(new MainServiceResource($service),'Service created successfully');
        } else {
            return $this->error([],'Something went wrong');
        }

    }
}
