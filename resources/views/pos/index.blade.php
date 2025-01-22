@extends('layouts.app')
@section('content')
    @php
        $cont = 0;
        $col1 = null;
        $col2 = null;
        if (strpos($config->total_columns, ':')) {
            [$col1, $col2] = explode(':', $config->total_columns);
            $config->total_columns = $col1 > $col2 ? $col1 : $col2;
        }
    @endphp
    @for ($i = 0; $i < $config->total_rows; $i++)
        <div class="row">
            @for ($j = 0; $j < $config->total_columns; $j++)
                @php
                    $cont += 1;
                    $classColumns = 'col-' . 12 / $config->total_columns;
                    if ($col1 != null) {
                        $classColumns = 'col-';
                        $classColumns .= $j == 0 ? ($col1 == 1 ? 4 : 8) : ($col2 == 1 ? 4 : 8);
                    }

                    $tile = $config->tiles->{'tile' . $cont};
                @endphp
                @if ($tile ?? false)
                    <div class="{{ $classColumns ?? '' }} p-2 columnPOS" id="section-{{ $tile['title'] }}">
                        @include("components.windows.{$tile['title']}", $tile['data'])
                    </div>
                @endif
            @endfor
        </div>
    @endfor
@endsection

@push('scripts')
    <script>
        $("#vertical-menu-btn").trigger('click');
    </script>
@endpush
