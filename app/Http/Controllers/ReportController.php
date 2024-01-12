<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends BaseController
{
    public function report(Request $request)
    {
        $data = DB::table('relation_view')->get()->toArray();
        $pdf = Pdf::loadView('pdf.report', ['data' => $data, 'today' => Carbon::now()->format('d/m/Y')]);
        return $pdf->download('report.pdf');
    }
}
