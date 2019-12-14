@extends('layouts/app')

@section('content')
<div class="search-bar-wrapper container">
    <form class="form-inline d-flex" methpod="GET" action="/wishlist/search">
        <input type="text" class="form-control mb-2 mr-sm-2 flex-grow-1" id="name" name="name" placeholder="Jane Doe">
        <button type="submit" class="btn btn-primary mb-2">Search</button>
    </form>
</div>
<div class="wishlists-wrapper container">
    <div class="row">
        @foreach($users as $user)
        <div class="wishlist col-sm-4 col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$user->name}}</h5>
                    <ul class="card-text">
                        @foreach(array_slice($user->wishes->toArray(),0,3) as $wish)
                            <li class='wish'>{{$wish['name']}}</li>
                        @endforeach
                    </ul>
                    <a href="/wishlist/{{$user->id}}" class="card-link">See More...</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection