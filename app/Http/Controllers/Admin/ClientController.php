<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
Use Alert,Storage;
use App\Http\Requests\Admin\Client\ClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        return view('admin.clients.form',compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $validated = $request->validated();

        if($request->image) {
            $validated['image'] = $request->image->store("/","clients");
        }

        if($request->active) {
            $validated['active'] = true;
        }else {
            $validated['active'] = false;
        }
        $validated['password'] = bcrypt($validated['password']);


        if(Client::create($validated)){
            Alert::toast('<h4>تم انشاء العميل بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->route('admin.clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('admin.clients.form',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        $validated = $request->validated();
        unset($validated['password_confirmation']);

        if($request->image) {
            Storage::disk('clients')->delete($client->image);
            $validated['image'] = $request->image->store("/","clients");
        }
        if($validated['password'] == null)
        {
            unset($validated['password']);
        }else{
            $validated['password'] = bcrypt($validated['password']);
        }

        if($request->active) {
            $validated['active'] = true;
        }else {
            $validated['active'] = false;
        }

        if($client->update($validated)){
            Alert::toast('<h4>تم تحديث المستخدم بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->back();    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {

        Storage::disk('clients')->delete($client->image);
        if($client->delete()){
            Alert::toast('<h4>تم حذف العميل بنجاح</h4>','success');
            return redirect(route('admin.clients.index'));
        }
        Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        return redirect(route('admin.clients.index'));
    }



    public function ajaxData()
    {
        return Datatables::of(Client::query())
        ->addColumn('image', function ($client) {
            if($client->image && $client->image != ""){
                return '<img src="'.\Storage::disk("clients")->url($client->image).'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            }else {
                return '<img src="'.url("imgs/no-user.png").'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            } 
        })->addColumn('action', function ($client) {
            return '
            <a  style="float:right" href="'.route('admin.clients.edit',$client->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> '.__("admin/clients.list.edit").'</a>
            <form method="post" action="'.route('admin.clients.destroy',$client->id).'">
             '.csrf_field().method_field("delete").'
             <button style="float:right" type="submit" class="delete-record btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> '.__("admin/clients.list.delete").'</a>
             </form>';
        })
        ->rawColumns(['image', 'action'])
        ->make(true);
    }

    public function delete_image(Request $request) {
        if($request->ajax()){
            $client = Client::findOrFail($request->id);
            Storage::disk('clients')->delete($client->image);
            $client->update(['image' => null]);
            return true;
        }
    }
}
