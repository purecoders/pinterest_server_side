@extends('template.master')
@section('content')
    @if($errors->any())
        @if($errors->first()=='0')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                The tag is already exist!
            </div>
        @endif
        @if($errors->first()=='1')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>Tag Created Successfully
            </div>
        @endif
    @endif


    <section id="actions" class="py-2 bg-light mb-1">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{route('tag.store')}}" onsubmit="return validateAddTagForm()" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="POST">
                        <input id="input-add-tag" type="text" name="name" class="form-control"
                               placeholder="Enter New Tag Name">
                        <Button type="submit" class="btn btn-success  btn-block mt-1"><i class="fa fa-plus"></i> Add
                            Tag
                        </Button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="input-group">
                            <input id="input-search" type="text" class="form-control" placeholder="Search">
                            <div class="input-group-append">
                                <a id="btn-search" href="" class="btn btn-primary">Search</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="posts">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lastest Tags</h4>
                        </div>
                        <table id="tblMain" class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th id="tag-id">tag-id</th>
                                <th>Title</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tags as $key => $tag)

                                <tr>
                                    <td scope="row">{{++$key+(($tags->currentPage()-1)*$tags->perPage())}}</td>
                                    <td>{{$tag->id}}</td>
                                    <td>{{$tag->name}}</td>
                                    <td class="tbl-tag-edit">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#editTagModal">
                                            <i class="fa fa-edit"></i> edit
                                        </button>
                                    </td>
                                    <td class="tbl-tag-delete">
                                        <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteTagModal">
                                            <i class="fa fa-remove"></i> delete
                                        </button>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                        <nav>
                            <ul class="pagination justify-content-center">
                                {{$tags->links()}}
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Edit Tag Modal -->
    <div class="modal fade" id="editTagModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Tag</h5>
                    <button class="close" data-dismiss="modal"><span class="text-light">&times;</span></button>
                </div>
                <form id="edit-form" action="" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_method" value="PUT">
                            <label for="modal-tag-name">Title</label>
                            <input id="edit-modal-tag-name" type="text" class="form-control" name="name" value="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Save Changes</button>
                        <button class="btn btn-secondary" data-dismiss="modal">close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Tag Modal -->
    <div class="modal fade" id="deleteTagModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Tag</h5>
                    <button class="close" data-dismiss="modal"><span class="text-light">&times;</span></button>
                </div>
                <form id="delete-form" action="" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Are You sure delete this tag:</label>
                            <h5 id="delete-modal-tag-name"></h5>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">Yes,Delete it</button>
                        <button class="btn btn-secondary" data-dismiss="modal">close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection