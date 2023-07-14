@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bank Statistics</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Total nb. of clients: {{$clients->count()}}</h3>
                    <h3>Total nb. of accounts: {{$accounts->count()}}</h3>
                    <h3>Total ammount in bank: {{$accounts->sum('balance')}} €</h3>
                    <h3>Biggest ammount in account: {{$accounts->max('balance')}} €</h3>
                    <h3>Smallest ammount in account: {{$accounts->min('balance')}} €</h3>
                    <h3>Average ammount in account: {{round($accounts->avg('balance'),2)}} €</h3>
                    <h3>Total nb. of accounts with 0 balance: {{$accounts->where('balance', 0)->count()}}</h3>
                    <h3>Total nb. of accounts with negative balance: {{$accounts->where('balance','<', 0)->count()}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
