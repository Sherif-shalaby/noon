<table class="table mb-0 @if (app()->isLocale('ar')) dir-rtl @endif" style="border: 2px solid rgb(177, 177, 177);">
    <thead>
        <tr>
            <th class="col1">@lang('lang.unit')</th>
            <th class="col2">@lang('lang.loading_cost')</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($units as $index => $unit)
            <tr>
                <td>
                    {{ $unit->name }}
                    <input class="initial-balance-input width-full m-0" type="hidden" value=" {{ $unit->id }}"
                        name="units[{{ $index }}][unit_id]">
                </td>
                <td>
                    <input class="initial-balance-input width-full m-0" type="text"
                        name="units[{{ $index }}][loading_cost]"
                        value="{{ number_format($unit->loading_cost, 3) }}">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
