<?php

namespace App\Http\Controllers\Api;
//app/Http/Controllers/Api/MyReportController.php

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportListResource;
use App\Http\Resources\ReportResource;
use App\Services\ReportService;
use Illuminate\Http\Request;

class MyReportController extends Controller
{
    public function __construct(protected ReportService $reports)
    {
    }

    public function index(Request $request)
    {
        $paginated = $this->reports->forUser(
            $request->user()->id,
            $request->only(['category', 'status', 'from', 'to']),
            (int) $request->input('per_page', 10)
        );

        return ReportListResource::collection($paginated);
    }

    public function show(Request $request, int $id)
    {
        return new ReportResource($this->reports->findForUser($id, $request->user()->id));
    }
}