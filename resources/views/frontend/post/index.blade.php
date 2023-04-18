@extends('layouts.app')
@section('content')
<div class="container-fluid">
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

    <div class="row justify-content-evenly bg-secondary">
        {{-- <div class="col-3">testing</div>
        <div class="col-6">
            <div id="testing_div"></div>

        </div> --}}
    </div>
    <div class="row justify-content-evenly m-2 p-3 bg-primary">
        @foreach ($post as $postItem)
        <div class="col-lg-3">user view</div>
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
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <small> {{ $postItem->comments->count() }}
                                                    {{ Str::plural('comment', $postItem->comments->count()) }} </small>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @foreach($postItem->comments as $comment)
                                                <div class="comment">

                                                    <small> <b>
                                                            {{ $comment->user->name }}:</b><small>{{ $comment->comment }}</small></small>
                                                    @if ($comment->user_id==Auth::id())
                                                    <button type="button"
                                                        class="btn btn-primary editbtn btn-sm">Edit</button></td>
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
                                                                                    <label for="name"
                                                                                        class="form-label">Message</label>
                                                                                    <textarea type="text" name="message"
                                                                                        id="message"
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
</div>
    {{ $post->links() }}
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
                                    <button type="submit" class="btn btn-primary btn-sm flex-end">Create
                                        Post</button>
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



<script>
    });
        $(document).on('click', '.editbtn', function(e){
                e.preventDefault();
                var test_id = $(this).val();
                $('#edit_comment').modal('show');
                //   alert(test_id);
                    
            });
</script>
@endsection