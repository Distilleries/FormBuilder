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
                        <div class="input-group">
                            <?php $options['attr']['id'] = $id; ?>
                            {!! Form::input($type, $name, $options['default_value'], $options['attr']) !!}
                            <span class="input-group-btn">
                              <button type="button"
                                      class="btn blue"
                                      onclick="moxman.browse({
                                              @if(!empty($options['extensions']))
                                              extensions: '{!!$options['extensions']!!} ',
                                              @endif
                                              @if(!empty($options['view']))
                                              view: '{!!$options['view']!!} ',
                                              @endif
                                              fields: '{!!$id!!} ',
                                              no_host: true
                                              });">
                                  <i class="glyphicon glyphicon-upload"></i>
                                  <span>{{trans('form-builder::form.pick_file')}}</span>
                              </button>
                            </span>
                        </div>

                        <script type="text/javascript" src='/assets/moxiemanager/js/moxman.api.min.js'></script>
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

