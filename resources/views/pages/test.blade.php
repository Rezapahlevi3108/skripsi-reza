<?php
public function kmeans(Request $request)
    {
        $option = OptionCluster::all()->sortByDesc('id')->first(); //Data diambil secara descending, jadi data diurutkan dari id paling tinggi hingga rendah (Data yang terkhir akan di proses duluan)
        $k = $option->clusters;
        $iterations = 100;

        $data = Data::all(); //Mengambil semua data dari model Data
        $n = count($data); //Menghitung jumlah data dan dimasukkan pada variabel $n
        $distances = array(); //Deklarasi veriabel $tabel sebagai array kosong yang nantinya akan digunakan untuk menyimpan jarak antara setiap data dan pusat kluster terdekat tiap iterasi
        $clusters = array(); //Deklarasi variabel $clusters sebagai array kosong yang nantinya akan digunakan untuk menyimpan hasil cluster tiap iterasi
        $centroid = array(); // Deklarasi variabel $centroid sebagai array kosong yang nantinya akan digunakan untuk menyimpan koordinat pusat kluster (menyimpan centroid)

        $randomIndexes = range(0, $n - 1); //Deklarasi variabel dengan array yang berisi angka dari 0 hingga jumlah data - 1
        shuffle($randomIndexes); //Data diacak berdasarkan indeks atau urutannya

        for ($i = 0; $i < $k; $i++) { //Perulangan yang akan berjalan sebanyak jumlah cluster yang ditentukan
            $centroid[$i] = $data[$randomIndexes[$i]]->toArray(); //Centroid akan dipilih dari urutan paling atas data yang sudah diacak
        }

        $stable = false; //Inisialisasi variabel $stable = false 
        $prevCentroid = array(); //Deklarasi variabel $prevCentroid sebagai array kosong yang nantinya akan digunakan untuk menyimpan centroid dari iterasi sebelumnya

        for ($i = 0; $i < $iterations; $i++) { //Perulangan yang akan berjalan sebanyak jumlah iterasi
            $distance_per_iteration = array(); //Deklarasi variabel yang akan digunakan untuk menyimpan jarak antara setiap data dengan pusat kluster yang terdekat per iterasi.
            $cluster_per_iteration = array(); // Deklarasi variabel yang akan digunakan untuk menyimpan kluster yang telah ditentukan untuk setiap data per iterasi

            foreach ($data as $key => $row) { //Perulangan untuk mengiterasi setiap elemen dalam $data yang disimpan dalam $row, indexnya (nomor array) disimpan dalam $key
                $minDistance = INF; //"INF" Untuk membandingkan dan memperbaharui $minDistance dengan jarak terkecil
                $cluster_per_row = array(); //Untuk menyimpan kluster yang ditentukan untuk setiap baris data per iterasi
                $distance_per_row = array(); //Untuk menyimpan jarak antara data saat ini dengan setiap pusat kluster yang terkait untuk setiap baris data per iterasi

                for ($j = 0; $j < $k; $j++) { //Perulangan untuk mengiterasi setiap pusat kluster yang ada, dengan variabel iterasi $j
                    //$row adalah data yang sedang dievaluasi, $centroid[$j] adalah centroid ke-$j yang digunakan dalam perhitungan
                    $distance = sqrt(
                        pow($row->sbd - $centroid[$j]['sbd'], 2) +
                        pow($row->ips - $centroid[$j]['ips'], 2) +
                        pow($row->ipa - $centroid[$j]['ipa'], 2) +
                        pow($row->bing - $centroid[$j]['bing'], 2) +
                        pow($row->mat - $centroid[$j]['mat'], 2) +
                        pow($row->pa - $centroid[$j]['pa'], 2) +
                        pow($row->pjok - $centroid[$j]['pjok'], 2) +
                        pow($row->pra - $centroid[$j]['pra'], 2) +
                        pow($row->bind - $centroid[$j]['bind'], 2) +
                        pow($row->pkn - $centroid[$j]['pkn'], 2)
                    );
                    if ($distance < $minDistance) { //Jika hasil perhitungan $distance lebih kecil dari $minDistance yang telah ditentukan sebelumnya, maka isi dari $minDistance akan diperbarui dengan hasil perhitungan $distance
                        $minDistance = $distance;
                        $row->cluster = $j + 1; //Cluster akan diisi atau diperbarui sesuai dengan centroid mana yang memiliki jarak terdekat dengan data
                    }
                    $distance_per_row[$j] = $distance; //Untuk menyimpan jarak data ke cluster pada satu iterasi
                    $cluster_per_row = $row->cluster; //Untuk menyimpan cluster yang ditentkan dalam satu iterasi
                }

                //Untuk menyimpan dan memperbarui hasil distances dan cluster tiap iterasi yang kemudian digunakan untuk proses iterasi selanjutnya
                $distance_per_iteration[$key] = $distance_per_row;
                $cluster_per_iteration[$key] = $cluster_per_row;
                $row->save();
            }

            for ($j = 0; $j < $k; $j++) {
                $data_cluster = Data::where('cluster', $j+1)->get(); //Mengambil semua data berdasarkan clusternya

                //Menghitung nilai rata-rata attribute setiap cluster dan dimasukkan pada centroid baru
                $centroid[$j]['sbd'] = $data_cluster->avg('sbd');
                $centroid[$j]['ips'] = $data_cluster->avg('ips');
                $centroid[$j]['ipa'] = $data_cluster->avg('ipa');
                $centroid[$j]['bing'] = $data_cluster->avg('bing');
                $centroid[$j]['mat'] = $data_cluster->avg('mat');
                $centroid[$j]['pa'] = $data_cluster->avg('pa');
                $centroid[$j]['pjok'] = $data_cluster->avg('pjok');
                $centroid[$j]['pra'] = $data_cluster->avg('pra');
                $centroid[$j]['bind'] = $data_cluster->avg('bind');
                $centroid[$j]['pkn'] = $data_cluster->avg('pkn');
            }

            $distances[$i] = $distance_per_iteration; //Menyimpan hasil perhitungan jarak tiap iterasi kedalam variabel $table
            $clusters[$i] = $cluster_per_iteration; //Menyimpan hasil cluster tiap iterasi kedalam variabel $cluster

            //Jika centroid saat ini sudah sama dengan centroid iterasi sebelumnya, maka keluar dari perulangan iterasi
            if ($centroid === $prevCentroid) {
                $stable = true;
                break;
            }

            $prevCentroid = $centroid; //Menyimpan hasil centroid saat ini kedalam $prevCentroid untuk membandingkan dengan hasil centroid iterasi selanjutnya
        }

        $results = DB::table('data')->orderBy('cluster')->get();
        $clusterCounts = $results->groupBy('cluster')->map->count(); //map digunakan untuk menghitung jumlah data tiap cluster

        session(['kmeans_data' => [
            'data' => $data,
            'results' => $results,
            'clusterCounts' => $clusterCounts,
            'distances' => $distances,
            'clusters' => $clusters,
            'k' => $k,
            'iterations' => $iterations,
            'stable' => $stable
        ]]);

        return view('pages.kmeans', compact('data', 'results', 'clusterCounts', 'distances', 'clusters', 'k', 'iterations', 'stable'));
    }

    public function dbi()
    {
        $data = DB::table('data')->orderBy('cluster')->get();

        if ($data->count() > 0 && $data->where('cluster', '!=', 0)->count() > 0) { // cek jika tabel data ada isinya dan kolom cluster tidak berisi 0 semua

            // 1. Hitung centroid dari setiap klaster
            $centroids = $data->groupBy('cluster')->map(function ($group) { // map digunakan untuk inisialisasi tiap cluster beserta isi clusternya pada variabel $group
                return [
                    // Menghitung rata2 tiap atribut
                    'sbd' => $group->avg('sbd'),
                    'ips' => $group->avg('ips'),
                    'ipa' => $group->avg('ipa'),
                    'bing' => $group->avg('bing'),
                    'mat' => $group->avg('mat'),
                    'pa' => $group->avg('pa'),
                    'pjok' => $group->avg('pjok'),
                    'pra' => $group->avg('pra'),
                    'bind' => $group->avg('bind'),
                    'pkn' => $group->avg('pkn'),
                ];
            });
    
            // 2. Hitung jarak setiap data ke masing-masing klaster
            $distances = $data->map(function ($item) use ($centroids) { // map digunakan untuk inisialisasi tiap baris data dengan variabel $item dan mengakses variabel $centroids
                $centroid = $centroids[$item->cluster]; // mengambil nilai centroid tiap cluster
                // Menghitung jarak antar data dengan centroidnya menggunakan rumus euclidean
                $distance = sqrt(
                    pow($item->sbd - $centroid['sbd'], 2) +
                    pow($item->ips - $centroid['ips'], 2) +
                    pow($item->ipa - $centroid['ipa'], 2) +
                    pow($item->bing - $centroid['bing'], 2) +
                    pow($item->mat - $centroid['mat'], 2) +
                    pow($item->pa - $centroid['pa'], 2) +
                    pow($item->pjok - $centroid['pjok'], 2) +
                    pow($item->pra - $centroid['pra'], 2) +
                    pow($item->bind - $centroid['bind'], 2) +
                    pow($item->pkn - $centroid['pkn'], 2)
                );
                return [
                    // 'id' => $item->id,
                    'cluster' => $item->cluster, // cluser berisi cluster tiap data
                    'distance' => $distance, // distance berisi jarak tiap data dengan centroidnya
                ];
            });
        
            // 3. Hitung sum square within (SSW) untuk setiap klaster
            $ssws = $distances->groupBy('cluster')->map(function ($group) use ($data) { // map digunakan untuk inisialisasi tiap cluster beserta jarak tiap data ke centroidnya pada variabel $group
                return $group->avg('distance'); // menghitung rata2 jarak tiap cluster
            });
    
            // 4. Hitung sum square between (SSB)
            $ssb = 0; // deklarasi untuk menyimpan nilai total SSB
            $ssbs = []; // matriks yang akan berisi nilai SSB antar kluster.
            foreach ($centroids as $clusterI => $centroidI) { // $clusterI adalah cluster, $centroidI adalah nilai centroid tiap cluster
                $ssbs[$clusterI] = []; //membuat sub-array kosong dalam matriks $ssbs untuk kluster saat ini
                foreach ($centroids as $clusterJ => $centroidJ) { //mengiterasi setiap centroid dalam kluster lagi, untuk membandingkan setiap pasangan centroid dalam kluster yang berbeda
                    if ($clusterI !== $clusterJ) { // jika tidak membandingkan centroid dengan cluster yang sama
                        // maka hitung jarak antar centroid menggunakan rumus euclidean
                        $distance = sqrt(
                            pow($centroidJ['sbd'] - $centroidI['sbd'], 2) +
                            pow($centroidJ['ips'] - $centroidI['ips'], 2) +
                            pow($centroidJ['ipa'] - $centroidI['ipa'], 2) +
                            pow($centroidJ['bing'] - $centroidI['bing'], 2) +
                            pow($centroidJ['mat'] - $centroidI['mat'], 2) +
                            pow($centroidJ['pa'] - $centroidI['pa'], 2) +
                            pow($centroidJ['pjok'] - $centroidI['pjok'], 2) +
                            pow($centroidJ['pra'] - $centroidI['pra'], 2) +
                            pow($centroidJ['bind'] - $centroidI['bind'], 2) +
                            pow($centroidJ['pkn'] - $centroidI['pkn'], 2)
                        );
                        $ssb += $distance;
                        $ssbs[$clusterI][$clusterJ] = $distance; // hasil perhitungannya disimpan disini
                    } else { // jika membandingkan centroid dengan cluster yang sama
                        $ssbs[$clusterI][$clusterJ] = 0; // maka nilainya adalah 0
                    }
                }
            }
    
            // 5. Hitung rasio
            $ratios = []; // variabel ini untuk menyimpan nilai ratio
            foreach ($ssws as $clusterI => $sswI) { // inisialisasi nilai ssw tiap cluster
                $maxR = 0; // unntuk menyimpan nilai max ratio tiap cluster
                foreach ($ssws as $clusterJ => $sswJ) { // inisialisasi lagi nilai ssw tiap cluster untuk dibandingkan dengan cluster lain
                    if ($clusterI !== $clusterJ) { // jika tidak membandingkan cluster yang sama
                        $r = ($sswI + $sswJ) / $ssbs[$clusterI][$clusterJ]; // maka hitung dengan rumus (nilai ssw cluster 1 + nilai ssw cluster 2 / nilai ssb cluster 1 dan 2)
                        if ($r > $maxR) { // jika nilai perhitungan ratio lebih besar dari nilai $maxR
                            $maxR = $r; // maka perbarui nilai $maxR dengan nilai baru yang lebih besar
                        }
                    }
                }
                $ratios[$clusterI] = $maxR; // masukkan nilai $maxR kedalam variabel $ratios
            }
    
            // 6. Hitung nilai DBI
            $dbi = collect($ratios)->avg(); // menghitung rata2 max ratio
    
            return view('pages.dbi', compact('data', 'centroids', 'distances', 'ssws', 'ssbs', 'ratios', 'dbi'));

        } else {

            return view('pages.dbi', compact('data'));
            
        }
    }