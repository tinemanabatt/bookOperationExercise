<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <h5 class="card-title">Borrow Books</h5>
            </div>

            <div class="row row-cols-1 row-cols-md-3">
                @forelse ($availableBooks as $book)
                    <div class="col mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('img/books/' . $book->id . '/' . $book->image_of_book) }}"
                                class="card-img-top" alt="..."
                                style="object-fit: contain; height: 30vh; width:100%">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">{{ $book->name_of_book }}</h5>

                                    @if ($book->is_borrowed == 1 && $book->user_id == Auth::user()->id)
                                        <span class="badge badge-success">Borrowed by you</span>
                                    @elseif ($book->is_borrowed == 1 && $book->user_id != Auth::user()->id)
                                        <span class="badge badge-danger">Already borrowed</span>
                                    @endif
                                </div>


                                <div class="d-flex justify-content-end">
                                    @if ($book->is_borrowed == 0 && $book->user_id != Auth::user()->id)
                                        <button type="button" class="btn btn-outline-primary"
                                            data-id="{{ $book->id }}"
                                            id="borrowBtn{{ $book->id }}">Borrow</button>
                                    @elseif ($book->is_borrowed == 1 && $book->user_id == Auth::user()->id)
                                        <button type="button" class="btn btn-warning" data-id="{{ $book->id }}"
                                            id="unborrowBtn{{ $book->id }}">Unborrow</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        $('#borrowBtn{{ $book->id }}').on('click', () => {
                            swal({
                                title: "Are you sure?",
                                text: "Do you want to reserve this book?",
                                icon: "warning",
                                buttons: {
                                    cancel: 'Cancel',
                                    true: 'OK'
                                },
                            }).then((response) => {
                                if (response == 'true') {

                                    swal({
                                        title: 'Success!',
                                        text: 'You have successfully reserved or borrowed this book!',
                                        icon: 'success'
                                    }).then((response) => {
                                        $id = $('#borrowBtn{{ $book->id }}').data('id');
                                        //console.log($id)
                                        const formdata = new FormData();
                                        formdata.append('book_id', $id);

                                        console.log([...formdata])

                                        axios.post('/borrowBook/' +
                                                $id)
                                            .then((response) => {
                                                location.reload();
                                            })
                                    })

                                }
                            })
                        })

                        // unborrow btn

                        $('#unborrowBtn{{ $book->id }}').on('click', () => {
                            swal({
                                title: "Are you sure?",
                                text: "Do you want to return this book?",
                                icon: "warning",
                                buttons: {
                                    cancel: 'Cancel',
                                    true: 'OK'
                                },
                            }).then((response) => {
                                if (response == 'true') {

                                    swal({
                                        title: 'Success!',
                                        text: 'You have successfully unborrowed this book!',
                                        icon: 'success'
                                    }).then((response) => {
                                        $id = $('#unborrowBtn{{ $book->id }}').data('id');
                                        //console.log($id)
                                        const formdata = new FormData();
                                        formdata.append('book_id', $id);

                                        console.log([...formdata])

                                        axios.post('/unborrowBook/' +
                                                $id)
                                            .then((response) => {
                                                location.reload();
                                            })
                                    })

                                }
                            })
                        })
                    </script>
                @empty
                    <p class="text-center mx-auto">No available books.</p>
                @endforelse

            </div>
        </div>
    </div>
</div>
