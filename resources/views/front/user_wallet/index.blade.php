@extends('front.layout')

@section('main')

<div class = 'container'>
    <h1>
        userwallet Index
    </h1>
    <div class="row">
        <form class = 'col s3' method = 'get' action = '{!!url("userWallet")!!}/create'>
            <button class = 'btn red' type = 'submit'>Create New userwallet</button>
        </form>
    </div>
    <table>
        <thead>
            <th>balance</th>
            <th>actions</th>
        </thead>
        <tbody>
            @foreach($userWallets as $userWallet)
            <tr>
                <td>{!!$userWallet->balance!!}</td>
                <td>
                    <div class = 'row'>
                        <a href = 'userWallet/{!!$userWallet->id!!}/deleteMsg" ><i class = 'material-icons'>delete</i></a>
                        <a href = 'userWallet/{!!$userWallet->id!!}/edit'><i class = 'material-icons'>edit</i></a>
                        <a href = 'userWallet/{!!$userWallet->id!!}'><i class = 'material-icons'>info</i></a>
                    </div>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $userWallets->render() !!}

</div>
@endsection