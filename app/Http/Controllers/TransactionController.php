<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class TransactionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Transaction::with('toUser');
        if ($request->filled('search')) {
            $query->whereLike(['toUser.name', 'toUser.email', 'toUser.phone', 'from_amount', 'to_amount'], $request->search);
        }
        $query = $query->latest()->paginate($request->get('per_page', config('constant.pagination')));
        return TransactionResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTransactionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTransactionRequest $request)
    {
        try {
            $to_user    = User::find($request->user['id']);
            $auth_user  = auth()->user();
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
            return $this->returnResponse("success", "Created successfully", new TransactionResource($transaction));
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
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

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTransactionRequest $request
     * @param Transaction $transaction
     * @return Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transaction $transaction
     * @return Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return $this->returnResponse("success", "Deleted successfully");
    }
}
