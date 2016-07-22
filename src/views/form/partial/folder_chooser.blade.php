<?php $uid = uniqid(); ?>
@if ($showLabel && $showField && !$options['is_child'])
    <div {!! $options['wrapperAttrs'] !!}  >
@endif

@if ($showLabel)
    <?php $options['label_attr']['class'] .= ' col-md-3'; ?>
    {!! Form::label($name, $options['label'], $options['label_attr']) !!}
@endif
<div class="col-md-4">
    @if ($showField)
        @if(empty($noEdit))
            {!! Form::input('hidden', $name, $options['default_value'], $options['attr']) !!}
            <a id="{{$uid}}-browser" href="#" class="btn btn-primary">{{$options['label_chooser']}}</a>
        @endif
    @endif

    <span id="{{$uid}}-browser-badger" class="badge {{$options['badge_class']}}">{{$options['default_value']}}</span>


    @if ($showError && isset($errors))
        {!!$errors->first(array_get($options, 'real_name', $name), '<span '.$options['errorAttrs'].'>:message</span>')!!}
    @endif
    @if(isset($options['help']))
        <span class="help-block">{!!$options['help']!!} </span>
    @endif

    <script type="text/javascript">
        jQuery('#{{$uid}}-browser').off('click').on('click',function(evt){
           evt.preventDefault();
           moxman.browse({
                path:jQuery('input[name="{{$name}}"]').val(),
                oninsert: function(args) {
                    var file = args.focusedFile;

                    if(file.isDirectory){
                        jQuery('input[name="{{$name}}"]').val(file.path);
                        jQuery('#{{$uid}}-browser-badger').html(file.path);
                    }
                }
            });
        });

        @if(empty($noEdit))
        jQuery('#{{$uid}}-browser-badger').html(jQuery('input[name="{{$name}}"]').val());
        @endif

    </script>

</div>
@if ($showLabel && $showField && !$options['is_child'])
    </div>
@endif