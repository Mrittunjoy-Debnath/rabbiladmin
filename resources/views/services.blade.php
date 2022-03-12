@extends('layout.app')

@section('content')

    <div class="container d-none" id="mainDiv">
        <div class="row">
            <div class="col-md-12 p-5">
                <button id="addNewBtnId" class="btn my-3 btn-danger">Add New</button>
                <table id="serviceDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Image</th>
                        <th class="th-sm">Name</th>
                        <th class="th-sm">Description</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="service_table">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="container" id="loaderDiv">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}" />

            </div>
        </div>
    </div>

    <div class="container d-none" id="wrongDiv">
        <div class="row">
            <div class="col-md-12 text-center p-5">
               <h3>Something Went Wrong !</h3>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 text-center">
                    <h5 class="mt-4">Do You Want To Delete?</h5>
                    <h5 class="mt-4 d-none" id="serviceDeleteId"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button  id="serviceDeleteConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <h5 class="mt-4 d-none" id="serviceEditId"></h5>
                    <div id="serviceEditForm" class="w-100 d-none">
                        <input type="text" id="serviceNameID" class="form-control mb-4" placeholder="Service Name">
                        <input type="text" id="serviceDesID" class="form-control mb-4" placeholder="Service Description">
                        <input type="text" id="serviceImgID" class="form-control mb-4" placeholder="Service Image Link">
                    </div>
                    <img id="serviceEditLoader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}" />
                    <h5 id="serviceEditWrong" class="d-none">Something Went Wrong !</h5>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="serviceEditConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">

                    <div id="serviceAddForm" class="w-100">
                        <h6 class="mb-4">Add New Service</h6>
                        <input type="text" id="serviceNameAddID" class="form-control mb-4" placeholder="Service Name">
                        <input type="text" id="serviceDesAddID" class="form-control mb-4" placeholder="Service Description">
                        <input type="text" id="serviceImgAddID" class="form-control mb-4" placeholder="Service Image Link">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="serviceAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        getServiceData();


        function getServiceData(){
            axios.get('/getServicesData')
                .then(function (response) {

                    if(response.status==200)
                    {
                        $('#mainDiv').removeClass('d-none');
                        $('#loaderDiv').addClass('d-none');

                        $('#serviceDataTable').DataTable().destroy();
                        $('#service_table').empty();

                        var dataJSON=response.data;
                        $.each(dataJSON, function(i, item) {
                            $('<tr>').html(
                                "<td>" + dataJSON[i].service_name + "</td>"+
                                "<td>" + dataJSON[i].service_des + "</td>"+
                                "<td>" + dataJSON[i].service_img + "</td>"+
                                "<td><a class='serviceEditBtn' data-id="+dataJSON[i].id+"><i class='fas fa-edit'></i> </a></td>"+
                                "<td><a class='serviceDeleteBtn' data-id="+dataJSON[i].id+"  ><i class='fas fa-trash-alt'></i> </a></td>"
                            ).appendTo('#service_table');
                        });

                        //Service Delete Btn Icon Click
                        $('.serviceDeleteBtn').click(function (){
                            var id = $(this).data('id');

                            $('#serviceDeleteId').html(id);
                            $('#deleteModal').modal('show');
                        })



                        //Service Table Edit Icon Click
                        $('.serviceEditBtn').click(function (){
                            var id = $(this).data('id');
                            $('#serviceEditId').html(id);
                            ServiceUpdateDetails(id);
                            $('#editModal').modal('show');
                        })

                        $('#serviceDataTable').DataTable({"order":false});
                        $('.dataTables_length').addClass('bs-select');

                    }
                    else{
                        $('#wrongDiv').removeClass('d-none');
                        $('#loaderDiv').addClass('d-none');
                    }


                }).catch(function (error) {
                $('#wrongDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');
            });
        }

        //Service Delete Modal Yes Btn
        $('#serviceDeleteConfirmBtn').click(function () {
            var id = $('#serviceDeleteId').html();
            ServiceDelete(id);
        })


        //service delete
        function ServiceDelete(deleteId)
        {
            $('#serviceDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>");  //Animation ..........
            axios.post('/ServiceDelete',{id:deleteId})
                .then(function (response){
                    $('#serviceDeleteConfirmBtn').html();

                    if(response.status==200)
                    {
                        if(response.data==1)
                        {
                            $('#deleteModal').modal('hide');
                            toastr.success('Delete success.');
                            getServiceData();
                        }
                        else {
                            $('#deleteModal').modal('hide');
                            toastr.error('Delete fail.');
                            getServiceData();
                        }
                    }
                    else {
                        $('#deleteModal').modal('hide');
                        toastr.error('something went wrong !');
                    }

                })
                .catch(function (error) {
                    $('#deleteModal').modal('hide');
                    toastr.error('something went wrong !');
                });
        }

        //each services Update details
        function ServiceUpdateDetails(detailsID)
        {
            axios.post('/ServiceDetails',{
                id:detailsID
            })
                .then(function (response){
                    if(response.status==200){
                        $('#serviceEditForm').removeClass('d-none');
                        $('#serviceEditLoader').addClass('d-none');
                        var jsonData = response.data;
                        $('#serviceNameID').val(jsonData[0].service_name);
                        $('#serviceDesID').val(jsonData[0].service_des);
                        $('#serviceImgID').val(jsonData[0].service_img);
                    }
                    else
                    {
                        $('#serviceEditLoader').addClass('d-none');
                        $('#serviceEditWrong').removeClass('d-none');
                    }
                })
                .catch(function (error) {
                    $('#serviceEditLoader').addClass('d-none');
                    $('#serviceEditWrong').removeClass('d-none');
                });
        }

        //Service Edit Modal Save Btn
        $('#serviceEditConfirmBtn').click(function () {
            var id = $('#serviceEditId').html();
            var name = $('#serviceNameID').val();
            var des = $('#serviceDesID').val();
            var img = $('#serviceImgID').val();
            ServiceUpdate(id,name,des,img);

        })

        //each services Update details
        function ServiceUpdate(serviceID,serviceName,serviceDes,serviceImg)
        {
            if(serviceName.length==0)
            {
                toastr.error('Service Name is Empty');
            }
            else if(serviceDes.length==0)
            {
                toastr.error('Service Description is Empty');
            }
            else if(serviceImg.length==0)
            {
                toastr.error('Service Image is Empty');
            }
            else {
                $('#serviceEditConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>"); //Animation

                axios.post('/ServiceUpdate',{
                    id:serviceID,
                    name:serviceName,
                    des:serviceDes,
                    img:serviceImg,
                })
                    .then(function (response){
                        $('#serviceEditConfirmBtn').html("Save");
                        if(response.status==200)
                        {
                            if(response.data==1)
                            {
                                $('#editModal').modal('hide');
                                toastr.success('Update success.');
                                getServiceData();
                            }
                            else {
                                $('#editModal').modal('hide');
                                toastr.error('Update fail.');
                                getServiceData();
                            }
                        }
                        else
                        {
                            $('#editModal').modal('hide');
                            toastr.success('something went wrong !');
                        }

                    })
                    .catch(function (error) {
                        $('#editModal').modal('hide');
                        toastr.error('something went wrong !');
                    });
            }

        }

        //Service Add New Btn Click

        $('#addNewBtnId').click(function() {
            $('#addModal').modal('show');
        });

        //Service Add Modal Save Btn
        $('#serviceAddConfirmBtn').click(function () {

            var name = $('#serviceNameAddID').val();
            var des = $('#serviceDesAddID').val();
            var img = $('#serviceImgAddID').val();
            ServiceAdd(name,des,img);

        })

        //Service Add Method
        function ServiceAdd(serviceName,serviceDes,serviceImg)
        {
            if(serviceName.length==0)
            {
                toastr.error('Service Name is Empty');
            }
            else if(serviceDes.length==0)
            {
                toastr.error('Service Description is Empty');
            }
            else if(serviceImg.length==0)
            {
                toastr.error('Service Image is Empty');
            }
            else {
                $('#serviceAddConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>"); //Animation

                axios.post('/ServiceAdd',{
                    name:serviceName,
                    des:serviceDes,
                    img:serviceImg,
                })
                    .then(function (response){
                        $('#serviceAddConfirmBtn').html("Save");
                        if(response.status==200)
                        {
                            if(response.data==1)
                            {
                                $('#addModal').modal('hide');
                                toastr.success('Add success.');
                                getServiceData();
                            }
                            else {
                                $('#addModal').modal('hide');
                                toastr.error('Add fail.');
                                getServiceData();
                            }
                        }
                        else
                        {
                            $('#addModal').modal('hide');
                            toastr.success('something went wrong !');
                        }

                    })
                    .catch(function (error) {
                        $('#addModal').modal('hide');
                        toastr.error('something went wrong !');
                    });
            }

        }

    </script>
@endsection


