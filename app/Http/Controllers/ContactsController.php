<?php

namespace App\Http\Controllers;

use App\ContactModel;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function ContactsIndex()
    {
        return view('contacts');
    }
    public function getContactsData()
    {
        $result = json_encode(ContactModel::orderBy('id','desc')->get());
        return $result;
    }

    public function ContactsDelete(Request $req)
    {
        $id = $req->input('id');
        $result = ContactModel::where('id','=',$id)->delete();

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
