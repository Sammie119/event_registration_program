@extends("layouts.guest")

@section('content')
    <main class="container">

        <!-- Default Accordion -->
        <div class="accordion h-100 d-flex align-items-center justify-content-center">
            <section class="section mobile">
                <div class="alert alert-info">
                    <p>Thank you for registering for the Apostolic World Conference 2026.</p>
                    <p>This link enables you to reserve and make advance payment for your accommodation during the conference.</p>
                    <p>The rates indicated are for 5 nights (check-in on 2nd November and check-out on 7th November) and includes bed, breakfast, shuttle bus service from and to the conference venue as well as airport pickup and drop-off service. The conference committee will assist you if you intend to arrive earlier than the check-in date or stay beyond the check-out dates.</p>
                    <p class="mb-0">We are guided by the data protection Act and your data will be used for the purposes of the AWC 2026 only.</p>
                </div>
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
                                            name="surname"
                                            required="true"
                                            label="Family Name / Surname"
                                            value=""
                                        />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <x-input-text
                                            type="text"
                                            name="other_names"
                                            required="true"
                                            label="Other Names"
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
                                            :codes="collect($country)->pluck('code', 'id')->toArray()"
                                            :selected="0"
                                            name="country"
                                            :type="0"
                                            required="true"
                                            label="Select Country"
                                        />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row g-2">
                                            <div class="col-4">
                                                <x-input-text
                                                    type="text"
                                                    name="dialing_code"
                                                    required="true"
                                                    label="Code"
                                                    placeholder="+233"
                                                    value=""
                                                />
                                            </div>
                                            <div class="col-8">
                                                <x-input-text
                                                    type="text"
                                                    name="phone_number"
                                                    required="true"
                                                    label="Phone Number"
                                                    placeholder="541234567"
                                                    value=""
                                                />
                                            </div>
                                        </div>
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
        // ISO 3166-1 alpha-2 country code -> international dialing code.
        const ISO_TO_DIALING_CODE = {
            AF: '+93', AL: '+355', DZ: '+213', AS: '+1', AD: '+376', AO: '+244', AI: '+1', AG: '+1',
            AR: '+54', AM: '+374', AW: '+297', AU: '+61', AT: '+43', AZ: '+994', BS: '+1', BH: '+973',
            BD: '+880', BB: '+1', BY: '+375', BE: '+32', BZ: '+501', BJ: '+229', BM: '+1', BT: '+975',
            BO: '+591', BA: '+387', BW: '+267', BR: '+55', BN: '+673', BG: '+359', BF: '+226', BI: '+257',
            KH: '+855', CM: '+237', CA: '+1', CV: '+238', KY: '+1', CF: '+236', TD: '+235', CL: '+56',
            CN: '+86', CO: '+57', KM: '+269', CG: '+242', CD: '+243', CR: '+506', CI: '+225', HR: '+385',
            CU: '+53', CY: '+357', CZ: '+420', DK: '+45', DJ: '+253', DM: '+1', DO: '+1', EC: '+593',
            EG: '+20', SV: '+503', GQ: '+240', ER: '+291', EE: '+372', SZ: '+268', ET: '+251', FJ: '+679',
            FI: '+358', FR: '+33', GA: '+241', GM: '+220', GE: '+995', DE: '+49', GH: '+233', GI: '+350',
            GR: '+30', GL: '+299', GD: '+1', GU: '+1', GT: '+502', GN: '+224', GW: '+245', GY: '+592',
            HT: '+509', HN: '+504', HK: '+852', HU: '+36', IS: '+354', IN: '+91', ID: '+62', IR: '+98',
            IQ: '+964', IE: '+353', IL: '+972', IT: '+39', JM: '+1', JP: '+81', JO: '+962', KZ: '+7',
            KE: '+254', KI: '+686', KP: '+850', KR: '+82', KW: '+965', KG: '+996', LA: '+856', LV: '+371',
            LB: '+961', LS: '+266', LR: '+231', LY: '+218', LI: '+423', LT: '+370', LU: '+352', MO: '+853',
            MG: '+261', MW: '+265', MY: '+60', MV: '+960', ML: '+223', MT: '+356', MH: '+692', MR: '+222',
            MU: '+230', MX: '+52', FM: '+691', MD: '+373', MC: '+377', MN: '+976', ME: '+382', MA: '+212',
            MZ: '+258', MM: '+95', NA: '+264', NR: '+674', NP: '+977', NL: '+31', NZ: '+64', NI: '+505',
            NE: '+227', NG: '+234', NU: '+683', MK: '+389', NO: '+47', OM: '+968', PK: '+92', PW: '+680',
            PA: '+507', PG: '+675', PY: '+595', PE: '+51', PH: '+63', PL: '+48', PT: '+351', PR: '+1',
            QA: '+974', RO: '+40', RU: '+7', RW: '+250', KN: '+1', LC: '+1', VC: '+1', WS: '+685',
            SM: '+378', ST: '+239', SA: '+966', SN: '+221', RS: '+381', SC: '+248', SL: '+232', SG: '+65',
            SK: '+421', SI: '+386', SB: '+677', SO: '+252', ZA: '+27', SS: '+211', ES: '+34', LK: '+94',
            SD: '+249', SR: '+597', SE: '+46', CH: '+41', SY: '+963', TW: '+886', TJ: '+992', TZ: '+255',
            TH: '+66', TL: '+670', TG: '+228', TO: '+676', TT: '+1', TN: '+216', TR: '+90', TM: '+993',
            TV: '+688', UG: '+256', UA: '+380', AE: '+971', GB: '+44', US: '+1', UY: '+598', UZ: '+998',
            VU: '+678', VA: '+379', VE: '+58', VN: '+84', YE: '+967', ZM: '+260', ZW: '+263',
        };

        document.addEventListener('DOMContentLoaded', function () {
            const countrySelect = document.querySelector('select[name="country"]');
            const dialingCodeInput = document.getElementById('dialing_code');
            let lastAutoValue = '';

            if (dialingCodeInput) {
                // If the user edits the field away from the last value we auto-filled,
                // stop overwriting it on future country changes.
                dialingCodeInput.addEventListener('input', function () {
                    if (dialingCodeInput.value !== lastAutoValue) {
                        lastAutoValue = null;
                    }
                });

                countrySelect && countrySelect.addEventListener('change', function () {
                    if (lastAutoValue === null) return;

                    const opt = countrySelect.selectedOptions[0];
                    const isoCode = opt ? opt.dataset.code : null;
                    const dialingCode = isoCode ? ISO_TO_DIALING_CODE[isoCode.toUpperCase()] : null;

                    if (dialingCode) {
                        dialingCodeInput.value = dialingCode;
                        lastAutoValue = dialingCode;
                    }
                });
            }

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
