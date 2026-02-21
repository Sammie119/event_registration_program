@extends("layouts.guest")

<style>
    .error-message {
        color: red;
        display: none;
        font-size: 0.9em;
    }
    .logo img {
        max-height: 90px !important;
    }

    @media print {
        .noprint{
            visibility: hidden;
        }

        /* @page{
            size: landscape;
        } */

        /* tfoot{
            page-break-before: always;
        } */
    }
</style>

<script type="text/javascript">
    function print_1(){
        window.print();
        window.location = "/";
    }
</script>

@section('content')
    <main class="container">
        <div class="d-flex justify-content-center py-4">
            <a class="logo d-flex align-items-center w-auto">
                <img src="https://letafricago.org/extensions/uploads/sites/522/2024/11/logo-removebg-preview.png" alt="">
            </a>
        </div><!-- End Logo -->
        <div class="d-flex justify-content-center">
            <h3>LET AFRICA GO CONFERENCE 2026</h3>
        </div>

        <div class="pagetitle mb-4 row">
            <div class="col-md-6">
                <h1 style="text-align: left">Receipt {{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</h1>
            </div>
            <div class="col-md-6">
                <h1 style="text-align: right">Date: {{ date("d M Y", strtotime($payment->date_paid)) }}</h1>
            </div>
        </div><!-- End Page Title -->

        <!-- Default Accordion -->
        <div class="accordion" id="accordionExample">
            <div class="accordion-item"></div>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">Name: {{ $payment->full_name }}</th>
                    </tr>
                    <tr>
                        <th scope="col">Contact: {{ $payment->contact }}</th>
                    </tr>
                </thead>
            </table>
            <div class="accordion-item"></div>
            <div class="accordion-item"></div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Room Description</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">2</th>
                        <td>{{ $payment->accommodation_type }}</td>
                        <td>GHS {{ number_format($payment->accommodation_fee, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: center;">Thank You for Registering for this Event</th>
                    </tr>
                </tfoot>
            </table>
        </div><!-- End Default Accordion Example -->
        <button class="noprint btn btn-outline-dark" onclick="print_1()">Print</button>
    </main>

@endsection

