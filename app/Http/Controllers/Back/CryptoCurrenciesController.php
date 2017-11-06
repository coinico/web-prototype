<?php

namespace App\Http\Controllers\Back;

use App\ {
    Models\CryptoCurrency,
    Http\Controllers\Controller,
    Http\Requests\CryptoCurrencyRequest
};

class CryptoCurrenciesController extends Controller
{
    use Indexable;

    /**
     * Create a new CryptoCurrenciesController instance.
     */
    public function __construct()
    {
        $this->table = 'crypto_currencies';
    }


    public function create()
    {

        return view('back.crypto_currencies.create', compact('status'));
    }

    public function store(CryptoCurrencyRequest $request)
    {
        CryptoCurrency::create($request->all());

        return redirect(route('properties.index'))->with('property-ok', __('La propiedad fue creada con éxito.'));
    }

    public function show(CryptoCurrency $cryptoCurrency)
    {
        return view('back.crypto_currencies.show', compact('cryptoCurrency'));
    }

    public function edit(CryptoCurrency $cryptoCurrency)
    {

        return view('back.crypto_currencies.edit', compact('cryptoCurrency'));
    }

    public function update(CryptoCurrencyRequest $request, CryptoCurrency $cryptoCurrency)
    {

        $cryptoCurrency->update($request->all());

        return back()->with('crypto_currency-ok', __('La crypto moneda fue actualizada con éxito.'));
    }

    public function destroy(CryptoCurrency $cryptoCurrency)
    {

        $cryptoCurrency->delete ();

        return response ()->json ();
    }
}
