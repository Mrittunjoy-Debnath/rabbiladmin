@extends('layout.app')

@section('content')
    <div class="container d-none" id="mainDivReviews">
        <div class="row">
            <div class="col-md-12 p-5">
                <button id="addNewReviewsBtnId" class="btn my-3 btn-danger">Add New</button>
                <table id="reviewDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Name</th>
                        <th class="th-sm">Description</th>
                        <th class="th-sm">Img</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="reviews_table">


                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="container" id="loaderDivReviews">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}" />

            </div>
        </div>
    </div>

    <div class="container d-none" id="wrongDivReviews">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <h3>Something Went Wrong !</h3>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addReviewsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">

                    <div id="" class="w-100">
                        <h6 class="mb-4">Add New Review</h6>
                        <input type="text" id="ReviewNameId" class="form-control mb-4" placeholder="Review Name">
                        <input type="text" id="ReviewDesId" class="form-control mb-4" placeholder="Review Description">
                        <input type="text" id="ReviewImgId" class="form-control mb-4" placeholder="Review Image Link">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="ReviewAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateReviewsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <h5 class="mt-4 d-none" id="ReviewEditId"></h5>
                    <div id="reviewEditForm" class="w-100 d-none">
                        <h6 class="mb-4">Update Review</h6>
                        <input type="text" id="ReviewNameUpdateId" class="form-control mb-4" placeholder="Review Name">
                        <input type="text" id="ReviewDesUpdateId" class="form-control mb-4" placeholder="Review Description">
                        <input type="text" id="ReviewImgUpdateId" class="form-control mb-4" placeholder="Review Image Link">
                    </div>
                    <img id="reviewEditLoader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}" />
                    <h5 id="reviewEditWrong" class="d-none">Something Went Wrong !</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="ReviewUpdateConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 text-center">
                    <h5 class="mt-4">Do You Want To Delete?</h5>
                    <h5 class="mt-4 d-none" id="ReviewDeleteId"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button  id="ReviewDeleteConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getReviewsData();

        //for Reviews data
        function getReviewsData(){
            axios.get('/getReviewsData')
                .then(function (response) {

                    if(response.status==200)
                    {
                        $('#mainDivReviews').removeClass('d-none');
                        $('#loaderDivReviews').addClass('d-none');


                        $('#reviewDataTable').DataTable().destroy();
                        $('#reviews_table').empty();

                        var dataJSON=response.data;
                        $.each(dataJSON, function(i, item) {
                            $('<tr>').html(
                                "<td>" + dataJSON[i].name + "</td>"+
                                "<td>" + dataJSON[i].des + "</td>"+
                                "<td>" + dataJSON[i].img + "</td>"+
                                "<td><a class='reviewEditBtn' data-id="+dataJSON[i].id+"><i class='fas fa-edit'></i> </a></td>"+
                                "<td><a class='reviewDeleteBtn' data-id="+dataJSON[i].id+"  ><i class='fas fa-trash-alt'></i> </a></td>"
                            ).appendTo('#reviews_table');
                        });

                        $('.reviewDeleteBtn').click(function () {
                            var id = $(this).data('id');
                            $('#ReviewDeleteId').html(id);
                            $('#deleteReviewModal').modal('show');
                        });

                        $('.reviewEditBtn').click(function () {
                            var id = $(this).data('id');
                            ReviewUpdateDetails(id);
                            $('#ReviewEditId').html(id);
                            $('#updateReviewsModal').modal('show');
                        });

                        $('#reviewDataTable').DataTable({"order":false});
                        $('.dataTables_length').addClass('bs-select');

                    }
                    else{
                        $('#wrongDivReviews').removeClass('d-none');
                        $('#loaderDivReviews').addClass('d-none');
                    }


                }).catch(function (error) {
                $('#wrongDivReviews').removeClass('d-none');
                $('#loaderDivReviews').addClass('d-none');
            });
        }

        $('#addNewReviewsBtnId').click(function () {

            $('#addReviewsModal').modal('show');
        });

        //projects confirm btn
        $('#ReviewAddConfirmBtn').click(function () {

            var ReviewName= $('#ReviewNameId').val();
            var ReviewDes= $('#ReviewDesId').val();
            var ReviewImg= $('#ReviewImgId').val();

            ReviewAdd(ReviewName,ReviewDes,ReviewImg);
        })

        //Projects Add Method
        function ReviewAdd(ReviewName,ReviewDes,ReviewImg)
        {
            if(ReviewName.length==0)
            {
                toastr.error('ReviewName is Empty');
            }
            else if(ReviewDes.length==0)
            {
                toastr.error('ReviewDes  is Empty');
            }
            else if(ReviewImg.length==0)
            {
                toastr.error('ReviewImg Image is Empty');
            }
            else {
                $('#ReviewAddConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>") //Animation

                axios.post('/ReviewsAdd',{
                    review_name:ReviewName,
                    review_desc:ReviewDes,
                    review_img:ReviewImg,
                })
                    .then(function (response){
                        $('#ReviewAddConfirmBtn').html("Save");
                        if(response.status==200)
                        {
                            if(response.data==1)
                            {
                                $('#addReviewsModal').modal('hide');
                                toastr.success('Add success.');
                                getReviewsData();
                            }
                            else {
                                $('#addReviewsModal').modal('hide');
                                toastr.error('Add fail.');
                                getReviewsData();
                            }
                        }
                        else
                        {
                            $('#addReviewsModal').modal('hide');
                            toastr.success('something went wrong !');
                        }

                    })
                    .catch(function (error) {
                        $('#addReviewsModal').modal('hide');
                        toastr.error('something went wrong !');
                    });
            }

        }

        $('#ReviewDeleteConfirmBtn').click(function () {
            var id = $('#ReviewDeleteId').html();
            ReviewDelete(id);
        });


        //Review delete
        function ReviewDelete(deleteId)
        {
            $('#ReviewDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>");  //Animation ..........
            axios.post('/ReviewsDelete',{
                id:deleteId
            })
                .then(function (response){
                    $('#ReviewDeleteConfirmBtn').html();

                    if(response.status==200)
                    {
                        if(response.data==1)
                        {
                            $('#deleteReviewModal').modal('hide');
                            toastr.success('Delete success.');
                            getReviewsData();
                        }
                        else {
                            $('#deleteReviewModal').modal('hide');
                            toastr.error('Delete fail.');
                            getReviewsData();
                        }
                    }
                    else {
                        $('#deleteReviewModal').modal('hide');
                        toastr.error('something went wrong !');
                    }

                })
                .catch(function (error) {
                    $('#deleteReviewModal').modal('hide');
                    toastr.error('something went wrong !');
                });

        }

        //Review Update
        function ReviewUpdateDetails(detailsID)
        {
            axios.post('/ReviewsDetails',{
                id:detailsID
            })
                .then(function (response){
                    if(response.status==200){

                        $('#reviewEditForm').removeClass('d-none');
                        $('#reviewEditLoader').addClass('d-none');

                        var jsonData = response.data;
                        $('#ReviewNameUpdateId').val(jsonData[0].name);
                        $('#ReviewDesUpdateId').val(jsonData[0].des);
                        $('#ReviewImgUpdateId').val(jsonData[0].img);
                    }
                    else
                    {
                        $('#reviewEditLoader').addClass('d-none');
                        $('#reviewEditWrong').removeClass('d-none');
                    }
                })
                .catch(function (error) {
                    $('#reviewEditLoader').addClass('d-none');
                    $('#reviewEditWrong').removeClass('d-none');
                });
        }


        $('#ReviewUpdateConfirmBtn').click(function () {
            var reviewID =$('#ReviewEditId').html();
            var reviewName=$('#ReviewNameUpdateId').val();
            var reviewDesc=$('#ReviewDesUpdateId').val();
            var reviewImg=$('#ReviewImgUpdateId').val();

            ReviewUpdate(reviewID,reviewName,reviewDesc,reviewImg);
        });


        //each Course Update details
        function ReviewUpdate(reviewID,reviewName,reviewDesc,reviewImg)
        {
            if(reviewName.length==0)
            {
                toastr.error('reviewName  is Empty');
            }
            else if(reviewDesc.length==0)
            {
                toastr.error('reviewDesc  is Empty');
            }
            else if(reviewImg.length==0)
            {
                toastr.error('reviewImg is Empty');
            }
            else {
                $('#ReviewUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>"); //Animation

                axios.post('/ReviewsUpdate',{
                    id:reviewID,
                    review_name:reviewName,
                    review_desc:reviewDesc,
                    review_img:reviewImg,
                })
                    .then(function (response){
                        $('#ReviewUpdateConfirmBtn').html("Save");
                        if(response.status==200)
                        {
                            if(response.data==1)
                            {
                                $('#updateReviewsModal').modal('hide');
                                toastr.success('Update success.');
                                getReviewsData();
                            }
                            else {
                                $('#updateReviewsModal').modal('hide');
                                toastr.error('Update fail.');
                                getReviewsData();
                            }
                        }
                        else
                        {
                            $('#updateReviewsModal').modal('hide');
                            toastr.success('something went wrong !');
                        }

                    })
                    .catch(function (error) {
                        $('#updateReviewsModal').modal('hide');
                        toastr.error('something went wrong !');
                    });
            }

        }

    </script>
@endsection
