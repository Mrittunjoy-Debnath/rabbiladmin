@extends('layout.app')

@section('content')
    <div class="container d-none" id="mainDivCourse">
        <div class="row">
            <div class="col-md-12 p-5">
                <button id="addNewCourseBtnId" class="btn my-3 btn-danger">Add New</button>
                <table id="courseDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th class="th-sm">Name</th>
                        <th class="th-sm">Course Fee</th>
                        <th class="th-sm">Class</th>
                        <th class="th-sm">Enroll</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="course_table">



                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="container" id="loaderDivCourses">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}" />

            </div>
        </div>
    </div>

    <div class="container d-none" id="wrongDivCourses">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <h3>Something Went Wrong !</h3>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <input id="CourseNameId" type="text" id="" class="form-control mb-3" placeholder="Course Name">
                                <input id="CourseDesId" type="text" id="" class="form-control mb-3" placeholder="Course Description">
                                <input id="CourseFeeId" type="text" id="" class="form-control mb-3" placeholder="Course Fee">
                                <input id="CourseEnrollId" type="text" id="" class="form-control mb-3" placeholder="Total Enroll">
                            </div>
                            <div class="col-md-6">
                                <input id="CourseClassId" type="text" id="" class="form-control mb-3" placeholder="Total Class">
                                <input id="CourseLinkId" type="text" id="" class="form-control mb-3" placeholder="Course Link">
                                <input id="CourseImgId" type="text" id="" class="form-control mb-3" placeholder="Course Image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="CourseAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  text-center">

                    <h5 class="mt-4 d-none" id="courseEditId"></h5>
                    <div id="courseEditForm" class="container d-none">
                        <div class="row">
                            <div class="col-md-6">
                                <input id="CourseNameUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Name">
                                <input id="CourseDesUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Description">
                                <input id="CourseFeeUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Fee">
                                <input id="CourseEnrollUpdateId" type="text" id="" class="form-control mb-3" placeholder="Total Enroll">
                            </div>
                            <div class="col-md-6">
                                <input id="CourseClassUpdateId" type="text" id="" class="form-control mb-3" placeholder="Total Class">
                                <input id="CourseLinkUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Link">
                                <input id="CourseImgUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Image">
                            </div>
                        </div>
                    </div>
                    <img id="courseEditLoader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}" />
                    <h5 id="courseEditWrong" class="d-none">Something Went Wrong !</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="CourseUpdateConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 text-center">
                    <h5 class="mt-4">Do You Want To Delete?</h5>
                    <h5 class="mt-4 d-none" id="CourseDeleteId"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button  id="CourseDeleteConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        getCoursesData();

        function getCoursesData(){
            axios.get('/getCoursesData')
                .then(function (response) {

                    if(response.status==200)
                    {
                        $('#mainDivCourse').removeClass('d-none');
                        $('#loaderDivCourses').addClass('d-none');


                        $('#courseDataTable').DataTable().destroy();
                        $('#course_table').empty();

                        var dataJSON=response.data;
                        $.each(dataJSON, function(i, item) {
                            $('<tr>').html(
                                "<td>" + dataJSON[i].course_name + "</td>"+
                                "<td>" + dataJSON[i].course_fee + "</td>"+
                                "<td>" + dataJSON[i].course_totalclass + "</td>"+
                                "<td>" + dataJSON[i].course_totalenroll + "</td>"+
                                "<td><a class='courseEditBtn' data-id="+dataJSON[i].id+"><i class='fas fa-edit'></i> </a></td>"+
                                "<td><a class='courseDeleteBtn' data-id="+dataJSON[i].id+"  ><i class='fas fa-trash-alt'></i> </a></td>"
                            ).appendTo('#course_table');
                        });

                        $('.courseDeleteBtn').click(function () {
                            var id = $(this).data('id');
                            $('#CourseDeleteId').html(id);
                            $('#deleteCourseModal').modal('show');
                        });

                        $('.courseEditBtn').click(function () {
                            var id = $(this).data('id');
                            CourseUpdateDetails(id);
                            $('#courseEditId').html(id);
                            $('#updateCourseModal').modal('show');
                        });

                        $('#courseDataTable').DataTable({"order":false});
                        $('.dataTables_length').addClass('bs-select');

                    }
                    else{
                        $('#wrongDivCourses').removeClass('d-none');
                        $('#loaderDivCourses').addClass('d-none');
                    }


                }).catch(function (error) {
                $('#wrongDivCourses').removeClass('d-none');
                $('#loaderDivCourses').addClass('d-none');
            });
        }

        $('#addNewCourseBtnId').click(function () {

            $('#addCourseModal').modal('show');
        });

        $('#CourseAddConfirmBtn').click(function () {

            var CourseName= $('#CourseNameId').val();
            var CourseDes= $('#CourseDesId').val();
            var CourseFee= $('#CourseFeeId').val();
            var CourseEnroll= $('#CourseEnrollId').val();
            var CourseClass= $('#CourseClassId').val();
            var CourseLink= $('#CourseLinkId').val();
            var CourseImg= $('#CourseImgId').val();

            CourseAdd(CourseName,CourseDes,CourseFee,CourseEnroll,CourseClass,CourseLink,CourseImg);
        })

        //Course Add Method
        function CourseAdd(CourseName,CourseDes,CourseFee,CourseEnroll,CourseClass,CourseLink,CourseImg)
        {
            if(CourseName.length==0)
            {
                toastr.error('CourseName is Empty');
            }
            else if(CourseDes.length==0)
            {
                toastr.error('CourseDes  is Empty');
            }
            else if(CourseFee.length==0)
            {
                toastr.error('CourseFee Image is Empty');
            }
            else if(CourseEnroll.length==0)
            {
                toastr.error('CourseEnroll is Empty');
            }
            else if(CourseLink.length==0)
            {
                toastr.error('CourseLink is Empty');
            }
            else if(CourseFee.length==0)
            {
                toastr.error('CourseFee is Empty');
            }
            else if(CourseImg.length==0)
            {
                toastr.error('CourseImg  is Empty');
            }
            else {
                $('#CourseAddConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>") //Animation

                axios.post('/CoursesAdd',{
                    course_name:CourseName,
                    course_des:CourseDes,
                    course_fee:CourseFee,
                    course_totalenroll:CourseEnroll,
                    course_totalclass:CourseClass,
                    course_link:CourseLink,
                    course_img:CourseImg,
                })
                    .then(function (response){
                        $('#CourseAddConfirmBtn').html("Save");
                        if(response.status==200)
                        {
                            if(response.data==1)
                            {
                                $('#addCourseModal').modal('hide');
                                toastr.success('Add success.');
                                getCoursesData();
                            }
                            else {
                                $('#addCourseModal').modal('hide');
                                toastr.error('Add fail.');
                                getCoursesData();
                            }
                        }
                        else
                        {
                            $('#addCourseModal').modal('hide');
                            toastr.success('something went wrong !');
                        }

                    })
                    .catch(function (error) {
                        $('#addCourseModal').modal('hide');
                        toastr.error('something went wrong !');
                    });
            }

        }

        $('#CourseDeleteConfirmBtn').click(function () {
            var id = $('#CourseDeleteId').html();
            CourseDelete(id);
        });


        //Course delete
        function CourseDelete(deleteId)
        {
            $('#CourseDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>");  //Animation ..........
            axios.post('/CoursesDelete',{id:deleteId})
                .then(function (response){
                    $('#CourseDeleteConfirmBtn').html();

                    if(response.status==200)
                    {
                        if(response.data==1)
                        {
                            $('#deleteCourseModal').modal('hide');
                            toastr.success('Delete success.');
                            getCoursesData();
                        }
                        else {
                            $('#deleteCourseModal').modal('hide');
                            toastr.error('Delete fail.');
                            getCoursesData();
                        }
                    }
                    else {
                        $('#deleteCourseModal').modal('hide');
                        toastr.error('something went wrong !');
                    }

                })
                .catch(function (error) {
                    $('#deleteCourseModal').modal('hide');
                    toastr.error('something went wrong !');
                });

        }
        //Course Update
        function CourseUpdateDetails(detailsID)
        {
            axios.post('/CoursesDetails',{
                id:detailsID
            })
                .then(function (response){
                    if(response.status==200){
                        $('#courseEditForm').removeClass('d-none');
                        $('#courseEditLoader').addClass('d-none');
                        var jsonData = response.data;
                        $('#CourseNameUpdateId').val(jsonData[0].course_name);
                        $('#CourseDesUpdateId').val(jsonData[0].course_des);
                        $('#CourseFeeUpdateId').val(jsonData[0].course_fee);
                        $('#CourseEnrollUpdateId').val(jsonData[0].course_totalenroll);
                        $('#CourseClassUpdateId').val(jsonData[0].course_totalclass);
                        $('#CourseLinkUpdateId').val(jsonData[0].course_link);
                        $('#CourseImgUpdateId').val(jsonData[0].course_img);
                    }
                    else
                    {
                        $('#courseEditLoader').addClass('d-none');
                        $('#courseEditWrong').removeClass('d-none');
                    }
                })
                .catch(function (error) {
                    $('#courseEditLoader').addClass('d-none');
                    $('#courseEditWrong').removeClass('d-none');
                });
        }

        $('#CourseUpdateConfirmBtn').click(function () {
            var courseID =$('#courseEditId').html();
            var courseName=$('#CourseNameUpdateId').val();
            var courseDes=$('#CourseDesUpdateId').val();
            var courseFee=$('#CourseFeeUpdateId').val();
            var courseEnroll=$('#CourseEnrollUpdateId').val();
            var courseClass=$('#CourseClassUpdateId').val();
            var courseLink=$('#CourseLinkUpdateId').val();
            var courseImg=$('#CourseImgUpdateId').val();

            CourseUpdate(courseID,courseName,courseDes,courseFee,courseEnroll,courseClass,courseLink,courseImg);
        });


        //each Course Update details
        function CourseUpdate(courseID,courseName,courseDes,courseFee,courseEnroll,courseClass,courseLink,courseImg)
        {
            if(courseName.length==0)
            {
                toastr.error('courseName  is Empty');
            }
            else if(courseDes.length==0)
            {
                toastr.error('courseDes  is Empty');
            }
            else if(courseFee.length==0)
            {
                toastr.error('courseFee is Empty');
            }
            else if(courseEnroll.length==0)
            {
                toastr.error('courseEnroll is Empty');
            }
            else if(courseClass.length==0)
            {
                toastr.error('courseClass is Empty');
            }
            else if(courseLink.length==0)
            {
                toastr.error('courseLink is Empty');
            }
            else if(courseImg.length==0)
            {
                toastr.error('courseImg is Empty');
            }
            else {
                $('#CourseUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>"); //Animation

                axios.post('/CoursesUpdate',{
                    id:courseID,
                    course_name:courseName,
                    course_des:courseDes,
                    course_fee:courseFee,
                    course_totalenroll:courseEnroll,
                    course_totalclass:courseClass,
                    course_link:courseLink,
                    course_img:courseImg,
                })
                    .then(function (response){
                        $('#CourseUpdateConfirmBtn').html("Save");
                        if(response.status==200)
                        {
                            if(response.data==1)
                            {
                                $('#updateCourseModal').modal('hide');
                                toastr.success('Update success.');
                                getCoursesData();
                            }
                            else {
                                $('#updateCourseModal').modal('hide');
                                toastr.error('Update fail.');
                                getCoursesData();
                            }
                        }
                        else
                        {
                            $('#updateCourseModal').modal('hide');
                            toastr.success('something went wrong !');
                        }

                    })
                    .catch(function (error) {
                        $('#updateCourseModal').modal('hide');
                        toastr.error('something went wrong !');
                    });
            }

        }


    </script>
@endsection
