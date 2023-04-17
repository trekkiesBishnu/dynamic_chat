@extends('layouts.app')
@section('content')
{{-- <div class="container-fluid"> --}}

    @foreach ($users as $d )
    <p>{{ $d->name }}:<small>{{ $d->email }}</small></p>
    @endforeach
{{-- </div> --}}

@endsection