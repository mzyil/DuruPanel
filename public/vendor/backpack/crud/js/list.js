/**
 * Created by Melih on 30.03.2017.
 */
jQuery(function($){

    'use strict';

    $('#crudTable').on('draw.dt', function () {
        $("input[type=search]").focus();
    } );
});