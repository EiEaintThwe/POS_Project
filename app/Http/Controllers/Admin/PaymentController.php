<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    //payment list
    public function list(){
        $payments = Payment::orderBy('type','asc')
                        ->when(request('searchKey'), function($query){
                            $query->whereAny(['account_number', 'account_name', 'type'],'like', '%'.request('searchKey').'%');
                        })
                        ->paginate(5);
        return view('admin.payment.list',compact('payments'));
    }

    //create payment
    public function create(Request $request){
        $this->checkValidation($request);

        Payment::create([
            'account_number' => $request->bankAccountNumber,
            'account_name' => $request->bankAccountName,
            'type' => $request->bankAccountType
        ]);

        Alert::success('Success Title', 'Payment Method Created Successfully');

        return back();

    }

    //edit payment
    public function edit($id){
        $payment = Payment::where('id', $id)->first();

        return view('admin.payment.edit', compact('payment'));
    }

    //update payment
    public function update(Request $request, $id){
        $this->checkValidation($request);

        Payment::where('id', $id)->update([
            'account_name' => $request->bankAccountName,
            'account_number' => $request->bankAccountNumber,
            'type' => $request->bankAccountType
        ]);

        Alert::success('Success Title', 'Payment Method Updated Successfully');
        return to_route('payment#list');

    }

    //delete payment
    public function delete($id){
        Payment::where('id', $id)->delete();

        return back();
    }

    //check validation
    private function checkValidation($request){
        $request->validate([
            'bankAccountNumber' => 'required',
            'bankAccountName' => 'required',
            'bankAccountType' => 'required'
        ]);
    }
}
