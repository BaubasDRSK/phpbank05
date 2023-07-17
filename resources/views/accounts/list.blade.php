@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Select recievers account:</h2>
                    <ul class="list-group list-group-flush">
                        @forelse($accounts as $acc)
                        <li class="list-group-item">
                            <div class="col-12 d-flex justify-content-between">
                                <div><h4 class="fw-bold">{{$acc->iban}}</h4> Balance: <span class="fw-bold text-danger">{{$acc->balance}} €</span> / Client: <span class="fw-bold text-success">{{$acc->client->fname}} {{$acc->client->lname}} </span></div>
                                <div>
                                    <form action="{{route('account-transfare', [$account, $acc->id])}}" method="get">
                                        <button class="btn btn-success" type="submit">Select</button>
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">
                            <p class="text-center">No accounts</p>
                        </li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
