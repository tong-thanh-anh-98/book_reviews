@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        @include('layouts.sidebar')
        
        <div class="col-md-9">
            @include('layouts.message')

            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    Profile
                </div>
                <div class="card-body">
                    <form action="{{ route('account.updateProfile',$user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label @error('name') is-invalid @enderror">Name</label>
                            <input type="text" value="{{ old('name', $user->name) }}" class="form-control" placeholder="Name" name="name" id="" />
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Email</label>
                            <input type="text" value="{{ old('email',$user->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email"  name="email" id="email"/>
                            @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                            @if (Auth::user()->image != "")
                                <img src="{{ asset('uploads/profile/thumbnail/'.Auth::user()->image) }}" class="img-fluid mt-4" alt="Image">
                            @else
                                <img src="{{ asset('images/no_image.png') }}" class="img-fluid mt-4" alt="Image">
                            @endif
                        </div>   
                        <button class="btn btn-primary mt-2">Update</button>
                    </form>                 
                </div>
            </div>                
        </div>
    </div>       
</div>
@endsection