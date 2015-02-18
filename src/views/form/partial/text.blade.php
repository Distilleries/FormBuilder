
@if($type == 'hidden')
    {!! Form::input($type, $name, $options['default_value'], $options['attr']) !!}
@else
@if ($showLabel && $showField && !$options['is_child'])
<div {!! $options['wrapperAttrs'] !!}  >
@endif

    @if ($showLabel)
    <?php $options['label_attr']['class'] .= ' col-md-3'; ?>
        {!! Form::label($name, $options['label'], $options['label_attr']) !!}
    @endif

    <div class="col-md-4">
    @if ($showField)
        @if(isset($noEdit) and $noEdit === true)
            {!!$options['default_value'] !!}
        @else
            {!! Form::input($type, $name, $options['default_value'], $options['attr']) !!}
        @endif
    @endif

    @if ($showError && isset($errors))
        {!!$errors->first(array_get($options, 'real_name', $name), '<span '.$options['errorAttrs'].'>:message</span>')!!}
    @endif
    @if(isset($options['help']))
    <span class="help-block">{!!$options['help']!!} </span>
    @endif


    </div>
@if ($showLabel && $showField && !$options['is_child'])
</div>
@endif

@endif
