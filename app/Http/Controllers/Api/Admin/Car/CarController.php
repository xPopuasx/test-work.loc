<?php

namespace App\Http\Controllers\Api\Admin\Car;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Car\GetCarsRequest;
use App\Http\Requests\Api\Admin\Car\StoreCarRequest;
use App\Http\Requests\Api\Admin\Car\UpdateCarRequest;
use App\Http\Resources\Api\Car\CarResource;
use App\Http\Resources\Api\Car\CarCollection;
use App\Http\Resources\Api\User\UserResource;
use App\Models\Car\Car;
use App\Models\User\User;
use App\Services\Car\CarService;
use Exception;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

/**
 * @group User management
 */
class CarController extends Controller
{
    public function __construct(private CarService $carService)
    {
    }

    /**
     * @apiResourceCollection App\Http\Resources\Api\Car\CarCollection
     * @apiResourceModel App\Models\Car\Car paginate=10
     * @param  GetCarsRequest  $request
     * @return CarCollection
     */
    #[Endpoint('show cars')]
    public function index(GetCarsRequest $request): CarCollection
    {
        $list = $this->carService->getWithPaginate($request->validated(), null);
        $list->load(['tenant']);

        return new CarCollection($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCarRequest  $request
     * @return CarResource
     *
     * @throws Exception
     */
    #[ResponseFromApiResource(CarResource::class, Car::class)]
    #[Endpoint('store car')]
    public function store(StoreCarRequest $request): CarResource
    {
        $car = $this->carService->create($request->validated(), null);
        $car->load(['tenant']);

        return new CarResource($car);
    }

    /**
     * Display the specified resource.
     *
     * @param  Car $car
     * @return CarResource
     */
    #[ResponseFromApiResource(CarResource::class, Car::class)]
    #[Endpoint('show car')]
    public function show(Car $car): CarResource
    {
        $car->load(['tenant']);

        return new CarResource($car);
    }

    /**
     * @param  UpdateCarRequest  $request
     * @param  Car $car
     * @return CarResource
     *
     * @throws Exception
     */
    #[ResponseFromApiResource(CarResource::class, Car::class)]
    #[Endpoint('update car')]
    public function update(UpdateCarRequest $request, Car $car): CarResource
    {
        $car = $this->carService->update($car, $request->validated());
        $car->load(['tenant']);

        return new CarResource($car);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Car  $car
     * @return JsonResponse
     */
    #[Response(['ok'], 200)]
    #[Endpoint('delete car')]
    public function destroy(Car $car): JsonResponse
    {
        $this->carService->delete($car);

        return response()->json('ok');
    }
}
