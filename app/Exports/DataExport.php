<?php

namespace App\Exports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DataExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Data::select('id', 'nis', 'nama', 'kelas', 'sbd', 'ips', 'ipa', 'bing', 'mat', 'pa', 'pjok', 'pra', 'bind', 'pkn', 'cluster')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama',
            'Kelas',
            'SBD',
            'IPS',
            'IPA',
            'BING',
            'MAT',
            'PA',
            'PJOK',
            'PRA',
            'BIND',
            'PKN',
            'Cluster',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->nis,
            $row->nama,
            $row->kelas,
            $row->sbd,
            $row->ips,
            (string) $row->ipa,
            $row->bing,
            $row->mat,
            $row->pa,
            $row->pjok,
            $row->pra,
            $row->bind,
            $row->pkn,
            (string) $row->cluster,
        ];
    }
}
