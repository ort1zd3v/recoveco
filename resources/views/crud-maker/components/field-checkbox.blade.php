<div class="{{$params['class']}}">
    <input type="hidden" name="{{$params['name']}}" value="0">
    <input 
        class="form-check-input p-3 button-add mt-0" 
        type="checkbox"  
        name="{{$params['name']}}" 
        value="{{$params['defaultValue']}}"
        id="{{$params['id']}}" 
        @if((!old() && isset($params['checked']) && $params['checked'] == true) || old($params['name']) == $params['defaultValue']) checked="checked" @endif
        >
</div>