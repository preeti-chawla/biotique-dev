/*
 * Allow multiple versions of libraries to be used.
 *
 * Copyright (c) 2009 Adaptavist.com
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://www.adaptavist.com/display/~mgibson/Using+multiple+versions+of+javascript+libraries
 */
(window.Versions || (function() {

var v;
v= window.Versions = {

	library: {},
	
	add: function ( name, versions, object ) {
		var vers = versions.split(/\s+/),
			lib = v.library[name] || {};
		
		while (vers.length) {
			lib[vers.shift()] = object;
		}
		
		v.library[name] = lib;
	},
	
	use: function ( name, version ) {
		return v.library[name][version] ||
			v.error("non-existent library version: "+name+"-"+version);
	},
	
	debug: false,
	
	error: function(msg) {
		if (v.debug) {
			if (window.console) {
				(console.error||console.log)(msg);
			} else if (window.opera && opera.postError) {
				opera.postError(msg);
			} else {
				alert(msg);
			}
		}		
	}

};

})());

