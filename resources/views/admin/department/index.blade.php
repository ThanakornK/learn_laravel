<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class=row>
                <div class="row">
                    <div class="col-md-8">
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        <div class="card">
                            <div class="card-header">Department Table</div>
                            <table class="table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">Number</th>
                                    <th scope="col">Department name</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($departments as $row)
                                  <tr>
                                      {{-- assign index row --}}
                                    <th>{{$departments->firstItem()+$loop->index}}</th> 
                                    <td>{{$row->department_name}}</td>
                                    {{-- call name of user_id from user() in Department model--}}
                                    {{-- eloquent --}}
                                    <td>{{$row->user->name}}</td>
                                    {{-- call join data by query builder --}}
                                    {{-- <td>{{$row->name}}</td> --}}
                                    <td >
                                        <a href="{{url('/department/edit/'.$row->id)}}" class="btn btn-primary">Edit</a>
                                    </td>
                                    <td >
                                        <a href="{{url('/department/softdelete/'.$row->id)}}" class="btn btn-warning">Delete</a>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              {{-- use for paging table --}}
                              {{$departments->links()}}
                        </div>

                        @if(count($trashDepartments)>0)
                        <div class="card my-2">
                            <div class="card-header">Bin Table</div>
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Number</th>
                                        <th scope="col">Department name</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Restore</th>
                                        <th scope="col">Delete permanantly</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($trashDepartments as $row)
                                        <tr>
                                            <th>{{$trashDepartments->firstItem()+$loop->index}}</th> 
                                            <td>{{$row->department_name}}</td>
                                            <td>{{$row->user->name}}</td>
                                            <td >
                                                <a href="{{url('/department/restore/'.$row->id)}}" class="btn btn-primary">Restore</a>
                                            </td>
                                            <td >
                                                <a href="{{url('/department/delete/'.$row->id)}}" class="btn btn-danger">Delete permanantly</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$trashDepartments->links()}}
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Form</div>
                            <div class="card-body">
                                <form action="{{route('addDepartment')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="department_name">Department name</label>
                                        <input type="text" class="form-control" name="department_name">
                                    </div>
                                    @error('department_name')
                                            <div class="my-2">
                                                <span class="text-danger">{{$message}}</span>
                                            </div>
                                    @enderror
                                    <br/>
                                    <input type="submit" value="Save" class="btn btn-primary">

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
