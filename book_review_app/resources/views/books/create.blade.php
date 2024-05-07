@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        @include('layouts.sidebar')
        
        <div class="col-md-9">
            <div class="card border-0 shadow">
                <div class="card-header text-white">
                    Add Book
                </div>
                <div class="card-body">
                    <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Title" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" placeholder="Author"  name="author" id="author" value="Tác Giả: {{ old('author') }}"/>
                            @error('author')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="discription" class="form-label">Discription</label>
                            <textarea name="discription" id="discription" class="form-control" placeholder="discription" cols="30" rows="5">{{ old('discription') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="Image" class="form-label">Image</label>
                            <input type="file" class="form-control  @error('image') is-invalid @enderror"  name="image" id="image"/>
                            @error('image')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="0">Active</option>
                                <option value="1">Block</option>
                            </select>
                        </div>
                        <button class="btn btn-primary mt-2">Create</button>
                    </form>
                </div>
            </div>                
        </div>
    </div>
</div>
@endsection