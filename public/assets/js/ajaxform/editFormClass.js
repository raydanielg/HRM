$(document).ready(function() {
	//$(".ajax_form").submit(function(event){
	$('body').on('submit','.ajax_form',function(){
			var posturl = $(this).attr('action');
			var formid = '#'+$(this).attr('id');
			
			$(this).ajaxSubmit({
				url: posturl,
				dataType: 'json',
				beforeSend: function(){
                    Metronic.blockUI({
                        target: '#ajaxFormDiv',
                        boxed: true
                    });
				},
				success: function(response){
                    showResponseMessage(response, "error");
                    Metronic.unblockUI('#ajaxFormDiv');
				},
				error:function(response){
                    resposeArray = {
                        "status" : "fail",
                        "errorCode": "unkonwn",
                        "message": "Problem occoured.Please login after sometime."
                    };
                    showResponseMessage(resposeArray, "error");
                    Metronic.unblockUI('#ajaxFormDiv');
                }
			});
			return false;
		});
	});

function slideToElement(element){
	$("html, body").animate({scrollTop: $(element).offset().top-50 }, 1000);
}

function slideToDiv(element){
	$("html, body").animate({scrollTop: $(element).offset().top-50 }, 1000);
}

$(document).ready(function(e) {
    $(".alert-message .close").click(function(e) {
        $(this).closest(".alert-message").fadeOut('slow');
    });
});
