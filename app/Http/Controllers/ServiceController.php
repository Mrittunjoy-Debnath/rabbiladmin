<?php

namespace App\Http\Controllers;

use App\ServicesModel;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function ServiceIndex()
    {
        return view('services');
    }

    public function getServicesData()
    {
        $result = json_encode(ServicesModel::orderBy('id','desc')->get());
        return $result;
    }

    public function getServicesDetails(Request $req)
    {
        $id = $req->input('id');
        $result = json_encode(ServicesModel::where('id','=',$id)->get());
        return $result;
    }


    public function ServiceDelete(Request $req)
    {
        $id = $req->input('id');
        $result = ServicesModel::where('id','=',$id)->delete();

        if($result==true)
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }

    public function ServiceUpdate(Request $req)
    {
        $id = $req->input('id');
        $name = $req->input('name');
        $des = $req->input('des');
        $img = $req->input('img');
        $result = ServicesModel::where('id','=',$id)->update(['service_name'=>$name,'service_des'=>$des,'service_img'=>$img]);

        if($result==true)
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }

    public function ServiceAdd(Request $req)
    {
        $name = $req->input('name');
        $des = $req->input('des');
        $img = $req->input('img');
        $result = ServicesModel::insert(['service_name'=>$name,'service_des'=>$des,'service_img'=>$img]);

        if($result==true)
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }
}
