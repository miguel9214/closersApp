<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheetsService;

class LeadController extends Controller
{
    protected $sheetsService;

    public function __construct(GoogleSheetsService $sheetsService)
    {
        $this->sheetsService = $sheetsService;
    }

    public function updateStatus(Request $request)
    {
        $this->sheetsService->updateStatus($request->input('row'), $request->input('status'));
        $this->sheetsService->logChange($request->input('row'), $request->input('status'));
        return response()->json(['message' => 'Estado actualizado']);
    }
}
