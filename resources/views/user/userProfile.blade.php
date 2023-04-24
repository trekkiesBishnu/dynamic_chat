@extends('frontend.post.main')
@section('content')
<div class="container-fluid mt-5  pt-4">
    
        <div class=" pt-5 text-center bg-info text-white text-center pb-4">My Profile</div>
   
    <div id="success_message"></div>
    <div class="row justify-content-evenly pt-5 mt-2">

        <div class="col-lg-6 border border-warning">
            <div class="text-white bg-primary  text-center mt-2" > <b>Information</b> </div>
            <hr>
            <form action="" class="mt-3">
                <label class="form-label" for="name">Name</label> 
                <input type="text" name="" id="" class="form-control" value="{{ $user->name }}">
                <label class="form-label" for="name">Roll No</label> 
                <input type="text" name="" id="" class="form-control" value="{{ $user->id }}">
                <label class="form-label" for="name">Email</label> 
                <input type="text" name="" id="" class="form-control" value="{{ $user->email }}">
                <label class="form-label" for="name">Password</label> 

                <button type="button" class="btn btn-info btn-sm mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#myModal">Password
                    Change</button>
                {{-- <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#myModal">Open Small Modal</button> --}}
    
    
            </form>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-3  ">
            <h3 class="text-white bg-warning text-center">User Profile </h3>
            <div id="profile_image_display">
                    <img class="img-fluid" src="{{ $user->hasMedia('user_image') ?  $user->getMedia('user_image')[0]->getFullUrl() : '' }}" alt=""
                    style="height:200px;weight:150px">
            </div>
          
{{--     
            <form action="{{ route('ProfileChange',$user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input class="form-control mt-2" type="file" name="image" required>
                <button class="btn btn-info mt-2"> Image Change Or Upload</button>
            </form>  --}}
      
            <form id="myForm" >
                <div id="user_image">
                <input type="hidden" id="user_id" value="{{ $user->id }}">
                <label for="image" class="form-label"></label>
                <input  type="file" name="img" id="img" class="form-control" onchange="submitImage()">
               </div>
                <div class="">
                  <p class="text-secondary">Just choose image </p>
                </div>
    
            </form>
        </div>
    </div>
</div>
{{-- modal  --}}
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Password Change</h4>
            </div>
            <div class="modal-body">
                <form  id="password_change" action="{{ route('user_password',$user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $user->id }}" id="user_id">
                    <br>
                    <label for="current_password">Current Password </label>
                    <input type="text" name="current_password" id="current_password" class="form-control">
                    @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                    <br>
                    <label for="new_password">New Password </label>
                    <input type="text" name="new_password" id="new_password" class="form-control">
                    @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror

                    <br>
                    <label for="confirm_password">Confirm Password </label>
                    <input type="text" name="confirm_password" id="confirm_password" class="form-control">
                    @error('confirm_password') <small class="text-danger">{{ $message }}</small> @enderror

                    <br>
                    {{-- <input type="submit" value="Confirm" class="form-control"> --}}
                    <button type="button" class="btn btn-primary">Update</button>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- The Modal -->
<div class="modal" id="imageEdit">
        <div class="modal-dialog">
          <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Modal Heading</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
      
            <!-- Modal body -->
            <div class="modal-body">
              Are you sure Want To Chage??
            </div>
      
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-primary btn_image" onclick="ajaxView()" value="{{ $user->id }}">Confirm</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
<script>
    function submitImage() {
        let myForm = document.getElementById('myForm');
        let url="{{ route('ProfileChange',':id') }}";
        var user_id=$('#user_id').val();
        url=url.replace(':id',user_id);
        const formData = new FormData(myForm);
        let imgField = document.getElementById('img');
        formData.append('img',imgField.files[0]);
        fetch(url,{
            method : 'post',
            headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
            body : formData
        }).then(function (res) { 
                
           
            return res.json();
            
         }).then(function( data){
            if(data.src!=''){
                    $('#profile_image_display').empty();
                    $('#profile_image_display').append(' <img  src="'+data.src+'" alt="" style="height:200px;weight:150px">');

                }
         }).catch(function (err) { 
             console.log(err);
             
          })

    }

    function ajaxView(){
     let url="{{ route('ajaxViewImage',':id') }}";
        var user_id=$('.btn_image').val();
        url=url.replace(':id',user_id);
            $.ajax({
                url:url,
                type:"GET",
                success:function(res){
                    $('#testing_div').html(res.view);

                },error:function(err){
                    
                }
            })
        }
</script>
@endsection