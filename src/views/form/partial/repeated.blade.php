@if($showLabel && $showField)
<div {!! $options['wrapperAttrs'] !!}  >
@endif
@if($showField)

    @if(isset($isNotEditable) and $isNotEditable === true)
        @if(method_exists($options['children']['first'],'view'))
         {!!$options['children']['first']->view([], true, true, false) !!}
        @endif
        @if(method_exists($options['children']['second'],'view'))
         {!!$options['children']['second']->view([], true, true, false) !!}
        @endif
    @else
        {!! $options['children']['first']->render([], true, true, false) !!}
        {!! $options['children']['second']->render([], true, true, false) !!}
    @endif
@endif
@if($showError && isset($errors))
    {!! $options['children']['first']->render([], false, false, true) !!}
    {!! $options['children']['second']->render([], false, false, true) !!}
@endif

@if ($showLabel && $showField)
</div>
@endif