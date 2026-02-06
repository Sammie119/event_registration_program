@extends("layouts.guest")

@section('content')
    <main class="container">

        <!-- Default Accordion -->
        <div class="accordion h-100 d-flex align-items-center justify-content-center">
            <div class="accordion-item" style="width: 40%;">
                <section class="section">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('registrant_complete') }}" method="post">
                        @csrf
                        <input type="hidden" name="reg_id" value="{{ $id }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><h3>Complete Registration</h3></h5>
                                <div class="row g-3">

                                    @include('includes.modal')

                                    <div class="col-md-12">
                                        <x-input-text
                                            type="text"
                                            name="name"
                                            required="true"
                                            readonly="true"
                                            label="Full Name"
                                            value="{{ $name }}"
                                        />
                                    </div>
                                    <div class="col-md-12">
                                        <x-input-select
                                            :options="$rooms"
                                            :selected="0"
                                            name="room_id"
                                            :type="0"
                                            required="true"
                                            label="Select Accommodation"
                                        />
                                    </div>
                                    <div class="col-md-12">
                                        <x-input-text
                                            type="text"
                                            name="food_preference"
                                            required="true"
                                            label="Any Special Dietary Requirements?"
                                            value=""
                                        />
                                    </div>

                                    <div class="modal-footer">
                                        <x-button
                                            type='button'
                                            class="btn-danger rounded-pill"
                                            icon="bi bi-arrow-left"
                                            name="Back"
                                            onclick="window.location.href='/'"
                                        />
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
                    </form>
                </section>
            </div>
        </div><!-- End Default Accordion Example -->
    </main>
@endsection
