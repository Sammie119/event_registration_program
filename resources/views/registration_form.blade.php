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
</style>

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

        <div class="pagetitle mb-4">
            <h1>Registration Form</h1>
        </div><!-- End Page Title -->

        <x-notify-error :messages="$errors->all()" />

        <!-- Default Accordion -->
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <section class="section">
                    <div class="row">
                        <form action="{{ route('registrant.store') }}" method="post" onsubmit="return validatePhone();">
                            @csrf
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Personal Information</h5>
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <x-input-select
                                                    :options="$title"
                                                    :selected="0"
                                                    name="title"
                                                    :type="0"
                                                    required="true"
                                                    label="Title"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="text"
                                                    name="first_name"
                                                    required="true"
                                                    label="First Name"
                                                    value=""
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="text"
                                                    name="surname"
                                                    required="true"
                                                    label="Surname"
                                                    value=""
                                                />
                                            </div>

                                            <div class="col-3">
                                                <x-input-select
                                                    :options="$gender"
                                                    :selected="0"
                                                    name="gender"
                                                    :type="0"
                                                    required="true"
                                                    label="Gender"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-select
                                                    :options="['35 years and below', '36 to 50 years', '51 to 65 years', 'Above 65 years']"
                                                    :selected="3"
                                                    name="date_of_birth"
                                                    :type="1"
                                                    :values="['35 years and below', '36 to 50 years', '51 to 65 years', 'Above 65 years']"
                                                    required="true"
                                                    label="Age Group"
                                                />
                                            </div>
                                            <div class="col-3">
                                                <x-input-select
                                                    :options="$marital_status"
                                                    :selected="0"
                                                    name="marital_status"
                                                    :type="0"
                                                    required=""
                                                    label="Marital Status"
                                                />
                                            </div>
                                            <div class="col-3">
                                                <x-input-select
                                                    :options="$nations"
                                                    :selected="0"
                                                    name="nationality_id"
                                                    :type="0"
                                                    required="true"
                                                    label="Nationality"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="email"
                                                    name="email"
                                                    required="true"
                                                    label="Email"
                                                    value=""
                                                />
                                            </div>

                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="tel"
                                                    name="phone_number"
                                                    required="true"
                                                    label="Phone Number"
                                                    value=""
                                                    placeholder="+233541234567"
                                                    {{--                                            pattern="^\+[1-9][0-9]{10,}$"--}}
                                                    class="phoneInput"
                                                    oninput="clearError(1)"
                                                />
                                                <div class="error-message" id="errorMsg">
                                                    Please enter a valid phone number starting with + and at least 12 digits (e.g., +233541234567).
                                                </div><br>
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="tel"
                                                    name="whatsapp_number"
                                                    required="true"
                                                    label="WhatsApp Number"
                                                    value=""
                                                    placeholder="+233541234567"
                                                    class="phoneInput"
                                                    oninput="clearError(2)"
                                                />
                                                <div class="error-message" id="errorMsg2">
                                                    Please enter a valid phone number starting with + and at least 12 digits (e.g., +233541234567).
                                                </div><br>
                                            </div>
                                            <div class="col-md-6">
                                                <x-input-text
                                                    type="text"
                                                    name="address"
                                                    required="true"
                                                    label="Address"
                                                    value=""
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Other Information</h5>
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="text"
                                                    name="passport_number"
                                                    required=""
                                                    label="Passport Number"
                                                    value=""
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="date"
                                                    name="issue_date"
                                                    required=""
                                                    label="Issue Date"
                                                    value=""
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="date"
                                                    name="expiry_date"
                                                    required=""
                                                    label="Expiry Date"
                                                    value=""
                                                />
                                            </div>

                                            <div class="col-md-3">
                                                <x-input-select
                                                    :options="$nations"
                                                    :selected="0"
                                                    name="residence_country_id"
                                                    :type="0"
                                                    required="true"
                                                    label="Country of Resident"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-select
                                                    :options="['English', 'French']"
                                                    :selected="3"
                                                    name="languages_spoken"
                                                    :type="1"
                                                    :values="['English', 'French']"
                                                    required="true"
                                                    label="Preferred Language at Conference"
                                                />
                                            </div>

                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="text"
                                                    name="emergency_contacts_name"
                                                    required="true"
                                                    label="Emergency Contact Person"
                                                    value=""
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="text"
                                                    name="emergency_contacts_relationship"
                                                    required="true"
                                                    label="Emergency Contact Relationship"
                                                    value=""
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-input-text
                                                    type="tel"
                                                    name="emergency_contacts_phone_number"
                                                    required="true"
                                                    label="Emergency Contact Phone Number"
                                                    value=""
                                                    placeholder="+233541234567"
                                                    class="phoneInput"
                                                    oninput="clearError(3)"
                                                />
                                                <div class="error-message" id="errorMsg3">
                                                    Please enter a valid phone number starting with + and at least 12 digits (e.g., +233541234567).
                                                </div><br>
                                            </div>

                                            <div class="col-md-3">
                                                <x-input-select
                                                    :options="['Yes', 'No']"
                                                    :selected="3"
                                                    name="disability"
                                                    :type="1"
                                                    :values="[1, 0]"
                                                    required="true"
                                                    label="Do you have a Disability?"
                                                />
                                            </div>
                                            <div class="col-md-9">
                                                <x-input-text
                                                    type="text"
                                                    name="special_needs"
                                                    required="true"
                                                    label="Have any special needs"
                                                    value=""
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    @include('includes.modal')

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
                        </form>
                    </div>
                </section>
            </div>
        </div><!-- End Default Accordion Example -->
    </main>

    <script>
        function validatePhone() {
            const phoneInput = document.querySelectorAll('.phoneInput');
            const errorMsg = document.getElementById('errorMsg');
            const errorMsg2 = document.getElementById('errorMsg2');
            const errorMsg3 = document.getElementById('errorMsg3');
            const regex = /^\+[1-9][0-9]{10,}$/;

            if (!regex.test(phoneInput[0].value)) {
                errorMsg.style.display = 'block';
                if (!regex.test(phoneInput[1].value)) {
                    errorMsg2.style.display = 'block';
                }
                if (!regex.test(phoneInput[2].value)) {
                    errorMsg3.style.display = 'block';
                }
                return false;
            }
            if (!regex.test(phoneInput[1].value)) {
                errorMsg2.style.display = 'block';
                if (!regex.test(phoneInput[2].value)) {
                    errorMsg3.style.display = 'block';
                }
                return false;
            }
            if (!regex.test(phoneInput[2].value)) {
                errorMsg3.style.display = 'block';
                return false;
            }
            return true;
        }

        function clearError(id) {
            if(id === 1)
                document.getElementById('errorMsg').style.display = 'none';
            else if(id === 2)
                document.getElementById('errorMsg2').style.display = 'none';
            else
                document.getElementById('errorMsg3').style.display = 'none';
        }

    </script>

    <script>
        function validatePhone2() {
            const phoneInput2 = document.querySelectorAll('.phoneInput2');
            const errorMsgg = document.getElementById('errorMsgg');
            const errorMsgg2 = document.getElementById('errorMsgg2');
            const regex = /^\+[1-9][0-9]{10,}$/;

            if (!regex.test(phoneInput2[0].value)) {
                errorMsgg.style.display = 'block';
                if (!regex.test(phoneInput2[1].value)) {
                    errorMsgg2.style.display = 'block';
                }
                return false;
            }
            if (!regex.test(phoneInput2[1].value)) {
                errorMsgg2.style.display = 'block';
                return false;
            }
            return true;
        }

        function clearError2(id) {
            if(id === 1)
                document.getElementById('errorMsgg').style.display = 'none';
            else
                document.getElementById('errorMsgg2').style.display = 'none';
        }

    </script>


@endsection
