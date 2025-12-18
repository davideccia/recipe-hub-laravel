<?php

namespace App\Services\Export;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\AwsS3V3Adapter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

abstract class PdfExport
{
    protected AwsS3V3Adapter|Filesystem $storage;
    protected string $fullPath;
    protected string $filename;

    public function __construct()
    {
        $this->storage = \Storage::disk('local');
        $this->fullPath = $this->storage->path("dompdf/{$this->filename}");
    }

    abstract public function pdf(): \Barryvdh\DomPDF\PDF;

    public function download(): BinaryFileResponse
    {
        $this->pdf()->save($this->fullPath);

        return response()->download($this->fullPath, $this->filename)->deleteFileAfterSend();
    }
}
