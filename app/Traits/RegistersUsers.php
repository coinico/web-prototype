<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers as BaseRegistersUsers;
use Bestmomo\LaravelEmailConfirmation\Notifications\ConfirmEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\DetectsApplicationNamespace;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;

trait RegistersUsers
{
    use BaseRegistersUsers, DetectsApplicationNamespace;

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        $user->confirmed = true;
        $user->valid = true;
        $user->confirmation_code = str_random(30);
        $user->save();

        $ethWallet = UserWallet::create(
            [
                'user_id' => $user->id,
                'crypto_currency' => 1,
            ]
        );

        UserWalletTransaction::create(
            [
                'address_from' => '0x',
                'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                'amount' => 100,
                'type' => 'credit',
                'memo' => 'Depósito inicial.',
                'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                'transaction_fee' => 0.0002,
                'total' => 100.0002,
                'user_wallet' => $ethWallet->id,
            ]
        );

        $ctfWallet = UserWallet::create(
            [
                'user_id' => $user->id,
                'crypto_currency' => 2,
            ]
        );

        UserWalletTransaction::create(
            [
                'address_from' => '0x',
                'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                'amount' => 10000,
                'type' => 'credit',
                'memo' => 'Depósito inicial.',
                'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                'transaction_fee' => 0.02,
                'total' => 10000.02,
                'user_wallet' => $ctfWallet->id,
            ]
        );

        $properties = array(
            array(
                'title' => 'Propiedad de '.$user->name,
                'user_id' => $user->id,
                'status_id' => 1,
                'description' => 'Hermosa casa de 4 ambientes con jardín delantero y trasero. La casa cuenta con un living comedor al frente, muy amplio y cómodo, con pisos cerámicos, calefactor tiro balanceado y gran ventanal a la calle que le otorga mucha luminosidad a este ambiente. La cocina es alargada y se encuentra totalmente azulejada, tiene amplia mesada e importante lugar de guardado en bajo mesada, y lavadero separado; además en la cocina nos encontramos con una entrada de servicio. Los dos dormitorios poseen pisos de parquet y placard de tres hojas con baulera, uno de ellos es a la calle y tiene salida al balcón, mientras que el otro está orientado al contra frente. El baño principal es completo y, tanto el baño principal como el toilette de recepción están totalmente revestidos en cerámicos.',
                'detail' => '',
                'images' => '9.jpg',
                'value' => '250000',
                'city' => "Chascomús, Buenos Aires, ARG",
                'location' => '{"lat":-35.5861403,"lng":-58.0839176}',
                'bidding_time' => '',
                'features' => '',
                'created_at' => new \DateTime()
            )

        );
        DB::table('properties')->insert($properties);

        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect(route('panel'));
    }

    /**
     * Handle a confirmation request
     *
     * @param  integer $id
     * @param  string  $confirmation_code
     * @return \Illuminate\Http\Response
     */
    public function confirm($id, $confirmation_code)
    {
        $model = config('auth.providers.users.model');

        $user = $model::whereId($id)->whereConfirmationCode($confirmation_code)->firstOrFail();
        $user->confirmation_code = null;
        $user->confirmed = true;
        $user->save();

        return redirect(route('login'))->with('confirmation-success', trans('confirmation::confirmation.success'));
    }

    /**
     * Handle a resend request
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->session()->has('user_id')) {

            $model = config('auth.providers.users.model');

            $user = $model::findOrFail($request->session()->get('user_id'));

            $this->notifyUser($user);

            return redirect(route('login'))->with('confirmation-success', trans('confirmation::confirmation.resend'));
        }

        return redirect('/');
    }

    /**
     * Notify user with email
     *
     * @param  Model $user
     * @return void
     */
    protected function notifyUser($user)
    {
        /*$class = $this->getAppNamespace() . 'Notifications\ConfirmEmail';

        if (!class_exists($class)) {
            $class = ConfirmEmail::class;
        }

        $user->notify(new $class);*/
    }
}
