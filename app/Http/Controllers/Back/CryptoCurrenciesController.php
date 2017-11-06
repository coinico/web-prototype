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

    /**
     * Show the form for creating a new contact.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('back.crypto_currency');
    }

    /**
     * Store a newly created contact in storage.
     *
     * @param  CryptoCurrencyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CryptoCurrencyRequest $request)
    {
        CryptoCurrency::create ($request->all ());

        return back ()->with ('ok', __('La crypto currency ha sido creada con éxito.'));
    }
}
