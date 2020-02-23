@extends('layouts/app')

@section('content')

<div class="header">
    <h3 class="text-center">
        Make A Wish!
    </h3>
    <p class="text-center">Is there something you have wanted to have for yourself? Let your friends and family know by adding it to your wish list.</p>
</div>

<form method="POST" action="/wish">
    @csrf

    <div class="form-group row">
        <label for="email" class="col-sm-4 col-form-label text-md-right">Name</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
            <small>100 characters max</small>

            @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-4 col-form-label text-md-right">Description</label>

        <div class="col-md-6">
            <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>{{{ old('description') }}}</textarea>
            <small>200 characters max</small>

            @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-4 col-form-label text-md-right">Desire (1-10)</label>

        <div class="col-md-6">
            <input id="desire" type="number" min="1" max="10" step="1" class="form-control{{ $errors->has('desire') ? ' is-invalid' : '' }}" name="desire" value="{{ old('desire') }}" required>

            @if ($errors->has('desire'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('desire') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="price" class="col-sm-4 col-form-label text-md-right">Price</label>

        <div class="col-md-6">
            <input id="price" type="number" min="0" step="0.01" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price') }}">

            @if ($errors->has('price'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-4 col-form-label text-md-right">Where To Buy</label>

        <div class="col-md-6">
            <input id="url" type="text" class="form-control{{ $errors->has('where_to_buy') ? ' is-invalid' : '' }}" name="where_to_buy" value="{{ old('where_to_buy') }}">
            <small>Is this a URL? <input type="checkbox" name="is_url" id="is_url" checked="checked"></small>

            @if ($errors->has('where_to_buy'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('where_to_buy') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </div>


</form>

@endsection
