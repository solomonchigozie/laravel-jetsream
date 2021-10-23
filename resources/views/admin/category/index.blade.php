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
                            All Category
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">created at</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- @php($i = 1) -->
                                    @foreach($categories as $category)
                                    <tr>
                                        <th scope="row">{{$categories->firstItem()+$loop->index }}</th>
                                        <td>{{$category->category_name}}</td>
                                        <td>{{$category->user->name }}</td>
                                        <td>
                                            @if($category->created_at == NULL)
                                            <span class="text-danger">No Date Set</span>
                                            @else
                                            {{ Carbon\carbon::parse($category->created_at)->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('category/edit/'.$category->id) }}" class="btn btn-info">Edit</a>
                                            <a href="{{url('softdelete/category/'.$category->id) }}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $categories->links() }}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Trash List
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">created at</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- @php($i = 1) -->
                                    @foreach($trashCat as $category)
                                    <tr>
                                        <th scope="row">{{$categories->firstItem()+$loop->index }}</th>
                                        <td>{{$category->category_name}}</td>
                                        <td>{{$category->user->name }}</td>
                                        <td>
                                            @if($category->created_at == NULL)
                                            <span class="text-danger">No Date Set</span>
                                            @else
                                            {{ Carbon\carbon::parse($category->created_at)->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('category/restore/'.$category->id) }}" class="btn btn-info">Restore</a>
                                            <a href="{{url('pdelete/category/'.$category->id) }}" class="btn btn-danger">P Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $trashCat->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            Add Category
                        </div>
                        <div class="card-body">
                            <form action="{{route('store.category')}}" method="post">
                                @csrf 
                                <div class="form-group">
                                    <label for="categoryname">Category Name:</label>
                                    <input type="text" name="category_name" id="categoryname" class="form-control">
                                    @error('category_name')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
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
