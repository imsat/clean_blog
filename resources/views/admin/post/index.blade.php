@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Posts
                        <a href="{{route('categories.create')}}" class="btn btn-success btn-sm float-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table id="posts" class="table text-center">
                            <thead>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Body</th>
                            <th>Created At</th>
                            <th>Options</th>
                            </thead>
                        </table>


                        {{--                        <table id="example2" class="table text-center">--}}
                        {{--                            <thead>--}}
                        {{--                            <tr>--}}
                        {{--                                <th style="width: 5%">#</th>--}}
                        {{--                                <th style="width: 20%">Title</th>--}}
                        {{--                                <th style="width: 10%">Category</th>--}}
                        {{--                                <th style="width: 35%">Body</th>--}}
                        {{--                                <th style="width: 10%">Status</th>--}}
                        {{--                                <th style="width: 20%">Action</th>--}}
                        {{--                            </tr>--}}
                        {{--                            </thead>--}}
                        {{--                            <tbody>--}}
                        {{--                            @php($i = 1)--}}
                        {{--                            @foreach($posts as $post)--}}
                        {{--                                <tr>--}}
                        {{--                                    <th scope="row">{{$i++}}</th>--}}
                        {{--                                    <td>{{$post->title}}</td>--}}
                        {{--                                    <td>{{$post->category->name}}</td>--}}
                        {{--                                    <td>{{$post->body}}</td>--}}
                        {{--                                    <td>--}}
                        {{--                                        <a href="#" class="text-dark"  onclick="return confirm('Are you sure to change!!!')">--}}
                        {{--                                            {{$post->status == 1 ? 'Active' : 'Inactive'}}--}}
                        {{--                                        </a>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td>--}}
                        {{--                                        <a href="{{route('posts.edit', $post->id)}}"--}}
                        {{--                                           class="btn btn-primary btn-sm">Edit</a>--}}
                        {{--                                        <a href="{{route('posts.show', $post->id)}}"--}}
                        {{--                                           class="btn btn-info btn-sm">View</a>--}}

                        {{--                                        {{Form::open(['route' => ['posts.destroy', $post->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}--}}
                        {{--                                        <button type="submit"--}}
                        {{--                                                title="Delete"--}}
                        {{--                                                onclick="return confirm('Are you sure to delete!!!')"--}}
                        {{--                                                class="btn btn-sm btn-danger">Delete--}}
                        {{--                                        </button>--}}
                        {{--                                        {{Form::close()}}--}}
                        {{--                                    </td>--}}
                        {{--                                </tr>--}}
                        {{--                            @endforeach--}}
                        {{--                            </tbody>--}}
                        {{--                        </table>--}}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#posts').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('allposts') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "id" },
                    { "data": "title" },
                    { "data": "category_name", "orderable": false },
                    { "data": "body" },
                    { "data": "created_at" },
                    { "data": "options", "orderable": false  }
                ],
                // "columnDefs": [
                //     { "orderable": false, "targets": 5 }
                // ]

            });
        });
    </script>
@endsection
