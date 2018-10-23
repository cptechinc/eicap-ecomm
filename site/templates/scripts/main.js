$(function() {
	$('[data-toggle="tooltip"]').tooltip();
	
	$("body").on("click", ".cart-item-search", function(e) {
		e.preventDefault();
		var button = $(this);
		var modal = config.modals.ajax;
		var loadinto = modal+" .modal-content";
		var href = URI(button.attr('href')).addQuery('modal', 'modal').normalizeQuery().toString();
		
		$(loadinto).loadin(href, function() {
			$(modal).modal('show');
			setTimeout(function (){ $(modal).find('.query').focus();}, 500);
		});
	});
	
	$("body").on("submit", "#item-search", function(e) {
		e.preventDefault();
		var form = $(this);
		var modal = config.modals.ajax;
		var loadinto = modal+" .modal-content";
		var href = URI(form.attr('action')).query(form.serialize()).addQuery('modal', 'modal').normalizeQuery().toString();
		
		$(loadinto).loadin(href, function() {
			$(modal).modal('show');
		});
	});
});
$.fn.extend({
	loadin: function(href, callback) {
		var element = $(this);
		var parent = element.parent();
		console.log('loading ' + element.returnelementdescription() + " from " + href);
		parent.load(href, function() { 
			callback(); 
		});
	},
	returnelementdescription: function() {
			var element = $(this);
			var tag = element[0].tagName.toLowerCase();
			var classes = '';
			var id = '';
			if (element.attr('class')) {
				classes = element.attr('class').replace(' ', '.');
			}
			if (element.attr('id')) {
				id = element.attr('id');
			}
			var string = tag;
			if (classes) {
				if (classes.length) {
					string += '.'+classes;
				}
			}
			if (id) {
				if (id.length) {
					string += '#'+id;
				}
			}
			return string;
		},
});
