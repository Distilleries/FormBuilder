<?php $id = uniqid(); ?>
@if ($showLabel && $showField)
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <div {!! $options['wrapperAttrs']!!}  >
        @endif

        @if ($showLabel)
            <?php $options['label_attr']['class'] .= ' col-md-3'; ?>
            {!! Form::label($name, $options['label'], $options['label_attr']) !!}
        @endif

        <div class="col-md-8">
            <?php $options['attr']['class'] .= ' '.$id; ?>
            @if ($showField)
                @if(isset($noEdit) and $noEdit === true)
                    {!! $options['default_value'] !!}
                @else
                    {!! Form::textarea($name, $options['default_value'], $options['attr']) !!}
                @endif


            @endif

            @if ($showError && isset($errors))
                {!! $errors->first(array_get($options, 'real_name', $name), '<div '.$options['errorAttrs'].'>:message</div>') !!}
            @endif
        </div>
        @if ($showLabel && $showField)
    </div>
@endif
@if(empty($noEdit))
    <script type="text/javascript">
        jQuery(document).ready(function(){
            tinymce.init({
                selector: ".{{$id}}",
                themes: "modern",
                plugins: [
                    "{{empty($options['moxiemanager'])?'moxiemanager':''}}  advlist autolink lists link image charmap hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                toolbar2: "media | forecolor backcolor emoticons",
                image_advtab: true,
                relative_urls: false,
                body_class: "content",
                @if(!empty($options['moxiemanager']))
                external_plugins: {
                    "moxiemanager": "{{config('app.url')}}{{$options['moxiemanager']}}"
                },
                @endif
                templates: [
                ]
            });
        });

    </script>
@endif
