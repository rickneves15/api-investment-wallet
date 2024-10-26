<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transactions\BuyTransactionRequest;
use App\Http\Requests\Transactions\SellTransactionRequest;
use App\Services\TransactionsService;

class TransactionController extends Controller
{

    public function __construct(private readonly TransactionsService $transactionsService) {}

    public function buy(BuyTransactionRequest $request)
    {
        return $this->transactionsService->buy($request);
    }

    public function sell(SellTransactionRequest $request)
    {
        return $this->transactionsService->sell($request);
    }
}
