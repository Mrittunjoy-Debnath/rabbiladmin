@extends('layout.app')
@section('title','Photo Gallery')

@section('content')
    <div id="mainDivId" class="container">
        <div class="row">
            <div class="col-md-12 p-3">
                <button data-toggle="modal" data-target="#PhotoModal" id="addNewPhotoBtnId" class="btn my-3 btn-sm btn-danger">Add New</button>
            </div>
        </div>
    </div>

    <div id="" class="container-fluid">
        <div class="row photoRow">

        </div>
    </div>

    <div class="modal fade" id="PhotoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  text-center">
                    <div class="container">
                        <div class="row">
                            <input class="form-control" id="imgInput" type="file"/>
                            <img class="imgPreview mt-3" id="imgPreview" src="{{asset('images/default-img.png')}}"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button id="SavePhoto" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#imgInput').change(function () {
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (event) {
                var ImgSource = event.target.result;
                $('#imgPreview').attr('src',ImgSource);
            }
        })

        $('#SavePhoto').on('click',function () {

            $('#SavePhoto').html("<div class='spinner-border spinner-border-sm text-white' role='status'></div>")

            var PhotoFile = $('#imgInput').prop('files')[0];

            var formData = new FormData();
            formData.append('photo',PhotoFile);

            axios.post("/PhotoUpload",formData).then(function (response) {

                if(response.status==200 && response.data ==1)
                {
                    $('#PhotoModal').modal('hide');
                    $('#SavePhoto').html('Save');
                    toastr.success('Photo upload success');
                }
                else {
                    $('#PhotoModal').modal('hide');
                    toastr.error('Photo upload failed');
                }

            }).catch(function (error) {
                $('#PhotoModal').modal('hide');
                toastr.error('Photo upload failed');
                $('#SavePhoto').html('Save');
            })
        })

        LoadPhoto();

        function LoadPhoto() {
            axios.get('/PhotoJSON').then(function (response) {
                $.each(response.data, function(i, item) {
                    $("<div class='col-md-3 p-1'>").html(
                        "<img class='imgOnRow' src="+item['location']+">"
                    ).appendTo('.photoRow');
                });
            }).catch(function (error) {

            })
        }
    </script>
@endsection
