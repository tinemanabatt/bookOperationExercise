@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Book</h5>

                <form action="{{ route('updateBook', $book->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="">Name of Book</label>
                        <input type="text"name="name_of_book" class="form-control" value="{{ $book->name_of_book }}">

                        @error('name_of_book')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">

                        <div class="form-group">
                            <label for="">Image of Book</label>
                            <input type="file" name="image_of_book" class="form-control-file"
                                value="{{ $book->image_of_book }}">
                            @error('image_of_book')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <img src="{{ asset('img/books/' . $book->id . '/' . $book->image_of_book) }}" alt=""
                            srcset="" width="300">
                    </div>



                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
