<?php

namespace App\Jobs;

use App\Models\Row;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertFromExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $array;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = array_map(function ($tag) {
            return [
                'uuid' => $tag[0],
                'name' => $tag[1],
                'date' => $tag[2]
            ];
        }, $this->array);

        Row::insert($data);


    }

}
