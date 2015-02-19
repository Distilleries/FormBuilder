@if ($showLabel && $showField)
    <div {!! $options['wrapperAttrs'] !!}  >
@endif

        @if ($showLabel)
            <?php $options['label_attr']['class'] .= ' col-md-3'; ?>
            {!! Form::label($name, $options['label'], $options['label_attr']) !!}
        @endif


            <div class="col-md-4">
                @if(isset($noEdit) and $noEdit === true)
                   <div class="{!!$name!!} -noEdit">{!!_('Loading...')!!} </div>
                @endif

                <?php $options['attr']['class'] = 'input-lg '.$options['attr']['class']; ?>
                {!! Form::input('hidden', $name, $options['default_value'], $options['attr']) !!}

                @if($showError && isset($errors))
                    {!!$errors->first(array_get($options, 'real_name', $name), '<div '.$options['errorAttrs'].'>:message</div>')!!}
                @endif
                @if(isset($options['help']))
                    <span class="help-block">{!!$options['help']!!} </span>
                @endif

            </div>
            <script type="text/javascript">
                <?php $options['formatter']['libelle'] = explode(',', $options['formatter']['libelle']); ?>
                jQuery(document).ready(function () {
                    @if(isset($noEdit) and $noEdit === true)
                            var elt =  jQuery("input[name='{!!$name!!} ']").val().split(",");

                            jQuery.ajax({
                                url: "{!! (!empty($options['action']))?$options['action']:'' !!} ",
                                dataType: 'json',
                                type: 'POST',
                                data: {
                                    'ids': elt,
                                    '_token': jQuery("input[name='_token']").val()
                                }
                            }).done(function (data) {
                                @if($options['multiple']=='true')
                                    var tpl = '<ul>';
                                    for (var i = 0; i < data.length; i++) {
                                        var libelle = '';
                                        var item = data[i];
                                        @foreach($options['formatter']['libelle'] as $libelle)

                                        if (typeof(item.{!! $libelle  !!} ) != 'undefined' && item.{!! $libelle  !!}  != null) {
                                            libelle += item.{!! $libelle  !!} +' ';
                                        }

                                        @endforeach
                                        tpl += '<li>'+libelle+'</li>';
                                    }
                                    tpl += '</ul>';
                                @else

                                    var tpl = '';
                                    for (var i = 0; i < data.length; i++) {
                                        var libelle = '';
                                        var item = data[i];
                                        @foreach($options['formatter']['libelle'] as $libelle)
                                        if (typeof(item.{!! $libelle  !!} ) != 'undefined' && item.{!! $libelle  !!}  != null) {
                                            libelle += item.{!! $libelle  !!} +' ';
                                        }
                                        @endforeach

                                        tpl += ''+libelle+'';
                                    }

                                @endif

                                jQuery('.{!!$name!!} -noEdit').html(tpl);
                            });
                    @else

                        jQuery("input[name='{!!$name!!} ']").select2({
                                placeholder: "{!!_('Select a value')!!} ",
                                minimumInputLength: {!! $options['minimumInputLength']  !!} ,
                                allowClear: {!!$options['allowClear']!!} ,
                                maximumSelectionSize: {!! $options['maximum_selection_size'] !!} ,
                                multiple: {!! $options['multiple'] !!} ,
                                initSelection: function (element, callback) {

                                    var elt = element.val().split(",");

                                    if (elt.length > 0) {
                                        jQuery.ajax({
                                            url: "{!! (!empty($options['action']))?$options['action']:'' !!} ",
                                            dataType: 'json',
                                            type: 'POST',
                                            data: {
                                                'ids': elt,
                                                '_token': jQuery("input[name='_token']").val()
                                            }
                                        }).done(function (data) {
                                            for (var i = 0; i < data.length; i++) {
                                                callback(data[i]);
                                            }
                                        });
                                    }
                                },

                                adaptContainerCssClass: function (clazz) {
                                    clazz = '';
                                    return clazz;
                                },
                                formatNoMatches: function () {
                                    return "{!!_('No result')!!} ";
                                },
                                formatInputTooShort: function (input, min) {
                                    var n = min - input.length;
                                    return "{!!_('Please enter :number or more character')!!} ".replace(':number', n);
                                },
                                formatSelectionTooBig: function (limit) {
                                    return "{!!_('You can only select :number items')!!} ".replace(':number', limit);
                                },
                                formatLoadMore: function (pageNumber) {
                                    return "{!!_('Loading...')!!} ";
                                },
                                formatSearching: function () {
                                    return "{!!_('Searching...')!!} ";
                                },
                                ajax: {
                                    url: "{!! (!empty($options['action']))?$options['action']:'' !!} ",
                                    dataType: 'json',
                                    type: 'POST',
                                    quietMillis: 100,
                                    data: function (term, page) {
                                        return {
                                            term: term, //search term
                                            page_limit: 10, // page size
                                            page: page,
                                            _token: jQuery("input[name='_token']").val()
                                        };
                                    },
                                    results: function (data, page) {
                                        var more = (page * 10) < data.total;
                                        // notice we return the value of more so Select2 knows if more results can be loaded
                                        return {results: data.elements, more: more};
                                    }
                                },
                                formatResult: function format(item) {

                                    var libelle = '';
                                    @foreach($options['formatter']['libelle'] as $libelle)
                                        if (typeof(item.{!! $libelle  !!} ) != 'undefined' && item.{!! $libelle  !!}  != null) {
                                            libelle += item.{!! $libelle  !!} +' ';
                                        }
                                    @endforeach

                                    return libelle;

                                },
                                formatSelection: function format(item) {
                                    var libelle = '';
                                    @foreach($options['formatter']['libelle'] as $libelle)
                                    if (typeof(item.{!! $libelle  !!} ) != 'undefined' && item.{!! $libelle  !!}  != null) {
                                        libelle += item.{!! $libelle  !!} +' ';
                                    }
                                    @endforeach

                                    return libelle;
                                }
                            });
                    @endif

                });
            </script>

@if ($showLabel && $showField)
    </div>
@endif
