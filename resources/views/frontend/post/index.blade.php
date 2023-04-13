{{-- @extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">Post</div>
        <div class="col-lg-6">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                Create Post
            </button>
        </div>
    </div>
</div> --}}
{{-- <div class="text-center">Available Post</div> 
<br> <br>
<div class="container-fluid bg-primary">
    <div class="row">

        @foreach ($post as $postItem)
        <div class="col-lg-2"></div>
        <div class="col-lg-8 border border-primary bg-secondary my-2">
            <img src="{{ $postItem->hasMedia('post_image') ? $postItem->getMedia('post_image')[0]->getFullUrl() : '' }}"
                alt="" style="height:200px;width:350px"> <small class="text-white flex-end">Posted
                on:{{ $postItem->created_at->diffForHumans() }}</small>
            <small>posted:by{{ $postItem->user->name }}</small>
            <h5 class="text-white">Post: <b class="text-dark"> {{ $postItem->name }}</b></h5>
            <p class="text-white">{{ $postItem->description }}</p>
            <small class="text-white">category:{{ $postItem->category->name }}</small>
            <br>
            <form action="{{ route('commentPost',$postItem->id) }}" method="POST">
                @csrf
                <label for="comment">Comment</label>
                <input type="text" name="comment" id="" class="fprm-control">
                <button type="submit" class="btn btn-secondary">Comment</button>
            </form>


        </div>
        <div class="col-lg-2">
            @if (!$postItem->likeBy(auth()->user()))
            <form action="{{ route('likeStore',$postItem->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary">Like </button>
            </form>
            @endif
            <p>{{ $postItem->like->count() }} {{ Str::plural( 'like',$postItem->like->count()) }}</p>
            <form action="{{ route('likeDelete',$postItem->id) }}" method="POST">
                @csrf
                @method('DELETE')
                @if ($postItem->likeBy(auth()->user()))

                <button type="submit" class="btn btn-secondary">Unlike </button>


                @endif
            </form>
        </div>
        @endforeach
    </div>
</div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Post Creating..</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-10">
                                <label for="name">Post Title</label>
                                <input type="text" name="name" id="name" class="form-control">
                                <label for="name">Description</label>
                                <textarea type="text" name="description" id="description"
                                    class="form-control"></textarea>

                                <label for="">Choose Category</label>
                                <select name="category_id" id="" class="form-control">
                                    <option value="">Choose Your Option</option>
                                    @foreach ($category as $Categoryitem)
                                    <option value="{{ $Categoryitem->id }}" class="form-control">
                                        {{ $Categoryitem->name }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <small>Image Upload..</small>
                                <input type="file" name="image" id="" class="form-control">

                                {{-- <div class="col-lg-2">
                                <br>
                                <button type="submit" class="btn btn-primary btn-sm flex-end">Create Post</button>
                                {{-- </div> 
                            </div>
                        </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
{{-- </div> --}}
{{-- @endsection --}}
@extends('layouts.app')
  @section('content')
      <div class="container" style="display:flex; flex-wrap: wrap;">
          <div class="col-lg-6">
              <h2>Posts</h2>
          </div>
          <div class="col-lg-6 d-flex justify-content-end align-items-center">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                  Create Post
              </button>
          </div>

          <hr>
              </div>

          @foreach ($post as $postItem)
              <div class="col-lg-9 mb-3 mx-5 me-5 justify-content-center">
                  <div class="card bg-light">
                      <img style="height:200px;width:200px" src="{{ $postItem->hasMedia('post_image') ? $postItem->getMedia('post_image')[0]->getFullUrl() : 'https://via.placeholder.com/350x200.png?text=No+Image' }}"
                           alt="Post Image" class="card-img-top">
                      <div class="card-body">
                          <h5 class="card-title">{{ $postItem->name }}</h5>
                          <p class="card-text">{{ Str::limit($postItem->description, 100) }}</p>
                      </div>
                      <div class="card-footer">
                          <small class="text-muted">
                              Posted on {{ $postItem->created_at->diffForHumans() }} by <b> {{ $postItem->user->name }}</b>
                          </small>
                          <div class="mt-2">
                              @if (!$postItem->likeBy(auth()->user()))
                                  <form action="{{ route('likeStore', $postItem->id) }}" method="POST">
                                      @csrf
                                      <button type="submit" class="btn btn-outline-primary btn-sm">
                                          <i class="bi bi-hand-thumbs-up"></i> Like
                                      </button>
                                  </form>
                              @endif

                              @if ($postItem->like->count() > 0)
                                  <span class="badge bg-primary rounded-pill">
                                          {{ $postItem->like->count() }} {{ Str::plural('like', $postItem->like->count()) }}
                                      </span>
                              @endif

                              @if ($postItem->likeBy(auth()->user()))
                                  <form action="{{ route('likeDelete', $postItem->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-outline-primary btn-sm">
                                          <i class="bi bi-hand-thumbs-down"></i> Unlike
                                      </button>
                                  </form>
                              @endif
                              <div class="comment-section">
                                <form action="{{ route('post.comment', $postItem->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group " >
                                    <button type="submit" class="btn btn-sm btn-primary float-end mt-1">Comment</button>
                                        <textarea name="comment" required id="comment" class="form-control" required placeholder="Add a comment"></textarea>
                                </div>
                                </form>
                                <div></div>
                                <div class="comments mx-1">
                                   
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                          <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <small> {{ $postItem->comments->count() }} {{ Str::plural('comment', $postItem->comments->count()) }} </small>
                                            </button>
                                          </h2>
                                          <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @foreach($postItem->comments as $comment)
                                                <div class="comment">
                                                   
                                                    <small> <b> {{ $comment->user->name }}:</b><small>{{ $comment->comment }}</small></small>
                                                    @if ($comment->user_id==Auth::id())
                                                    <small>
                                                            <button type="button" value="{{ $comment->id }}" class="btn btn-secondary editComment btn-sm" >Edit</button>
                                                    </small>
                                                    @endif 
                                                </div>
                                            @endforeach
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                   </div>
              </div>
         </div>
      @endforeach
    </div>
 </div>
 <!-- The Modal -->
<div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Post Creating..</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-10">
                                    <label for="name">Post Title</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    <label for="name">Description</label>
                                    <textarea type="text" name="description" id="description"
                                        class="form-control"></textarea>
    
                                    <label for="">Choose Category</label>
                                    <select name="category_id" id="" class="form-control">
                                        <option value="">Choose Your Option</option>
                                        @foreach ($category as $Categoryitem)
                                        <option value="{{ $Categoryitem->id }}" class="form-control">
                                            {{ $Categoryitem->name }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <small>Image Upload..</small>
                                    <input type="file" name="image" id="" class="form-control">
    
                                    <div class="col-lg-2">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-sm flex-end">Create Post</button>
                                   </div> 
                                </div>
                            </div>
                    </form>
                </div>
    
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
    
            </div>
        </div>
    </div>

 <!-- The Modal edit comment-->
<!-- Modal -->
{{-- <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#myModal1">Open Modal</button> --}}
<div class="modal fade" id="editComment" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
              <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>

 <script>
     $(document).on('click', '.editComment', function(e){
                e.preventDefault();
                var test_id = $(this).val();
                // $('#editComment').modal('show');
                 $('#editComment').modal('show')
                
                  alert(test_id);
                // $.ajax({
                //     type: "get",
                //     url: "url",
                //     data: "data",
                //     dataType: "dataType",
                //     success: function (response) {
                        
                //     }
                // });
     });
 </script>
@endsection
