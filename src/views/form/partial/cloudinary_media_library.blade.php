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
                    @if(! empty($options['default_value']))
                        <img src="{{ cloudinary_url($options['default_value']) }}" alt="{{ $options['default_value'] }}" class="img-thumbnail">
                    @endif
                @else
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-promise/4.1.1/es6-promise.auto.min.js"></script>
                    <script src="https://media-library.cloudinary.com/global/all.js"></script>
                    <script>
                        window['ml_{{ $id }}'] = cloudinary.createMediaLibrary({
                            cloud_name: "{{ config('laravel-form-builder.cloudinary.cloud_name') }}",
                            api_key: "{{ config('laravel-form-builder.cloudinary.cloud_name') }}",
                            multiple: false
                        }, {
                            insertHandler: function (data) {
                                if (data.assets.length > 0) {
                                    const asset = data.assets[0];
                                    jQuery('#{{$id}}').val(asset.public_id);
                                }
                            }
                        });
                    </script>

                    <div class="input-group">
                        <?php $options['attr']['id'] = $id; ?>
                        {!! Form::input($type, $name, $options['default_value'], $options['attr']) !!}
                        <span class="input-group-btn">
                              <button type="button"
                                      id="cloudinary_{{ $id }}"
                                      class="btn blue"
                                      onclick="window['ml_{{ $id }}'].show()">
                                  <i class="glyphicon glyphicon-upload"></i>
                                  <span>{{trans('form-builder::form.pick_file')}}</span>
                              </button>
                        </span>
                    </div>
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
