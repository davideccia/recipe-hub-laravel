<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\MediaDeleteRequest;
use App\Http\Requests\Media\MediaShowRequest;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function show(MediaShowRequest $request, Media $media): Media
    {
        return $media;
    }

    public function destroy(MediaDeleteRequest $request, Media $media): JsonResponse
    {
        $media->delete();

        return response()->json(status: 204);
    }
}
