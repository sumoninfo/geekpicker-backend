<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
        $transactions = (new TransactionService())->getAllTransaction($request);
        return TransactionResource::collection($transactions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTransactionRequest $request
     * @return string
     */
    public function store(StoreTransactionRequest $request)
    {
        DB::beginTransaction();
        try {
            $transaction = (new TransactionService())->storeTransaction($request);
            DB::commit();
            return $this->returnResponse("success", "Created successfully", new TransactionResource($transaction));
        } catch (QueryException $e) {
            DB::rollback();
            return $this->returnResponse("error", $e->getMessage(), '', 502);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->returnResponse("error", $e->getMessage(), '', $e->getCode());
        }
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return $this->returnResponse("success", "Deleted successfully");
    }
}
