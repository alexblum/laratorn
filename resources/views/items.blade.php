@extends('layouts.app')

@section('title', 'Items')

@section('content')
    <form action="/items" method="post">
        {{ csrf_field() }}
        <div class="field">
            <div class="control">
                <input class="input" type="text" name="searchQuery" value="{{ $searchQuery }}" placeholder="Item name">
            </div>
        </div>
    </form>

    <div id="items-container">
        <table class="table is-hoverable is-striped" id="items">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Type</th>
                <th>Buy price</th>
                <th>Sell price</th>
                <th>Market value</th>
                <th>Circulation</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ str_limit(strip_tags($item->description), 160) }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->buy_price }}</td>
                <td>{{ $item->sell_price }}</td>
                <td>{{ $item->market_value }}</td>
                <td>{{ $item->circulation }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
