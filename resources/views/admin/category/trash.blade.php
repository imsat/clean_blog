@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Category Trash</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Category</a></li>
                        <li class="breadcrumb-item active">Category Trash</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Category Trash</div>

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
                                            <span
                                                class="badge {{$category->status == 1 ? 'badge-success' : 'badge-danger'}}">{{$category->status == 1 ? 'Active' : 'Inactive'}}</span>
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

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
