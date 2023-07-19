@php
$config_langs = config('constants.langs');
@endphp
<div class="col-md-12">
<table class="table hide collapse {{!empty($type)&&$type=='product'?'editTextareaTogle':''}}" @if(!empty($type)) id="translation_details_{{$type}}" @else id="translation_table_company" @endif>
    <tbody>
        @foreach ($config_langs as $key => $lang)
            <tr>
                <td>
                    <textarea class="form-control translations" name="details_translations[{{ $attribute }}][{{ $key }}]"
                        value=""
                        placeholder="{{ $lang['full_name'] }}">@if (!empty($translations[$attribute][$key])) {{ $translations[$attribute][$key] }} @endif</textarea>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
</div>
