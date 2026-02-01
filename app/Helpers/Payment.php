<?php

namespace App\Helpers;

use App\Models\OnlinePayment;
use App\Models\Registrant;

class Payment
{
    public static function makePayment($email, $amount, $callback_url)
    {
//        $amount = ceil(Utils::exchange_rate($amount) * 100);

        $url = config('services.paystack.payment_url');

        $fields = [
            'email' => $email,
            'amount' => $amount,
            'subaccount' => "ACCT_f4kp67u7sbtd0x8",
            'callback_url' => route($callback_url),
        ];

        $fields_string = http_build_query($fields);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ". config('services.paystack.secret_key'),
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        $response = json_decode($result, true);

        if (!$response || !$response['status']) {
            die('Paystack Error: ' . ($response['message'] ?? 'Unknown error'));
        }

        header("Location: " . $response['data']['authorization_url']);
        exit;
    }

    public static function paymentReceipt(array $data, $paymentDetails, $response)
    {
        OnlinePayment::firstOrCreate([
            'payment_mode' => $paymentDetails['channel'],
            'reference' => $paymentDetails['reference'],
        ],[
            'reg_id' => $data['id'],
//            'accommodation_type' => null,
//            'accommodation_fee' => null,
//            'special_food' => null,
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

        return 0;
    }
}
