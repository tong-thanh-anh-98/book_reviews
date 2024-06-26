@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        @include('layouts.sidebar')
        
        <div class="col-md-9">
            <div class="card border-0 shadow">
                <div class="card-header text-white">
                    Edit Book
                </div>
                <div class="card-body">
                    <form action="{{ route('books.update', $book->id) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Title" name="title" id="title" value="{{ old('title', $book->title) }}"/>
                            @error('title')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" placeholder="Author"  name="author" id="author" value="{{ old('author', $book->author) }}"/>
                            @error('author')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="discription" class="form-label">Discription</label>
                            <textarea name="discription" id="discription" class="form-control" placeholder="discription" cols="30" rows="5">{{ old('discription', $book->discription) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="Image" class="form-label">Image</label>
                            <input type="file" class="form-control  @error('image') is-invalid @enderror"  name="image" id="image"/>
                            @error('image')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                            @if (!empty($book->image))
                                <img src="{{ asset('uploads/books/thumbnail/'.$book->image) }}" class="img-fluid mt-4" alt="Image">
                            @else
                                <img src="{{ asset('images/no_image.png') }}" class="img-fluid mt-4" alt="Image">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="0" {{ ($book->status == 0) ? 'selected' : '' }}>Active</option>
                                <option value="1" {{ ($book->status == 1) ? 'selected' : '' }}>Block</option>
                            </select>
                        </div>
                        <button class="btn btn-primary mt-2">Update</button>
                    </form>
                </div>
            </div>                
        </div>
    </div>       
</div>
@endsection
