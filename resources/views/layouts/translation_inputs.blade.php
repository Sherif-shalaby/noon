@php
    $config_langs = config('constants.langs');
@endphp
<div class="col-md-12 position-absolute" style="top: 35px;z-index: 1;">
    <table class="table hide collapse {{ !empty($open_input) && $open_input == true ? 'editTogle' : '' }}"
        @if (!empty($type)) id="translation_table_{{ $type }}" @else id="translation_table_company" @endif>
        <tbody>
            @foreach ($config_langs as $key => $lang)
                <tr>

                    <td>
                        <input class="form-control translations" type="text"
                            name="translations[{{ $attribute }}][{{ $key }}]"
                            value="@if (!empty($translations[$attribute][$key])) {{ $translations[$attribute][$key] }} @endif"
                            placeholder="{{ $lang['full_name'] }}">
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if (!empty($open_input) && $open_input == true)
    <script>
        $(document).ready(function() {
            $('table.editTogle')
                .find("tr")
                .each(function() {
                    if ($(this).find('input.translations').val()) {
                        $('table.editTogle').removeClass('collapse')
                        return;
                    }
                });
        });
    </script>
@endif
