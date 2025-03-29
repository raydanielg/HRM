// Variable for testing error is from javascript or php
var slideID = "";

function showResponseMessage(response, divID) {
    $('#' + divID).html('');
    toastrType = typeof toastrType !== 'undefined' ? toastrType : 'success';

    if (response.status == "fail") {
        if (typeof response.errors == "object") {

            // For Sliding to first error div
            var iCount = 0;

            for (var key in response.errors) {
                if (response.errors.hasOwnProperty(key)) {

                    if (iCount == 0) {
                        slideID = key;
                    }

                    var obj = response.errors[key];
                    showInputError(key, obj[0]);

                }
            }

            if (typeof slideID != "undefined" && slideID != "") {
                $("html, body").animate({scrollTop: $("[name='" + slideID + "']").offset().top - 70}, 200);
            }

            if (response.toastrHeading && response.toastrMessage) {
                showToastrMessage(response.toastrMessage, response.toastrHeading, 'error')
            }
        }
        else {
            $('#' + divID).html('<div class="alert alert-danger"><p>' + response.message + '</p></div>');
        }
    }
    else {
        if (response.status === "success") {
            $('#' + divID).html('<div class="alert alert-success"><p>' + response.message + '</p></div>');

            if (response.action == "redirect") {
                window.location.href = response.url;
            }
            if (response.action == "showToastr") {
                toastrType = typeof response.toastrType !== 'undefined' ? response.toastrType : 'success';
                showToastrMessage(response.toastrMessage, response.toastrHeading, toastrType)
            }

            if (response.action == "reload") {
                window.location.reload();
            }

        }
        else {
            if (response.status == "responsePending") {
                $('#' + divID).html('<div class="alert alert-info"><p>' + response.message + '</p></div>');

            }
        }
    }

    return false;
}

function hideErrors() {
    $(".has-error").each(function () {
        $(this).find(".help-block").text("");
        $(this).removeClass("has-error");
    });
}

function showInputError(inputName, errorMessage) {
    var formGroup = $("[name='" + inputName + "']").closest(".form-group");
    formGroup.addClass("has-error");
    formGroup.find(".help-block").text(errorMessage);

    if (slideID == "") {
        $("html, body").animate({scrollTop: $("[name='" + slideID + "']").offset().top - 70}, 1000);
    }
}

function showToastrMessage(toastrMessage, toastrHeading, toastrType) {
    toastrType = typeof toastrType !== 'undefined' ? toastrType : 'success';

    toastr[toastrType](toastrMessage, toastrHeading);
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}

function prepareMessage(rawMessage, tag, replacement) {

    return rawMessage.replace(tag, replacement);
}

function showErrors(object) {
    var keys = Object.keys(object);

    $(".has-error").find(".help-block").remove();
    $(".has-error").removeClass("has-error");

    for (var i = 0; i < keys.length; i++) {
        var ele = $("[name='" + keys[i] + "']");
        if (ele.length == 0) {
            ele = $("#" + keys[i]);
        }
        var grp = ele.closest(".form-group");
        $(grp).find(".help-block").remove();
        $(grp).find("div:first").append('<div class="help-block">' + object[keys[i]] + '</div>');
        $(grp).addClass("has-error");
    }
}



function loadingButton(id) {
    var button = $(id);

    var text = "Submitting...";

    if (button.width() < 20) {
        text = "...";
    }

    if (button.is("button")) {
        button.attr("data-prev-text", button.html());
        button.text(text);
        button.prop("disabled", true);
    }
    else {
        button.attr("data-prev-text", button.val());
        button.val(text);
        button.prop("disabled", true);
    }
}

function unloadingButton(id) {
    var button = $(id);

    if (button.is("button")) {
        button.html(button.attr("data-prev-text"));
        button.prop("disabled", false);
    }
    else {
        button.val(button.attr("data-prev-text"));
        button.prop("disabled", false);
    }
}

$.fn.serializeJson = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function blockUI(div, message) {
    if (message == undefined) {
        message = "Loading...";
    }

    var html = '<div class="loading-message"><img src="' + assetsPath + '/loader.gif" align=""></div>';


    if (div != undefined) { // element blocking
        var el = $(div);
        var centerY = false;
        if (el.height() <= ($(window).height())) {
            centerY = true;
        }
        el.block({
            message: html,
            baseZ: 1000,
            centerY: centerY,
            css: {
                top: '10%',
                border: '0',
                padding: '0',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: '#555',
                opacity: 0.05,
                cursor: 'wait'
            }
        });
    } else { // page blocking
        $.blockUI({
            message: html,
            baseZ: 1000,
            css: {
                border: '0',
                padding: '0',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: '#555',
                opacity: 0.05,
                cursor: 'wait'
            }
        });
    }
}

function unblockUI(div) {
    if (div == undefined) {
        $.unblockUI();
    }
    else {
        $(div).unblock({
            onUnblock: function () {
                $(div).css('position', '');
                $(div).css('zoom', '');
            }
        });
    }

}