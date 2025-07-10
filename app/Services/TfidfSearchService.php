<?php
namespace App\Services;

class TfidfSearchService
{
    public function search($produkList, $query, $top_n = 10)
    {
        $documents = $produkList->map(function ($produk) {
            return strtolower($produk->nama_produk . ' ' . $produk->deskripsi);
        })->toArray();

        $query = strtolower($query);
        $terms = array_unique(explode(' ', $query));

        $tfidfDocs = [];
        $docTermCount = [];

        foreach ($documents as $i => $doc) {
            $tokens = array_count_values(explode(' ', $doc));
            $docTermCount[$i] = $tokens;
        }

        $df = [];
        foreach ($terms as $term) {
            foreach ($docTermCount as $tokens) {
                if (isset($tokens[$term])) {
                    $df[$term] = ($df[$term] ?? 0) + 1;
                }
            }
        }

        $N = count($documents);
        $results = [];

        foreach ($docTermCount as $i => $tokens) {
            $tfidf = [];
            foreach ($terms as $term) {
                $tf = isset($tokens[$term]) ? $tokens[$term] / array_sum($tokens) : 0;
                $idf = isset($df[$term]) ? log($N / $df[$term]) : 0;
                $tfidf[] = $tf * $idf;
            }

            $queryVec = array_fill(0, count($terms), 1);
            $dotProduct = array_sum(array_map(function ($a, $b) {
                return $a * $b;
            }, $tfidf, $queryVec));

            $docNorm = sqrt(array_sum(array_map(fn($v) => $v ** 2, $tfidf)));
            $queryNorm = sqrt(count($queryVec));

            $cosineSim = $docNorm && $queryNorm ? $dotProduct / ($docNorm * $queryNorm) : 0;

            if ($cosineSim > 0) {
                $results[] = [
                    'produk' => $produkList[$i],
                    'score' => round($cosineSim, 4),
                ];
            }
        }

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        return array_slice($results, 0, $top_n);
    }
}
