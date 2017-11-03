<?php

namespace App\Http\Controllers\Back;

use App\ {
    Http\Requests\PropertyRequest,
    Http\Controllers\Controller,
    Models\Category,
    Models\Property,
    Repositories\PropertyRepository
};
use GuzzleHttp\Client;

class PropertyController extends Controller
{
    use Indexable;

    /**
     * Create a new PropertyController instance.
     *
     * @param  \App\Repositories\PropertyRepository $repository
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;

        $this->table = 'properties';
    }

    /**
     * Update "new" field for property.
     *
     * @param  \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function updateSeen(Property $property)
    {
        $property->ingoing->delete ();

        return response ()->json ();
    }

    /**
     * Update "active" field for property.
     *
     * @param  \App\Models\Property $property
     * @param  bool $status
     * @return \Illuminate\Http\Response
     */
    public function updateActive(Property $property, $status = false)
    {
        $property->active = $status;
        $property->save();

        return response ()->json ();
    }

    /**
     * Show the form for creating a new property.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('title', 'id');

        return view('back.properties.create', compact('categories'));
    }

    /**
     * Store a newly created property in storage.
     *
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
        $this->repository->store($request);

        return redirect(route('properties.index'))->with('property-ok', __('The property has been successfully created'));
    }

    /**
     * Display the property.
     *
     * @param  \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return view('back.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the property.
     *
     * @param  \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        $this->authorize('manage', $property);

        $categories = Category::all()->pluck('title', 'id');

        return view('back.properties.edit', compact('property', 'categories'));
    }

    /**
     * Update the property in storage.
     *
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @param  \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyRequest $request, Property $property)
    {
        $this->authorize('manage', $property);

        $this->repository->update($property, $request);

        return back()->with('property-ok', __('The property has been successfully updated'));
    }

    /**
     * Remove the property from storage.
     *
     * @param Property $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        $this->authorize('manage', $property);

        $property->delete ();

        return response ()->json ();
    }


    /**
     * Display a listing of json markets.
     *
     * @return \Illuminate\Http\Response
     */
    public function markets()
    {
        $client = new Client();
        $res = $client->get('https://bittrex.com/api/v2.0/pub/Markets/GetMarketSummaries?_=1509478036773');
        $markets = json_decode($res->getBody(), true);

        $result = array();

        foreach ($markets['result'] as $market){

            if ($market['Summary']['Ask'] && $market['Summary']['Bid']) {
                $spread = 100 * ($market['Summary']['Ask'] - $market['Summary']['Bid']) / $market['Summary']['Ask'];
            } else {
                $spread = 0;
            }

            if($market['Summary']['PrevDay']){
                $change = ($market['Summary']['Last'] - $market['Summary']['PrevDay']) / $market['Summary']['PrevDay'] * 100;
            }else {
                $change = 0;
            }

            $changeString = "";
            $changeString .= number_format($change, 1);
            $changeString .= "%";

            $spreadString = "";
            $spreadString .= number_format($spread, 1);
            $spreadString .= "%";

            $result[$market['Market']['BaseCurrency']][] = [
                $market['Market']['MarketName'], //Market
                $market['Market']['MarketCurrencyLong'], //Currency
                number_format($market['Summary']['BaseVolume'], 3, '.', ','), //Volume
                $changeString,  //Change
                number_format($market['Summary']['Last'], 8, '.', ','), //Last price
                number_format($market['Summary']['High'], 8, '.', ','), //High
                number_format($market['Summary']['Low'], 8, '.', ','), //Low
                $spreadString,  //Spread
                date_format(date_create($market['Summary']['Created']),"d/m/Y")  //Added

            ];
        }
        if($res->getStatusCode() == 200){
            return response($result);
        }else{
            //@todo: Vista de error
        }
    }
}
