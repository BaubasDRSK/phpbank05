@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add or withdraw funds:</h5>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div >
                                <h3 class="d-flex justify-content-center">{{$client->fname}} {{$client->lname}}</h3>
                                <h5 class="d-flex justify-content-center">IBAN: {{$account->iban}}</h5>
                                <h5 class="d-flex justify-content-center">Balance: {{$account->balance}}€</h5>
                            </div>
                            <form class='col-4' action="{{route('account-update', $account)}}" method="post" class="login-form">
                                <div class="input mb-4">
                                    <label class="mr3" for="amount">Amount</label>
                                    <input class="form-control" type="number" name="amount" min=0 step='0.01' id="amount" required>
                                </div>
                                <button class="btn btn-success" type="submit" name='add' value=1>+ Add to account</button>
                                <button class="btn btn-danger" type="submit" name='minus' value=1>- Withdraw</button>
                                <a class="btn btn-warning ms-4" href="{{route('client-edit',['client'=>$client, 'page'=>1])}}">Cancel</a>
                                
                                @method('put')
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