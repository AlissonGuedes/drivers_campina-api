'use strict';

var navbar,
    btn_menu,
    hide_on_modal,
    modal,
    form,
    $form,
    Form;

var Dashboard = {

    init: function() {

        navbar = $('.page-topbar').find('.navbar-main');
        btn_menu = $('body').find('a[data-target="slide-out"]');
        hide_on_modal = $('.hide-on-display-modal');
        modal = $('body').find('.modal').attr('id');

        this.searchs();
        this.modal_close();
        // 	$('button[data-toggle="modal"],table[data-toggle="modal"] tr td').on('click', function(e)
        // 	{
        // 		console.log(e.currentTarget.dataset);
        // 		var title = e.currentTarget.dataset.title || e.currentTarget.dataset.tooltip;
        // 		alert(title);
        // 			if(e.currentTarget.dataset.target !== 'modal-location')
        // 		Dashboard.modal_form.open(title);
        // 	});

        $('body').find('.input-field').each(function() {

            $(this).append(
                $('<div/>', {
                    'class': 'line-ripple',
                })
            ).append(
                $('<div/>', {
                    'class': 'helper-line'
                }).append(
                    $('<div/>', {
                        'class': 'helper-text'
                    })
                ).append(
                    $('<div/>', {
                        'class': 'helper-counter'
                    })
                )
            );

        });

    },

    searchs: function() {

        var filter = $('.dataTables_filter');
        var search = filter.find('input[type="search"]');
        var input = $('.header-search-input,.search-box-sm');
        var placeholder = search.attr('placeholder');

        if (filter.length > 0) {

            input.attr('placeholder', placeholder).on('keyup', function() {
                search.val(this.value).keyup();
            });

            $('.search-sm-close').on('click', function() {
                input.val('');
                search.val('').keyup();
            });

            search.on('keyup', function() {
                input.val(this.value);
            });

            filter.parent().parent().parent().parent().hide();

        } else {

            input.on('keyup', function() {

                $.ajax({
                    'url': BASE_URL + 'search',
                    'type': 'post',
                    'dataType': 'html',
                    'data': {
                        q: $(this).val()
                    },
                    success: function(data) {
                        $('#main').hide();
                        $('#content').remove('#results').append($('<div id="results"/>').html('Nada encontrado'));
                    }

                });

            });

        }

    },

    modal_form: {
        open: function(title) {

            // Remover todas as mensagens de alertas
            $('#toast-container').find('.toast').remove();

            // limpar o campo de pesquisa se estiver aberto (devices)
            $('.search-sm').hide().find('.search-sm-close').click();

            // ocultar todos os elementos do cabeçalho
            animate(hide_on_modal, 'fadeOut fast', function(e) {
                e.hide();
            });

            /*** Título da página ***/

            animate(navbar.find('.page-title').html($('<h2/>').html(title)), 'fadeIn fast delay-200ms', function(e) {
                e.show();
            });

            /*** Botão submit ***/
            $('.submit_form').removeClass('display-none');

            animate($('.submit_form'), 'fadeIn fast delay-200ms', function(e) {
                Form.Blocked(e.find('button[type="submit"]'), 'save', false);
            });

            /*** Botão fechar ***/

            // animar botão de fechar a modal
            btn_menu.find('i').text('close');
            btn_menu.removeClass('hide-on-large-only').addClass('btn-modal-close');
            animate(btn_menu, 'rotateIn slow', function(e) {
                e.removeAttr('data-target');
                e.removeClass('sidenav-trigger sidebar-collapse');
            });

        },

        close: function(self) {

            /*** Título da página ***/
            animate(navbar.find('.page-title'), 'fadeOut fast', function(e) {
                e.empty();
            });

            /*** Botão submit ***/
            animate($('.submit_form'), 'fadeOut fast', function(e) {
                e.addClass('display-none');
            });

            /*** Botão fechar ***/

            // Animar botão fechar e voltar exibir o menu
            animate(self, 'rotateOut slow', function(e) {
                e.attr('data-target', 'slide-out').find('i').text('menu');
                e.addClass('sidenav-trigger sidebar-collapse hide-on-large-only').removeClass('btn-modal-close');
                animate(e, 'rotateIn faster');
            });

            // Remover modal
            $('button[type="reset"].modal-close').click();

            /*** Re-Exibir todos os elementos do cabeçalho. ***/
            animate(hide_on_modal.show(), 'fadeIn fast delay-200ms', function(e) {
                e.show();
            });

        },

    },

    modal_close: function() {

        var result;

        form = $('#' + modal).find('form').attr('id');
        $form = '#' + form;

        Form = new Forms();

        $('nav .submit_form').find('button[type="submit"]').on('click', function() {
            var $form = $('#' + modal).find('form').attr('id');

            Form.formSubmit($('#' + $form));

            setTimeout(function() {
                result = Form.getResult();
                if (typeof result !== 'undefined' && result.type === 'success')
                    Dashboard.modal_form.close(btn_menu);
                console.log('--- result - file: app.js ---');
                console.log(result);
            }, 500);


        });

        btn_menu.on('click', function(e) {

            e.preventDefault();

            var self = $(this);

            if (self.hasClass('sidenav-trigger'))
                return;

            swal({

                title: 'Você tem certeza?',
                text: 'As alterações não foram salvas.',
                dangerMode: true,
                closeOnClickOutside: true,
                closeOnEsc: true,
                buttons: {
                    cancel: {
                        text: 'Cancelar',
                        value: false,
                        visible: true,
                    },
                    delete: {
                        text: 'Excluir',
                        value: true,
                        visible: true,
                    }
                }

            }).then(function(excluir) {

                if (excluir)
                    Dashboard.modal_form.close(self);

            });

        });

    }

};

