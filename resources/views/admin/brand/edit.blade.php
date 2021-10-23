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

                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            Edit Brand
                        </div>
                        <div class="card-body">
                            <form action="{{ url('brand/update/'.$brands->id) }}" method="post" enctype="multipart/form-data">
                                @csrf 
                                <input type="hidden" name="old_image" value="{{$brands->brand_image}}">
                                <div class="form-group">
                                    <label for="brandname">Update Brand Name:</label>
                                    <input type="text" name="brand_name" id="brandname" 
                                    value="{{$brands->brand_name }}" class="form-control">
                                    @error('brand_name')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="brandimage">Update Brand Image:</label>
                                    <input type="file" name="brand_image" id="brandimage" 
                                    value="{{$brands->brand_image }}" class="form-control">
                                    @error('category_image')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <img src="{{asset($brands->brand_image)}}" alt="" class="img-fluid">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Update Brand</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
