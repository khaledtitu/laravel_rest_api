<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\CarRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Resources\CarResource;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        $cars = Car::with('user')->get();
        return CarResource::collection($cars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(CarRequest $request)
    {
        try {
            $car = new Car;
            $car->fill($request->validated())->save();
            return new CarResource($car);

        } catch (\Throwable $th) {
            throw new HttpException(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(CarRequest $request, $id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->fill($request->validated())->save();
            return new CarResource($car);
        } catch (\Throwable $th) {
            throw new HttpException(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Car $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        try { 
            $car->delete();
            return response($car,JsonResponse::HTTP_NO_CONTENT);
        }catch (\Throwable $th) {
            throw new HttpException(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $th->getMessage());
        }
    }
}
