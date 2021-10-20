(function ($) {
	'use strict';


	var MfnGutenberg = {
		init: function () {
			if( !$('body').hasClass('post-new-php') ){
		      MfnGutenberg.addButton();
			}
		},

		addButton: function() {
			setTimeout(function() {
				if( !$('#editor .mfn-live-edit-page-button').length ){
					$('#editor').find('.edit-post-header .edit-post-header__toolbar').append('<div style="margin-right: 10px;" class="mfn-live-edit-page-button"><a href="'+ window.location.href.replace('action=edit', 'action=mfn-live-builder') +'" class="mfn-btn mfn-switch-live-editor mfn-btn-green">Edit with Live Builder</a></div>');
				}
			}, 2000);
		}
	};

	$(function () {

		wp.domReady(function() {
			MfnGutenberg.init();
		});

		wp.data.subscribe(function () {
		  var isSavingPost = wp.data.select('core/editor').isSavingPost();
		  var isAutosavingPost = wp.data.select('core/editor').isAutosavingPost();

		  if (isSavingPost && !isAutosavingPost) {
		    MfnGutenberg.addButton();

		  }
		})

	});


})(jQuery);
