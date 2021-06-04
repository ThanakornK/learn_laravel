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
                            <div class="card-header">Service Table</div>
                            <table class="table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">Number</th>
                                    <th scope="col">Service image</th>
                                    <th scope="col">Service name</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $row)
                                  <tr>
                                    <th>{{$services->firstItem()+$loop->index}}</th> 
                                    <td>
                                        <img src="{{asset($row->service_image)}}" alt="" width="100px" height="100px" />
                                    </td>
                                    <td>{{$row->service_name}}</td>
                                    <td >
                                        <a href="{{url('/service/edit/'.$row->id)}}" class="btn btn-primary">Edit</a>
                                    </td>
                                    <td >
                                        <a href="{{url('/service/delete/'.$row->id)}}" class="btn btn-warning"
                                        onclick="return confirm('Are you confirm to delete this service ?')"
                                        >
                                        Delete</a>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              {{$services->links()}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Service Form</div>
                            <div class="card-body">
                                <form action="{{route('addService')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="service_name">Service name</label>
                                        <input type="text" class="form-control" name="service_name">
                                    </div>
                                    @error('service_name')
                                            <div class="my-2">
                                                <span class="text-danger">{{$message}}</span>
                                            </div>
                                    @enderror
                                    <div class="form-group">
                                        <label for="service_image">Service picture</label>
                                        <input type="file" class="form-control" name="service_image">
                                    </div>
                                    @error('service_image')
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
