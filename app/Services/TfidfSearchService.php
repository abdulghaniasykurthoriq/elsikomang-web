<?php
namespace App\Services;

class TfidfSearchService
{
    protected $stopwords = [
        'yang', 'dan', 'di', 'ke', 'dari', 'untuk', 'dengan', 'adalah', 'itu', 'ini', 'pada',
        'karena', 'oleh', 'sebagai', 'juga', 'akan', 'maka', 'dalam', 'atau', 'tersebut',
        // kamu bisa tambah sesuai kebutuhan
    ];

    public function search($produkList, $query, $top_n = 10)
    {
        // Preprocessing dokumen produk
        $documents = $produkList->map(function ($produk) {
            $text = strtolower($produk->nama_produk . ' ' . $produk->deskripsi);
            return $this->preprocess($text);
        })->toArray();

        // Preprocessing query
        $query = strtolower($query);
        $terms = array_unique($this->preprocess($query));

        $docTermCount = [];

        // Tokenisasi dan TF
        foreach ($documents as $i => $tokens) {
            $docTermCount[$i] = array_count_values($tokens);
        }

        // DF: document frequency
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

        // TF-IDF dan Cosine Similarity
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

    // Fungsi preprocessing: tokenizer + stopword + stemming sederhana
    protected function preprocess($text)
    {
        // 1. Hapus simbol
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);

        // 2. Tokenisasi
        $tokens = explode(' ', $text);

        // 3. Hapus stopword dan stemming
        $cleaned = [];
        foreach ($tokens as $token) {
            $token = trim($token);
            if ($token && !in_array($token, $this->stopwords)) {
                $cleaned[] = $this->stem($token);
            }
        }

        return $cleaned;
    }

    // Fungsi stemming sederhana (rule-based, tidak pakai library)
    protected function stem($word)
    {
        // Rule sederhana: hapus imbuhan depan / akhir
        $prefixes = ['ber', 'ter', 'se', 'me', 'di', 'ke', 'pe'];
        $suffixes = ['kan', 'an', 'i', 'lah', 'nya'];

        foreach ($prefixes as $pre) {
            if (str_starts_with($word, $pre)) {
                $word = substr($word, strlen($pre));
                break;
            }
        }

        foreach ($suffixes as $suf) {
            if (str_ends_with($word, $suf)) {
                $word = substr($word, 0, -strlen($suf));
                break;
            }
        }

        return $word;
    }
}
