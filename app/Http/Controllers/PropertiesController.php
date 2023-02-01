<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Resources\PropertiesResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PropertiesResource::collection(Property::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePropertyRequest $request)
    {
        $request->validated();
        $property = Property::create([
            'broker_id' => $request->broker_id,
            'address' => $request->address,
            'listing_type' => $request->listing_type,
            'city' => $request->city,
            'description' => $request->description
        ]);

        $property->characteristic()->create([
            'property_id' => $property->id,
            'price' => $request->price,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'sqft' => $request->sqft,
            'price_sqft' => $request->price_sqft,
            'property_type' => $request->property_type,
            'status' => $request->status
        ]);


        return new PropertiesResource($property);
    }

    /**
     * Display the specified resource.
     *
     * @param Property $property
     * @return Response
     */
    public function show(Property $property)
    {
        return  new PropertiesResource($property);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        $property->update($request->only([
            'broker_id', 'address', 'listing_type', 'city', 'description'
        ]));

        $property->characteristic()
            ->where('property_id', $property->id)
            ->update($request->only([
            'property_id', 'price', 'bedrooms', 'bathrooms', 'sqft', 'price_sqft', 'property_type','status'
        ]));

        return  new PropertiesResource($property);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return  response()->json([
           'success' => true,
           'message' => "Property successfully deleted from database"
        ]);
    }
}
