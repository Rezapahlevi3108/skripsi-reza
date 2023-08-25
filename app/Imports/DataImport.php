<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Data([
            'nis' => $row['nis'],
            'nama' => $row['nama'],
            'kelas' => $row['kelas'],
            'sbd' => $row['sbd'],
            'ips' => $row['ips'],
            'ipa' => $row['ipa'],
            'bing' => $row['bing'],
            'mat' => $row['mat'],
            'pa' => $row['pa'],
            'pjok' => $row['pjok'],
            'pra' => $row['pra'],
            'bind' => $row['bind'],
            'pkn' => $row['pkn'],
            'cluster' => 0,
        ]);
    }
}
