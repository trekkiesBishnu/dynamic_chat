@extends('frontend.post.main')
@section('content')

<div class="container  " style="display:flex; flex-wrap: wrap;">
    <div class="col-lg-6 mt-5 pt-5">
        <h2>Posts</h2>
    </div>
    <div class="col-lg-6 mt-5 pt-4 d-flex justify-content-end align-items-center">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Create Post
        </button>
    </div>

    <hr>
</div>
<div class="container-fluid">

    @foreach ($post as $key=>$postItem)
    <div class="row justify-content-evenly">
        <div class="col-lg-12">
            <div class="card bg-light col-lg-9 px-5 mx-5 my-2">
                <div>
                    <p class="float-end">posted by:<b>{{ $postItem->user->name }}</b></p>
                    <p class="text-black"> Post name:: <span class="card-title ">{{ $postItem->name }}</span></p>
                    <small class=" float-end">
                        Posted on {{ $postItem->created_at->diffForHumans() }}

                    </small>
                </div>
                <img class="img-fluid mx-3 px-4" style="height:200px;width:500px"
                    src="{{ $postItem->hasMedia('post_image') ? $postItem->getMedia('post_image')[0]->getFullUrl() : 'https://via.placeholder.com/350x200.png?text=No+Image' }}"
                    alt="Post Image" class="card-img-top">

                <div class="card-body">
                    <p class="card-text">description:<b>{{$postItem->description }}</b></p>
                </div>
                @if (Auth::id())

                <div class="like-dislike-form">
                        <span class="badge bg-primary rounded-pill " id="like_count{{ $key }}">
                                {{ $postItem->like->count() }} {{ Str::plural('like', $postItem->like->count()) }}
                            </span>
                    <form id="like-post-form" >
                        <input type="hidden" id="like_unlike{{ $key }}" value="{{ $postItem->likeBy(auth()->user())?'Unlike':'Like' }}">
                        <button bishnu="me" type="button" class="btn btn-outline-primary btn-sm post-like"
                           id="{{ $postItem->id }}-likeUnlike_btn"  onclick="likeunlike('{{ $postItem->id }}','like_count{{ $key }}','unlikeWhen{{ $key }}','like_unlike{{ $key }}')">
                            <i class="bi bi-hand-thumbs-up"></i><span id="unlikeWhen{{ $key }}" >{{ !$postItem->likeBy(auth()->user())?'Like':'Unlike' }}</span>
                        </button>
                    </form>
                
                    @endif
                </div>
                <div class="comment-section">
                        <form >
                            <div class="form-group ">
                                <button type="button" class="btn btn-sm btn-primary float-end mt-1" onclick="commentpost('{{ $postItem->id }}')">Comment</button>
                                <textarea name="comment" required id="comment" class="form-control" required
                                    placeholder="Add a comment"></textarea>
                            </div>
                        </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
{{-- <div class="  pt-2 mt-2 bg-primary ">
    <div class="row">
        <div class="col-lg-12">

            @foreach ($post as $postItem)

            <div class="col-lg-9  ">
                <div class="card bg-light">
                    <img class="img-fluid" style="height:200px;width:200px"
                        src="{{ $postItem->hasMedia('post_image') ? $postItem->getMedia('post_image')[0]->getFullUrl() : 'https://via.placeholder.com/350x200.png?text=No+Image' }}"
alt="Post Image" class="card-img-top">
<div class="card-body">
    <h5 class="card-title">{{ $postItem->name }}</h5>
    <p class="card-text">{{ Str::limit($postItem->description, 100) }}</p>
</div>
<div class="card-footer">
    <small class="text-muted">
        Posted on {{ $postItem->created_at->diffForHumans() }} by <b>
            {{ $postItem->user->name }}</b>
    </small>
    @if (Auth::id())

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
        @endif

        <div class="comment-section">
            <form action="{{ route('post.comment', $postItem->id) }}" method="POST">
                @csrf
                <div class="form-group ">
                    <button type="submit" class="btn btn-sm btn-primary float-end mt-1">Comment</button>
                    <textarea name="comment" required id="comment" class="form-control" required
                        placeholder="Add a comment"></textarea>
                </div>
            </form>

            <div class="comments mx-1">

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <small> {{ $postItem->comments->count() }}
                                    {{ Str::plural('comment', $postItem->comments->count()) }}
                                </small>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                @foreach($postItem->comments as $comment)
                                <div class="comment">

                                    <small> <b>
                                            {{ $comment->user->name }}:</b><small>{{ $comment->comment }}</small></small>
                                    @if ($comment->user_id==Auth::id())
                                    <button type="button" class="btn btn-primary editbtn btn-sm">Edit</button></td>
                                    <!-- The Modal edit comment-->
                                    <div class="modal" id="edit_comment">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Comment Updating..</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <form
                                                                    action="{{ route('comment.update',$comment->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <label for="name" class="form-label">Message</label>
                                                                    <textarea type="text" name="message" id="message"
                                                                        class="form-control">{{ $comment->comment }}</textarea>
                                                                    <button type="submit"
                                                                        class="float-end">Update</button>
                                                                </form>
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
@endforeach

</div> --}}

{{-- post modal  --}}
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create Post</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-10">
                                <label for="title">Post Title</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label for="category_id">Choose Category</label>
                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">Choose Your Option</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <label for="image">Image Upload</label>
                                <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror" required>
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <button type="submit" class="btn btn-primary btn-sm mt-3">Create Post</button>
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
{{-- post modal end  --}}

<script>
$(document).ready(function(){
       

 });

       function likeunlike(postId,countDivId,buttonText,statusDiv){
          let status=$('#'+statusDiv).val();
          var url="{{ route('likeStore',':id') }}";
          url=url.replace(':id',postId);
          $.ajax({
              type: "post",
              url: url,
              data: {id:postId,status:status},
              success: function (res) {

                if(res.success==true){
                    $('#'+countDivId).text(res.count+' Like');
                    $('#'+buttonText).text(res.text);
                    $('#'+statusDiv).val(res.text);
                   
                }
              }
          });
       }

       function commentpost(postId){
        var comment=$('#comment').val();
        var url="{{ route('post.comment',':id') }}";
          url=url.replace(':id',postId);
          

          $.ajax({
              type: "post",
              url: url,
              data:{id:postId,comment:comment},
              success: function (res) {
                  alert(res.message);
                //   console.log(res.data);
               

                  


              }
          });
       }
      
</script>
@endsection