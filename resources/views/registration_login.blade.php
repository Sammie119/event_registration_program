@extends("layouts.guest")

@section('content')
    <main class="container">

        <!-- Default Accordion -->
        <div class="accordion h-100 d-flex align-items-center justify-content-center">
                            <div class="card mt-5">
                                <div class="card-body mt-5 mb-5">
                                    <h1>Thank you for Registering for <br> {{ config('app.name') }}</h1>
{{--                                    @if (session('error'))--}}
{{--                                        <div class="alert alert-danger">--}}
{{--                                            {{ session('error') }}--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    <div class="row g-3">--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <x-input-text--}}
{{--                                                type="text"--}}
{{--                                                name="email"--}}
{{--                                                required="true"--}}
{{--                                                label="Email/Mobile Number"--}}
{{--                                                value=""--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <x-input-text--}}
{{--                                                type="password"--}}
{{--                                                name="password"--}}
{{--                                                required="true"--}}
{{--                                                label="Token"--}}
{{--                                                value=""--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="modal-footer">--}}
{{--                                            <x-button--}}
{{--                                                type='button'--}}
{{--                                                class="btn-danger rounded-pill"--}}
{{--                                                icon="bi bi-arrow-left"--}}
{{--                                                name="Back"--}}
{{--                                                onclick="window.location.href='/'"--}}
{{--                                            />--}}
{{--                                            <x-button--}}
{{--                                                type='submit'--}}
{{--                                                class="btn-success rounded-pill"--}}
{{--                                                icon="bi bi-save2"--}}
{{--                                                name="Submit"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-center">
                                    <a href="/book_room"><strong>Click here to book a room</strong></a>
                                </div>

                            </div>

        </div><!-- End Default Accordion Example -->
    </main>
@endsection
