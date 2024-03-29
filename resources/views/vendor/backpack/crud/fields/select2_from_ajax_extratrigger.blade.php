<!-- select2 from ajax -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <?php $entity_model = $crud->model; ?>
    <input type="hidden" name="{{ $field['name'] }}" id="select2_ajax_{{ $field['idname'] }}"
           @if(isset($field['entry']))
            value="{{ $entry->$field['model_attr'] }}"
           @endif
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])
    >

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

@php
    $connected_entity = new $field['model'];
    $connected_entity_key_name = $connected_entity->getKeyName();
@endphp

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if (isset($field['loadcssjs']) && $field['loadcssjs'] == true)

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <!-- include select2 css-->
    <link href="{{ asset('vendor/backpack/select2/select2.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendor/backpack/select2/select2-bootstrap-dick.css') }}" rel="stylesheet" type="text/css"/>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('vendor/backpack/select2/select2.js') }}"></script>
    @endpush

@endif

<!-- include field specific select2 js-->
@push('crud_fields_scripts')
<script type="text/javascript" class="select2_ajax_func_skeleton_{{$field['classsuffix']}}">
    //$ = jQuery;
    // trigger select2 for each untriggered select2 box
    $("#select2_ajax_{{ $field['idname'] }}").each(function (i, obj) {
        if (!$(obj).data("select2")) {
            $(obj).select2({
                placeholder: "{{ $field['placeholder'] }}",
                minimumInputLength: "{{ $field['minimum_input_length'] }}",
                ajax: {
                    url: function () {
                        if ("{{ $field['data_source'] }}".indexOf("{{ isset($field['replacepart']) ? $field['replacepart'] : "SOMETEXT" }}") >= 0) {
                            return "{{ $field['data_source'] }}".replace(
                                new RegExp("{{ isset($field['replacepart']) ? $field['replacepart'] : "SOMETEXT"  }}", "g"),
                                document.getElementById(obj.id.replace(new RegExp("zone", "g"), "country")).getAttribute("value")
                            );
                        }
                        return "{{ $field['data_source'] }}";
                    },
                    dataType: 'json',
                    quietMillis: 250,
                    data: function (term, page) {
                        return {
                            q: term, // search term
                            page: page
                        };
                    },
                    results: function (data, params) {
                        params.page = params.page || 1;

                        var result = {
                            results: $.map(data.data, function (item) {
                                        @if(is_array($field['attribute']))
                                var textToReturn = "";
                                @foreach($field['attribute'] as $attr)
                                    textToReturn += item["{{ $attr }}"] + " ~~ ";
                                @endforeach
                                    return {
                                    text: textToReturn,
                                    id: item["{{ $connected_entity_key_name }}"]
                                };
                                @else
                                    textField = "{{ $field['attribute'] }}";
                                return {
                                    text: item[textField],
                                    id: item["{{ $connected_entity_key_name }}"]
                                }
                                @endif
                            }),
                            more: data.current_page < data.last_page
                        };

                        return result;
                    },
                    cache: true
                },
                initSelection: function (element, callback) {
                    // the input tag has a value attribute preloaded that points to a preselected repository's id
                    // this function resolves that id attribute to an object that select2 can render
                    // using its formatResult renderer - that way the repository name is shown preselected
                    $.ajax("{{ isset($field['data_source_single']) ? $field['data_source_single'] : $field['data_source'] }}" + '/' + "{{ isset($field['entry']) ? $field['entry']->$field['model_attr'] : "" }}", {
                        dataType: "json"
                    }).done(function (data) {
                        var callbackArg = {};
                                @if(is_array($field['attribute']))
                        var textToReturn = "";
                        @foreach($field['attribute'] as $attr)
                            textToReturn += " " + data["{{ $attr }}"];
                        @endforeach
                            callbackArg = {
                            text: textToReturn,
                            id: data["{{ $connected_entity_key_name }}"]
                        };
                        @else
                            textField = "{{ $field['attribute'] }}";
                        callbackArg = {
                            text: data[textField],
                            id: data["{{ $connected_entity_key_name }}"]
                        };
                        @endif
                        callback(callbackArg);
                    });
                }
            }).select2('val', []);
        }
    });
</script>
@endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
