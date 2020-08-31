@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Post
{{--                        <a href="{{route('posts.create')}}" class="btn btn-success btn-sm float-right">Add New</a>--}}
                        <a href="#" data-toggle="modal" data-target="#postCreate"
                           class="btn btn-success btn-sm float-right">Add New</a>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
{{--                            {{ session('status') }}--}}
                        </div>
                    @endif
                    <table id="posts" class="table text-center">
                        <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 15%">Title</th>
                            <th style="width: 20%">Body</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%">image</th>
                            <th style="width: 10%">Category</th>
                            <th style="width: 10%">Tag</th>
                            <th style="width: 20%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = 1)
                        @foreach($posts as $post)
                            <tr>
                                <th scope="row">{{$i++}}</th>
                                <td>{{$post->title}}</td>
                                <td>{{$post->body}}</td>
                                <td>
                                    <a href="{{route('posts.status.update', $post->id)}}"  onclick="return confirm('Are you sure to change!!!')">
                                        {{$post->status == 1 ? 'Active' : 'Inactive'}}
                                    </a>
                                </td>
                                <td>
                                    <img src="{{asset('images/'. $post->image)}}" class="card-img-top" alt="image" style="height: 50px; width: 50px;">
                                </td>
                                <td>{{$post->category->name}}</td>
{{--                                <td>{{$post->user->name}}</td>--}}
                                <td>
                                    @foreach($post->tags as $tag)
                                        <span class="badge badge-success">{{$tag->name}}</span>
                                    @endforeach
                                </td>
                                <td>
{{--                                    <a href="{{route('posts.edit', $post->id)}}"--}}
{{--                                       class="btn btn-primary btn-sm">Edit</a>--}}
                                    <button type="button" onclick="openPostEditModal({{$post->id}})" class="btn btn-primary btn-sm">Edit</button>
{{--                                    <a href="{{route('posts.show', $post->id)}}"--}}
{{--                                       class="btn btn-info btn-sm">View</a>--}}
                                    <button type="button" onclick="openShowPostModal({{$post->id}})" class="btn btn-info btn-sm">
                                        View
                                    </button>

                                    {{Form::open(['route' => ['posts.destroy', $post->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}
                                    <button type="submit"
                                            title="Delete"
                                            onclick="return confirm('Are you sure to delete!!!')"
                                            class="btn btn-sm btn-danger">Delete
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

    <!-- Post Create Modal -->
    <div class="modal fade" id="postCreate" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Post Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{Form::open(['route' => 'posts.store', 'method' => 'POST', 'enctype'=>"multipart/form-data"])}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input required type="text" name="title" for="title" class="form-control" id="title" >
                        <span class="text-danger ">{{$errors->has('title') ? $errors->first('title') : ''}}</span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Body</label>
                        <input required type="textarea" name="body" for="body" class="form-control" id="body" >
                        <span class="text-danger ">{{$errors->has('body') ? $errors->first('body') : ''}}</span>
                    </div>

                    <div class="form-group">
                        <select class="custom-select mb-3" name="category_id">
                            <option selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                <span class="text-danger ">{{$errors->has('category_id') ? $errors->first('category_id') : ''}}</span>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <select multiple class="custom-select mb-3" name="tag_id[]">
                            <option selected>Select Tag</option>
                            @foreach($tags as $tag)
                                <option  value="{{$tag->id}}">{{$tag->name}}</option>
                                <span class="text-danger ">{{$errors->has('tag_id') ? $errors->first('tag_id') : ''}}</span>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Upload Image</label>
                        <input type="file" required accept="image/png" name="image" for="image" class="form-control-file" id="image">
                        <span class="text-danger ">{{$errors->has('image') ? $errors->first('image') : ''}}</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>


    <!-- Category Show Modal -->
    <div class="modal fade" id="postShowModal" tabindex="-1" aria-labelledby="categoryShowLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postShowLabel">Post Show</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Id</th>
                            <td id="showPostId"></td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td id="showPostTitle"></td>
                        </tr>
                        <tr>
                            <th>Body</th>
                            <td id="showPostBody"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="showPostStatus"></td>
                        </tr>
                        <tr>
                            <th>Tags</th>
                            <td id="showPostTags"></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td id="showPostCreated_at"></td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td id="showPostImage"><img src="{{asset('images/'. $post->image)}}" class="card-img-top" alt="image"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Post Edit Modal -->
    <div class="modal fade" id="postEditModal" tabindex="-1" aria-labelledby="postEditLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postEditLabel">Post Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{Form::open(['id' => 'postEditForm', 'method' => 'PUT', 'enctype'=>"multipart/form-data"])}}
                {{--                    {{Form::open(['route' => ['categories.update', $category->id], 'method' => 'PUT' ])}}--}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Post Title</label>
{{--                        <input type="text" name="title" value="{{$post->title}}" class="form-control" id="postEditTitle" >--}}
                        <input type="text" name="title" class="form-control" id="editPostTitle" >
                        <span class="text-danger ">{{$errors->has('title') ? $errors->first('title') : ''}}</span>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
{{--                        <input type="textarea" name="body" value="{{$post->body}}" class="form-control" id="body" >--}}
                        <input type="textarea" name="body" class="form-control" id="editPostBody" >
                        <span class="text-danger ">{{$errors->has('body') ? $errors->first('body') : ''}}</span>
                    </div>
                    {{--                    <div class="form-group">--}}
                    {{--                        <label for="category">Category Name</label>--}}
                    {{--                        <select class="custom-select" name="category_id">--}}
                    {{--                            @foreach($categories as $category)--}}
                    {{--                                <option--}}
                    {{--                                    value="{{$category->id}}" {{$category->id == $post->category_id ? 'selected' : '' }}>{{$category->name}}</option>--}}
                    {{--                                   id="editPostCategoryName" value="{{$category->id}}" {{$category->id == $post->category_id ? 'selected' : '' }}></option>--}}
                    {{--                            @endforeach--}}
                    {{--                        </select>--}}
                    {{--                    </div>--}}
                    <div class="form-group">
                        <label for="category">Category Name</label>
                        <select class="custom-select" name="category_id" id="editPostCategorySelect">
                        </select>
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label for="tag">Tags</label>--}}
{{--                        <select multiple class="custom-select mb-3" name="tag_id[]">--}}
{{--                            --}}{{--                                <option selected>Select Tag</option>--}}
{{--                            --}}{{--                                @foreach($tags as $tag)--}}
{{--                            --}}{{--                                    <option  value="{{$tag->id}}">{{$tag->name}}</option>--}}
{{--                            --}}{{--                                    <span class="text-danger ">{{$errors->has('tag_id') ? $errors->first('tag_id') : ''}}</span>--}}
{{--                            --}}{{--                                @endforeach--}}
{{--                            @foreach($tags as $id => $tag)--}}
{{--                                <option value="{{$id}}"--}}
{{--                                @foreach($post->tags as $val)--}}
{{--                                    {{$val->id == $id ? 'selected': ''}}--}}
{{--                                    @endforeach >--}}
{{--                                    {{$tag->name}}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>  --}}

                    <div class="form-group">
                        <label for="tag">Tags</label>
                        <select multiple class="custom-select mb-3" name="tag_id[]" id="editPostTagSelect">
                        </select>
                    </div>

                    <div class="form-group custom-file">
                        <label class="custom-file-label">Choose file</label>
                        <input type="file" name="image" class="custom-file-input" id="inputGroupFile01"
                               aria-describedby="inputGroupFileAddon01">
                        <img src="" alt="Post image" class="img-fluid h-100 mt-2"  id="editPostAvatar">


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    <button type="button" class="btn btn-sm btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
    </div>


@endsection

@section('script')
{{--    <script>--}}
{{--        $(document).ready( function () {--}}
{{--            $('#posts').DataTable();--}}
{{--        } );--}}
{{--    </script>--}}


    <script>
        let posts = @json($posts)

            function openShowPostModal(id){
                let post = posts.find(post => post.id == id)
                // console.log(post);
                $('#showPostId').html(post.id);
                $('#showPostTitle').html(post.title);
                $('#showPostBody').html(post.body);
                $('#showPostStatus').html(post.status== 1 ? 'Active' : 'Inactive');
                $('#showPostCreated_at').html(post.created_at);
                $('#showPostImage').html(post.image);

                $('#showPostTags').html('');
                $.each(post.tags, function (index, tag) {
                    $('#showPostTags').append("<span class='badge badge-success mr-1'>" + tag.name + "</span>")
                })

                // Open modal
                $('#postShowModal').modal('show');
            }

        // function openCategoryEditModal(id){
        //     // Find category
        //     let category = categories.data.find(catetory => catetory.id == id)
        //     // Catch app Url
        //     const appUrl =  $('meta[name="app-url"]').attr('content');
        //     // Dynamic edit form action attribute
        //     $('#categoryEditForm').attr('action', appUrl + '/categories/' + category.id);
        //     // console.log(app_url);
        //     $('#editCategoryName').val(category.name);
        //     // short form
        //     // category.status == 1 ? $('#editCategoryStatusActive').prop( "checked", true ) : $('#editCategoryStatusInactive').prop( "checked", true );
        //     //alternative
        //     if(category.status == 1){
        //         $('#editCategoryStatusActive').prop( "checked", true )
        //     }else {
        //         $('#editCategoryStatusInactive').prop( "checked", true )
        //     }
        //     // Open modal
        //     $('#categoryEditModal').modal('show');
        // }

        function openPostEditModal(id){
                //find Post
            let post = posts.find(post => post.id == id);
            let categories = @json($categories);
            let tags = @json($tags);

            // console.log(post.tags);
            // console.log(categories);
            // Catch app Url
            const appUrl =  $('meta[name="app-url"]').attr('content');
            // Dynamic edit form action attribute

            $('#postEditForm').attr('action',appUrl + '/posts/'+ post.id)
            $('#editPostAvatar').attr('src', appUrl +  '/images/' + post.image);

            // console.log(appUrl);
            $('#editPostTitle').val(post.title)
            $('#editPostBody').val(post.body)
            //$('#editPostCategoryName').val(post.category.name)

            $('#postEditModal').modal('show');

            // Populate all categories in option
            $.each(categories, function (index, category) {
                $('#editPostCategorySelect').append("<option value='" +category.id+ "' >"+  category.name + "</option>")
            });

            // Dynamically select category start
            // $(function() {
            //     $("[name=category_id] option").each(function() {
            //         if( $(this).prop('value') == post.category_id ) { $(this).prop('selected','selected'); }
            //     });
            // });
            //2nd way
            $('#editPostCategorySelect option[value='+ post.category_id+']').attr("selected", "selected");

            // Dynamically select category end



            // Populate all categories in option
            $.each(tags, function (index, tag) {
                $('#editPostTagSelect').append("<option   value='" +tag.id+ "' >"+  tag.name + "</option>")
            });

            //1st way
            // for(var i=0; i< post.tags.length; i++){
            //     $('#editPostTagSelect option[value='+ tags[i].id+']').attr("selected", "selected");
            // }
            //2nd way
            $.each(post.tags, function (index, tag) {
                $('#editPostTagSelect option[value='+ tag.id+']').attr("selected", "selected");
            });



        }

    $(document).ready( function () {
        $('#posts').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": [4,6] }
            ]
        });
    } );
    </script>
@endsection
