<?php

namespace App\Http\Livewire\ProcessInvoice;

use App\Models\Employee;
use App\Models\JobType;
use App\Models\ProcessInvoice;
use App\Models\System;
use Livewire\Component;

class Index extends Component
{
    public $employees, $invoices = [], $update_processing = 0;
    public $invoice = [
        // [
        //     'id'=>'',
        //     'is_processed'=>0,
        //     'employee_id'=>0,
        // ]
    ];
    protected $listeners = ['listenerReferenceHere'];
    public function listenerReferenceHere($data)
    {
        if (isset($data['var']) && !isset($data['name'])) {
            $this->UpdateStatus($data['var'], $data['id'], $data['val']);
        }
    }
    public function render()
    {
        $this->invoices = ProcessInvoice::orderBy('is_processed', 'asc')->get();
        foreach ($this->invoices as $key => $row) {
            $this->invoice[] = [
                'id' => $row->id,
                'created_at' => $row->created_at,
                'invoice_no' => $row->invoice_no,
                'customer_name' => $row->customer?->name,
                'city' => $row->customer?->city?->name,
                'state' => $row->customer?->state?->name,
                'phone' => $row->customer?->phone,
                'payment_status' => $row->transaction?->payment_status,
                'amount' => $row->transaction->transaction_payments?->sum('amount'),
                'dollar_amount' => $row->transaction_payments?->sum('dollar_amount'),
                'delivery_date' => $row->transaction?->delivery_date,
                'is_processed' => $row->is_processed,
                'employee_id' => $row->employee_id,
            ];
        }

        $this->dispatchBrowserEvent('componentRefreshed');

        return view('livewire.process-invoice.index');
    }
    public function mount()
    {
        $jobType = JobType::where('title', 'Processor')->first();
        $this->employees = Employee::where('job_type_id', $jobType->id ?? 0)->pluck('employee_name', 'id');
        $this->update_processing = System::getProperty('update_processing');
    }
    public function UpdateStatus($index, $id, $employee_id)
    {
        $process_invoice = ProcessInvoice::find($id);
        $process_invoice->update([
            'employee_id' => $employee_id,
            'is_processed' => !$process_invoice->is_processed,
        ]);
        return redirect('/process-invoice');
    }
}
