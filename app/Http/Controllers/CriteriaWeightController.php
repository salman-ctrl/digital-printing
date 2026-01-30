<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\CriteriaWeight;
use Illuminate\Http\Request;

class CriteriaWeightController extends Controller
{
    public function create()
    {
        $criterias = Criteria::all();
        return view('criteria_weights.create', compact('criterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'weights.*' => 'required|numeric|min:1|max:5',
        ]);

        foreach ($request->weights as $criteriaId => $weight) {
            CriteriaWeight::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'criteria_id' => $criteriaId,
                ],
                [
                    'weight' => $weight,
                ]
            );
        }

        return redirect()->back()->with('success', 'Bobot kriteria berhasil disimpan');
    }
}
