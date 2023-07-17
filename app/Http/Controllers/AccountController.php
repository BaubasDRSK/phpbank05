<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\MOdels\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $client = Client::find($request->client);

        $account = new Account;
        $account->client_id = $client->id;
        $account->iban = generateLithuanianIBAN();
        $account->balance = 0;
        $account->save();
        return redirect()->back()
        ->with('success', 'New account was added!');

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
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account, Client $client)
    {
        return view('accounts.edit',
          [
            'account'=>$account,
            'client'=>$client
          ]
          );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $validator = Validator::make(
            $request->all(),[
                'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
            ],
            [
                'amount.required' => '??',
                'amount.integer' => 'Check amount'
            ]);

            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }

            if ($request->add){
                $newAmount = $account->balance + $request->amount;
            }

            if ($request->minus && $request->amount <= $account->balance){
                $newAmount = $account->balance - $request->amount;
            }

            $account->balance = $newAmount;
            $account->save();
            return redirect()
            ->back()
            ->with('success', 'New account has been added!');
    }

    public function delete(Account $account)
    {
        if ($account->balance != 0){
            return redirect()->back()->withErrors(['Balance not 0, account canot be deleted!']);
        }
        $account->delete();
        return redirect()->back()->with('success', 'Account has been deleted!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }

    public function transfare(Account $account, Client $client)
    {
        return view('accounts.transfare',
        [
          'account'=>$account,
          'client' => $client
        ]
        );
    }

    public function execute(Account $account, Request $request, Client $client)
    {
        $validator = Validator::make(
            $request->all(),[
                'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'iban2' => 'required|regex:/^LT\d{16}/'
            ],
            [
                'amount.required' => '??',
                'amount.regex' => 'Check amount',
                'iban2.required' => '??',
                'iban2.regex' => 'Check IBAN'
            ]);

            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }

            $account2 = Account::where('iban','=',$request->iban2)->first();

            if (is_null($account2)){
                return redirect()->back()->withErrors('Recievers Account does not exist!');
            }

            if ($account->balance >= $request->amount){
                $account->balance -= $request->amount;
                $account2->balance += $request->amount;
                $account->save();
                $account2->save();
                return redirect()->back()->with('success', 'Funds where transfared!');
            }
            return redirect()->back()->withErrors('Balance is not sufficient');
    }
}


