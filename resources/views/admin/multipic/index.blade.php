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
                    <!-- @php($i = 1) -->
                    <div class="card-group">
                        @foreach($images as $multi)
                            <div class="col-md-4 mt-5">
                                <div class="card">
                                    <img src="{{asset($multi->image)}}" alt="" >
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            Add  Multi Picture
                        </div>
                        <div class="card-body">
                            <form action="{{route('store.image')}}" method="post" enctype="multipart/form-data">
                                @csrf 
                                <div class="form-group">
                                    <label for="brandimage">Brand Image:</label>
                                    <input type="file" name="image[]" id="brandimage" class="form-control" multiple="">
                                    @error('image')
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
