@extends('template.master')
@section('content')
    <!-- Actions -->

    <section id="actions" class="py-4 bg-light mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ml-auto">


                    <div class="row">
                        <form action="{{url('user-search')}}" method="post">
                            @csrf

                            <div class="input-group">
                                <input name="text" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <input type="submit"  class="btn btn-primary" value="search">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--Usesr -->
    <section id="users">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lastest Users</h4>
                        </div>
                        <table id="tblMain" class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>user_name</th>
                                <th>Email</th>
                                <th>Block</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($users as $key => $user)
                                <tr>
                                    <td scope="row">{{++$key+(($users->currentPage()-1)*$users->perPage())}}</td>
                                    <td>{{$user->user_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td class="tbl-tag-block">

                                        <a class="btn btn-danger" href="{{url('user-delete', $user->id)}}">
                                            <i class="fa fa-ban"></i> Block
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination justify-content-center">
                                {{$users->links()}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Tag Modal -->
    <div class="modal fade" id="blockUserModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Block User</h5>
                    <button class="close" data-dismiss="modal"><span class="text-light">&times;</span></button>
                </div>
                <form id="block-form" action="" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Are You sure Block this User:</label>
                            <h5 id="block-modal-user-name"></h5>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">Yes,sure</button>
                        <button class="btn btn-secondary" data-dismiss="modal">close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection