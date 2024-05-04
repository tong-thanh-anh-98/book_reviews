@extends('layouts.app')

@section('main')

<div class="container">
    <div class="row my-5">
        @include('layouts.sidebar')
        
        <div class="col-md-9">
            
            <div class="card border-0 shadow">
                @include('layouts.message')

                <div class="card-header text-white">
                    Books
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
                        <form id="searchForm" action="{{ route('books.index') }}" method="get">
                            <div class="d-flex">
                                <input type="text" class="form-control" name="keyword" id="keyword" value="{{ Request::get('keyword') }}" placeholder="Search keyword">
                                <button type="submit" class="btn btn-primary ms-2">Search</button>
                                <!-- <a href="{{ route('books.index') }}" class="btn btn-secondary ms-2">Clear</a> -->
                                <button type="button" class="btn btn-secondary ms-2" onclick="clearKeywordAndRedirect()">Clear</button>
                            </div>
                        </form>
                    </div>       
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th width="150">Action</th>
                            </tr>
                            <tbody>
                                @if ($books->isNotEmpty())
                                    @foreach ($books as $book)
                                        <tr>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->author }}</td>
                                            <td>3.0 (3 Reviews)</td>
                                            <td>
                                                @if ($book->status == 0)
                                                    <span class="text-success">Active</span>
                                                @else
                                                    <span class="text-danger">Block</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <a href="" onclick="deleteBook({{ $book->id }});" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </thead>
                    </table>
                    @if ($books->isNotEmpty())
                        {{ $books->links() }}
                    @endif
                </div>
                
            </div>
        </div>
    </div>       
</div>
@endsection

@section('script')
    <script>
        function deleteBook($id) {
            if (confirm('Are you wan to delete?')) {
                $.ajax({
                    type: 'delete',
                    url: '{{ route('books.destroy') }}',
                    data: {id:id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                    },
                    success: function (response) {
                        window.location.href = "{{ route('books.index') }}";
                    }
                });
            }
        }
    </script>
@endsection