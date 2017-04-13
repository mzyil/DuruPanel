<!-- text input -->

<?php
/**
 * @type \Illuminate\Database\Eloquent\Collection $modelCollection
 *
 */
$modelCollection = $field['model']::where('customer_id', '=', $entry->customer_id)->get();
?>

<?php $i = 1; ?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach($modelCollection as $currAddr)
    <div @include('crud::inc.field_wrapper_attributes') >

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading{{$i}}">
                    <h4 class="panel-title">
                        <a style="display: block; width: 100%;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}"
                           aria-expanded="true" aria-controls="collapse{{$i}}">
                            Adres {{$i}}
                        </a>
                    </h4>
                </div>
                <div id="collapse{{$i}}" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="heading{{$i}}">
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
                                                name="address[{{$i}}][{{ $currAttr }}]"
                                                value="{{ $currAddr->$currAttr }}"
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
                        $field['select2_country']['entry'] = $currAddr;
                        $field['select2_country']['classsuffix'] = "country".$i;
                        $field['select2_country']['idname'] = "country".$i;
                        $field['select2_country']['name'] = str_replace("__ID__", "$i", $field['select2_country_name']);

                        $field['select2_zone']['entry'] = $currAddr;
                        $field['select2_zone']['classsuffix'] = "zone".$i;
                        $field['select2_zone']['idname'] = "zone".$i;
                        $field['select2_zone']['name'] = str_replace("__ID__", "$i", $field['select2_zone_name']);

                        $field['select2_country']['loadcssjs'] = $i == 1;
                        @endphp
                        @include('vendor.backpack.crud.fields.select2_from_ajax_extratrigger', array('field' => $field['select2_country']))
                        @include('vendor.backpack.crud.fields.select2_from_ajax_extratrigger', array('field' => $field['select2_zone']))
                        @include('crud::fields.hidden', array('field' =>  ['name' => "address[$i][address_id]", 'value' => $currAddr->getKey()]))
                    </div>
                </div>
            </div>
        </div>
    @push('crud_fields_scripts')
    <script type="application/javascript">
        jQuery(document).ready(function($) {
            var counter = {{ $i }};
            eval($(".select2_ajax_func_skeleton_country" + counter.toString())[0].innerHTML.replace(new RegExp("__ID__", "g"), counter.toString()));
            eval($(".select2_ajax_func_skeleton_zone" + counter.toString())[0].innerHTML.replace(new RegExp("__ID__", "g"), counter.toString()));
        });

    </script>
    @endpush
    <?php $i++ ?>
    @endforeach
</div>
