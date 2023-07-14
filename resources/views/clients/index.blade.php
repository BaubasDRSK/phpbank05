@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Clients List</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($clients as $client)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="d-flex">
                                        <div class="ms-2">
                                            <div>{{$client->fname}} {{$client->lname}} / Total accounts [{{$client->accounts()->count()}}] / Total balance [{{$client->accounts()->sum('balance')}}]</div>

                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-success" href="" >
                                        {{-- {{route('authors-edit', $author)}} --}}
                                        Edit
                                    </a>
                                    <a class="btn btn-danger" href="" >
                                        {{-- {{route('authors-delete', $author)}} --}}
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">
                            <p class="text-center">No clients</p>
                        </li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $clients->links() }}</div>
</div>
@endsection
