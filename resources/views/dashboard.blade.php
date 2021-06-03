<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class=row>
                <table class="table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">First join</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php($i=1)
                        @foreach($users as $row)
                      <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>{{$row->name}}</td>
                        <td>{{$row->email}}</td>
                        <td>{{$row->created_at->diffForHumans()}}</td>
                        {{-- if use query builder --}}
                        {{-- <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td> --}}
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</x-app-layout>
