<div class="table-responsive">
    <table  id='{!! $name !!}' class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>@{{ libelle.base }}</th>
            <th v-for="(key, head) in columns | orderBy '$key' -1">
            @if(!isset($noEdit) or $noEdit === false)
                <div class="input-group">
                    <div class="icheck-inline">
                        <label><h4><strong>@{{ libelle[key] }}</strong></h4></label>
                        <label>
                            <input class="icheck check-all" name="@{{key}}" type="radio" value="1">  {{trans('form-builder::form.all')}}
                        </label>
                        <label>
                            <input class="icheck uncheck-all" name="@{{key}}" type="radio" value="0">  {{trans('form-builder::form.none')}}
                        </label>
                    </div>
                </div>
            @endif

            </th>
    </tr>
    </thead>
    <tbody>
        <tr v-for="(key, head) in headers">
            <td>@{{ key }} </td>
            <td v-for="(tkey, type) in head | orderBy '$key' -1">
                <div class="input-group">
                    <div class="icheck-list" >
                        <label  v-for="ch in type" >
                            <input class="icheck" data-checkbox="@{{selected[tkey] && selected[tkey].indexOf(ch.id) > -1 ? 'icheckbox_line-blue' : 'icheckbox_line-grey'}}"  data-label="@{{ch.libelle}}" name="{!! $name !!}[@{{tkey}}][]" type="checkbox" value="@{{ch.id}}" v-model="selected[tkey].indexOf(ch.id) > -1"   {!! isset($noEdit) && $noEdit === true ? 'disabled' : 'enabled' !!}>
                        </label>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
    </table>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        var choice_area_ajax_vue = new Vue ({
            el: '#{!! $name !!}',
            data: {
                'header': [],
                'selected': []
            },
            ready: function() {
                if ($('#{!! $options["caller"] !!}').length == 0 || $('#{!! $options["caller"] !!}').val().length > 0)
                {
                    this.fetchTypeOfTasks();
                }
            },
            methods: {
                fetchTypeOfTasks: function(role_id, id) {
                    var self = this;
                    $.ajax({
                        url : "{!! (!empty($options['action']))?$options['action']:'' !!} ",
                        dataType: 'json',
                        type: 'POST',
                        data: $('#{!! $name !!}').parents('form').serialize()
                    }).done(function (response) {
                        self.$set('headers', response.choices);
                        self.$set('libelle', response.libelle);
                        self.$set('selected', response.selected);
                        $.each(response.choices, function (i, e){
                            self.$set('columns', e);
                            return false;
                        });
                        self.$nextTick(function () {
                            Metronic.init();
                            new dist.Form.Permission.Global();
                        });
                    });
                }
            }
        });

        $('#{!! $options["caller"] !!}').on('change', function (){
            if ($(this).val() != choice_area_ajax_vue.oldValue && $(this).val().length > 0)
            {
                choice_area_ajax_vue.oldValue = $(this).val();
                choice_area_ajax_vue.fetchTypeOfTasks();
            }
        });
    });
</script>