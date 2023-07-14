<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $clients = Client::all();

        $sortBy = $request->sort_by ?? '';
        $orderBy = $request->order_by ?? '';
        if ($orderBy && !in_array($orderBy, ['asc', 'desc'])) {
            $orderBy = '';
        }
        $filterBy = $request->filter_by ?? '';
        $filterValue = $request->filter_value ?? '0';
        $perPage = (int) $request->per_page ?? 5;
        $perPage = $perPage == 0 ? 5 : $perPage;
        
        if ($request->s) {

            $clients = Client::where('lname', 'like', '%'.$request->s.'%')->paginate($perPage)->withQueryString();
        
        } else {
        
            // $clients = Client::all();
            $clients = Client::where('lname','like','%');

            //filtravimas
            $clients = match($filterBy) {
                'lname' => $clients->where('lname', '=', $filterValue),
                default => $clients
            };

            //rikiavimas
            $clients = match($sortBy) {
                'lname' => $clients->orderBy('lname', $orderBy),
                // 'rate' => $clients->orderBy('rate', $orderBy),
                default => $clients
            };

            // $clients = $clients->get();
            $clients = $clients->paginate($perPage)->withQueryString();

        }




        return view('clients.index', 
        [
            'clients' => $clients,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
            'filterBy' => $filterBy,
            'filterValue' => $filterValue,
            'perPage' => $perPage,
            's' => $request->s ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
