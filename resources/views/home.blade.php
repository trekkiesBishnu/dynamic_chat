@extends('frontend.post.main')
{{-- @extends('layouts.app') --}}
@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        {{-- <div id="testing_div"></div> --}}
        <div class="container-fluid">

        </div>
        @if(count($users)>0)
       
                <div class="col-lg-3 mt-3">
                    <ul class="list-group">
                        @foreach ($users as $user)
                        <li id="{{ $user->id }}-select_status" class="list-group-item list-group-item-dark cursor-pointer user_list " data-id="{{ $user->id }}">

                        @if ($user->hasMedia('user_image'))
                            <img src="{{ $user->getMedia('user_image')[0]->getFullUrl() }}" alt="" class="img-thumbnail" style="height:50px;width:80px">
                        @else
                        <img src="{{ asset('image/images.jpg')  }}" alt="" srcset="" class="img-thumbnail" style="height:50px;width:80px">
                        @endif
                                {{ $user->name }}
                                <b><sup id="{{ $user->id }}-status" class="offline-status">Offline</sup></b>

                            </li>
                        
                        @endforeach
                    </ul>
                </div>
               
                <div class="col-lg-9 mt-4">
                    <h1 class="start-head">Click For Start Chat</h1>
                    <div class="chat-section " >
                         <div id="chat-container">


                            {{-- chat here for sender and receiver  --}}
                            
                            </div>
                            <form action="" id="chat-form">
                                <input type="text" name="message" id="message" required placeholder="Enter message" >
                                <input type="submit" value="Send" class="btn btn-primary btn-lg float-end mx-5 ">
                            </form>
                       
                    </div>
                </div>
        @else
            <div class="container-fluid text-center col-lg-12">
                <h4>User Not Found!</h4>
            </div>
        @endif
    </div>
</div>
{{-- delete modal  --}}
<!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="DeleteMessageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Message Deleting..</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form  id="delete-message-form">
            <div class="modal-body">
                <input type="hidden" name="id" id="delete_message_id">
                <p>Are You sure Want delete beleow message?</p>
                <p><b id="chat-message-name"></b></p>
            </div>
       
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger delete_message">Delete</button>
        </div>
    </form>
      </div>
    </div>
  </div>


@endsection
