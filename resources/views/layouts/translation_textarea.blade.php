@php
$config_langs = config('constants.langs');
@endphp
<div class="col-md-12">
<table class="table hide collapse" @if(!empty($type)) id="translation_details_{{$type}}" @else id="translation_table_company" @endif>
    <tbody>
        @foreach ($config_langs as $key => $lang)
            <tr>

                <td>
                    <textarea class="form-control translations" name="details_translations[{{ $attribute }}][{{ $key }}]"
                        value="@if(!isset($data)){{old('translations.'.$attribute.".".$key)}}@else{{$data->translation[$attribute][$key]??""}}@endif"
                        placeholder="{{ $lang['full_name'] }}"></textarea>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
</div>
