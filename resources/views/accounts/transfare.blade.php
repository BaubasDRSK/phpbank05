@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Funds transfare</h5>

                    <div class="container">
                        <div class="row justify-content-center">
                            <form class='col-4' action="{{route('account-execute', ['account'=>$account, 'account2'=>$account2])}}" method="post" class="login-form">
                                <h4 class="main-h">Please fill transfare details</h4>

                                    <div class="input mb-4">
                                        <label class="mr-3" for="fname">Transfare from</label>
                                        <p class="mr-3">Owner: {{$account->client->fname}} {{$account->client->lname}}</p>
                                        <p class="mr-3">Curent balance: {{$account->balance}}</p>
                                        <p class="form-control">{{$account->iban}} </p>
                                    </div>

                                    <div class="input mb-4">
                                        <label  class="mr-3" for="iban2">Transfare to:</label>
                                        <p class="mr-3">Owner: {{$account2->client->fname}} {{$account->client->lname}}</p>
                                        <p class="mr-3">Curent balance: {{$account2->balance}}</p>
                                        <p class="form-control">{{$account2->iban}} </p>
                                    </div>

                                    <div class="input mb-4">
                                        <label  class="mr-3" for="amount">Transfare amount:</label>
                                        {{-- <img src="/img/person.svg" alt="lname"> --}}
                                        <input  class="form-control" type="number" step='0.01' name="amount" id="amount" placeholder="Enter amount to transfare"  required>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Transfare</button>
                                    <a class="btn btn-warning" href="{{route('client-edit',[$account->client->id, 1])}}" class="btn-red" >Cancel / Close</a>
                                    @csrf
                                </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


