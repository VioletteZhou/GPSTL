	
	/*
	The following file/script is a part of free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 2 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.
	
	License URI: http://www.gnu.org/licenses/gpl-2.0.html*/
	
	// active menu
	
	if(jQuery('#top-menu li').hasClass('current-menu-item')){
	  jQuery('.current-menu-item a').attr({
	  'aria-current': 'page'
	  });
	}
	
	function taleem_menu_nav() {
	
	jQuery('#top-menu li:last a:last').on('keydown', function(e) {
	  if (e.keyCode === 9) {
		if (!e.shiftKey) {
		  e.preventDefault();
		  jQuery('[aria-controls="top-menu"]').focus();
		}
	  }
	});
	
	jQuery('#top-menu > li:last-child .dropdown-toggle').on('keydown', function(e) {
	  if (jQuery(this).attr('aria-expanded') == 'true') {
		if (e.keyCode === 9) {
		  if (!e.shiftKey) {
			e.preventDefault();
			jQuery('.sub-menu li a').focus();
		  }
		}
	  } else {
		if (e.keyCode === 9) {
		  if (!e.shiftKey) {
			e.preventDefault();
			jQuery('[aria-controls="top-menu"]').focus();
		  }
		}
	  }
	});
	
	// At start of navigation block, refocus close button on SHIFT+TAB
	
	jQuery('#top-menu li:first a:first').on('keydown', function(e) {
	  if (e.keyCode === 9) {
		if (e.shiftKey) {
		  e.preventDefault();
		  jQuery('[aria-controls="top-menu"]').focus();
		}
	  }
	});
	
	// If the menu is visible, always TAB into it from the menu button
	
	jQuery('[aria-controls="top-menu"]').on('keydown', function(e) {
	  if (e.keyCode === 9) {
		if (jQuery(this).attr('aria-expanded') == 'true') {
		  if (!e.shiftKey) {
			e.preventDefault();
			jQuery('#top-menu li:first a:first').focus();
		  } else {
			if (e.shiftKey) {
			  e.preventDefault();
			  jQuery('#main').focus();
			}
		  }
		}
	  }
	});
	
	};
	
	masthead = jQuery('#masthead');
	menuToggle = masthead.find('.menu-toggle');
	menuToggle.on('click.twentyseventeen', function() {
	 taleem_menu_nav();
	});