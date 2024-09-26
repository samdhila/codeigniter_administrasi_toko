jQuery(function($) {
	$(document).on('click', '.toolbar a[data-target]', function(e) {
		e.preventDefault();
		var target = $(this).data('target');
		$('.widget-box.visible').removeClass('visible');//hide others
		$(target).addClass('visible');//show target
	});
});
//you don't need this, just used for changing background
jQuery(function($) {
	$('body').attr('class', 'login-layout light-login');
	$('#id-text2').attr('class', 'grey');
	$('#id-company-text').attr('class', 'blue');
});

$(document).ready(function(){
    $("#f_login").submit(function(){
		var uname = $('#username').val();
		var pass = $('#password').val();
		 $.ajax({
			 type: "POST",
			 url: base_url+'login/aksi_login',
			 dataType: 'JSON',
			 data: {username: uname, password: pass},
			 cache:false,
			 success: function(data){
				 var status = data.status;
				 var msg = data.msg;
				if (status == '1'){
					jQuery(function($) {
						$.gritter.add({
							title: 'Login Error',
							text: msg,
							class_name: 'gritter-error  gritter-light'
						});
					});
				}else{
					jQuery(function($) {
						$.gritter.add({
							title: 'Login Success',
							text: msg,
							class_name: 'gritter-success  gritter-light'
						});
						//console.log('asd');
						window.location.href = base_url+'admin/home';
					});
				}
			},
			error: function(data){
				jQuery(function($) {
						$.gritter.add({
							title: 'Login Error',
							text: "Username dan Password tidak boleh kosong",
							class_name: 'gritter-success  gritter-light'
						});
					});
			}
		});
			return false;
	});
 });
