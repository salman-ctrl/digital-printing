<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSpecification;
use App\Models\Criteria;
use App\Models\CriteriaWeight;
use App\Models\TopsisLog;
use App\Services\TopsisService;
use Illuminate\Http\Request;

class TopsisAdminController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    public function index(Request $request)
    {
        $logs = TopsisLog::with(['user', 'category'])->latest()->paginate(10);
        $criterias = Criteria::all();

        // Ambil ID log dari request atau gunakan yang terbaru
        $selectedLogId = $request->query('log_id');
        $selectedLog = $selectedLogId 
            ? TopsisLog::find($selectedLogId) 
            : TopsisLog::latest()->first();

        $topsis = null;
        if ($selectedLog) {
            $topsis = $selectedLog->full_calculation;
            
            // Re-map objects in results if they are arrays (from JSON)
            if (isset($topsis['results'])) {
                foreach ($topsis['results'] as &$res) {
                    if (is_array($res['specification'])) {
                        // We need the specification to have the product relation for the view
                        $specId = $res['specification_id'] ?? $res['specification']['id'];
                        $res['specification'] = ProductSpecification::with('product.category')->find($specId);
                    }
                }
            }
        }

        // 🔥 SAFE GUARD
        if (!$topsis) {
            $topsis = [
                'results' => [],
                'matrix' => [],
                'normalized_matrix' => [],
                'weighted_matrix' => [],
                'ideal_positive' => [],
                'ideal_negative' => [],
            ];
        }

        return view('admin.topsis.index', [
            'logs' => $logs,
            'selectedLog' => $selectedLog,
            'topsis' => $topsis,
            'criterias' => $criterias
        ]);
    }

    public function destroy($id)
    {
        try {
            $log = TopsisLog::findOrFail($id);
            $log->delete();
            return redirect()->route('admin.topsis.index')->with('success', 'Log perhitungan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus log: ' . $e->getMessage());
        }
    }
}