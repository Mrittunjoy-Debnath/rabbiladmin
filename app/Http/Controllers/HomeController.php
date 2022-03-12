<?php

namespace App\Http\Controllers;

use App\ContactModel;
use App\CourseModel;
use App\ProjectsModel;
use App\ReviewModel;
use App\ServicesModel;
use App\VisitorModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function HomeIndex()
    {
        $TotalContact= ContactModel::count();
        $TotalCourse= CourseModel::count();
        $TotalProject= ProjectsModel::count();
        $TotalReview= ReviewModel::count();
        $TotalService= ServicesModel::count();
        $TotalVisitor= VisitorModel::count();

        return view('home',[
            'TotalContact'=>$TotalContact,
            'TotalCourse'=>$TotalCourse,
            'TotalProject'=>$TotalProject,
            'TotalReview'=>$TotalReview,
            'TotalService'=>$TotalService,
            'TotalVisitor'=>$TotalVisitor,
        ]);
    }
}
