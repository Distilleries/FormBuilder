@if ($showLabel && $showField)
<div {!! $options['wrapperAttrs'] !!}  >
@endif

    @if ($showLabel)
    <?php $options['label_attr']['class'] .= ' col-md-3'; ?>
        {!! Form::label($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if ($showLabel)
    <div class="col-md-4">
    @endif
    @if ($showField)
     <?php $emptyVal = $options['empty_value'] ? ['' => $options['empty_value']] : null; ?>
     @if(isset($noEdit) and $noEdit === true)
         {!! (isset($options['choices']) and isset($options['choices'][$options['selected']]))?$options['choices'][$options['selected']]:'' !!}
     @else
          {!! Form::select($name, (array)$emptyVal + $options['choices'], (array)$options['selected'], $options['attr'])!!}
     @endif
    @endif

    @if ($showError && isset($errors))
        {!!$errors->first(array_get($options, 'real_name', $name), '<div '.$options['errorAttrs'].'>:message</div>')!!}
    @endif
    @if ($showLabel)
        @if(isset($options['help']))
        <span class="help-block">{!!$options['help']!!}</span>
        @endif
        </div>
    @endif
@if ($showLabel && $showField)
</div>
@endif
