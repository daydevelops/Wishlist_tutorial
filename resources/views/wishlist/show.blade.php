@extends('layouts/app')

@section('content')

<div class="header d-flex flex-row justify-content-between mb-4">
    <h2>
        {{$user->name}}
    </h2>
    <a href='/wish/new'><button class="btn btn-primary">New</button></a>
</div>
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th scope='col'>Name</th>
            <th scope='col'>Description</th>
            <th scope='col'>Desire</th>
            <th scope='col'>Price CAD</th>
            <th scope='col'>Where to buy</th>
            @auth
                @if ($user->id == auth()->id())
                    <th scope='col'>Delete?</th>
                @else
                    <th scope='col'>Purchased?</th>
                @endif
            @endauth
        </tr>
    </thead>

    <tbody>
        @foreach($user->wishes as $wish)
            @if (auth()->check() && $wish->purchased_by != null && $wish->user_id != auth()->id())
                <tr class='purchased'>
            @else
                <tr>
            @endif
                <td>{{$wish->name}}</td>
                <td>{{$wish->description}}</td>
                <td>{{$wish->desire}}</td>
                <td>{{$wish->price}}</td>
                <td>{{$wish->url}}</td>
                @auth
                    @if ($user->id == auth()->id())
                        <td><button class="btn btn-sm btn-danger" onclick="deleteWish({{$wish->id}})">Delete</button></td>
                    @elseif ($wish->purchased_by == auth()->id())
                        <td><button class='btn btn-sm btn-danger' onclick="unpurchaseWish({{$wish->id}})">Unpurchase</button></td>
                    @elseif ($wish->purchased_by == null)
                        <td><button class='btn btn-sm btn-primary' onclick="purchaseWish({{$wish->id}})">Mark as purchased</button></td>
                    @else 
                        <td>Wish granted already!</td>
                    @endif
                @endauth
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('js')
	<script src='{{ asset("js/show.js") }}'></script>
@endsection