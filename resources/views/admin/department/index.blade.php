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
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              {{-- use for paging table --}}
                              {{$departments->links()}}
                        </div>
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
