@if (count($dynamicAttributes) > 0)
    <h3>@lang('clients.dynamic attribues')</h3>

    @foreach ($dynamicAttributes as $attribute)
        <div class="mb-3">
            <label for="" class="col-12 col-md-12 control-label">
                {{ucfirst($attribute->name)}} {{$attribute->is_required ? '*' : ''}}
            </label>
            <div class="col-12 col-md-12">
                <input 
                    type="text" 
                    name="dynamics[{{$attribute->id}}]"
                    class="form-control"
                    placeholder="{{ucfirst($attribute->name)}}"
                    {{$attribute->is_required ? 'required' : ''}}
                    value="{{old("dynamics[$attribute->id") ?? ($clientAttributes[$attribute->id] ?? "")}}">
            </div>
            <div class="form-text">{{$attribute->description ?? ''}}</div>
        </div>
    @endforeach
@endif