<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi.. <b>{{Auth::user()->name}}</b>
            
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
                @endif

                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            All Brand
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">Brand Name</th>
                                    <th scope="col">Brand Image</th>
                                    <th scope="col">created at</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- @php($i = 1) -->
                                    @foreach($brands as $brand)
                                    <tr>
                                        <th scope="row">{{$brands->firstItem()+$loop->index }}</th>
                                        <td>{{$brand->brand_name}}</td>
                                        <td><img src="{{asset($brand->brand_image)}}" style="height:40px; width:70px" alt=""></td>
                                        <td>
                                            @if($brand->created_at == NULL)
                                            <span class="text-danger">No Date Set</span>
                                            @else
                                            {{ Carbon\carbon::parse($brand->created_at)->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('brand/edit/'.$brand->id) }}" class="btn btn-info">Edit</a>
                                            <a href="{{url('brand/delete/'.$brand->id) }}" onclick="return confirm('Are you sure you want to delete')" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $brands->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            Add  Brand
                        </div>
                        <div class="card-body">
                            <form action="{{route('store.brand')}}" method="post" enctype="multipart/form-data">
                                @csrf 
                                <div class="form-group">
                                    <label for="brandname">Brand Name:</label>
                                    <input type="text" name="brand_name" id="brandname" class="form-control">
                                    @error('brand_name')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="brandimage">Brand Image:</label>
                                    <input type="file" name="brand_image" id="brandimage" class="form-control">
                                    @error('brand_image')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-primary" type="submit">submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
