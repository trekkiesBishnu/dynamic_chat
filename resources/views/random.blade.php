{{-- @extends('layouts.app')
@section('content') --}}
<div class="container-fluid">
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
                            <a class="btn btn-primary" href="{{ route('edit_ajaxUser',$d->id) }}">Edit</a>
                            <a class="btn btn-danger" href="">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

{{-- @endsection --}}