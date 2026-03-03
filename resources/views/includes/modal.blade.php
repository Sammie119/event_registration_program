<!-- Button trigger modal -->
<a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    <strong>Information on accommodation >></strong>
</a>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (request()->is('/'))
                    <h4>Registration Information</h4>
                    <p>Please, click on <b>Submit</b> to submit this form.</p>
                    <p>After submission, you will receive a login <b>token</b> through your email. Use the received <b>token</b> to
                        login and continue with the registration process</p>

                    <h4>Registration Fee</h4>
                    <p>The registration fee is USD 50 and covers all conference benefits, excluding accommodation.</p>
                @else
                    <h4>Accommodation Categories and Fee</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category</th>
                            <th scope="col">Images</th>
                            <th scope="col">Fee</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td nowrap>Category A</td>
                                <td nowrap>
                                    <img src="{{ asset('assets/img/rooms/cat_a_1.jpg') }}" width="50%" alt="Room Image">
                                    <img src="{{ asset('assets/img/rooms/cat_a_2.jpg') }}" width="50%" alt="Room Image">
                                </td>
                                <td nowrap>USD 400 <br>
                                    (For 4 Nights)
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td nowrap>Category B <br> (2 Persons in a Room)</td>
                                <td nowrap>
                                    <img src="{{ asset('assets/img/rooms/cat_b_1.jpg') }}" width="50%" alt="Room Image">
                                    <img src="{{ asset('assets/img/rooms/cat_b_2.jpg') }}" width="50%" alt="Room Image">
                                </td>
                                <td nowrap>USD 100 <br>
                                    (For 4 Nights)
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

