<div class="col-12">
    @include("crud-maker.components.form-row", ["params" => [
        [
            "name" => "search-input",
            "id" => "search-input",
            "class" => "form-control",
            "entity" => "products",
            "type" => "text",
            "defaultValue" => old("search-input") ?? "",
        ]
    ]])

    @empty(!$categories)
        <ul class="nav nav-tabs category-tabs" role="tablist">
            <li>
                <a class="nav-link" data-bs-toggle="tab" href="#home" role="tab">
                    <i class="fas fa-undo"></i>
                </a>
            </li>
        @foreach ($categories as $category)
                <li data-id="{{$category->id}}">
                    <a class="nav-link" data-bs-toggle="tab" href="#home" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">{{$category->name}}</span>
                    </a>
                </li>
        @endforeach
        </ul>
    @endempty

    {{ $html->table() }}
</div>