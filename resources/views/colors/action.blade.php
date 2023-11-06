  <div class="bn-group">
      <button type="button" class="btn btn-primary btn-sm text-white mx-1" data-toggle="modal"
          data-target="#edit{{ $color->id }}" title="{{ __('Edit') }}">
          <i class="fa fa-edit"></i>
      </button>


      <a data-href="{{ route('colors.destroy', $color->id) }}" title="{{ __('Delete') }}"
          class="btn btn-danger btn-sm text-white delete_item"><i class="fa fa-trash"></i>
      </a>
  </div>
  {{-- modal edit --}}
  <div class="modal fade" id="edit{{ $color->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header mb-4 d-flex justify-content-between py-0  flex-row">
                  <h5 class="modal-title" id="exampleModalLabel">{{ __('colors.editcolor') }}</h5>
                  <button type="button" class="close  m-0" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="{{ route('colors.update', $color->id) }}" method="POST">
                  <div class="modal-body p-0">
                      @csrf
                      @method('PUT')
                      <div
                          class=" d-flex mb-2 align-items-center form-group flex-row  @if (app()->isLocale('ar')) pr-4 @else pl-4 @endif">
                          <label class="modal-label-width" for="name">@lang('colors.colorname')</label>
                          <div
                              class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                              <input type="text" style="width: 100%"
                                  class="form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                  placeholder="@lang('colors.colorname')" name="name"
                                  value="{{ old('name', $color->name) }}">
                              <button class="add-button d-flex justify-content-center align-items-center"
                                  style="font-weight: 700;font-size: 26px" type="button" data-toggle="collapse"
                                  data-target="#translation_table_color" aria-expanded="false"
                                  aria-controls="collapseExample">
                                  {{-- {{ __('categories.addtranslations') }} --}} +
                              </button>
                              @error('name')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                          @include('layouts.translation_inputs', [
                              'attribute' => 'name',
                              'translations' => [],
                              'type' => 'color',
                              'data' => $color,
                          ])
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('cancel') }}</button>
                      <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  {{-- end modal edit --}}
