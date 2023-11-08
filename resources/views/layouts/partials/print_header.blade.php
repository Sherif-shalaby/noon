<div class="row" style="text-align: center; p-3" id="invoice_heaer_div" >
    @php
        $logo = App\Models\System::getProperty('logo');
    @endphp
    <img src="@if(!empty($letter_header)){{asset('/uploads/'.$logo)}}@else{{asset('/uploads/'.session('logo'))}}@endif" alt="header" id="header_invoice_img" style="width: auto; margin: auto;  max-height: 150px;">
</div>
