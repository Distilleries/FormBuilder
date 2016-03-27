<?php $id = uniqid(); ?>
@if ($showLabel and $showField and ! $options['is_child'])
    <div {!! $options['wrapperAttrs'] !!}  >
@endif
    @if ($showLabel)
        <?php $options['label_attr']['class'] .= ' col-md-3'; ?>
        {!! Form::label($name, $options['label'], $options['label_attr']) !!}
    @endif
    <div class="col-md-4">
        @if ($showField)
            @if (isset($noEdit) and ($noEdit === true))
                {!! $options['default_value'] !!}
            @else
                <?php $options['attr']['class'] .= ' datepicker'; ?>
                    @if (! empty($options['range']))
                        <?php $options['attr']['class'] .= ' input-sm'; unset($options['attr']['id']); ?>
                        <div id="{{ $id }}" class="input-daterange input-group">
                            {!! Form::input($type, $name . '[start]', $options['default_value'], $options['attr']) !!}
                            <span class="input-group-addon">{{ trans('form-builder::form.to') }}</span>
                            {!! Form::input($type, $name . '[end]', $options['default_value'], $options['attr']) !!}
                        </div>
                    @else
                        {!! Form::input($type, $name, $options['default_value'], $options['attr']) !!}
                    @endif

                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        @if (! empty($options['range']))
                            jQuery('#{!! $id !!} .input-sm')
                        @else
                            jQuery('input[name="{!! $name !!}"]')
                        @endif.datepicker({
                            format: '{!! $options['format'] !!}',
                            @if (! empty($options['todayHighlight']))
                                todayHighlight: true,
                            @endif
                            @if (! empty($options['autoclose']))
                                autoclose: true,
                            @endif
                            @if (! empty($options['language']))
                                language: '{!! $options['language'] !!}',
                            @endif
                            orientation: "left"
                        }).on('changeDate', function (selected) {
                            var startDate = new Date(selected.date.valueOf());
                            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

                            if (jQuery(this).attr('name') == '{{ $name . '[end]' }}') {
                                jQuery('input[name="{{ $name . '[start]' }}"]').datepicker('setEndDate', startDate);
                            } else {
                                jQuery('input[name="{{ $name . '[end]' }}"]').datepicker('setStartDate', startDate);
                            }
                        });
                    });
                </script>
            @endif
        @endif

        @if ($showError and isset($errors))
            {!! $errors->first(array_get($options, 'real_name', $name), '<span ' . $options['errorAttrs'] . '>:message</span>') !!}
        @endif
        @if (! empty($options['help']))
            <span class="help-block">{!! $options['help'] !!} </span>
        @endif
    </div>
@if ($showLabel and $showField and ! $options['is_child'])
    </div>
@endif
