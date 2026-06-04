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

		form.on('submit', function(e) {
			e.preventDefault();
			formMessages.removeClass('success error').text('');
			submitBtn.addClass('is-loading');

			$.ajax({
				type: 'POST',
				url: form.attr('action'),
				data: form.serialize()
			})
			.done(function(response) {
				formMessages.removeClass('error').addClass('success').text(response);
				form.find('input:not([type="hidden"])').val('');
				form.find('textarea').val('');
			})
			.fail(function(data) {
				formMessages.removeClass('success').addClass('error');
				formMessages.text(data.responseText || fallbackError);
			})
			.always(function() {
				submitBtn.removeClass('is-loading');
			});
		});
	}

	bindAjaxForm('#contact-form', '.ajax-response');
	bindAjaxForm('#newsletter-form', '.newsletter-response');
});
