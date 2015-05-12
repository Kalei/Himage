/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */
function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam)
        {
            return sParameterName[1];
        }
    }
}

$(document).ready(function () {
    'use strict';

    var page = getUrlParameter('page') ? getUrlParameter('page') : 0;
    var nb_max = getUrlParameter('nb_max') ? getUrlParameter('nb_max') : 10;
    var sort = getUrlParameter('sort') ? getUrlParameter('sort') : 'ID_DESC';
    var recherche = getUrlParameter('recherche') ? getUrlParameter('recherche') : null;
    var url = '/images/photos/';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        prependFiles: true,
        url: url + '?page=' + page + '&nb_max=' + nb_max + '&sort=' + sort + ((recherche != null) ? '&recherche=' + recherche : ''),
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            page++;
            $('#fileupload').fileupload({
                prependFiles: false,
                url: url + '?page=' + page + '&nb_max=' + nb_max + '&sort=' + sort + ((recherche != null) ? '&recherche=' + recherche : ''),
            });
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                url: $('#fileupload').fileupload('option', 'url'),
                dataType: 'json',
                context: $('#fileupload')[0]
            }).always(function () {
                $(this).removeClass('fileupload-processing');
            }).done(function (result) { // ICI on a terminé le chargement des images ( youpi )

                $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});

                $("ul.notes-echelle li").mouseover(function () {
                    // On passe les notes supérieures à l'état inactif (par défaut)
                    $(this).nextAll("li").addClass("note-off");
                    // On passe les notes inférieures à l'état actif
                    $(this).prevAll("li").removeClass("note-off");
                    // On passe la note survolée à l'état actif (par défaut)
                    $(this).removeClass("note-off");
                });
                // Lorsque l'on sort du sytème de notation à la souris
                $("ul.notes-echelle").mouseout(function () {
                    // On passe toutes les notes à l'état inactif
                    $(this).children("li").addClass("note-off");
                    // On simule (trigger) un mouseover sur la note cochée s'il y a lieu
                    $(this).find("li input:checked").parent("li").trigger("mouseover");
                });

                $("ul.notes-echelle input").focus(function () {
                    console.log($(this));
                    // On passe les notes supérieures à l'état inactif (par défaut)
                    $(this).parent("li").nextAll("li").addClass("note-off");
                    // On passe les notes inférieures à l'état actif
                    $(this).parent("li").prevAll("li").removeClass("note-off");
                    // On passe la note du focus à l'état actif (par défaut)
                    $(this).parent("li").removeClass("note-off");
                }).blur(function () {
                    // Si il n'y a pas de case cochée
                    if ($(this).parent("ul.notes-echelle").find("li input:checked").length == 0) {
                        // On passe toutes les notes à l'état inactif
                        $(this).parent("ul.notes-echelle").find("li").addClass("note-off");
                    }
                }).click(function () {
                    // On supprime les classes de note cochée
                    $(this).parent("ul.notes-echelle").find("li").removeClass("note-checked");
                    // On applique la classe de note cochée sur l'item choisi
                    $(this).parent("li").addClass("note-checked");

                    var $form = $(this).closest('form');
                    var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                    $.ajax({
                        url: $form.attr("action"),
                        data: $form.serialize(),
                        type: method,
                        success: function (data) {
                            //console.log(data);
                        }
                    });

                });

                $(".dformat_list").change(function () {
                    var $form = $(this).closest('form');
                    var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                    $.ajax({
                        url: $form.attr("action"),
                        data: $form.serialize(),
                        type: method,
                        success: function (data) {
                            //console.log(data);
                        }
                    });
                });

                $(".form-description").submit(function () {
                    var $form = $(this);
                    var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                    $.ajax({
                        url: $form.attr("action"),
                        data: $form.serialize(),
                        type: method,
                        success: function (data) {
                            //console.log(data);
                            $form.append('<span class="alert alert-success" style="padding:5px;">à été modifié</span>');
                            setTimeout(function () {
                                $('.form-description .alert').fadeOut('slow');
                            }, 3000);
                        }
                    });

                    return false;
                });

                $(".form-titre").submit(function () {
                    var $form = $(this);
                    var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                    $.ajax({
                        url: $form.attr("action"),
                        data: $form.serialize(),
                        type: method,
                        success: function (data) {
                            $form.append('<span class="alert alert-success" style="padding:5px;">à été modifié</span>');

                            setTimeout(function () {
                                $('.form-titre .alert').fadeOut('slow');
                            }, 3000);
                        }
                    });

                    return false;
                });

                $(".form-nom").submit(function () {
                    var $form = $(this);
                    var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                    $.ajax({
                        url: $form.attr("action"),
                        data: $form.serialize(),
                        type: method,
                        success: function (data) {
                            $form.append('<span class="alert alert-success" style="padding:5px;">à été modifié</span>');
                            console.log(data);
                            setTimeout(function () {
                                $('.form-nom .alert').fadeOut('slow');
                            }, 3000);
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });

                    return false;
                });
            });
        }
        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            prependFiles: true,
            url: url + '?page=' + page + '&nb_max=' + nb_max + '&sort=' + sort + ((recherche != null) ? '&recherche=' + recherche : ''),
        });
    });

    $('#fileupload').bind('fileuploadsubmit', function (e, data) {
        var inputs = data.context.find(':input');
        var selects = data.context.find('option:selected');
        data.formData = inputs.serializeArray();
        console.debug(data);
        if (inputs.filter(function () {
            return !this.value && $(this).prop('required');
        }).first().focus().length) {
            data.context.find('button').prop('disabled', false);
            return false;
        }
        data.formData = inputs.serializeArray();
        console.debug(data);
    });


    $(document).on("change", ".recadrage_auto", function () {
        console.debug($(this).next("input"));
        $(this).next("input").val($(this).find("option:selected").text());
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                    )
            );

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                        .text('Upload server currently unavailable - ' +
                                new Date())
                        .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) { // ICI on a terminé le chargement des images ( youpi )
            console.log(result);
            $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});

            $("ul.notes-echelle li").mouseover(function () {
                // On passe les notes supérieures à l'état inactif (par défaut)
                $(this).nextAll("li").addClass("note-off");
                // On passe les notes inférieures à l'état actif
                $(this).prevAll("li").removeClass("note-off");
                // On passe la note survolée à l'état actif (par défaut)
                $(this).removeClass("note-off");
            });
            // Lorsque l'on sort du sytème de notation à la souris
            $("ul.notes-echelle").mouseout(function () {
                // On passe toutes les notes à l'état inactif
                $(this).children("li").addClass("note-off");
                // On simule (trigger) un mouseover sur la note cochée s'il y a lieu
                $(this).find("li input:checked").parent("li").trigger("mouseover");
            });

            $("ul.notes-echelle input").focus(function () {
                console.log($(this));
                // On passe les notes supérieures à l'état inactif (par défaut)
                $(this).parent("li").nextAll("li").addClass("note-off");
                // On passe les notes inférieures à l'état actif
                $(this).parent("li").prevAll("li").removeClass("note-off");
                // On passe la note du focus à l'état actif (par défaut)
                $(this).parent("li").removeClass("note-off");
            }).blur(function () {
                // Si il n'y a pas de case cochée
                if ($(this).parent("ul.notes-echelle").find("li input:checked").length == 0) {
                    // On passe toutes les notes à l'état inactif
                    $(this).parent("ul.notes-echelle").find("li").addClass("note-off");
                }
            }).click(function () {
                // On supprime les classes de note cochée
                $(this).parent("ul.notes-echelle").find("li").removeClass("note-checked");
                // On applique la classe de note cochée sur l'item choisi
                $(this).parent("li").addClass("note-checked");

                var $form = $(this).closest('form');
                var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                $.ajax({
                    url: $form.attr("action"),
                    data: $form.serialize(),
                    type: method,
                    success: function (data) {
                        //console.log(data);
                    }
                });

            });

            $(".dformat_list").change(function () {
                var $form = $(this).closest('form');
                var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                $.ajax({
                    url: $form.attr("action"),
                    data: $form.serialize(),
                    type: method,
                    success: function (data) {
                        //console.log(data);
                    }
                });
            });

            $(".form-description").submit(function () {
                var $form = $(this);
                var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                $.ajax({
                    url: $form.attr("action"),
                    data: $form.serialize(),
                    type: method,
                    success: function (data) {
                        //console.log(data);
                        $form.append('<span class="alert alert-success" style="padding:5px;">à été modifié</span>');
                        setTimeout(function () {
                            $('.form-description .alert').fadeOut('slow');
                        }, 3000);
                    }
                });

                return false;
            });

            $(".form-titre").submit(function () {
                var $form = $(this);
                var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                $.ajax({
                    url: $form.attr("action"),
                    data: $form.serialize(),
                    type: method,
                    success: function (data) {
                        $form.append('<span class="alert alert-success" style="padding:5px;">à été modifié</span>');

                        setTimeout(function () {
                            $('.form-titre .alert').fadeOut('slow');
                        }, 3000);
                    }
                });

                return false;
            });

            $(".form-nom").submit(function () {
                var $form = $(this);
                var method = $form.attr("method") ? $form.attr("method").toUpperCase() : "GET";
                $.ajax({
                    url: $form.attr("action"),
                    data: $form.serialize(),
                    type: method,
                    success: function (data) {
                        $form.append('<span class="alert alert-success" style="padding:5px;">à été modifié</span>');
                        console.log(data);
                        setTimeout(function () {
                            $('.form-nom .alert').fadeOut('slow');
                        }, 3000);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

                return false;
            });
        });
    }
});