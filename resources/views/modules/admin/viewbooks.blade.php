<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">Books Management</h5>
                <a href="{{ route('createBook') }}" class="btn btn-primary">Add Book</a>
            </div>
            @if (Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table" id="bookManagementTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name of Book</th>
                            <th scope="col">Availability Status</th>
                            <th scope="col">Borrowed by</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($books as $book)
                            <tr>
                                <th scope="row">{{ $book->id }}</th>
                                <td>{{ $book->name_of_book }}</td>
                                @if ($book->is_borrowed == 0)
                                    <td><span class="badge badge-warning">Not yet borrowed</span>
                                    </td>
                                @else
                                    <td><span class="badge badge-success">Borrowed</span></td>
                                @endif
                                @if ($book->user_id == 1)
                                    <td><span class="badge badge-warning">Not yet borrowed</span>
                                    </td>
                                @else
                                    <td>{{ $book->name }}</td>
                                @endif
                                <td colspan="3">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#viewModal{{ $book->id }}">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                    <a class="btn btn-info btn-sm" href="{{ route('editBook', $book->id) }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" id="deleteBtn{{ $book->id }}"
                                        data-id="{{ $book->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal for View Button -->
                            <div class="modal fade" id="viewModal{{ $book->id }}" tabindex="-1"
                                aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex justify-content-center">

                                                <img src="{{ asset('img/books/' . $book->id . '/' . $book->image_of_book) }}"
                                                    alt="" class="text-center" width="300">
                                            </div>

                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <b>Name of Book:</b>
                                                    {{ $book->name_of_book }}
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Borrowed by:</b>
                                                    {{ $book->name }}
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Availability Status:</b>
                                                    @if ($book->is_borrowed == 1)
                                                        <span class="badge badge-success">Borrowed</span>
                                                    @else
                                                        <span class="badge badge-warning">Not yet borrowed</span>
                                                    @endif
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Modal for View Button -->

                            <!-- Function For Delete Button -->
                            <script>
                                $('#deleteBtn{{ $book->id }}').on('click', () => {
                                    $id = $('#deleteBtn{{ $book->id }}').data('id')

                                    swal({
                                        title: 'Are you sure?',
                                        text: 'Do you want to delete this book?',
                                        icon: 'warning',
                                        buttons: {
                                            cancel: 'Cancel',
                                            true: 'OK'
                                        }
                                    }).then((response) => {
                                        if (response == 'true') {
                                            swal({
                                                title: 'Success!',
                                                text: 'You have successfully deleted this book!',
                                                icon: 'success'
                                            }).then((response) => {
                                                const formdata = new FormData();

                                                formdata.append('book_id', $id)
                                                console.log([...formdata])

                                                axios.post('/deleteBook/' + $id, formdata)
                                                    .then((response) => {
                                                        location.reload();
                                                    })
                                            })
                                        }
                                    })
                                    //console.log($id)
                                })
                            </script>
                            <!-- End of Function For Delete Button -->

                        @empty
                            {{-- <tr>
                                <td colspan="5" class="text-center">No records yet.</td>
                            </tr> --}}
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#bookManagementTable').DataTable();
    });
</script>

{{-- TODO: VIEW AND DELETE --}}
