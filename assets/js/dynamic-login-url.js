jQuery(document).ready(function ($) {
	console.log('test');
    $.ajax({
        url: ajax_object.ajax_url,
        method: 'POST',
        data: {
            action: 'get_dynamic_login_url'
        },
        success: function (response) {
            if (response.success) {
				console.log(response.data);
                $('#track-login-click').attr('href', response.data.login_btn.url);
				console.log(response);
            }
        },
        error: function () {
            console.error('Failed to fetch the dynamic login URL');
        }
    });
});