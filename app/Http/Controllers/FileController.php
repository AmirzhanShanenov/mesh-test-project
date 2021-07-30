<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExcelRequest;
use App\Jobs\InsertFromExcelJob;
use App\traits\ApiResponser;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;


class FileController extends Controller
{
    use ApiResponser;

    public function importToRow(StoreExcelRequest $request)
    {
//        try {
            $request->validated();
            $upload_folder = 'public';
            $filename = $request->file('file')->getClientOriginalName();
            $path = Storage::putFileAs($upload_folder, $request->file('file'), $filename);
            // read spreadsheet
            $spreadsheet = IOFactory::load(storage_path('app/' . $path));
            $worksheet = $spreadsheet->getActiveSheet();
            $data = array_map('array_filter', $worksheet->toArray());
            $data = array_filter($data);
            Redis::set($filename, count($data));
            $chunkedArray = array_chunk($data, 1000);
//            unlink(storage_path($path));
            unset($chunkedArray[0]);
            foreach ($chunkedArray as $array) {
                InsertFromExcelJob::dispatch($array);
            }
            return $this->successResponse('Success uploading file');
//        } catch (\Exception $error) {
////            return $this->errorResponse('Unexpected Error. Try Later', 500);
//            return $this->errorResponse($error->getMessage(), 500);
//        }
    }

}
