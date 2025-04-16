<?php

namespace App\Http\Controllers\SuperUser;

use App\Models\HsnCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class SuperUserHsnController extends Controller
{
    public function index(): JsonResponse
    {
        $hsnCodes = HsnCode::all();
        return response()->json($hsnCodes);
    }
}
