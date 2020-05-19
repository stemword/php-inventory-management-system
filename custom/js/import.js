$(document).ready(function() {
	// top nav bar 
	$('#importbrand').addClass('active');
	// manage product data table
	
	$("#brandfile").fileinput({
		overwriteInitial: true,
	  maxFileSize: 2500,
	  showClose: false,
	  showCaption: false,
	  browseLabel: '',
	  removeLabel: '',
	  browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
	  removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
	  removeTitle: 'Cancel or reset changes',
	  elErrorContainer: '#kv-avatar-errors-1',
	  msgErrorClass: 'alert alert-block alert-danger',
	  layoutTemplates: {main2: '{preview} {remove} {browse}'},
	  defaultPreviewContent: '<img src="assests/images/photo_default.png" alt="Profile Image" style="width:100%;">',							    
		allowedFileExtensions: ["csv", "xls", "xlsx"]
	  });
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		  
		

		// submit product form
		$("#submitImportForm").unbind('submit').bind('submit', function() {
			// form validation
			$(".text-danger").remove();
			var brandfile = $("#brandfile").val();
			if(brandfile == "") {
				$("#brandfile").closest('.center-block').after('<p class="text-danger">Brand file field is required</p>');
				$('#brandfile').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#brandfile").find('.text-danger').remove();
				// success out for form 
				$("#brandfile").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(brandfile) {
				// submit loading button
				$("#importBrandBtn").button('loading');

				var form = $(this);
				var formData = new FormData(this);

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: formData,
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					success:function(response) {

						if(response.success == true) {
							// submit loading button
							$("#importBrandBtn").button('reset');
							
							$("#submitImportForm")[0].reset();

							$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																	
							// shows a successful message after operation
							$('#add-product-messages').html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');

							// remove the mesages
		          $(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert

							// remove text-error 
							$(".text-danger").remove();
							// remove from-group error
							$(".form-group").removeClass('has-error').removeClass('has-success');

						} // /if response.success
						else {
							$('#add-product-messages').html('<div class="alert alert-danger">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');
				  $("#importBrandBtn").button('reset');
							
				  $("#submitImportForm")[0].reset();
						}
						
					} // /success function
				}); // /ajax function
			}	 // /if validation is ok 					

			return false;
		}); // /submit product form 

	//}); // /add product modal btn clicked
	

	// remove product 	

}); // document.ready fucntion
