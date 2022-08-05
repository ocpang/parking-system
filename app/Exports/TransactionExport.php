<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionExport implements FromView
{
    protected $start_date;
    protected $end_date;
    
    public function __construct($param) {
        $this->start_date  = $param['start_date'];
        $this->end_date  = $param['end_date'];
    }

    public function view(): View
    {
        $query = Transaction::select('transactions.*', 'users.name as user_name', 'up.name as up_user_name')
                        ->join('users','users.id','=','transactions.user_created')
                        ->leftJoin('users as up','up.id','=','transactions.user_updated')
                        ->orderBy('transactions.created_at','desc');

        if($this->start_date != "" && $this->end_date != ""){
            $query = $query->whereBetween('transactions.created_at', [$this->start_date, $this->end_date]);
        }

        return view('export.transaction', [
            'model' => $query->get(),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }
}
