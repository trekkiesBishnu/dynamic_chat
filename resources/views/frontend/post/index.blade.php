@extends('layouts.app')
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
</div>
{{-- <div class="text-center">Available Post</div> --}}
<br> <br>
<div class="container-fluid bg-primary">
    <div class="row">

        @foreach ($post as $postItem)
        <div class="col-lg-2"></div>
        <div class="col-lg-8 border border-primary bg-secondary my-2">
            <img src="{{ $postItem->hasMedia('post_image') ? $postItem->getMedia('post_image')[0]->getFullUrl() : '' }}"
                alt="" style="height:200px;width:350px"> <small class="text-white flex-end">Posted on:{{ $postItem->created_at->diffForHumans() }}</small>
                <small>posted:by{{ $postItem->user->name }}</small>
            <h5 class="text-white">Post: <b class="text-dark"> {{ $postItem->name }}</b></h5>
            <p class="text-white">{{ $postItem->description }}</p>
            <small class="text-white">category:{{ $postItem->category->name }}</small>
            

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

                                {{-- <div class="col-lg-2"> --}}
                                <br>
                                <button type="submit" class="btn btn-primary btn-sm flex-end">Create Post</button>
                                {{-- </div> --}}
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
@endsection