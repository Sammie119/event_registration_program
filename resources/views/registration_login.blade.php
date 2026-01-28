@extends("layouts.guest")

@section('content')
    <main class="container">

        <!-- Default Accordion -->
        <div class="accordion h-100 d-flex align-items-center justify-content-center">
            <div class="accordion-item" style="width: 40%;">
                <section class="section">
                        <form action="{{ route('registrant_login') }}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Login Details</h5>
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <x-input-text
                                                type="text"
                                                name="email"
                                                required="true"
                                                label="Email/Mobile Number"
                                                value=""
                                            />
                                        </div>
                                        <div class="col-md-12">
                                            <x-input-text
                                                type="password"
                                                name="password"
                                                required="true"
                                                label="Token"
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
