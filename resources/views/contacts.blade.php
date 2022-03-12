@extends('layout.app')
@section('content')
    <div class="container " id="mainDivContacts">
        <div class="row">
            <div class="col-md-12 p-5">
                <table id="contactDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Name</th>
                        <th class="th-sm">Mobile</th>
                        <th class="th-sm">Email</th>
                        <th class="th-sm">Message</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="contacts_table">


                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="container" id="loaderDivContacts">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}" />

            </div>
        </div>
    </div>

    <div class="container d-none" id="wrongDivContacts">
        <div class="row">
            <div class="col-md-12 text-center p-5">
                <h3>Something Went Wrong !</h3>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 text-center">
                    <h5 class="mt-4">Do You Want To Delete?</h5>
                    <h5 class="mt-4 d-none" id="ContactDeleteId"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                    <button  id="ContactDeleteConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getContactsData();

        //for Contacts data
        function getContactsData(){
            axios.get('/getContactsData')
                .then(function (response) {

                    if(response.status==200)
                    {
                        $('#mainDivContacts').removeClass('d-none');
                        $('#loaderDivContacts').addClass('d-none');


                        $('#contactDataTable').DataTable().destroy();
                        $('#contacts_table').empty();

                        var dataJSON=response.data;
                        $.each(dataJSON, function(i, item) {
                            $('<tr>').html(
                                "<td>" + dataJSON[i].contact_name + "</td>"+
                                "<td>" + dataJSON[i].contact_mobile + "</td>"+
                                "<td>" + dataJSON[i].contact_email + "</td>"+
                                "<td>" + dataJSON[i].contact_msg + "</td>"+
                                "<td><a class='contactDeleteBtn' data-id="+dataJSON[i].id+"  ><i class='fas fa-trash-alt'></i> </a></td>"
                            ).appendTo('#contacts_table');
                        });

                        $('.contactDeleteBtn').click(function () {
                            var id = $(this).data('id');
                            $('#ContactDeleteId').html(id);
                            $('#deleteContactModal').modal('show');
                        });


                        $('#contactDataTable').DataTable({"order":false});
                        $('.dataTables_length').addClass('bs-select');

                    }
                    else{
                        $('#wrongDivContacts').removeClass('d-none');
                        $('#loaderDivContacts').addClass('d-none');
                    }


                }).catch(function (error) {
                $('#wrongDivContacts').removeClass('d-none');
                $('#loaderDivContacts').addClass('d-none');
            });
        }

        $('#ContactDeleteConfirmBtn').click(function () {
            var id = $('#ContactDeleteId').html();
            ContactDelete(id);
        });


        //Contacts delete
        function ContactDelete(deleteId)
        {
            $('#ContactDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>");  //Animation ..........
            axios.post('/ContactsDelete',{id:deleteId})
                .then(function (response){
                    $('#ContactDeleteConfirmBtn').html();

                    if(response.status==200)
                    {
                        if(response.data==1)
                        {
                            $('#deleteContactModal').modal('hide');
                            toastr.success('Delete success.');
                            getContactsData();
                        }
                        else {
                            $('#deleteContactModal').modal('hide');
                            toastr.error('Delete fail.');
                            getContactsData();
                        }
                    }
                    else {
                        $('#deleteContactModal').modal('hide');
                        toastr.error('something went wrong !');
                    }

                })
                .catch(function (error) {
                    $('#deleteContactModal').modal('hide');
                    toastr.error('something went wrong !');
                });

        }

    </script>
@endsection
