<?php

namespace App\Services\Export\Recipe;

use App\Models\Recipe;
use App\Services\Export\PdfExport;
use Barryvdh\DomPDF\Facade\Pdf;

class RecipePdfExport extends PdfExport
{

    public function __construct(private Recipe $recipe)
    {
        $this->filename = \Str::slug($this->recipe->title) . '.pdf';
        parent::__construct();
    }

    public static function init(Recipe $recipe): static
    {
        return new static($recipe);
    }

    public function pdf(): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('dompdf.recipes.recipe_export_pdf', [
            'recipe' => $this->recipe->loadMissing(['ingredients', 'images']),
        ]);
    }
}
