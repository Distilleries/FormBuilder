@if ($showLabel and $showField)
    <div {!! $options['wrapperAttrs'] !!}>
        @endif

        @if ($showLabel)
            <?php $options['label_attr']['class'] .= ' col-md-3'; ?>
            {!! Form::label($name, $options['label'], $options['label_attr']) !!}
        @endif

        @if ($showLabel)
            <div class="col-md-4">
                @endif

                @if ($showField)
                    @if (isset($noEdit) and $noEdit === true)
                        <?php
                        if (! empty($options['default_value'])) {
                            $options['default_value'] = is_string($options['default_value']) ? explode(',', $options['default_value']) : $options['default_value'];
                        }
                        ?>
                        @if(is_array($options['default_value']) && !empty($options['default_value']))
                            @foreach($options['default_value'] as $tag)
                                <span class="label label-info">{!! $tag !!} </span>
                            @endforeach
                        @endif
                    @else
                        <?php $options['class'] = isset($options['class']) ? $options['class'] . ' tags ' : ' tags '; ?>
                        {!! Form::input($type, $name, $options['default_value'], $options['attr']) !!}
                    @endif
                @endif

                @if ($showError and isset($errors))
                    {!! $errors->first(array_get($options, 'real_name', $name), '<div ' . $options['errorAttrs'] . '>:message</div>') !!}
                @endif

                @if ($showLabel)
                    @if (isset($options['help']))
                        <span class="help-block">{!! $options['help'] !!}</span>
                    @endif
            </div>
        @endif

        @if ($showLabel and $showField)
    </div>
    @if (empty($noEdit))
        <script type="text/javascript">
            jQuery(document).ready(function () {
                $('input[name="{{ $name }}"]').select2({
                    tags: [],
                    tokenSeparators: [','],
                    @if ( !empty($options['maximumInputLength']))
                    maximumInputLength: {{ $options['maximumInputLength'] }}
                    @endif
                });
            });
        </script>
    @endif
@endif
