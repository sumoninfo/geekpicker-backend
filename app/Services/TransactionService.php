<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    /**
     * store transaction data
     *
     * @param Request $request
     * @return Transaction
     */
    public function storeTransaction(Request $request)
    {
        $to_user     = User::find($request->user['id']);
        $auth_user   = auth()->user();
        $transaction = new Transaction();
        $transaction->fill($request->all());
        $transaction->from_user_id  = $auth_user->id;
        $transaction->to_user_id    = $to_user->id;
        $transaction->from_currency = $auth_user->currency;
        $transaction->to_currency   = $to_user->currency;
        $transaction->from_amount   = $request->amount;
        $transaction->to_amount     =
            $this->getAmountFromCurrencyCalculation($auth_user->currency, $to_user->currency, $request->amount);
        $transaction->save();
        return $transaction;
    }

    /**
     * get converted amount from and to currency amount
     *
     * @param $from_currency
     * @param $to_currency
     * @param $amount
     * @return float|int
     */
    private function getAmountFromCurrencyCalculation($from_currency, $to_currency, $amount)
    {
        $access_key         = config('services.currency.access_key');
        $res                =
            Http::get("http://api.currencylayer.com/live?format=1&access_key={$access_key}&currencies={$from_currency},{$to_currency}&source=USD");
        $result             = $res->json();
        $to_currency_rate   = $result['quotes']["USD{$to_currency}"];
        $from_currency_rate = $result['quotes']["USD{$from_currency}"];
        return number_format(($to_currency_rate / $from_currency_rate) * $amount, 4);
    }
}