function toggle(e) {
    checkboxes = document.getElementsByName("foo");
    for (var i = 0, o = checkboxes.length; i < o; i++) checkboxes[i].checked = e.checked
}

function resizetable() {
    0 < $(".vertical-layout").length ? $(".app-email .collection").css({
        maxHeight: $(window).height() - 350 + "px"
    }) : $(".app-email .collection").css({
        maxHeight: $(window).height() - 410 + "px"
    })
}

$(document).ready(function() {
        "use strict";
        900 < $(window).width() && $("#email-sidenav").removeClass("sidenav");
        new Quill(".snow-container .compose-editor", {
            modules: {
                toolbar: ".compose-quill-toolbar"
            },
            placeholder: "Write a Message... ",
            theme: "snow"
        });
        if ($("#email-sidenav").sidenav({
                onOpenStart: function() {
                    $("#sidebar-list").addClass("sidebar-show")
                },
                onCloseEnd: function() {
                    $("#sidebar-list").removeClass("sidebar-show")
                }
            }), 0 < $("#sidebar-list").length) new PerfectScrollbar("#sidebar-list", {
            theme: "dark",
            wheelPropagation: !1
        });
        if (0 < $(".app-email .collection").length) new PerfectScrollbar(".app-email .collection", {
            theme: "dark",
            wheelPropagation: !1
        });

        if (0 < $('#scroll-table .table-body .table-body--content').length) new PerfectScrollbar('#scroll-table .table-body .table-body--content', {
            theme: 'dark',
            wheelPropagation: !1
        });
        if ($(".email-list li").click(function() {
                var e = $(this);
                e.hasClass("sidebar-title") || ($("li").removeClass("active"), e.addClass("active"))
            }), $('.app-email i[type="button"]').click(function(e) {
                $(this).closest("tr").remove()
            }), $(".app-email .favorite i").on("click", function(e) {
                e.preventDefault(), $(this).toggleClass("amber-text")
            }), $(".app-email .email-label i").on("click", function(e) {
                e.preventDefault(), $(this).toggleClass("amber-text"), "label_outline" == $(this).text() ? $(
                    this).text("label") : $(this).text("label_outline")
            }), $(".app-email .delete-mails").on("click", function() {
                $(".collection-item").find("input:checked").closest(".collection-item").remove()
            }), $(".app-email .delete-task").on("click", function() {
                $(this).closest(".collection-item").remove()
            }), $(".sidenav-trigger").on("click", function() {
                $(window).width() < 960 && ($(".sidenav").sidenav("close"), $(".app-sidebar").sidenav("close"))
            }), $("#email_filter").on("keyup", function() {
                $(".email-brief-info").css("animation", "none");
                var e = $(this).val().toLowerCase();
                "" != e ? ($(".email-collection .email-brief-info").filter(function() {
                        $(this).toggle(-1 < $(this).text().toLowerCase().indexOf(e))
                    }), 0 == $(".email-brief-info:visible").length ? $(".no-data-found").hasClass("show") ||
                    $(".no-data-found").addClass("show") : $(".no-data-found").removeClass("show")) : $(
                    ".email-collection .email-brief-info").show()
            }), $(".compose-email-trigger").on("click", function() {
                $(".email-overlay").addClass("show"), $(".email-compose-sidebar").addClass("show")
            }), $(
                ".email-compose-sidebar .cancel-email-item, .email-compose-sidebar .close-icon, .email-compose-sidebar .send-email-item, .email-overlay"
            ).on("click", function() {
                $(".email-overlay").removeClass("show"), $(".email-compose-sidebar").removeClass("show"), $(
                    "input").val(""), $(".compose-editor .ql-editor p").html(""), $("#edit-item-from").val(
                    "user@example.com")
            }), 0 < $(".email-compose-sidebar").length) new PerfectScrollbar(".email-compose-sidebar", {
            theme: "dark",
            wheelPropagation: !1
        });
        0 < $("html[data-textdirection='rtl']").length && $("#email-sidenav").sidenav({
            edge: "right",
            onOpenStart: function() {
                $("#sidebar-list").addClass("sidebar-show")
            },
            onCloseEnd: function() {
                $("#sidebar-list").removeClass("sidebar-show")
            }
        })
    }),
    $(window).on("resize", function() {
        resizetable(), $(".email-compose-sidebar").removeClass("show"), $(".email-overlay").removeClass("show"), $(
            "input").val(""), $(".compose-editor .ql-editor p").html(""), $("#edit-item-from").val(
            "user@example.com"), 899 < $(window).width() && $("#email-sidenav").removeClass("sidenav"), $(
            window).width() < 900 && $("#email-sidenav").addClass("sidenav")
    }),
    resizetable();