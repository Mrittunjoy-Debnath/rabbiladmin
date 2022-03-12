<?php

namespace App\Http\Controllers;

use App\ReviewModel;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function ReviewsIndex()
    {

        return view('reviews');
    }

    public function getReviewsData()
    {
        $result = json_encode(ReviewModel::orderBy('id','desc')->get());
        return $result;
    }

    public function ReviewsAdd(Request $req)
    {
        $review_name = $req->input('review_name');
        $review_desc = $req->input('review_desc');
        $review_img = $req->input('review_img');

        $result = ReviewModel::insert([
            'name'=>$review_name,
            'des'=>$review_desc,
            'img'=>$review_img,
        ]);

        if($result==true)
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }

    public function getReviewsDetails(Request $req)
    {
        $id = $req->input('id');
        $result = json_encode(ReviewModel::where('id','=',$id)->get());
        return $result;
    }

    public function ReviewsDelete(Request $req)
    {
        $id = $req->input('id');
        $result = ReviewModel::where('id','=',$id)->delete();

        if($result==true)
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }

    public function ReviewsUpdate(Request $req)
    {
        $id = $req->input('id');

        $review_name = $req->input('review_name');
        $review_desc = $req->input('review_desc');
        $review_img = $req->input('review_img');


        $result = ReviewModel::where('id','=',$id)->update([
            'name'=>$review_name,
            'des'=>$review_desc,
            'img'=>$review_img,

        ]);

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
