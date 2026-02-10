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
            'whatsapp_number' => $request['whatsapp_number'],
        ],[
            'title' => $request['title'],
            'first_name' => $request['first_name'],
            'surname' => $request['surname'],
            'marital_status' => $request['marital_status'],
            'nationality_id' => $request['nationality_id'],
            'email' => $request['email'],
            'address' => $request['address'],
            'residence_country_id' => $request['residence_country_id'],
            'languages_spoken' => $request['languages_spoken'],
            'passport_number' => $request['passport_number'],
            'issue_date' => $request['issue_date'],
            'expiry_date' => $request['expiry_date'],
            'emergency_contacts_name' => $request['emergency_contacts_name'],
            'emergency_contacts_relationship' => $request['emergency_contacts_relationship'],
            'emergency_contacts_phone_number' => $request['emergency_contacts_phone_number'],
            'disability' => $request['disability'],
            'special_needs' => $request['special_needs'],
            'token' => $token,
        ]);


        if($results){
                $msg = 'Congrats ' . $results->first_name . ' for your interest in this Event. Registration is incomplete until full payment of the Event registration fee is made.'."\n". 'Login token : ' . $token;

//            WhatsappNotificationJob::dispatch($results->whatsapp_number, $msg);
            Mail::to($results->email)->send(new EmailNotification($results->first_name, $token));

            if(($request['nationality_id'] == 64) || ($request['residence_country_id'] == 64)){
                $event_amount = config('services.paystack.amount');
                Payment::makePayment($results->email, $event_amount, 'registrant_page');
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
//        dd($request['reference']);
        $response = (new PayStackPayment())->verifyTransaction($request['reference']);

        if ($response['status'] && $response['data']['status'] === 'success') {
            $paymentDetails = $response['data'];

            $data = Registrant::where('email', $paymentDetails['customer']['email'])->first()->toArray();

            $count = OnlinePayment::where('customer_id', $paymentDetails['id'])->count();

            if($count === 0){
                Payment::paymentReceipt($data, $paymentDetails, $response);
            }
        }

        return view('registration_login');
    }

    /**
     * Display the specified resource.
     */
    public function show(Registrant $registrant)
    {
        return view('registration_complete');
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
        $reg = Registrant::find($request['reg_id']);
        $room = Room::find($request['room_id']);

        $payment = OnlinePayment::where('reg_id', $request['reg_id'])->first();

        if ($room->occupants_left == 0) {
            return back()->with('error', "Room is not available at the moment.");
        }

        if(is_null($payment->accommodation_type)) {
            if($payment){
                OnlinePayment::find($payment->id)->update([
                    'accommodation_type' => $room->slug,
                    'special_food' => $request['food_preference'],
                ]);
            }
        }

        Payment::makePayment($reg->email, $room->price, 'registrant_complete');
//        Payment::makePayment($reg->email, 10, 'registrant_complete_return');

//        return redirect(route('registrant_complete_return', absolute: false))->with("success", "Successful!!!.");
    }

    public function registrationCompleteReturn(Request $request)
    {
        if(isset($request['reference'])){
            $response = (new PayStackPayment())->verifyTransaction($request['reference']);

            if ($response['status'] && $response['data']['status'] === 'success') {
                $paymentDetails = $response['data'];

                $data = Registrant::where('email', $paymentDetails['customer']['email'])->first();

                $payment = OnlinePayment::where('reg_id', $data->id)->first();

                if($payment->accommodation_fee <= 0) {
                    if($payment){
                        OnlinePayment::find($payment->id)->update([
                            'accommodation_fee' => $paymentDetails['amount'] / 100,
                        ]);
                    }

                    $room = Room::where('slug',$payment->accommodation_type)->first();

                    if ($room->occupants_left > 0) {
                        $room->decrement('occupants_left');
                    }
                }

                $detail = OnlinePayment::find($payment->id);

                return view('receipt', ['data' => $data, 'payment' => $detail]);
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
