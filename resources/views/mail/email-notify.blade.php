<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<style type="text/css">
    @media (min-width: 768px) {
        .gradient-form {
            height: 100vh !important;
        }
    }
</style>
<body>
<section class="h-100 gradient-form bg-info">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-8">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-md-3 mx-md-4">

                                <div class="text-center">
                                    <h4 class="mt-1 mb-3 pb-1">Let Africa Go Conference</h4>
                                </div>

                                <div class="text-center">
                                    <div class="input-group">
                                        <div class="form-floating">
                                            <h2>Hi {{ $name }},</h2>

                                            <p>Thank you for successfully registering for our upcoming event dated <strong>May 14th – 16th, 2026</strong></p>

                                            <p>We are truly excited about your participation and look forward to having you join us. Your registration has been received and confirmed,
                                                and we are confident that this event will be impactful, enriching, and well worth your time.</p>

                                            <a href="https://letafricagoconference.tacms.net/book_room">Click here to book your room</a>

                                            <p>Thank you once again for being part of this event. We look forward to welcoming you.</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>



