@extends('layouts.app')
@section('content')
    <section class="invoice-section">
        <div class="invoice-content bg-white shadow rounded-3 pb-2">
            <h1 class="invoice-name text-center rounded-3 fw-bold mb-0 pt-2">
                {{ __('site.Bill_Number') }}
                <br>
                #{{ $invoice->id }}
            </h1>
            <h4 class="mb-2 fw-bold mb-3 text-center mt-2">
                {{ $setting['site_title'] }}
            </h4>
            <div class="the_date d-flex align-items-center justify-content-evenly mb-3">
                <div class="date-holder ">
                    <small>{{ $invoice->date }}</small>
                </div>
                <div class="date-holder ">
                    <small>{{ $invoice->created_at->format('H:i a') }}</small>
                </div>
            </div>
            <div class="logo-holder m-auto text-center  rounded-3 mb-3">
                <img class="the_image mx-auto  h-auto rounded-3" src="{{ display_file($setting['logo']) }}" width="150"
                    alt="logo">
            </div>
            <div class="me-2">
                <div class="tax-number  mb-2 fw-bold">
                    {{-- <small>{{ __('site.Tax_Number') }} : <span class="">{{ $setting['tax'] }}</span></small> --}}
                </div>
                <div class="the_address mb-4 fw-bold">
                    <div class="address-holder">
                        {{-- <small>{{ $setting['address'] }}</small> --}}
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table main-table text-center rounded-3 w-100">
                    <thead class="border-0">
                        <tr>
                            <th class="">
                                <div>{{ __('site.Description') }}</div>
                                <div class="">Description</div>
                            </th>
                            <th class="">
                                <div class="">{{ __('site.price') }}</div>
                                <div class="">price</div>
                            </th>
                            <th>
                                <div class="">{{ __('site.Quantity') }}</div>
                                <div class="">Qty</div>
                            </th>
                            <th>
                                <div class="">{{ __('site.The_Tax') }}</div>
                                <div class="">Vat</div>
                            </th>
                            <th>
                                <div class="">{{ __('site.Total') }}</div>
                                <div class="">Total</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
                                    {{ $item->price }}
                                </td>
                                <td>
                                    {{ $item->quantity }}
                                </td>
                                <td>
                                    {{ $item->tax ?? 0 }}
                                </td>
                                <td>
                                    {{ $item->total }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="table-responsive second-table mt-2">
                <table class="table main-table" id="data-table">
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-end ">
                                <div class="text-center spechial-text">{{ __('site.Total_before_discount_and_tax') }}</div>
                                <div class="text-center spechial-text">Total before deduction and tax</div>
                            </td>
                            <td colspan="2"> {{ $invoice->price }}</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-end ">
                                <div class="text-center spechial-text">{{ __('site.value_added_tax') }}</div>
                                <div class="text-center spechial-text">value added tax</div>
                            </td>
                            <td colspan="2"> {{ $invoice->tax }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-end ">
                                <div class="text-center spechial-text"> {{ __('site.Discount') }} Dicsc</div>
                                <!-- <div class="text-center spechial-text"></div> -->
                            </td>
                            <td colspan="2"> {{ $invoice->discount }}</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-end ">
                                <div class="text-center spechial-text"> {{ __('site.cash_Money') }} Cash</div>
                                <!-- <div class="text-center spechial-text"></div> -->
                            </td>
                            <td colspan="2"> {{ $invoice->cash }}</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="2" class="text-end ">
                                <div class="text-center spechial-text"> {{ __('site.Network_pay') }} Card</div>
                                <div class="text-center spechial-text"></div>
                            </td>
                            <td colspan="2"> {{ $invoice->card }}</td>
                        </tr> --}}
                        <tr>
                            <td colspan="2" class="text-end ">
                                <div class="text-center spechial-text"> {{ __('site.rest') }} Rest</div>
                                <!-- <div class="text-center spechial-text"></div> -->
                            </td>
                            <td colspan="2"> {{ $invoice->rest }}</td>
                        </tr>

                        <tr class="">
                            <td colspan="1" class="text-end ">
                                <div class="text-center spechial-text"> {{ __('site.Total') }} Total</div>
                                <!-- <div class="text-center spechial-text"></div> -->
                            </td>
                            <td colspan="3 " class="">{{ $invoice->total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            {{-- <div class="bar_code_holder text-center">
                {!! $qrCode !!}
            </div> --}}
            <div class="d-flex justify-content-center not-print mt-3">
                <button class="btn btn-sm btn-info" onclick="print()">{{ __('site.Print') }}</button>
            </div>

        </div>
    </section>
    {{-- @push('js')
        <script>
            // print
            if (document.getElementById("prt-content")) {
                var btnPrtContent = document.getElementById("btn-prt-content");
                btnPrtContent.addEventListener("click", printDiv);

                function printDiv() {
                    var prtContent = document.getElementById("prt-content");
                    newWin = window.open("");
                    newWin.document.head.replaceWith(document.head.cloneNode(true));
                    newWin.document.body.appendChild(prtContent.cloneNode(true));
                    setTimeout(() => {
                        newWin.print();
                        newWin.close();
                    }, 600);
                }
            }
        </script>
    @endpush --}}
@endsection
