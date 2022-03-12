@extends('layout.app')
@section('title','home')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-3 p-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="count-card-title">{{$TotalVisitor}}</h3>
                        <h3 class="count-card-text">Total visitor</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 p-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="count-card-title">{{$TotalService}}</h3>
                        <h3 class="count-card-text">Total Service</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 p-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="count-card-title">{{$TotalProject}}</h3>
                        <h3 class="count-card-text">Total Project</h3>
                    </div>
                </div>
            </div>


            <div class="col-md-3 p-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="count-card-title">{{$TotalCourse}}</h3>
                        <h3 class="count-card-text">Total Course</h3>
                    </div>
                </div>
            </div>



            <div class="col-md-3 p-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="count-card-title">{{$TotalContact}}</h3>
                        <h3 class="count-card-text">Total Contact</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 p-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="count-card-title">{{$TotalReview}}</h3>
                        <h3 class="count-card-text">Review</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
