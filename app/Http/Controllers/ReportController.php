<?php

namespace App\Http\Controllers;

use App\Http\Resources\MostConversionUserResource;
use App\Http\Resources\Reports\ThirdHighestAmountConvertedResource;
use App\Http\Resources\Reports\TotalAmountConvertedResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    /**
     * @return array
     */
    public function dashboardData()
    {
        $data                         = [];
        $data['most_conversion_user'] = $this->mostConversionUser();
        $data['total_users']          = User::count();
        $data['total_transactions']   = Transaction::count();
        return $data;
    }

    /**
     *
     * @return MostConversionUserResource
     */
    public function mostConversionUser(): MostConversionUserResource
    {
        $most_conversion_user = User::with('transactions')
            ->addSelect(['total_amount' => Transaction::selectRaw('sum(from_amount) as total')
                ->whereColumn('from_user_id', 'users.id')
                ->groupBy('from_user_id')
            ])
            ->orderBy('total_amount', 'DESC')->first();
        return new MostConversionUserResource($most_conversion_user);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function totalAmountConverted(Request $request)
    {
        $query = User::with('transactions')
            ->addSelect(['total_amount' => Transaction::selectRaw('sum(from_amount) as total')
                ->whereColumn('from_user_id', 'users.id')
                ->groupBy('from_user_id')
            ])
            ->orderBy('total_amount', 'DESC');
        if ($request->filled('search')) {
            $query->whereLike(['name', 'email', 'phone'], $request->search);
        }
        $transactions = $query->paginate($request->get('per_page', config('constant.pagination')));
        return TotalAmountConvertedResource::collection($transactions);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function thirdHighestAmountReport(Request $request)
    {
        $query = User::with('transaction');
        if ($request->filled('search')) {
            $query->whereLike(['name', 'email', 'phone'], $request->search);
        }
        $transactions = $query->paginate($request->get('per_page', config('constant.pagination')));
        return ThirdHighestAmountConvertedResource::collection($transactions);
    }
}
