<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransitionRequest;
use App\Http\Requests\UpdateTransitionRequest;
use App\Models\Transition;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class TransitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTransitionRequest $request
     * @return Response
     */
    public function store(StoreTransitionRequest $request)
    {
       // try {
            $to_user    = User::find($request->user['id']);
            $auth_user  = auth()->user();
            $transition = new Transition();
            $transition->fill($request->all());
            $transition->from_user_id  = $auth_user->id;
            $transition->to_user_id    = $to_user->id;
            $transition->from_currency = $auth_user->currency;
            $transition->to_currency   = $to_user->currency;
          return  $transition->amount        =
                $this->getAmountFromCurrencyCalculation($auth_user->currency, $to_user->currency, $request->amount);
            return $transition;
            $transition->save();
        /*} catch (\Exception $exception) {
            return $exception;
        }*/
    }

    /**
     * @param $from_currency
     * @param $to_currency
     * @param $amount
     * @return float|int
     */
    private function getAmountFromCurrencyCalculation($from_currency, $to_currency, $amount)
    {
        $access_key                  = config('services.currency.access_key');
        $res                         =
            Http::get("http://api.currencylayer.com/live?format=1&access_key={$access_key}&currencies={$from_currency},{$to_currency}&source=USD");
        $result                      = $res->json();
        return $result;
        $to_currency                 = "USD{$to_currency}";
        $currency_calculation_amount = $result['quotes'][$to_currency];
        return $currency_calculation_amount;
        return ($amount * $currency_calculation_amount);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Transition $transition
     * @return Response
     */
    public function show(Transition $transition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTransitionRequest $request
     * @param \App\Models\Transition $transition
     * @return Response
     */
    public function update(UpdateTransitionRequest $request, Transition $transition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Transition $transition
     * @return Response
     */
    public function destroy(Transition $transition)
    {
        //
    }
}
