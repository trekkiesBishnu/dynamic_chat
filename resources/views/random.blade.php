{{-- @extends('layouts.app')
@section('content') --}}
<div class="container-fluid">
    <div id="message_update"></div>
    <div class="row">
        <div class="col-2">test</div>
        <div class="col-10">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $d )
                    <tr>

                        <td>{{ $d->id }}</td>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->email }}</td>
                        <td> <img class="img-fluid" src="{{ $d->hasMedia('user_image') ?  $d->getMedia('user_image')[0]->getFullUrl() : '' }}" alt=""
                            style="height:50px;weight:80px">
                        </td>
                        <td>
                            {{-- <a class="btn btn-primary edit_user" href="{{ route('edit_ajaxUser',$d->id) }}">Edit</a> --}}
                            <button class="btn btn-primary edit_user" value="{{ $d->id }}" >Edit</button>
                            <a class="btn btn-danger delete"  >Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

 {{-- for edit user  --}}

 <div class="modal" id="edit_user">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">user Updating..</h4>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                    <input type="hidden" name="user_id" id="user_id" value=>

                                    <label for="name" class="form-label">NAme</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control">
                                    <button type="submit" class="float-end update_user" >Update</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
<script>
   $('.delete').click(function () {
    confirm('Are You sure Want to Delete');
});

$('.edit_user').click(function (){
    var user_id=$(this).val();
    let url="{{ route('edit_ajaxUser',':id') }}";
    url=url.replace(':id',user_id);

    $.ajax({
        type: "get",
        url: url,
        data: "data",
        dataType: "Json",
        success: function (res) {
           $('#edit_user').modal('show');
           $('#name').val(res.data.name);
           $('#email').val(res.data.email);
           $('#user_id').val(res.data.id);

        }
    });
});

$('.update_user').click(function(){
    var user_id=$('#user_id').val();
    var name=$('#name').val();
    var email=$('#email').val();
    let url="{{ route('update_ajaxUser',':id') }}";
    url=url.replace(':id',user_id);


    $.ajax({
        type: "put",
        url: url,
        data: { name:name,email:email  },
        dataType: "Json",
        success: function (response) {
            // console.log(response);
            $('#edit_user').modal('hide');
            $('#message_update').addClass('alert alert-success');
            $('#message_update').text(response.message);
            ajaxView();


        }
    });
});
</script>

{{-- @endsection --}}