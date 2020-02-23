@extends('layouts/app')

@section('content')
<div class='container'>
        <div class="header d-flex flex-row justify-content-between mb-4">
            <h2>
                {{$user->name}}
            </h2>

            @if ($user->id == auth()->id())
            <a href='/wish/new'><button class="btn btn-primary">New</button></a>
            @else
            @if ($user->is_friend)
            <button class="btn btn-danger" onclick="unfriend({{$user->id}})">Unfriend</button>
            @else
            <button class="btn btn-primary" onclick="friend({{$user->id}})">Friend</button>
            @endif
            @endif
        </div>
        <table class="table table-hover table-bordered">
            <thead class="border-dark">
                <tr class="border-dark">
                    <th scope='col' class="border-dark">Name</th>
                    <th scope='col' class="border-dark">Description</th>
                    <th scope='col' class="border-dark">Desire</th>
                    <th scope='col' class="border-dark">Price CAD</th>
                    <th scope='col' class="border-dark">Where to buy</th>
                    @auth
                    @if ($user->id == auth()->id())
                    <th scope='col' class="border-dark">Delete?</th>
                    @else
                    <th scope='col' class="border-dark">Purchased?</th>
                    @endif
                    @endauth
                </tr>
            </thead>

            <tbody>
                @foreach($user->wishes as $wish)
                @if (auth()->check() && $wish->purchased_by != null && $wish->user_id != auth()->id())
                <tr class='purchased border-dark'>
                    @else
                <tr class="border-dark">
                    @endif
                    <td class="border-dark">{{$wish->name}}</td>
                    <td class="border-dark">{{$wish->description}}</td>
                    <td class="border-dark">{{$wish->desire}}</td>
                    <td class="border-dark">{{$wish->price}}</td>
                    @if ($wish->is_url)
                    <td class="border-dark"><a href="{{$wish->where_to_buy}}">Link</a></td>
                    @else
                    <td class="border-dark">{{$wish->where_to_buy}}</td>
                    @endif

                    @auth
                    @if ($user->id == auth()->id())
                    <td class="border-dark"><button class="btn btn-sm btn-danger" onclick="deleteWish({{$wish->id}})">Delete</button></td>
                    @elseif ($wish->purchased_by == auth()->id())
                    <td class="border-dark"><button class='btn btn-sm btn-danger' onclick="unpurchaseWish({{$wish->id}})">Unpurchase</button></td>
                    @elseif ($wish->purchased_by == null)
                    <td class="border-dark"><button class='btn btn-sm btn-primary' onclick="purchaseWish({{$wish->id}})">Mark as purchased</button></td>
                    @else
                    <td class="border-dark">Wish granted already!</td>
                    @endif
                    @endauth
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endsection

@section('js')
<script src='{{ asset("js/show.js") }}'></script>
@endsection