@extends('layout.app')

@section('content')

    <div class="container d-none" id="mainDivProjects">
        <div class="row">
            <div class="col-md-12 p-5">
                <button id="addNewProjectsBtnId" class="btn my-3 btn-danger">Add New</button>
                <table id="projectDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Name</th>
                        <th class="th-sm">Description</th>
                        <th class="th-sm">Project Link</th>
                        <th class="th-sm">Project Img</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="projects_table">


                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="container" id="loaderDivProjects">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}" />

            </div>
        </div>
    </div>

    <div class="container d-none" id="wrongDivProjects">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <h3>Something Went Wrong !</h3>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addProjectsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">

                    <div id="" class="w-100">
                        <h6 class="mb-4">Add New Project</h6>
                        <input type="text" id="ProjectNameId" class="form-control mb-4" placeholder="Project Name">
                        <input type="text" id="ProjectDesId" class="form-control mb-4" placeholder="Project Description">
                        <input type="text" id="ProjectLinkId" class="form-control mb-4" placeholder="Project Link">
                        <input type="text" id="ProjectImgId" class="form-control mb-4" placeholder="Project Image Link">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="ProjectAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateProjectsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <h5 class="mt-4 d-none" id="ProjectEditId"></h5>
                    <div id="projectEditForm" class="w-100 d-none">
                        <h6 class="mb-4">Update Project</h6>
                        <input type="text" id="ProjectNameUpdateId" class="form-control mb-4" placeholder="Project Name">
                        <input type="text" id="ProjectDesUpdateId" class="form-control mb-4" placeholder="Project Description">
                        <input type="text" id="ProjectLinkUpdateId" class="form-control mb-4" placeholder="Project Link">
                        <input type="text" id="ProjectImgUpdateId" class="form-control mb-4" placeholder="Project Image Link">
                    </div>
                    <img id="projectEditLoader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}" />
                    <h5 id="projectEditWrong" class="d-none">Something Went Wrong !</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="ProjectUpdateConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 text-center">
                    <h5 class="mt-4">Do You Want To Delete?</h5>
                    <h5 class="mt-4 d-none" id="ProjectDeleteId"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button  id="ProjectDeleteConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getProjectsData();

        //for projects data
        function getProjectsData(){
            axios.get('/getProjectsData')
                .then(function (response) {

                    if(response.status==200)
                    {
                        $('#mainDivProjects').removeClass('d-none');
                        $('#loaderDivProjects').addClass('d-none');


                        $('#projectDataTable').DataTable().destroy();
                        $('#projects_table').empty();

                        var dataJSON=response.data;
                        $.each(dataJSON, function(i, item) {
                            $('<tr>').html(
                                "<td>" + dataJSON[i].project_name + "</td>"+
                                "<td>" + dataJSON[i].project_desc + "</td>"+
                                "<td>" + dataJSON[i].project_link + "</td>"+
                                "<td>" + dataJSON[i].project_img + "</td>"+
                                "<td><a class='projectEditBtn' data-id="+dataJSON[i].id+"><i class='fas fa-edit'></i> </a></td>"+
                                "<td><a class='projectDeleteBtn' data-id="+dataJSON[i].id+"  ><i class='fas fa-trash-alt'></i> </a></td>"
                            ).appendTo('#projects_table');
                        });

                        $('.projectDeleteBtn').click(function () {
                            var id = $(this).data('id');
                            $('#ProjectDeleteId').html(id);
                            $('#deleteProjectModal').modal('show');
                        });

                        $('.projectEditBtn').click(function () {
                            var id = $(this).data('id');
                            ProjectUpdateDetails(id);
                            $('#ProjectEditId').html(id);
                            $('#updateProjectsModal').modal('show');
                        });

                        $('#projectDataTable').DataTable({"order":false});
                        $('.dataTables_length').addClass('bs-select');

                    }
                    else{
                        $('#wrongDivProjects').removeClass('d-none');
                        $('#loaderDivProjects').addClass('d-none');
                    }


                }).catch(function (error) {
                $('#wrongDivProjects').removeClass('d-none');
                $('#loaderDivProjects').addClass('d-none');
            });
        }

        $('#addNewProjectsBtnId').click(function () {

            $('#addProjectsModal').modal('show');
        });

        //projects confirm btn
        $('#ProjectAddConfirmBtn').click(function () {

            var ProjectName= $('#ProjectNameId').val();
            var ProjectDes= $('#ProjectDesId').val();
            var ProjectLink= $('#ProjectLinkId').val();
            var ProjectImg= $('#ProjectImgId').val();

            ProjectAdd(ProjectName,ProjectDes,ProjectLink,ProjectImg);
        })

        //Projects Add Method
        function ProjectAdd(ProjectName,ProjectDes,ProjectLink,ProjectImg)
        {
            if(ProjectName.length==0)
            {
                toastr.error('ProjectName is Empty');
            }
            else if(ProjectDes.length==0)
            {
                toastr.error('ProjectDes  is Empty');
            }
            else if(ProjectLink.length==0)
            {
                toastr.error('ProjectLink Image is Empty');
            }
            else if(ProjectImg.length==0)
            {
                toastr.error('ProjectImg is Empty');
            }

            else {
                $('#ProjectAddConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>") //Animation

                axios.post('/ProjectsAdd',{
                    project_name:ProjectName,
                    project_desc:ProjectDes,
                    project_link:ProjectLink,
                    project_img:ProjectImg,
                })
                    .then(function (response){
                        $('#ProjectAddConfirmBtn').html("Save");
                        if(response.status==200)
                        {
                            if(response.data==1)
                            {
                                $('#addProjectsModal').modal('hide');
                                toastr.success('Add success.');
                                getProjectsData();
                            }
                            else {
                                $('#addProjectsModal').modal('hide');
                                toastr.error('Add fail.');
                                getProjectsData();
                            }
                        }
                        else
                        {
                            $('#addProjectsModal').modal('hide');
                            toastr.success('something went wrong !');
                        }

                    })
                    .catch(function (error) {
                        $('#addProjectsModal').modal('hide');
                        toastr.error('something went wrong !');
                    });
            }

        }

        $('#ProjectDeleteConfirmBtn').click(function () {
            var id = $('#ProjectDeleteId').html();
            ProjectDelete(id);
        });


        //Course delete
        function ProjectDelete(deleteId)
        {
            $('#ProjectDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>");  //Animation ..........
            axios.post('/ProjectsDelete',{id:deleteId})
                .then(function (response){
                    $('#ProjectDeleteConfirmBtn').html();

                    if(response.status==200)
                    {
                        if(response.data==1)
                        {
                            $('#deleteProjectModal').modal('hide');
                            toastr.success('Delete success.');
                            getProjectsData();
                        }
                        else {
                            $('#deleteProjectModal').modal('hide');
                            toastr.error('Delete fail.');
                            getProjectsData();
                        }
                    }
                    else {
                        $('#deleteProjectModal').modal('hide');
                        toastr.error('something went wrong !');
                    }

                })
                .catch(function (error) {
                    $('#deleteProjectModal').modal('hide');
                    toastr.error('something went wrong !');
                });

        }

        //Project Update
        function ProjectUpdateDetails(detailsID)
        {
            axios.post('/ProjectsDetails',{
                id:detailsID
            })
                .then(function (response){
                    if(response.status==200){

                        $('#projectEditForm').removeClass('d-none');
                        $('#projectEditLoader').addClass('d-none');

                        var jsonData = response.data;
                        $('#ProjectNameUpdateId').val(jsonData[0].project_name);
                        $('#ProjectDesUpdateId').val(jsonData[0].project_desc);
                        $('#ProjectLinkUpdateId').val(jsonData[0].project_link);
                        $('#ProjectImgUpdateId').val(jsonData[0].project_img);
                    }
                    else
                    {
                        $('#projectEditLoader').addClass('d-none');
                        $('#projectEditWrong').removeClass('d-none');
                    }
                })
                .catch(function (error) {
                    $('#projectEditLoader').addClass('d-none');
                    $('#projectEditWrong').removeClass('d-none');
                });
        }


        $('#ProjectUpdateConfirmBtn').click(function () {
            var projectID =$('#ProjectEditId').html();
            var projectName=$('#ProjectNameUpdateId').val();
            var projectDesc=$('#ProjectDesUpdateId').val();
            var projectLink=$('#ProjectLinkUpdateId').val();
            var projectImg=$('#ProjectImgUpdateId').val();

            ProjectUpdate(projectID,projectName,projectDesc,projectLink,projectImg);
        });


        //each Course Update details
        function ProjectUpdate(projectID,projectName,projectDesc,projectLink,projectImg)
        {
            if(projectName.length==0)
            {
                toastr.error('projectName  is Empty');
            }
            else if(projectDesc.length==0)
            {
                toastr.error('projectDesc  is Empty');
            }
            else if(projectLink.length==0)
            {
                toastr.error('projectLink is Empty');
            }
            else if(projectImg.length==0)
            {
                toastr.error('projectImg is Empty');
            }
            else {
                $('#ProjectUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>"); //Animation

                axios.post('/ProjectsUpdate',{
                    id:projectID,
                    project_name:projectName,
                    project_desc:projectDesc,
                    project_link:projectLink,
                    project_img:projectImg,
                })
                    .then(function (response){
                        $('#ProjectUpdateConfirmBtn').html("Save");
                        if(response.status==200)
                        {
                            if(response.data==1)
                            {
                                $('#updateProjectsModal').modal('hide');
                                toastr.success('Update success.');
                                getProjectsData();
                            }
                            else {
                                $('#updateProjectsModal').modal('hide');
                                toastr.error('Update fail.');
                                getProjectsData();
                            }
                        }
                        else
                        {
                            $('#updateProjectsModal').modal('hide');
                            toastr.success('something went wrong !');
                        }

                    })
                    .catch(function (error) {
                        $('#updateProjectsModal').modal('hide');
                        toastr.error('something went wrong !');
                    });
            }

        }

    </script>
@endsection
