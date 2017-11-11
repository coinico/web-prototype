<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers as BaseRegistersUsers;
use Bestmomo\LaravelEmailConfirmation\Notifications\ConfirmEmail;
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
