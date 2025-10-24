<?php

namespace App\Http\Requests\Recipe;

use App\Http\Requests\Media\AddMediaToResourceRequest;
use Illuminate\Support\Facades\Auth;

class AddImagesRequest extends AddMediaToResourceRequest
{
    public function authorize(): bool
    {
        return Auth::hasUser();
    }
}
