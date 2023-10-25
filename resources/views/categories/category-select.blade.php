<!-- categories/category-select.blade.php -->

@foreach ($categories as $category)
    <option value="{{ $category->id }}">{{ $prefix }} {{ $category->name }}</option>
    @if ($category->subCategories->count() > 0)
        @include('categories.category-select', ['categories' => $category->subCategories, 'prefix' => ' '.$prefix . '-'])
    @endif
@endforeach