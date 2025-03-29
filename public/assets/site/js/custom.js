function showErrors(response) {
    var object = response.errors;
    var keys = Object.keys(object);

    $(".has-error").find(".help-block").remove();
    $(".has-error").removeClass("has-error");

    for(var i=0; i< keys.length; i++) {
        var ele = $("#"+keys[i]);
        var grp = ele.closest(".form-group");
        $(grp).find(".help-block").remove();
        $(grp).append('<div class="help-block">'+object[keys[i]]+'</div>');
        $(grp).addClass("has-error");
    }
}

function blockUI(div, message) {
    if (message == undefined) {
        message = "Loading...";
    }

    var html = '<div class="loading-message"><img src="' + assetsPath + 'images/bars.svg" align=""></div>';


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
