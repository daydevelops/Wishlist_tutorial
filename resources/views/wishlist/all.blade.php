@extends('layouts/app')

@section('content')

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