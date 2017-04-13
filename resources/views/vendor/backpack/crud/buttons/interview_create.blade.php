@if ($crud->hasAccess('create'))
    <a href="{{ url('admin/interview'.'/create/'.$crud->request->customer_id) }}" class="btn btn-primary ladda-button" data-style="zoom-in"><span
                class="ladda-label"><i
                    class="fa fa-plus"></i> Görüşme Ekle</span></a>
@endif