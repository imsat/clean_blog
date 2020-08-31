@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Category Trash </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($trashCategories as $category)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td>{{$category->name}}</td>
                                    <td>
                                        <span class="badge {{$category->status == 1 ? 'badge-success' : 'badge-danger'}}">{{$category->status == 1 ? 'Active' : 'Inactive'}}</span>
                                    </td>
                                    <td>
                                        {{Form::open(['route' => ['categories.restore', $category->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}
                                        <button type="submit"
                                                title="Delete"
                                                onclick="return confirm('Are you sure to restore!!!')"
                                                class="btn btn-sm btn-outline-danger">Restore
                                        </button>
                                        {{Form::close()}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
