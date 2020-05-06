/**
 * @class	DataTable
 * @author	Alisson Guedes
 * @date	28/04/2020
 * @comment	Funções para organizar tabelas html5.
 */

'use strict'

var __self;

var DataTable = {

    init: () => {

        __self = DataTable;
        var col = window.location.href.split('/').slice(-2);

        $('body').find('.table').each(function() {

            $(this).find('.table-header').find('.table-col').each(function() {

                if (typeof $(this).data('orderable') === 'undefined' || $(this).data('orderable'))
                    $(this).addClass('sort');

                if (col[0] === $(this).text().trim().toLowerCase()) {
                    $(this).parents('.table').find('.table-header').find('.table-col').removeClass('asc desc')
                    $(this).addClass(col[1]);
                }

            })

        })

        __self.Search();
        __self.Ordernar();
        __self.Checkbox();
        __self.Categoria();
        __self.Adicionar();

    },

    ajax: ($url = '', $params = '') => {

        let $base_url = $('.table').data('url') + $url;

        $url = $base_url + '/' + $params;

        $.ajax({
            'type': 'get',
            'url': $url,
            'success': (data) => {
                var tbody = data;
                window.history.pushState('', '', $url);
                $('.table').find('.table-body').html($(tbody).find('.table-body').html());
                __self.Checkbox();
            }
        });


    },

    Search: () => {

        $('.search').find('input[type="search"]').keyup(delay(function(e) {

            var $search = $(this).val();
            let $sort;
            let $column;
            let $url;
            let $params = '';

            let $column_sort = $('.table').find('.table-header').find('.table-col');
            $('.table').find('.table-header').find('.table-col.checkbox').find(':checkbox#check-all').prop('checked', false).change();

            if ($column_sort.hasClass('asc')) {
                $column = $('.asc').text().toLowerCase().trim();
                $sort = 'asc';
            } else if ($column_sort.hasClass('desc')) {
                $column = $('.desc').text().toLowerCase().trim();
                $sort = 'desc';
            }

            if ($search !== '') {
                $url = '/filtro';
                $params = $search + '/';
            }

            __self.ajax($url, $params + $column + '/' + $sort);

        }, 300));

    },

    Ordernar: () => {

        $('body').find('.table').find('.table-header .table-col').on('click', function() {

            if ($(this).data('orderable') === false)
                return;

            let $search = $('.search').find('input[type="search"]').val();
            let $filtro = '';
            let $sort;
            let $column;
            let $params = '';

            $column = $(this).text().toLowerCase().trim();

            if ($(this).hasClass('asc')) {
                $(this).parent().find('.sort').removeClass('asc desc');
                $(this).addClass('desc');
                $sort = 'desc';
            } else {
                $(this).parent().find('.sort').removeClass('asc desc');
                $(this).addClass('asc');
                $sort = 'asc';
            }

            if ($search !== '')
                $filtro = 'filtro/' + $search + '/';

            $params = $filtro + $column + '/' + $sort;

            __self.ajax('', $params);

        });

    },

    Checkbox: () => {

        if ($('.table .table-body .table-row').find('.checkbox :checkbox').length === 0)
            $('.table .table-header').find('.checkbox :checkbox').attr('disabled', true);
        else
            $('.table .table-header').find('.checkbox :checkbox').attr('disabled', false);

        $('.table .table-body .table-row').find('.checkbox').find('label').on('click', function() {
            $(this).parent().find(':checkbox').toggle();
        })

        $('.table .table-header .table-row').find('.checkbox :checkbox').on('change', function() {

            if ($(this).is(':checked')) {
                $(this).parents('.table').find('.table-body').find('.checkbox :checkbox').prop('checked', true).change();
            } else {
                $(this).parents('.table').find('.table-body').find('.checkbox :checkbox').prop('checked', false).change();
            }

            __self.CheckboxState();

        })

        $('.table .table-body .table-row').find('.checkbox :checkbox').on('change', function() {

            $(this).prop('checked');

            if ($(this).is(':checked')) {

                if (!$(this).parent().find('i').is(':visible')) {
                    animate($(this).parent().find('i').show(), 'fadeIn fast', function(e) {
                        e.show();
                    });
                }

            } else {
                animate($(this).parent().find('i'), 'fadeOut fast', function(e) {
                    e.hide();
                });
            }

            __self.CheckboxState();

        });

    },

    CheckboxState: () => {

        var countCheckbox = $('.table .table-body :input:checkbox.trash').length;
        var countCheckeds = $('.table .table-body :input:checkbox.trash:checked').length;
        var indeterminate = document.getElementById('check-all');
        var buttonsAction = $('.table .table-header .table-actions');

        if (countCheckeds > 0) {

            $('button.btn-trash').attr('disabled', false);

            if (countCheckeds === countCheckbox) {

                indeterminate.indeterminate = false;

            } else if (countCheckeds < countCheckbox) {

                if (typeof indeterminate !== 'undefined' && indeterminate !== null)
                    indeterminate.indeterminate = true;
            }

            $('.table .table-header .checkbox :checkbox').prop('checked', true);
            $('.table .table-header .table-actions ~ .table-col').css({ 'z-index': '-1', 'position': 'relative' });
            buttonsAction.removeClass('animated fadeIn fadeOut fast').addClass('animated fadeIn fast').css({
                'opacity': '1',
                'display': 'flex'
            });

        } else {

            $('button.btn-trash').attr('disabled', true);
            $('.table .checkbox :checkbox:checked').prop('checked', false);
            buttonsAction.removeClass('animated fadeIn fadeOut fast').addClass('animated fadeOut').css({
                'opacity': '0',
                'display': 'none'
            });

            if (typeof indeterminate !== 'undefined' && indeterminate !== null)
                indeterminate.indeterminate = false;
            $('.table .table-header .table-actions ~ .table-col').css({ 'z-index': '1', 'position': 'relative' });

        }

    },

    Categoria: () => {

        $('#listar-categorias').find('li a').on('click', function() {

            let $href;
            let $url = $('.table').data('url');
            $href = $(this).attr('href').split('#').splice(1).toString();

            let $search = $('.search').find('input[type="search"]').val();
            let $filtro = '';
            let $sort;
            let $column;
            let $params = '';

            if ($('#page-form').is(':visible')) {
                $('#back-list').click();
            }


            if ($('.table .table-header').find('.table-col').hasClass('asc')) {
                $column = $('.table .table-header').find('.table-col.asc').text().toLowerCase().trim();
                $sort = 'asc';
            } else if ($('.table .table-header').find('.table-col').hasClass('desc')) {
                $column = $('.table .table-header').find('.table-col.desc').text().toLowerCase().trim();
                $sort = 'desc';
            }

            if ($search !== '')
                $filtro = 'filtro/' + $search + '/';

            $params = $filtro + $column + '/' + $sort;

            $(this).parents('#listar-categorias').find('li a').removeClass('active');
            $(this).addClass('active');

            __self.ajax('/' + $href, $params);

        });
    },

    Adicionar: () => {

        $('#adicionar').on('click', function() {
            $('#page-list').hide();
            $('#page-form').show();
            $('#page-form').find('*').attr('disabled', false);
            $('#adicionar').attr('disabled', true);
            $('[autofocus]').focus();
        })

        $('#back-list').on('click', function() {
            $('#page-list').show();
            $('#page-form').hide();
            $('#page-form').find('*').attr('disabled', true);
            $('#adicionar').attr('disabled', false);
        })

    }

}