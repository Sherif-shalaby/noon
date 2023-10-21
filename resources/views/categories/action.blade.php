<div class="bn-group">
    <a class="btn btn-success btn-sm fonticon-wrap" href="{{ route('categories.edit', $categorie->id) }}"
        title="{{ __('Edit') }}">
        <i class="icon-note"></i>
    </a>
    <a data-href="{{ route('categories.destroy', $categorie->id) }}" title="{{ __('Delete') }}"
        class="btn btn-danger text-white btn-sm delete_item"><i class="fa fa-trash"></i>

    </a>
</div>
