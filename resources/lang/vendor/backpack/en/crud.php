<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backpack Crud Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the CRUD interface.
    | You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    // Forms
    'save_action_save_and_new' => 'Kaydet ve yeni kayıt',
    'save_action_save_and_edit' => 'Kydet ve bu kayıdı düzenle',
    'save_action_save_and_back' => 'Kaydet ve geri dön',
    'save_action_changed_notification' => 'Kaydettikten sonraki varsayılan davranış değiştirildi',

    // Create form
    'add'                 => 'Ekle',
    'back_to_all'         => 'Geri dön ',
    'cancel'              => 'İptal',
    'add_a_new'           => 'Yeni ekle ',

    // Edit form
    'edit'                 => 'Düzenle',
    'save'                 => 'Kaydet',

    // Revisions
    'revisions'            => 'Revisions',
    'no_revisions'         => 'No revisions found',
    'created_this'          => 'created this',
    'changed_the'          => 'changed the',
    'restore_this_value'   => 'Restore this value',
    'from'                 => 'from',
    'to'                   => 'to',
    'undo'                 => 'Undo',
    'revision_restored'    => 'Revision successfully restored',

    // CRUD table view
    'all'                       => 'Bütün ',
    'in_the_database'           => 'veritabaındaki',
    'list'                      => 'Liste',
    'actions'                   => 'Eylemler',
    'preview'                   => 'Önizleme',
    'delete'                    => 'Sil',
    'admin'                     => 'Admin',
    'details_row'               => 'Bu detaylar satırı.',
    'details_row_loading_error' => 'Detaylar yüklenirken hata oluştu. Lütfen tekrar deneyin.',

        // Confirmation messages and bubbles
        'delete_confirm'                              => 'Bu kaydı silmek istediğinizden emin misiniz?',
        'delete_confirmation_title'                   => 'Kayıt silindi',
        'delete_confirmation_message'                 => 'Kayıt başarılı bir şekilde silindi.',
        'delete_confirmation_not_title'               => 'SilinMEdi.',
        'delete_confirmation_not_message'             => "Bir hata oluştu. Kayıt silinmemiş olabilir.",
        'delete_confirmation_not_deleted_title'       => 'SilinMEdi.',
        'delete_confirmation_not_deleted_message'     => 'Hiçbir şey olmadı. Kaydınız güvende.',

        // DataTables translation
        'emptyTable'     => 'Tabloda kayıt yok.',
        'info'           => '_TOTAL_ kayıttan _START_ ile _END_ arası gösteriliyor.',
        'infoEmpty'      => '0 kayıttan 0 ile 0 arası gösteriliyor.',
        'infoFiltered'   => '(_MAX_ arasından filtrelendi)',
        'infoPostFix'    => ' ',
        'thousands'      => '.',
        'lengthMenu'     => 'sayfa başına _MENU_ kayıt',
        'loadingRecords' => 'Yükleniyor...',
        'processing'     => 'İşleniyor...',
        'search'         => 'Ara: ',
        'zeroRecords'    => 'Eşleşen kayıt bulunamadı',
        'paginate'       => [
            'first'    => 'İlk',
            'last'     => 'Son',
            'next'     => 'Sonraki',
            'previous' => 'Önceki',
        ],
        'aria' => [
            'sortAscending'  => ': activate to sort column ascending',
            'sortDescending' => ': activate to sort column descending',
        ],

    // global crud - errors
        'unauthorized_access' => 'Unauthorized access - you do not have the necessary permissions to see this page.',
        'please_fix' => 'Please fix the following errors:',

    // global crud - success / error notification bubbles
        'insert_success' => 'The item has been added successfully.',
        'update_success' => 'The item has been modified successfully.',

    // CRUD reorder view
        'reorder'                      => 'Reorder',
        'reorder_text'                 => 'Use drag&drop to reorder.',
        'reorder_success_title'        => 'Done',
        'reorder_success_message'      => 'Your order has been saved.',
        'reorder_error_title'          => 'Error',
        'reorder_error_message'        => 'Your order has not been saved.',

    // CRUD yes/no
        'yes' => 'Evet',
        'no' => 'Hayır',

    // Fields
        'browse_uploads' => 'Browse uploads',
        'clear' => 'Clear',
        'page_link' => 'Page link',
        'page_link_placeholder' => 'http://example.com/your-desired-page',
        'internal_link' => 'Internal link',
        'internal_link_placeholder' => 'Internal slug. Ex: \'admin/page\' (no quotes) for \':url\'',
        'external_link' => 'External link',
        'choose_file' => 'Choose file',

    //Table field
        'table_cant_add' => 'Cannot add new :entity',
        'table_max_reached' => 'Maximum number of :max reached',

    // File manager
    'file_manager' => 'Dosya yöneticisi',
];
