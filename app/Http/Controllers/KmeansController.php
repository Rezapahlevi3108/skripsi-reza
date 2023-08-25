<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use App\Models\OptionCluster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KmeansController extends Controller
{
    public function optionCluster(){
        return view('pages.option-cluster');
    }

    public function setCluster(Request $request)
    {
        $data = new OptionCluster();
        $data->clusters = $request->clusters;
        $data->save();
        return $this->kmeans($request);
    }

    public function showKmeans()
    {
        $results = DB::table('data')->get();
        if ($results->count() > 0 && $results->where('cluster', '!=', 0)->count() > 0) {
            $kmeansData = session('kmeans_data', []);
        
            if ($kmeansData) {
                $data = $kmeansData['data'];
                $results = $kmeansData['results'];
                $clusterCounts = $kmeansData['clusterCounts'];
                $distances = $kmeansData['distances'];
                $clusters = $kmeansData['clusters'];
                $k = $kmeansData['k'];
                $iterations = $kmeansData['iterations'];

                return view('pages.kmeans', compact('data', 'results', 'clusterCounts', 'distances', 'clusters', 'k', 'iterations'));
            }
        } else {
            return view('pages.kmeans', compact('results'));
        }  
    }

    public function kmeans(Request $request)
    {
        $option = OptionCluster::all()->sortByDesc('id')->first();
        $k = $option->clusters;
        $iterations = 100;

        $data = Data::all();
        $n = count($data);
        $distances = array();
        $clusters = array();
        $centroid = array();

        $randomIndexes = range(0, $n - 1);
        shuffle($randomIndexes);

        // Centroid awal
        for ($i = 0; $i < $k; $i++) { 
            $centroid[$i] = $data[$randomIndexes[$i]]->toArray();
        }

        $prevCentroid = array();

        // Perhitungan per iterasi
        for ($i = 0; $i < $iterations; $i++) {
            $distance_per_iteration = array();
            $cluster_per_iteration = array();

            foreach ($data as $key => $row) {
                $minDistance = INF;
                $cluster_per_row = array();
                $distance_per_row = array();

                // Perhitungan per baris
                for ($j = 0; $j < $k; $j++) {
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
                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $row->cluster = $j + 1;
                    }
                    $distance_per_row[$j] = $distance;
                    $cluster_per_row = $row->cluster;
                }

                $distance_per_iteration[$key] = $distance_per_row;
                $cluster_per_iteration[$key] = $cluster_per_row;
                $row->save();
            }

            // Perhitungan centroid tiap iterasi
            for ($j = 0; $j < $k; $j++) {
                $data_cluster = Data::where('cluster', $j+1)->get();

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

            $distances[$i] = $distance_per_iteration;
            $clusters[$i] = $cluster_per_iteration;

            if ($centroid === $prevCentroid) {
                break;
            }

            $prevCentroid = $centroid;
        }

        $results = DB::table('data')->orderBy('cluster')->get();
        $clusterCounts = $results->groupBy('cluster')->map->count();

        session(['kmeans_data' => [
            'data' => $data,
            'results' => $results,
            'clusterCounts' => $clusterCounts,
            'distances' => $distances,
            'clusters' => $clusters,
            'k' => $k,
            'iterations' => $iterations
        ]]);

        return view('pages.kmeans', compact('data', 'results', 'clusterCounts', 'distances', 'clusters', 'k', 'iterations'));
    }

    public function dbi()
    {
        $data = DB::table('data')->orderBy('cluster')->get();

        if ($data->count() > 0 && $data->where('cluster', '!=', 0)->count() > 0) {

            // Hitung centroid dari setiap klaster
            $centroids = $data->groupBy('cluster')->map(function ($group) {
                return [
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
    
            // Hitung jarak setiap data ke masing-masing klaster
            $distances = $data->map(function ($item) use ($centroids) {
                $centroid = $centroids[$item->cluster];
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
                    'cluster' => $item->cluster,
                    'distance' => $distance,
                ];
            });
        
            // Hitung SSW untuk setiap klaster
            $ssws = $distances->groupBy('cluster')->map(function ($group) use ($data) {
                return $group->avg('distance');
            });
    
            // Hitung SSB
            $ssbs = [];
            foreach ($centroids as $clusterI => $centroidI) {
                $ssbs[$clusterI] = [];
                foreach ($centroids as $clusterJ => $centroidJ) {
                    if ($clusterI !== $clusterJ) {
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
                        $ssbs[$clusterI][$clusterJ] = $distance;
                    } else {
                        $ssbs[$clusterI][$clusterJ] = 0;
                    }
                }
            }
    
            // Hitung max rasio
            $ratios = [];
            foreach ($ssws as $clusterI => $sswI) {
                $maxR = 0;
                foreach ($ssws as $clusterJ => $sswJ) {
                    if ($clusterI !== $clusterJ) {
                        $r = ($sswI + $sswJ) / $ssbs[$clusterI][$clusterJ];
                        if ($r > $maxR) {
                            $maxR = $r;
                        }
                    }
                }
                $ratios[$clusterI] = $maxR;
            }
    
            // Hitung nilai DBI
            $dbi = collect($ratios)->avg();
    
            return view('pages.dbi', compact('data', 'centroids', 'distances', 'ssws', 'ssbs', 'ratios', 'dbi'));

        } else {

            return view('pages.dbi', compact('data'));
            
        }
    }

    public function perhitunganView(){
        return view('pages.perhitungan');
    }

    public function perhitungan(Request $request)
    {
        $bilangan1 = $request->satu;
        $bilangan2 = $request->dua;
        echo $bilangan1 + $bilangan2;
    }
}
