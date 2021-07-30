<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function publicUserCanUseExcelMethod()
    {
        $this->withoutExceptionHandling();
        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile(storage_path('templates/test.xls'),'test.xls', 'xls', null, true);
        $response = $this->post('/api/rows/import', [
            'file' => $file,
        ]);
        dump($response->json());
//        $response->assertOk();
    }
}
