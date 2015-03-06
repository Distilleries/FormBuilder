@if(isset($noEdit) and $noEdit === true)
   @if ($showLabel && $showField && !$options['is_child'])
        <div {!! $options['wrapperAttrs'] !!}  >
   @endif
           <label class="col-md-3"></label>
           <div class="col-md-4">
               @if ($showLabel)
                 {!! $options['label'].': ' !!}
               @endif
               <span class="label label-{!! $options['checked']?'success':'danger' !!} ">{!! \Distilleries\FormBuilder\Helpers\StaticLabel::yesNo($options['checked']) !!} </span>
           </div>
   @if ($showLabel && $showField && !$options['is_child'])
       </div>
   @endif
@else
    @if ($showLabel && $showField && !$options['is_child'])
    <div {!! $options['wrapperAttrs'] !!}  >
        <label class="col-md-3"></label>
        <div class="col-md-4">
        @endif
               @if ($showField)
                   {!! Form::radio($name, $options['default_value'], $options['checked'], $options['attr']) !!}
               @endif

               @if ($showLabel)
                   @if ($options['is_child'])
                       <label {!! $options['labelAttrs'] !!} >{!! $options['label'] !!} </label>
                   @else
                       {!! Form::label($name, $options['label'], $options['label_attr']) !!}
                   @endif
               @endif

               @if ($showError && isset($errors))
                   {!! $errors->first(array_get($options, 'real_name', $name), '<div '.$options['errorAttrs'].'>:message</div>') !!}
               @endif


        @if ($showLabel && $showField && !$options['is_child'])
        </div>
    </div>
    @endif
@endif
