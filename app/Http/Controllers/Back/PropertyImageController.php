<?php

namespace App\Http\Controllers\Back;

use App\ {
    Http\Requests\PropertyRequest,
    Http\Controllers\Controller,
    Models\PropertyStatus,
    Models\Property,
    Repositories\PropertyRepository
};
use Illuminate\Http\Request;
use App\Models\PropertyImage;

class PropertyImageController extends Controller
{

    /**
     * Create a new PropertyController instance.
     *
     * @param  \App\Repositories\PropertyRepository $repository
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;

        $this->table = 'property_images';
    }


    public function index($id)
    {
        $property = Property::find($id);
        return view('properties.images.index')->with(compact('property'));
    }

    public function upload($id, Request $request)
    {
        $file = $request->file('file');
        $path = public_path() . '/images/properties/'. $id . '/' ;

        $fileName = uniqid() . $file->getClientOriginalName();

        $file->move($path, $fileName);

        $propertyImage = new PropertyImage();
        $propertyImage->property_id = $id;
        $propertyImage->user_id = auth()->user()->id;
        $propertyImage->file_name = $fileName;
        $propertyImage->save();

        return $propertyImage;
    }

}
