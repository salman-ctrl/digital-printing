<?php

namespace App\Services;

class TopsisService
{
    public function calculate($specifications, $criteriaWeights, $criterias)
    {
        if ($specifications->isEmpty()) {
            return $this->emptyResult();
        }

        // ========================
        // 1. MATRIX (X)
        // ========================
        $matrix = [];

        foreach ($specifications as $spec) {
            foreach ($criterias as $criteria) {

                $column = $this->mapCriteria($criteria->name);

                $value = $column && isset($spec->$column)
                    ? (float) $spec->$column
                    : 0;

                // Jika kolom tidak ditemukan secara langsung, coba ambil dari atribut model
                if (!$column) {
                    $columnLower = strtolower(str_replace(' ', '_', trim($criteria->name)));
                    $value = (float) ($spec->$columnLower ?? 0);
                }

                $matrix[$spec->id][$criteria->id] = $value;
            }
        }

        // ========================
        // 2. NORMALISASI (R)
        // ========================
        $normalizedMatrix = [];

        foreach ($criterias as $criteria) {

            $sumSquares = 0;
            $columnValues = [];

            foreach ($matrix as $row) {
                $val = $row[$criteria->id];
                $sumSquares += pow($val, 2);
                $columnValues[] = $val;
            }

            $divider = sqrt($sumSquares);
            
            // Cek apakah semua nilai dalam kolom sama
            $allSame = count(array_unique($columnValues)) === 1;

            foreach ($matrix as $specId => $row) {
                if ($allSame) {
                    // Jika semua nilai sama, normalisasi ke 1.0 agar bobot tetap berpengaruh
                    // Namun, jika semua 0 tetap 0. 
                    // Jika nilai adalah benefit (misal kualitas), kita asumsikan 1.0 (semua bagus sama)
                    // Jika nilai adalah cost (misal harga), kita asumsikan 1.0 (semua mahal sama)
                    $normalizedMatrix[$specId][$criteria->id] = $columnValues[0] > 0 ? 1.0 : 0.0;
                } else {
                    $normalizedMatrix[$specId][$criteria->id] =
                        $divider > 0
                            ? $row[$criteria->id] / $divider
                            : 0;
                }
            }
        }

        // ========================
        // 3. WEIGHTED (Y)
        // ========================
        $weightedMatrix = [];

        foreach ($normalizedMatrix as $specId => $row) {
            foreach ($criterias as $criteria) {

                // Ambil bobot, default ke 1 jika tidak ada
                $weight = isset($criteriaWeights[$criteria->id]) 
                    ? (float) $criteriaWeights[$criteria->id] 
                    : 1.0;

                // Terapkan pembobotan
                $weightedMatrix[$specId][$criteria->id] = $row[$criteria->id] * $weight;
                
                // Jika semua nilai sama (normalized 1.0), bobot akan membuat nilai tetap sama di semua produk.
                // Untuk membuat rank berubah saat bobot diubah (ketika nilai dasar sama), 
                // kita bisa menambahkan sedikit penyesuaian berdasarkan posisi atau ID agar ada pembeda tipis
                // Namun cara terbaik adalah memastikan data di database bervariasi.
            }
        }

        // ========================
        // 4. IDEAL SOLUTION
        // ========================
        $idealPositive = [];
        $idealNegative = [];

        foreach ($criterias as $criteria) {

            $values = array_column($weightedMatrix, $criteria->id);

            $type = strtolower($criteria->type ?? 'benefit');

            if ($type === 'cost') {
                $idealPositive[$criteria->id] = min($values);
                $idealNegative[$criteria->id] = max($values);
            } else {
                $idealPositive[$criteria->id] = max($values);
                $idealNegative[$criteria->id] = min($values);
            }
        }

        // ========================
        // 5. DISTANCE + SCORE
        // ========================
        $results = collect();

        foreach ($weightedMatrix as $specId => $row) {

            $dPlus = 0;
            $dMinus = 0;

            foreach ($criterias as $criteria) {

                $dPlus += pow(
                    $row[$criteria->id] - $idealPositive[$criteria->id],
                    2
                );

                $dMinus += pow(
                    $row[$criteria->id] - $idealNegative[$criteria->id],
                    2
                );
            }

            $dPlus = sqrt($dPlus);
            $dMinus = sqrt($dMinus);

            $score = ($dPlus + $dMinus) > 0
                ? $dMinus / ($dPlus + $dMinus)
                : 0;

            $results->push([
                'specification_id' => $specId,
                'specification' => $specifications->firstWhere('id', $specId),
                'preference_value' => round($score, 6),

                'matrix' => $matrix[$specId],
                'normalized' => $normalizedMatrix[$specId],
                'weighted' => $weightedMatrix[$specId],

                'd_plus' => $dPlus,
                'd_minus' => $dMinus,
            ]);
        }

        return [
            'results' => $results->sortByDesc('preference_value')->values(),
            'matrix' => $matrix,
            'normalized_matrix' => $normalizedMatrix,
            'weighted_matrix' => $weightedMatrix,
            'ideal_positive' => $idealPositive,
            'ideal_negative' => $idealNegative,
        ];
    }

    private function mapCriteria($name)
    {
        return match (trim($name)) {
            'Harga' => 'harga',
            'Kualitas Warna' => 'kualitas_warna',
            'Daya Tahan' => 'daya_tahan',
            'Tekstur Bahan' => 'tekstur_bahan',
            'Ukuran Cetak' => 'ukuran_cetak',
            default => null
        };
    }

    private function emptyResult()
    {
        return [
            'results' => collect(),
            'matrix' => [],
            'normalized_matrix' => [],
            'weighted_matrix' => [],
            'ideal_positive' => [],
            'ideal_negative' => [],
        ];
    }
}