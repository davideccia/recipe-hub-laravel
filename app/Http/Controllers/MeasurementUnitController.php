<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeasurementUnit\MeasurementUnitDestroyRequest;
use App\Http\Requests\MeasurementUnit\MeasurementUnitIndexRequest;
use App\Http\Requests\MeasurementUnit\MeasurementUnitShowRequest;
use App\Http\Requests\MeasurementUnit\MeasurementUnitStoreRequest;
use App\Http\Requests\MeasurementUnit\MeasurementUnitUpdateRequest;
use App\Http\Resources\MeasurementUnitResource;
use App\Models\MeasurementUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementUnitController extends Controller
{
    public function index(MeasurementUnitIndexRequest $request): JsonResource
    {
        $validatedRequestInput = $request->validated();
        $measurementUnits = MeasurementUnit::query()->with($validatedRequestInput['with'] ?? []);

        if ($validatedRequestInput['paginate'] ?? false) {
            $measurementUnits = $measurementUnits->paginate($validatedRequestInput['per_page'] ?? 10, page: $validatedRequestInput['page'] ?? 1);
        } else {
            $measurementUnits = $measurementUnits->get();
        }

        return MeasurementUnitResource::collection($measurementUnits);
    }

    public function store(MeasurementUnitStoreRequest $request): MeasurementUnitResource
    {
        $validatedRequestInput = $request->validated();
        $measurementUnit = (new MeasurementUnit)->fill($validatedRequestInput);

        $measurementUnit->saveOrFail();

        return new MeasurementUnitResource($measurementUnit->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function show(MeasurementUnitShowRequest $request, MeasurementUnit $measurementUnit): MeasurementUnitResource
    {
        $validatedRequestInput = $request->validated();

        return new MeasurementUnitResource($measurementUnit->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function update(MeasurementUnitUpdateRequest $request, MeasurementUnit $measurementUnit): MeasurementUnitResource
    {
        $validatedRequestInput = $request->validated();
        $measurementUnit = $measurementUnit->fill($validatedRequestInput);

        $measurementUnit->saveOrFail();

        return new MeasurementUnitResource($measurementUnit->loadMissing($validatedRequestInput['with'] ?? []));
    }

    public function destroy(MeasurementUnitDestroyRequest $request, MeasurementUnit $measurementUnit): JsonResponse
    {
        $measurementUnit->delete();

        return response()->json(status: 204);
    }
}
