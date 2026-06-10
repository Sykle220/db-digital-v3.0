$(function() {
	function bindAjaxForm(formSelector, messagesSelector) {
		var form = $(formSelector);
		if (!form.length) return;

		var formMessages = form.find(messagesSelector).length
			? form.find(messagesSelector)
			: $(messagesSelector);
		var submitBtn = form.find('button[type="submit"]');
		var lang = (document.documentElement.lang || 'fr').slice(0, 2);
		var fallbackError = lang === 'fr'
			? 'Une erreur est survenue. Veuillez réessayer.'
			: 'An error occurred. Please try again.';

		function submitForm(extraData) {
			formMessages.removeClass('success error text-success text-danger').text('');
			submitBtn.addClass('is-loading');

			var payload = form.serialize();
			if (extraData) {
				payload += (payload ? '&' : '') + extraData;
			}

			$.ajax({
				type: 'POST',
				url: form.attr('action'),
				data: payload,
				dataType: 'json',
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
					'Accept': 'application/json'
				}
			})
			.done(function(response) {
				var message = (response && response.message) ? response.message : String(response || '');
				var isSuccess = !response || response.success !== false;
				formMessages.removeClass('error text-danger').addClass(isSuccess ? 'success text-success' : 'error text-danger').text(message);
				if (isSuccess) {
					form.find('input:not([type="hidden"])').val('');
					form.find('textarea').val('');
					if (response && response.track && window.dbaTrack) {
						window.dbaTrack(response.track, { form: form.attr('id') || '' });
					}
				}
			})
			.fail(function(xhr) {
				formMessages.removeClass('success text-success').addClass('error text-danger');
				var message = fallbackError;
				try {
					var json = JSON.parse(xhr.responseText);
					if (json && json.message) message = json.message;
				} catch (err) {
					if (xhr.responseText) message = xhr.responseText;
				}
				formMessages.text(message);
			})
			.always(function() {
				submitBtn.removeClass('is-loading');
			});
		}

		form.on('submit', function(e) {
			e.preventDefault();
			if (window.RECAPTCHA_SITE_KEY && window.grecaptcha) {
				window.grecaptcha.ready(function() {
					window.grecaptcha.execute(window.RECAPTCHA_SITE_KEY, { action: 'submit' }).then(function(token) {
						submitForm('g-recaptcha-response=' + encodeURIComponent(token));
					});
				});
				return;
			}
			submitForm();
		});
	}

	bindAjaxForm('#contact-form', '.ajax-response');
	bindAjaxForm('#newsletter-form', '.newsletter-response');
});
