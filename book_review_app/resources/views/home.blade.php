@extends('layouts.app')

@section('main')
<div class="container mt-3 pb-5">
    <div class="row justify-content-center d-flex mt-5">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h2 class="mb-3">Book Lists</h2>
                {{-- <div class="mt-2">
                    <a href="#" class="text-dark">Clear</a>
                </div> --}}
            </div>
            <div class="card shadow-lg border-0">
                <form id="searchForm" action="{{ route('home') }}" method="get">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-10">
                                <input type="text" class="form-control form-control-lg" name="keyword" id="keyword" value="{{ Request::get('keyword') }}" placeholder="Search by title">
                            </div>
                            <div class="col-lg-1 col-md-1">
                                <button class="btn btn-primary btn-lg w-100"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                            <div class="col-lg-1 col-md-1">
                                <button class="btn btn-secondary btn-lg w-100" onclick="clearKeywordAndRedirect()"><i class="fa-solid fa-delete-left"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row mt-4">
                @if ($books->isNotEmpty())
                    @foreach ($books as $book)
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card border-0 shadow-lg">
                                <a href="{{ route('book.detail', $book->id) }}">
                                    @if (!empty($book->image))
                                        <img src="{{ asset('uploads/books/thumbnail/'.$book->image) }}" class="card-img-top" alt="Image">
                                    @else
                                        <img src="https://placehold.co/990x1400?text=No Image" class="card-img-top" alt="Image">
                                    @endif
                                </a>
                                <div class="card-body">
                                    <h3 class="h4 heading">{{ $book->title }}</h3>
                                    <p>{{ $book->author }}</p>
                                    <div class="star-rating d-inline-flex ml-2" title="">
                                        <span class="rating-text theme-font theme-yellow">0.0</span>
                                        <div class="star-rating d-inline-flex mx-2" title="">
                                            <div class="back-stars ">
                                                <i class="fa fa-star " aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
            
                                                <div class="front-stars" style="width: 0%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="theme-font text-muted">(0 Reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
