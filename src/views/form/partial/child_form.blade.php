@if(empty($model) and !empty($options['model']))
    <?php $model = $options['model']; ?>

@endif
@if($showLabel)

    <div class="portlet light unbordered">
        <div class="portlet-title">
            <div class="caption">
                @if(isset($options['icon']))
                    <i class="glyphicon glyphicon-{!!$options['icon']!!} "></i>
                @endif
                <span class="caption-subject bold uppercase font-yellow"> {!!$options['label']!!} </span>
            </div>
        </div>
    </div>
@endif
@if($showField)
    @foreach ((array)$options['children'] as $child)

        @if($child->getType() != 'submit' and $child->getType() != 'button')

            @if(isset($noEdit) and $noEdit === true)
                @if(method_exists($child,'view'))
                    <?php $default = $child->getOptions(); ?>
                    @if(empty($default['default_value']))
                        <?php $name = last(explode('[', rtrim($child->getName(), ']'))); ?>
                        {!! $child->view(['default_value'=>(!empty($model) && $model && $model->exists and isset($model->{$name}))?$model->{$name}:$default['default_value']]) !!}
                    @else
                        {!! $child->view() !!}
                    @endif

                @endif
            @else
                {!!$child->render() !!}
            @endif
        @endif
    @endforeach
@endif

@if ($showError && isset($errors))
    {!! $errors->first(array_get($options, 'real_name', $name), '<div '.$options['errorAttrs'].'>:message</div>') !!}
@endif
