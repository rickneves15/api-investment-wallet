<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transactions\TransactionRequest;
use App\Services\TransactionsService;

class TransactionController extends Controller
{

    public function __construct(private readonly TransactionsService $transactionsService) {}

    public function buy(TransactionRequest $request)
    {
        return $this->transactionsService->buy($request);
    }

    public function sell(TransactionRequest $request)
    {
        return $this->transactionsService->sell($request);
    }
}
