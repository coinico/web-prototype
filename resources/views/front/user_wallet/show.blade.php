@extends('front.layout')

@section('main')

<div class = 'container'>
    <h1>
        Show userwallet
    </h1>
    <form method = 'get' action = '{!!url("userWallet")!!}'>
        <button class = 'btn blue'>userwallet Index</button>
    </form>
    <table class = 'highlight bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b><i>balance : </i></b>
                </td>
                <td>{!!$userWallet->balance!!}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection