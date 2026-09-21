<?php
namespace App\Http\Controllers\Api;

//app/Http/Controllers/Api/ReportController.php
use App\Http\Controllers\Controller;
use App\Http\Requests\CreditWalletRequest;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportStatusRequest;
use App\Http\Resources\AdminReportListResource;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\Request;
use App\Http\Resources\AdminReportResource;
class ReportController extends Controller
{
    public function __construct(protected ReportService $reports)
    {
    }
//     public function adminShow(Report $report)
// {
//     return new AdminReportResource($report->load(['suspects', 'evidenceFiles', 'categories', 'user']));
// }
public function store(StoreReportRequest $request)
{
    $data = $request->validated();
    $data['user_id'] = auth('sanctum')->id(); // was: $request->user()?->id
    $data['files'] = $request->file('files', []);

    return new ReportResource($this->reports->create($data));
}
    public function track(string $passcode)
    {
        return new ReportResource($this->reports->findByPasscode($passcode));
    }

    public function adminIndex(Request $request)
    {
        $paginated = $this->reports->forAdmin(
            $request->only(['category_id', 'status', 'anonymity', 'from', 'to']),
            (int) $request->input('per_page', 10)
        );

        return AdminReportListResource::collection($paginated);
    }

public function updateStatus(UpdateReportStatusRequest $request, Report $report)
{
    return new ReportResource(
        $this->reports->updateStatus($report, $request->validated()['status'], $request->user()->id)
    );
}

public function adminShow(Report $report)
{
    return new AdminReportResource($report->load(['suspects', 'evidenceFiles', 'categories', 'user']));
}



    public function destroy(Report $report)
    {
        $this->reports->delete($report);

        return response()->json(['message' => 'Report deleted.']);
    }

    public function creditWallet(CreditWalletRequest $request, Report $report)
    {
        $transaction = $this->reports->creditWallet(
            $report,
            $request->validated()['wallet_id'],
            $request->validated()['amount']
        );

        return response()->json(['message' => 'Wallet credited.', 'transaction_id' => $transaction->id]);
    }
}