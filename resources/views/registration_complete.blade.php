@extends("layouts.guest")

@section('content')
    <main class="container">

        <!-- Default Accordion -->
        <div class="accordion h-100 d-flex align-items-center justify-content-center">
            <section class="section mobile">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('registrant_complete') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <img src="{{ asset('assets/img/acc.jpeg') }}" alt="flayer" height="100%" class="rounded img-fluid">
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <h5 class="card-title"><h3>Book Accommodation</h3></h5>
                                    <div class="col-12 mb-3">
                                        <x-input-text
                                            type="text"
                                            name="name"
                                            required="true"
                                            label="Full Name"
                                            value=""
                                        />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <x-input-text
                                            type="text"
                                            name="contact"
                                            required="true"
                                            label="Contact Number"
                                            value=""
                                        />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <x-input-text
                                            type="text"
                                            name="email"
                                            required="true"
                                            label="Email"
                                            value=""
                                        />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <x-input-select
                                            :options="$country"
                                            :selected="0"
                                            name="country"
                                            :type="0"
                                            required="true"
                                            label="Select Country"
                                        />
                                    </div>
                                    <div class="col-12 mb-3" id="room-intl-wrapper">
                                        <x-input-select
                                            :options="$rooms"
                                            :selected="0"
                                            name="room_id"
                                            :type="0"
                                            required="true"
                                            label="Select Accommodation"
                                        />
                                    </div>

                                    <div class="col-12 mb-3" id="room-gh-wrapper" style="display:none;">
                                        <x-input-select
                                            :options="$rooms_gh"
                                            :selected="0"
                                            name="room_id"
                                            :type="0"
                                            label="Select Accommodation (Ghana)"
                                        />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <x-input-text
                                            type="text"
                                            name="food_preference"
                                            required="true"
                                            label="Any Special Dietary Requirements?"
                                            value=""
                                        />
                                    </div>

{{--                                    @include('includes.modal')--}}

                                    <div class="modal-footer">
                                        {{--                                        <x-button--}}
                                        {{--                                            type='button'--}}
                                        {{--                                            class="btn-danger rounded-pill"--}}
                                        {{--                                            icon="bi bi-arrow-left"--}}
                                        {{--                                            name="Back"--}}
                                        {{--                                            onclick="window.location.href='/'"--}}
                                        {{--                                        />--}}
                                        <x-button
                                            type='submit'
                                            class="btn-success rounded-pill"
                                            icon="bi bi-save2"
                                            name="Submit"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div><!-- End Default Accordion Example -->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countrySelect = document.querySelector('select[name="country"]');
            const intlWrapper   = document.getElementById('room-intl-wrapper');
            const ghWrapper     = document.getElementById('room-gh-wrapper');

            if (!countrySelect || !intlWrapper || !ghWrapper) return;

            const intlSelect = intlWrapper.querySelector('select');
            const ghSelect    = ghWrapper.querySelector('select');

            function isGhana(select) {
                const opt = select.selectedOptions[0];
                if (!opt) return false;
                // Checks both the visible text and the value, in case
                // your $country array uses an id rather than the name.
                return opt.text.trim().toLowerCase() === 'ghana'
                    || opt.value.trim().toLowerCase() === 'ghana';
            }

            function toggleRooms() {
                const ghana = isGhana(countrySelect);

                ghWrapper.style.display   = ghana ? '' : 'none';
                intlWrapper.style.display = ghana ? 'none' : '';

                // Keep validation/submission in sync with visibility:
                // only the visible select should be required and submitted.
                if (ghSelect) {
                    ghSelect.disabled = !ghana;
                    ghSelect.required = ghana;
                }
                if (intlSelect) {
                    intlSelect.disabled = ghana;
                    intlSelect.required = !ghana;
                }
            }

            countrySelect.addEventListener('change', toggleRooms);
            toggleRooms(); // run once on load in case of a pre-selected value
        });
    </script>
@endsection
