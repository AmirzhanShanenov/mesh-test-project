<?php

namespace App\Imports;

use App\Models\Row;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class RowImport implements ToModel
{
    use Importable;

    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required|string',
            '2' => 'required|date_format:"d.m.y"',

        ];
    }

    public function model(array $row)
    {
         Row::create([
            'uuid' => $row[0],
            'name' => $row[1],
            'date' => $row[2],
        ]);
    }
}
