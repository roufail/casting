<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use App\Models\User;
use App\Models\UserService;
use App\Models\Setting;
use App\Http\Resources\Service\ServiceCollection;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\Service\RatingCollection;

use App\Http\Resources\MainService\MainServiceCollection;
use App\Http\Resources\MainService\MainServiceResource;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

use App\Http\Requests\Api\ServiceRequest;
use App\Http\Requests\Api\MainServiceRequest;
class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $services = UserService::query();
        if($request->has('search')) {
            $services = $services->whereHas('service',function($service)use($request){
                $service->where('title','like','%'.$request->search.'%');
            });
        }

        if($request->has('orderby')) {
            $order = $request->has('order') ? $request->order : "desc";
            $order = in_array($order,["asc","desc"]) ? $order : "desc";
            $orderby = "created_at";
            switch ($request->orderby) {
                case "top_rated":
                    $services->withCount("ratings")->orderby("ratings_count",$order); 
                    break;

                case "bought":
                    $services->withCount(["orders" => function($orders){
                        $orders->where("status","done");
                    }])->orderby("orders_count",$order); 
                    break;
    
                default:
                    $services->orderby($orderby,$order); 
                    break;
            }
        }


        $services = $services->with("user")->paginate(15)->appends(request()->query());
        return $this->success(new ServiceCollection($services),'Services Retrived successfully');
    }


    public function myservices($search=null){
        $services = auth()->user()->services()->latest()->paginate(15)->appends(request()->query());
        $services->map(function($service){
            $service->load_payer = false;
        });
        return $this->success(new ServiceCollection($services),'Services Retrived successfully');
    }


    

    public function main_services(){
        $services = Service::paginate(15,['id','title']);
        return $this->success(new MainServiceCollection($services),'Services Retrived successfully');
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
            $service->load_payer = false;
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
            return $this->success(new ServiceResource($service->load('user')),'Service retrived successfully');
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

        if(!$service) {
            return $this->error([],'service not exists');
        }


        $validated = $request->validated();
        $validated['active'] = 0;
        if($request->exists('active')){
            $validated['active'] = 1;
        }

        if($service->update($validated)){
            $service->load_payer = false;
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
            return $this->success(new MainServiceResource($service),'Service retrived successfully');
        } else {
            return $this->error([],'Something went wrong');
        }

    }
    
    public function categories(Request $request)
    {
        $categories = Category::paginate(15);
        return $this->success(new CategoryCollection($categories),'categories successfully');
    }
    public function category(Category $category)
    {
        $category->load_services = true;
        return $this->success(new CategoryResource($category->load("services")),'categories successfully');
    }

    public function service(Request $request,UserService $UserService)
    {
        // return $this->success(new ServiceResource($UserService->load(['user.services' => function($services) {
        //     $services->orderBy("price","asc");
        // },'user.work_video'])),'Service retrived successfully');
        //$UserService->load_payer = false;

        $UserService->load(['user.work_video']);
        return $this->success(new ServiceResource($UserService),'Service retrived successfully');
    }



    public function service_reviews(UserService $UserService) {
        $rating = $UserService->ratings()->with("client:id,name,image")->paginate(15);
        return $this->success(new RatingCollection($rating),'ratings retrived successfully');
    }

    public function service_categories(){
        $rating = $UserService->ratings->load("client:id,name,image");
        return $this->success(RatingResource::collection($rating),'ratings retrived successfully');  
    }

    public function fees(){
        return $this->success(Setting::where('setting_key','percentage')->pluck('setting_value','setting_key')->toArray(),'fees retrived successfully');  
    }

}
