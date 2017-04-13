<!-- text input -->

{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

{{-- @push('crud_fields_styles')
    <!-- no styles -->
@endpush --}}


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

@push('crud_fields_scripts')
<script type="text/html" id="form_skeleton">
    <div @include('crud::inc.field_wrapper_attributes') >
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a style="display: block; width: 100%;" role="button" data-toggle="collapse"
                           data-parent="#accordion" href="#collapse__ID__"
                           aria-expanded="true" aria-controls="collapse__ID__">
                            Adres __ID__
                        </a>
                    </h4>
                </div>
                <div id="collapse__ID__" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="heading__ID__">
                    <div class="panel-body">
                        @foreach($field['attribute'] as $currAttr)
                            <div @include('crud::inc.field_wrapper_attributes') >
                                <label>{!! $field['labels'][$currAttr] !!}</label>
                                @include('crud::inc.field_translatable_icon')
                                @if(isset($field['prefix']) || isset($field['suffix']))
                                    <div class="input-group"> @endif
                                        @if(isset($field['prefix']))
                                            <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
                                        <input
                                                type="text"
                                                name="address[__ID__][{{ $currAttr }}]"
                                                value=""
                                                @include('crud::inc.field_attributes')
                                        >
                                        @if(isset($field['suffix']))
                                            <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif
                                        @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

                                {{-- HINT --}}
                                @if (isset($field['hint']))
                                    <p class="help-block">{!! $field['hint'] !!}</p>
                                @endif
                            </div>
                        @endforeach
                        @php
                        $field['select2_country']['loadcssjs'] = true;
                        @endphp
                        @include('vendor.backpack.crud.fields.select2_from_ajax_extratrigger', array('field' => $field['select2_country']))
                        @include('vendor.backpack.crud.fields.select2_from_ajax_extratrigger', array('field' => $field['select2_zone']))
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
<script id="add_address_button_code" type="text/html">
@include("vendor.backpack.crud.buttons.add_address_field")
</script>
<script type="application/javascript">
    var counter = 1;
    jQuery(document).ready(function($) {
       $('#saveActions').append(document.getElementById('add_address_button_code').innerHTML);
        var skeleton = document.getElementById('form_skeleton').innerHTML;
        $("#add_address_button").click(function (event) {
           $(".box-body.row").append(skeleton.replace(new RegExp("__ID__", "g"), counter.toString()));
           eval($(".select2_ajax_func_skeleton_country")[0].innerHTML.replace(new RegExp("__ID__", "g"), counter.toString()));
           eval($(".select2_ajax_func_skeleton_zone")[0].innerHTML.replace(new RegExp("__ID__", "g"), counter.toString()));
           counter++;
        });
    });

</script>
@endpush


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}

