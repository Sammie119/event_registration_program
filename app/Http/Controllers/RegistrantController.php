<?php

namespace App\Http\Controllers;

use App\Helpers\Payment;
use App\Helpers\PayStackPayment;
use App\Helpers\Utils;
use App\Jobs\WhatsappNotificationJob;
use App\Mail\EmailNotification;
use App\Models\Country;
use App\Models\OnlinePayment;
use App\Models\Registrant;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RegistrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = Utils::getLookups(22);
        $data['gender'] = Utils::getLookups(2);
        $data['marital_status'] = Utils::getLookups(3);
        $data['profession'] = Utils::getLookups(10);
        $data['nations'] = Country::orderBy('name', 'asc')->get();

        return view('registration_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = Utils::generateToken();

        $results = Registrant::updateOrCreate([
            'date_of_birth' => $request['date_of_birth'],
            'gender' => $request['gender'],
            'phone_number' => $request['phone_number'],
        ],[
            'title' => $request['title'],
            'first_name' => $request['first_name'],
            'surname' => $request['surname'],
            'marital_status' => $request['marital_status'],
            'nationality_id' => $request['nationality_id'],
            'email' => $request['email'],
            'address' => 'Address',
            'residence_country_id' => $request['residence_country_id'],
            'languages_spoken' => $request['languages_spoken'],
            'disability' => $request['disability'],
            'special_needs' => $request['special_needs'],
            'token' => $token,
        ]);


        if($results){
            Mail::to($results->email)->send(new EmailNotification($results->first_name, $token));

            if(($request['nationality_id'] == 64) || ($request['residence_country_id'] == 64)){
                $event_amount = config('services.paystack.amount');
                if($event_amount > 0){
                    Payment::makePayment($results->email, $event_amount, 'registrant_page');
                }
            }

            return redirect(route('registrant_page', absolute: false))->with("success", "Registration Successful!!. Check your SMS/Whatsapp for further instructions.");
        }

        return back()->with('error', 'Role Creation Unsuccessful!!!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(isset($request['reference'])){
            $response = (new PayStackPayment())->verifyTransaction($request['reference']);

            if ($response['status'] && $response['data']['status'] === 'success') {
                $paymentDetails = $response['data'];

                $data = Registrant::where('email', $paymentDetails['customer']['email'])->first()->toArray();

                $count = OnlinePayment::where('customer_id', $paymentDetails['id'])->count();

                if ($count === 0) {
                    Payment::paymentReceipt($data, $paymentDetails, $response);
                }
            }
        }

        return view('registration_login');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data['rooms'] = Room::selectRaw("id, concat(name, ' - USD', price) as name")->where('occupants_left', '>', 0)->get()->toArray();
        return view('registration_complete', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function registrationLogin(Request $request)
    {
        $reg = Registrant::where('token', $request['password'])->first();

        if($reg){
            if(Utils::check($reg->phone_number, $request['email']) || Utils::check($reg->email, $request['email'])){

                $data['name'] = $reg->first_name . ' ' . $reg->surname;
                $data['id'] = $reg->id;
                $data['rooms'] = Room::selectRaw("id, concat(name, ' - USD', price) as name")->where('occupants_left', '>', 0)->get()->toArray();
                return view('registration_complete', $data);
            }

            return back()->with('error', "Login Unsuccessful!!!. Try again.");
        }

        return back()->with('error', "Login Unsuccessful!!!. Try again.");
    }

    /**
     * Update the specified resource in storage.
     */
    public function registrationComplete(Request $request)
    {
        $result = explode(" ", $request['name']);

        $email = $request['email'];
        $request->session()->put('data', [
            'full_name' => trim($request['name']),
            'phone_number' => $request['contact']
        ]);
        $room = Room::find($request['room_id']);

        if ($room->occupants_left == 0) {
            return back()->with('error', "Room is not available at the moment.");
        }

        OnlinePayment::firstOrCreate([
                'full_name' => $email,
                'reference' => $request['contact'],
            ], [
                'payment_mode' => 'channel',
                'reg_id' => 0,
                'contact' => 'phone_number',
                'accommodation_type' => $room->slug,
                'transaction_no' => 0,
                'amount_paid' => 0.10,
                'date_paid' => date('Y-m-d'),
                'comment' => 'message',
                'approved' => 0,
                'approved_at' => date('Y-m-d'),
                'event_total_fee' => 0.10,
                'customer_id' => 0,
                'payment_status' => 0,
        ]);
//        Payment::makePayment($email, 10, 'registrant_complete_return');
        Payment::makePayment($email, $room->price, 'registrant_complete_return');

        return 0;
    }

    public function registrationCompleteReturn(Request $request)
    {
        if(isset($request['reference'])){
            $response = (new PayStackPayment())->verifyTransaction($request['reference']);

            if ($response['status'] && $response['data']['status'] === 'success') {
                $paymentDetails = $response['data'];

                $data = $request->session()->get('data');

                $payment = OnlinePayment::where('full_name', $paymentDetails['customer']['email'])->first();

//                dd($data, $payment);

                if($payment) {
                    OnlinePayment::find($payment->id)->update([
                        'payment_mode' => $paymentDetails['channel'],
                        'reference' => $paymentDetails['reference'],
                        'reg_id' => 0,
                        'full_name' => $data['full_name'],
                        'contact' => $data['phone_number'],
                        'accommodation_fee' => $paymentDetails['amount'] / 100,
                        'transaction_no' => $paymentDetails['id'],
                        'amount_paid' => $paymentDetails['amount'] / 100,
                        'date_paid' => date('Y-m-d', strtotime($paymentDetails['transaction_date'])),
                        'comment' => $response['message'],
                        'approved' => 1,
                        'approved_at' => date('Y-m-d', strtotime($paymentDetails['paid_at'])),
                        'event_total_fee' => $paymentDetails['amount'] / 100,
                        'customer_id' => $paymentDetails['customer']['id'],
                        'payment_status' => $response['status'],
                    ]);

                    $room = Room::where('slug',$payment->accommodation_type)->first();

                    if ($room->occupants_left > 0) {
                        $room->decrement('occupants_left');
                    }
                }

                $detail = OnlinePayment::where('reference', $paymentDetails['reference'])->first();

//                return 'Room Payment Successful';
                if($detail)
                    return view('receipt', ['payment' => $detail]);
                return "No Receipt Found";
            }
        } else {
            return "No Receipt Found";
        }
        return null;
//        return view('receipt');
//        return redirect(route('registrant.index', absolute: false));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registrant $registrant)
    {
        //
    }
}
