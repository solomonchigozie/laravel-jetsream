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
                            Edit Category
                        </div>
                        <div class="card-body">
                            <form action="{{ url('category/update/'.$categories->id) }}" method="post">
                                @csrf 
                                <div class="form-group">
                                    <label for="categoryname">Update Category Name:</label>
                                    <input type="text" name="category_name" id="categoryname" 
                                    value="{{$categories->category_name }}" class="form-control">
                                    @error('category_name')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Update Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
