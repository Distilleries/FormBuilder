<?php $id = uniqid(); ?>
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
                    <?php $options['attr']['class'] .= ' datepicker'; ?>
                        @if($options['range'])
                            <?php $options['attr']['class'] .= ' input-sm'; ?>
                            <?php unset($options['attr']['id']); ?>
                            <div id="{{$id}}" class="input-daterange input-group">
                                {!! Form::input($type, $name.'[start]', $options['default_value'], $options['attr']) !!}
                                <span class="input-group-addon">{{trans('form-builder::form.to')}}</span>
                                {!! Form::input($type, $name.'[end]', $options['default_value'], $options['attr']) !!}
                            </div>
                        @else
                            {!! Form::input($type, $name, $options['default_value'], $options['attr']) !!}
                        @endif

                    <script type="text/javascript">

                        jQuery(document).ready(function () {

                            @if($options['range'])
                                jQuery("#{!! $id !!} .input-sm")
                            @else
                                jQuery("input[name='{!!$name!!} ']")
                             @endif.datepicker({
                                format: '{!!$options['format']!!}',
                                @if($options['todayHighlight'])
                                todayHighlight: true,
                                @endif
                                @if($options['autoclose'])
                                autoclose: true,
                                @endif
                                orientation: "left"



                            }).on('changeDate', function(selected){

                                var startDate = new Date(selected.date.valueOf());
                                startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

                                if(jQuery(this).attr('name') == '{{$name.'[end]'}}'){
                                    jQuery('input[name="{{$name.'[start]'}}"]').datepicker('setEndDate', startDate);
                                }else{
                                    jQuery('input[name="{{$name.'[end]'}}"]').datepicker('setStartDate', startDate);
                                }

                            });
                        });
                    </script>
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
