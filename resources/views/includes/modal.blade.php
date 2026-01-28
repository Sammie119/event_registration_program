<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    <strong>Information... Click me >></strong>
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Registration Fee</h4>
                <p>The registration fee is USD 50, which includes all conference materials and conference tags.</p>
                <h4>Accommodation Categories and Fee</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Description</th>
                        <th scope="col">Fee</th>
                    </tr>
                    </thead>
                    <?php
                        $rooms = App\Models\Room::orderBy('id', 'asc')->get();
                    ?>
                    <tbody>
                        @foreach($rooms as $key => $room)
                            <tr>
                                <th scope="row">{{ ++$key }}</th>
                                <td>{{ $room->name }}</td>
                                <td>{!! nl2br($room->details) !!}</td>
                                <td>USD {{ $room->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

