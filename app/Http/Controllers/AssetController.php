<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assets\AssetStoreRequest;
use App\Models\Asset;
use App\Services\AssetsService;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function __construct(private readonly AssetsService $assetsService) {}

    public function index(Request $request)
    {
        return $this->assetsService->getAll($request);
    }

    public function store(AssetStoreRequest $request)
    {
        return $this->assetsService->create($request);
    }

    public function show($id)
    {
        return $this->assetsService->getOne($id);
    }

    public function destroy($id)
    {
        return $this->assetsService->delete($id);
    }
}
