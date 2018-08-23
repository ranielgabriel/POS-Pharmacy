@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventories</h1>
    @foreach ($inventories as $inventory)
        {{ $inventory }}
    @endforeach
</div>
{{ $inventories->links() }}
@endsection()