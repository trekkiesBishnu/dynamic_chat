@if (Auth::id())

<div class="mt-2">
    @if (!$postItem->likeBy(auth()->user()))
    <form id="like-post-form">

        <button type="button" class="btn btn-outline-primary btn-sm post-like"
            data-id="{{ $postItem->id }}">
            <i class="bi bi-hand-thumbs-up"></i><span id="unlikeWhen"> Like</span>
        </button>
    </form>
    {{-- <form action="{{ route('likeStore', $postItem->id) }}" method="POST" id="like-post-form">
    @csrf
    <button type="submit" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-hand-thumbs-up"></i> Like
    </button>
    </form> --}}
    @endif

    @if ($postItem->like->count() > 0)
    <span class="badge bg-primary rounded-pill " id="like_count">
        {{ $postItem->like->count() }} {{ Str::plural('like', $postItem->like->count()) }}
    </span>
    @endif

    @if ($postItem->likeBy(auth()->user()))
    <form >
        <button type="button" class="btn btn-outline-primary btn-sm dislike_post" data-id="{{ $postItem->id }}">
            <i id="whenLike" class="bi bi-hand-thumbs-down">Unlike</i> 
        </button>
    </form>
    @endif
    {{-- @if ($postItem->likeBy(auth()->user()))
    <form action="{{ route('likeDelete', $postItem->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-hand-thumbs-down"></i> Unlike
        </button>
    </form>
    @endif --}}
    @endif
</div>