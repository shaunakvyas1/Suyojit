/**
 * JS Shop-Configuration
 */

stockimg = new Array();
stockimg[10] = 'stock_green.png';
stockimg[14] = 'stock_green.png';
stockimg[15] = 'stock_green.png';
stockimg[20] = 'stock_green_yellow.png';
stockimg[30] = 'stock_yellow.png';
stockimg[40] = 'stock_yellow_orange.png';
stockimg[45] = 'stock_orange.png';
stockimg[50] = 'stock_orange.png';
stockimg[60] = 'stock_grey.png';
stockimg[70] = 'stock_lightblue.png';
stockimg[71] = 'stock_green.png';
stockimg[73] = 'stock_lightblue_green.png';
stockimg[76] = 'stock_lightblue_yellow.png';
stockimg[80] = 'stock_black.png';
stockimg[90] = 'stock_grey.png';

config = {
	/** common settings * */
	language : 'de', // can be changed during initialization
	debug : false,
	/** easynav settings * */
	easynav : {
		popupDelay : 200,
		treeDataFile : "/js/js.php?js=navtree"
	},
	/** ajax settings * */
	ajax : {
		waitImage : "/images/graphics/waiting.gif",
		stockInfoUrl : {
			de : "http://" + document.domain
					+ "/php/index.php?cmd=stockinfo&loc=de&text=1&artid=", // Article-ID
																			// will
																			// be
																			// added
			en : "http://" + document.domain
					+ "/php/index.php?cmd=stockinfo&loc=en&text=1&artid="
		},
		distriInfoUrl : {
			de : "http://" + document.domain
					+ "/php/index.php?cmd=distriinfo&loc=de&artid=",
			en : "http://" + document.domain
					+ "/php/index.php?cmd=distriinfo&loc=en&artid="
		},
		prodVariantsUrl : {
			de : "http://" + document.domain
					+ "/php/index.php?cmd=variantinfo&loc=de&artid=",
			en : "http://" + document.domain
					+ "/php/index.php?cmd=variantinfo&loc=en&artid="
		}
	},
	/** mainmenu settings * */
	mainMenu : {
		cachePictures : [ 'bg/menutabmiddle.png', 'bg/menutabborder.png',
				'bg/menubtnmiddle.png', 'bg/menubtnborder.png' ],
		picturePath : '/images/',
		menuIncludePath : '/menu/',
		slideDownSpeed : 50,
		fadeOutSpeed : 200
	},
	/** search settings * */
	search : {
		caption : {
			de : "suchen...",
			en : "search..."
		}
	},
	/** softwaredownload settings (detail pages) * */
	detailDownload : {
		url : {
			de : "http://www.batronix.com/versand/downloads/index.html",
			en : "http://www.batronix.com/shop/downloads/index.html"
		}
	},
	/** tab settings (detail pages) * */
	tabs : {
		defaultTab : 0
	},
	/** internal init * */
	init : function() {
		// console.log(window.location.pathname);
		// console.log(window.document.referrer);
		var path = window.location.pathname;
		var shopurl = path.indexOf('/shop/');
		if (shopurl > -1)
			this.language = 'en';
		// console.log('Sprache: '+this.language);
	}
};
config.init();


/**
 * JS-Toolbox
 */

/* USE config.js */

tools = {
		htmlEntities: function (str) {
		    return String(str).replace(/&/g, '&amp;')
		                      .replace(/</g, '&lt;')
		                      .replace(/>/g, '&gt;')
		                      .replace(/"/g, '&quot;')
		                      .replace(/ä/g, '&auml;')
		                      .replace(/ü/g, '&uuml;')
		                      .replace(/ö/g, '&ouml;')
		                      .replace(/Ä/g, '&Auml;')
		                      .replace(/Ü/g, '&Uuml;')
		                      .replace(/Ö/g, '&Ouml;')
		                      .replace(/ß/g, '&szlig;')
		                      ;
		},
		con: {
			log: function (logtext) {
				if (window.console) {
					if (config.debug)
						console.log(logtext);
				}
			}
		}
};
$(function () {
	$('#query').focus(function() {
		var value = $(this).attr('value');
		value = $.trim(value);
		if(value==config.search.caption.de || value==config.search.caption.en || value=="") {
			$(this).val("");
		}
	    $(this).addClass('queryfocussed');
    });
	$('#query').blur(function() {
      	var value = $(this).val();
		value = $.trim(value);
      	var loc = $('#queryloc').val();
		if(value==config.search.caption.de || value==config.search.caption.en || value=="") {
			if (loc=="de") {
				$(this).val(config.search.caption.de);
			}	
			if (loc=="en") {
				$(this).val(config.search.caption.en);
			}	
		}
	    $(this).removeClass('queryfocussed');
	});
	$('#headerquery').submit(function(event) {
		var value = $('#query').val();
		value = $.trim(value);
		tools.con.log(value);
		if (value==config.search.caption.de || value==config.search.caption.en || value=="") {
	        event.preventDefault();
	        $('#query').focus();
			return false;
		}
	});
});
function arrayUnique(array) {
	var a = array.concat();
	for ( var i = 0; i < a.length; ++i) {
		for ( var j = i + 1; j < a.length; ++j) {
			if (a[i] === a[j])
				a.splice(j--, 1);
		}
	}
	return a;
};
function Numsort(a, b) {
	return a - b;
}
function expon(val, min, max) {
	var minv = Math.log(min);
	var maxv = Math.log(max);
	var scale = (maxv - minv) / (max - min);
	return Math.exp(minv + scale * (val - min));
}
function logposition(val, min, max) {
	var minv = Math.log(min);
	var maxv = Math.log(max);
	var scale = (maxv - minv) / (max - min);
	return (Math.log(val) - minv) / scale + min;
}
function stepToValue(step) {
	if (typeof step != "string")
		return step;
	steps = step.split(' ');
	var val = steps[0];
	if (steps[1] != undefined) {
		var p = steps[1];
		if (p == "k")
			val = val * 1000;
		else if (p == "K")
			val = val * 1000;
		else if (p == "M")
			val = val * 1000000;
		else if (p == "G")
			val = val * 1000000000;
		else if (p == "T")
			val = val * 1000000000000;
		else if (p == "m")
			val = val * 0.001;
		else if (p == "u")
			val = val * 0.000001;
		else if (p == "n")
			val = val * 0.000000001;
		else if (p == "p")
			val = val * 0.000000000001;
		else if (p == "f")
			val = val * 0.000000000000001;
		else
			return step;
	}
	return val;
}
function valueToStep(value) {
	var unit = 1000;
	if ((value > 0) && (value < unit))
		return value;
	var exp = Math.floor(Math.log(value) / Math.log(unit));
	var pre = "kMGTPE".charAt(exp - 1);
	var pow = (Math.pow(unit, exp));
	return (value / pow) + " " + pre;
}
function contains(a, obj) {
	for ( var i = 0; i < a.length; i++) {
		if (a[i] === obj)
			return true;
	}
	return false;
}
function isNumeric(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}
function array_diff(arr1) {
	var retArr = new Array(), argl = arguments.length, k1 = '', i = 1, k = '', arr = {};

	arr1keys: for (k1 in arr1) {
		for (i = 1; i < argl; i++) {
			arr = arguments[i];
			for (k in arr) {
				if (arr[k] === arr1[k1])
					continue arr1keys;
			}
			retArr.push(arr1[k1]);
		}
	}
	return retArr;
}
function getMinSortPosition(Itemlist) {
	var minpos = -1;
	for (idx in Itemlist) {
		if (minpos == -1)
			minpos = Itemlist[idx].SortPosition;
		if (Itemlist[idx].SortPosition > minpos)
			minpos = Itemlist[idx].SortPosition;
	}
	return minpos;
}
function getMinValue(Itemlist) {
	var minval = -1;
	for (idx in Itemlist) {
		if (minval == -1)
			minval = Itemlist[idx];
		if (Itemlist[idx] < minval)
			minval = Itemlist[idx];
	}
	return minval;
}
function getMaxValue(Itemlist) {
	var maxval = -1;
	for (idx in Itemlist) {
		if (maxval)
			maxval = Itemlist[idx];
		if (Itemlist[idx] > maxval)
			maxval = Itemlist[idx];
	}
	return maxval;
}

(function($, document) {

	var pluses = /\+/g;
	function raw(s) {
		return s;
	}
	function decoded(s) {
		return decodeURIComponent(s.replace(pluses, ' '));
	}

	$.cookie = function(key, value, options) {

		// key and at least value given, set cookie...
		if (arguments.length > 1
				&& (!/Object/.test(Object.prototype.toString.call(value)) || value == null)) {
			options = $.extend({}, $.cookie.defaults, options);

			if (value == null) {
				options.expires = -1;
			}

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			}

			value = String(value);

			return (document.cookie = [ encodeURIComponent(key), '=',
					options.raw ? value : encodeURIComponent(value),
					options.expires ? '; expires=' + options.expires.toUTCString() : '', // use
																																								// expires
																																								// attribute,
																																								// max-age
																																								// is
																																								// not
																																								// supported
																																								// by
																																								// IE
					options.path ? '; path=' + options.path : '',
					options.domain ? '; domain=' + options.domain : '',
					options.secure ? '; secure' : '' ].join(''));
		}

		// key and possibly options given, get cookie...
		options = value || $.cookie.defaults || {};
		var decode = options.raw ? raw : decoded;
		var cookies = document.cookie.split('; ');
		for ( var i = 0, parts; (parts = cookies[i] && cookies[i].split('=')); i++) {
			if (decode(parts.shift()) === key) {
				return decode(parts.join('='));
			}
		}
		return null;
	};

	$.cookie.defaults = {};

})(jQuery, document);

var Sort = {
	texts : {
		de : {
			title : "Produktfilter / Sortierung",
			titleSort : "Sortierung",
			initTitle : "Produktfilter / Sortierung wird initialisiert...",
			reset : "Filter zur&uuml;cksetzen",
			sort : "Sortierung",
			dontcare : "egal",
			yes : "Ja",
			no : "Nein",
			unsorted : "unsortiert",
			price : "Preis",
			stock : "Verf&uuml;gbarkeit",
			name : "Name",
			asc : "aufsteigend",
			desc : "absteigend",
			count : "angezeigte Produkte",
			variant : "Gr&ouml;&szlig;e",
			of : "von",
			review : "Bewertung",
			reviews : "Bewertungen",
		},
		en : {
			title : "Product filter / sorting",
			titleSort : "Sorting",
			initTitle : "Initialising product filter / sorting...",
			reset : "reset filter",
			sort : "Sorting",
			dontcare : "don't care",
			yes : "Yes",
			no : "No",
			unsorted : "unsorted",
			price : "Price",
			stock : "Availability",
			name : "Name",
			asc : "ascending",
			desc : "descending",
			count : "Products shown",
			variant : "Size",
			of : "of",
			review : "Review",
			reviews : "Reviews",
		}
	},
	reviewsCollected : false,
	collectStock : true,
	items : [],
	tables : [],
	initvalues : [],
	preventActivation : false,
	Ranges : new Array(),
	sortOnly : false,
	log : function(text) {
		if (window.console)
			console.log(text);
	},

	init : function() {
		// console.clear();
		var showMetaData = false;
		var c = $.cookie('debugstate');
		if (c) {
			showMetaData = true;
		}

		if (typeof SortItems == "undefined")
			return;
		SortItems.language = SortItems.language.toLowerCase();

		Sort.sortOnly = SortItems.sortOnly();
		$("div.producttable")
				.each(
						function(index) {

							var grp = $(this).attr("id");
							if (grp != null) {
								grp = grp.replace('listgrp', '');
								grp = grp.replace('ProductArea', '');
							} else
								return;

							if (SortItems.settings[grp] != undefined) {
								if (SortItems.settings[grp]["AvailabilityFilter"].Unit == "true")
									SortItems.regSetting(grp, "Stock", "", "rangestep2");
								if (SortItems.settings[grp]["VariantFilter"].Unit == "true")
									SortItems.regSetting(grp, "_Variant", "", "rangestep2");

								// if (SortItems.settings[grp]["enabled"].Unit
								// != "true") return;
							}

							Sort.tables[grp] = new Array();
							Sort.tables[grp]["scope"] = $(this).children('.sortcontent');
							Sort.tables[grp]["items"] = [];
							Sort.tables[grp]["position"] = 0;

							if (Sort.sortOnly === false) {
								$(this)
										.before(
												'<div class="productfilter ui-accordion ui-widget ui-helper-reset ui-state-disabled">'
														+ '<h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons">'
														+ '<span class="ui-accordion-header-icon ui-icon-loading"></span>'
														+ Sort.texts[SortItems.language].initTitle
														+ '</h3><div></div></div>');
							}

							if ((SortItems.settings[grp]) && (SortItems.settings[grp]["collectStock"]) && (SortItems.settings[grp]["collectStock"].Unit == "false"))
								Sort.collectStock = false;

							Sort.collectData(grp);

							if (Sort.tables[grp]["items"].length > 1)
								Sort.createFilterbox(this, grp);

							if (showMetaData)
								Sort.printMetadata(grp);

						});
		var element = "div.heading";
		$(element + ":contains('Bild')").prepend(
				'<button name="send[1]" style="display:none; visibility: hidden;" />');
		$(element + ":contains('Picture')").prepend(
				'<button name="send[1]" style="display:none; visibility: hidden;" />');
		$(element + ":contains('Beschreibung')").wrapInner(
				'<button class="sortcol sortname" value="" name="sort"></button>');
		$(element + ":contains('Description')").wrapInner(
				'<button class="sortcol sortname" name="sort" value=""></button>');
		$("button.sortname").prepend('<div class="unsort"></div>');
		$(element + ":contains('Preis')").wrapInner(
				'<button class="sortcol sortprice" name="sort" value=""></button>');
		$(element + ":contains('Price')").wrapInner(
				'<button class="sortcol sortprice" name="sort" value=""></button>');
		$("button.sortprice").prepend('<div class="unsort"></div>');
		$(element + ":contains('Lager')").wrapInner(
				'<button class="sortcol sortstock de" name="sort" value=""></button>');
		$(element + ":contains('Stock')").wrapInner(
				'<button class="sortcol sortstock en" name="sort" value=""></button>');
		$("button.de>span").remove();
		$("button.de").append(
				'<span>Kauf / </span><div class="unsort"></div><span>Lager</span>');
		$("button.en>span").remove();
		$("button.en").append(
				'<span>Buy / </span><div class="unsort"></div><span>Stock</span>');

		Sort.registerSortEvent('sortname', '2');
		Sort.registerSortEvent('sortprice', '3');
		Sort.registerSortEvent('sortstock', '4');
	},

	registerSortEvent : function(aClass, SortID) {
		$("." + aClass).click(
				function(event) {
					event.preventDefault();
					var dir = 0;
					if ($(this).find('div').hasClass('unsort'))
						dir = 0;
					if ($(this).find('div').hasClass('sortup'))
						dir = 1;
					if ($(this).find('div').hasClass('sortdown'))
						dir = 0;
					var grp = $(this).parent().parent().parent().children('.sortcontent')
							.parent().attr("id").replace('listgrp', '').replace(
									'ProductArea', '');
					$('#' + Sort.tables[grp]["sortid"]).val(SortID + dir);
					Sort.stateChanged(grp);
				});
	},

	createID : function(aPrefix) {
		var d = new Date();
		return aPrefix + "-" + d.getTime() + "-"
				+ Math.floor(Math.random() * 1000000);
	},

	stateChanged : function(grp) {
		Sort.tables[grp]["items"].sort();
		if (Sort.preventActivation)
			return;
		// console.clear();
		var filterSettings = new Array();
		var sortvalues = new Array('position', 'Name', 'Preis', 'Stock');
		var adata = SortItems.settings[grp];
		if (adata != undefined) {
			for ( var Feature in adata) {
				var myType = adata[Feature]["Type"];
				var types = myType.split('|');

				for (idx in types) {
					var aType = types[idx];
					var aUnit = adata[Feature]["Unit"];
					var aID = adata[Feature]["DomID"];
					if ((aType == "range") || (aType == "rangelog")) {
						var val = $('#' + aID).slider("values");
						filterSettings.push({
							aName : Feature,
							aMin : val[0],
							aMax : val[1],
							aType : "range"
						});
					}
					if ((aType == "rangestep") || aType == "rangestep2") {
						var aslider = $('#' + aID);
						var val = aslider.slider("values");
						// aslider.slider('option', 'slide')(null, { values: val
						// })
						var rangesteps = new Array();
						for ( var itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
							var pid = Sort.tables[grp]["items"][itemID];
							if (pid == undefined)
								continue;
							var value = SortItems.itemData[pid][Feature];
							if (Feature == "Stock") {
								for (idx in value) {
									var sstep = value[idx];
									if (sstep['StockState'] == '14')
										sstep['StockState'] = '10';
									if (sstep['SortPosition'] == '88600')
										sstep['SortPosition'] = '89000';
									if (sstep['StockState'] == '15')
										sstep['StockState'] = '10';
									if (sstep['SortPosition'] == '88500')
										sstep['SortPosition'] = '89000';
									if (sstep['StockState'] == '71')
										sstep['StockState'] = '10';
									if (sstep['SortPosition'] == '82900')
										sstep['SortPosition'] = '89000';
									rangesteps.push(sstep);
								}
							} else if (Feature == "_Variant") {
								for (idx in value) {
									var sstep = value[idx];
									rangesteps.push(sstep);
								}
							} else
								rangesteps.push(value);
						}
						rangesteps = Sort.sortRangeSteps(rangesteps, aType == "rangestep",
								(Feature == "Stock" || Feature == "_Variant"));
						// console.log({steps:rangesteps});
						var amin, amax = 0;
						if (aType == "rangestep") {
							amin = stepToValue(rangesteps[val[0]]);
							amax = stepToValue(rangesteps[val[1]]);
						} else {
							if (Feature == "Stock") {
								// console.log(rangesteps);
								amin = rangesteps[val[0]];
								amax = rangesteps[val[1]];
							} else if (Feature == "_Variant") {
								// console.log(rangesteps);
								amin = rangesteps[val[0]];
								amax = rangesteps[val[1]];
							} else {
								amin = parseFloat(rangesteps[val[0]]);
								amax = parseFloat(rangesteps[val[1]]);
							}
						}
						filterSettings.push({
							aName : Feature,
							aMin : amin,
							aMax : amax,
							aType : aType
						});
					}
					if (aType == "check") {
						var values = new Array();
						for (itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
							var pid = Sort.tables[grp]["items"][itemID];
							if (pid == undefined)
								continue;
							var value = SortItems.itemData[pid][Feature];
							if (value != undefined) {
								value = value.toString();
								// var idx = $.inArray(value, values);
								if (values[value] != undefined) {
									values[value] = values[value] + 1;
								} else {
									values[value] = 1;
								}
							}
						}
						var idx = 1;
						for ( var value in values) {
							if (value != undefined) {
								var id = aID + '-' + idx;
								var checked = document.getElementById(id).checked;
								if (checked) {
									filterSettings.push({
										aName : Feature,
										aType : aType,
										aValue : value
									});
								}
								idx++;
							}
						}
					}
					if ((aType == "checklist") || (aType == "checklist2col")) {
						var features = aUnit.split('|');
						var values = new Array();
						for (itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
							var pid = Sort.tables[grp]["items"][itemID];
							if (pid == undefined)
								continue;
							var value = SortItems.itemData[pid][Feature];
							if (value != undefined) {
								value = value.toString();
								var itemfeatures = value.split('|');
								for ( var idx in itemfeatures) {
									var feat = itemfeatures[idx];
									var found = $.inArray(feat, features);
									if (found != -1) {
										if (values[feat] != undefined) {
											values[feat] = values[feat] + 1;
										} else {
											values[feat] = 1;
										}
									}
								}
							}
						}
						var idx = 1;
						for ( var value in values) {
							if (value != undefined) {
								// value = values[valueidx];
								var id = aID + '-' + idx;
								var checked = document.getElementById(id).checked;
								if (checked) {
									filterSettings.push({
										aName : Feature,
										aFeat : value,
										aValue : true,
										aType : aType
									});
								}
								idx++;
							}
						}
					}
					if (aType == "featurelist") {
						var features = aUnit.split('|');
						var values = new Array();
						for (itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
							var pid = Sort.tables[grp]["items"][itemID];
							if (pid == undefined)
								continue;
							var value = SortItems.itemData[pid][Feature];
							if (value != undefined) {
								value = value.toString();
								var itemfeatures = value.split('|');
								for ( var idx in itemfeatures) {
									var feat = itemfeatures[idx];
									var found = $.inArray(feat, features);
									if (found != -1) {
										if (values[feat] != undefined) {
											values[feat] = values[feat] + 1;
										} else {
											values[feat] = 1;
										}
									}
								}
							}
						}
						var idx = 1;
						for ( var value in values) {
							if (value != undefined) {
								// value = values[valueidx];
								var id = aID + '-' + idx + '_1';
								var checked = document.getElementById(id).checked;
								if (checked) {
									filterSettings.push({
										aName : Feature,
										aFeat : value,
										aValue : true,
										aType : aType
									});
								}
								var id = aID + '-' + idx + '_2';
								var checked = document.getElementById(id).checked;
								if (checked) {
									filterSettings.push({
										aName : Feature,
										aFeat : value,
										aValue : false,
										aType : aType
									});
								}
								idx++;
							}
						}
					}

					if (aType == "sort") {
						sortvalues.push(Feature);
					}
					if (aType == "sort2") {
						sortvalues.push(Feature);
					}
				}
			}
		}
		var dosort = $('#' + Sort.tables[grp]["sortid"]).val();
		var sortby = ('' + dosort)[0];
		var dir = ('' + dosort)[1];

		// Sortierbuttons in Tabellenüberschrift neu setzen
		sortname = $('#listgrp' + grp).find(".sortname").find('div');
		sortprice = $('#listgrp' + grp).find(".sortprice").find('div');
		sortstock = $('#listgrp' + grp).find(".sortstock").find('div');
		var sortname = $('#ProductArea' + grp).find(".sortname").find('div');
		var sortprice = $('#ProductArea' + grp).find(".sortprice").find('div');
		var sortstock = $('#ProductArea' + grp).find(".sortstock").find('div');
		sortname.removeClass().addClass('unsort');
		sortprice.removeClass().addClass('unsort');
		sortstock.removeClass().addClass('unsort');
		var sortclass = new Array('sortup', 'sortdown');
		if (sortby == 2)
			sortname.removeClass().addClass(sortclass[dir]);
		if (sortby == 3)
			sortprice.removeClass().addClass(sortclass[dir]);
		if (sortby == 4)
			sortstock.removeClass().addClass(sortclass[dir]);
		// Filtern
		excludePids = new Array();
		reincludePids = new Array();
		var result = new Array();
		var pids = new Array();
		// console.log({filter:filterSettings});

		for (itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
			var pid = Sort.tables[grp]["items"][itemID];
			if (pid == undefined)
				continue;
			pids.push(pid);
			var exclude = new Array();
			var include = new Array();

			for ( var idx in filterSettings) {
				var filter = filterSettings[idx];
				var t = filter.aType;
				var value = SortItems.itemData[pid][filter.aName];

				if (t == "range" || t == "rangestep2") {
					if (filter.aName == "Stock") {
						if ((getMinSortPosition(value) < filter.aMin)
								|| (getMinSortPosition(value) > filter.aMax))
							exclude.push(filter.aName);
					} else if (filter.aName == "_Variant") {
						var doexclude = true;
						for (idx in value) {
							var testval = parseInt(value[idx]);
							if ((testval >= parseInt(filter.aMin))
									&& (testval <= parseInt(filter.aMax))) {
								var stocks = SortItems.itemData[pid]['Stock'];
								var stock = 10;
								for ( var id in stocks) {
									if (stocks[id].Name == value[idx]) {
										stock = parseInt(stocks[id].StockState);
									}
								}
								if (stock != 80)
									doexclude = false;
							}
						}
						if (doexclude) {
							exclude.push(filter.aName);
						}

						// console.log(value);
						// var minval = getMinValue(value);
						// var maxval = getMaxValue(value);
						// console.log(minval + " >= " + filter.aMin);
						// console.log(maxval + " <= " + filter.aMax);

					} else {
						if ((value < filter.aMin) || (value > filter.aMax))
							exclude.push(filter.aName);
					}
				}
				if (t == "rangestep") {
					value = stepToValue(value);
					if ((value < filter.aMin) || (value > filter.aMax))
						exclude.push(filter.aName);
				}
				if (t == "check") {
					if (value != filter.aValue)
						exclude.push(filter.aName);
					else
						include.push(filter.aName);
				}
				if ((t == "featurelist") || (t == "checklist")
						|| (t == "checklist2col")) {
					if (value == undefined && filter.aValue == true) {
						exclude.push(filter.aFeat);
						continue;
					} else if (value == undefined) {
						continue;
					}
					var itemfeatures = value.split('|');
					found = false;
					for (idx in itemfeatures) {
						var feat = itemfeatures[idx];
						if (feat == filter.aFeat)
							found = true;
					}
					if (found != filter.aValue) {
						exclude.push(filter.aFeat);
					}
				}
			}
			exclude = array_diff(exclude, include);
			// console.group(pid)
			// console.log('excluding ',exclude);
			// console.log('including ',include);
			// console.groupEnd();
			if (exclude.length == 0)
				result.push(pid);
		}
		Sort.updateResultCount(grp, result.length, pids.length);
		var t = sortvalues[sortby - 1];
		Sort.tables[grp]["items"].sort(function() {
			if (t == "Stock") {
				a = getMinSortPosition(SortItems.itemData[arguments[1 - dir]][t]);
				b = getMinSortPosition(SortItems.itemData[arguments[dir]][t]);
			} else {
				a = SortItems.itemData[arguments[dir]][t];
				b = SortItems.itemData[arguments[1 - dir]][t];
			}

			if (a == 88600)
				a = 89000;
			if (a == 88500)
				a = 89000;
			if (a == 82900)
				a = 89000;
			if (b == 88600)
				b = 89000;
			if (b == 88500)
				b = 89000;
			if (b == 82900)
				b = 89000;

			// Wenn die Sortierung ergibt, dass zwei Produkte identisch
			// sind, dann an dieser Stelle nach Generierungsposition
			// sortieren
			if (a === b) {
				a = SortItems.itemData[arguments[1 - dir]]['position'];
				b = SortItems.itemData[arguments[dir]]['position'];
			}
			a = stepToValue(a);
			b = stepToValue(b);
			if (isNumeric(a) && isNumeric(b)) {
				return a - b;
			} else {
				return a.toLowerCase() > b.toLowerCase() ? 1 : a.toLowerCase() < b
						.toLowerCase() ? -1 : 0;
			}
		});
		Sort.Show(grp, result);
	},

	createSortBox : function(parent, grp, additionalValues) {
		var id = Sort.createID("Sort");
		var style = "width:334px; float:left; margin:5px 10px;";
		var options = "";
		options = options + '<option value="10">'
				+ Sort.texts[SortItems.language].unsorted + '</option>';
		options = options + '<option value="20">'
				+ Sort.texts[SortItems.language].name + ' '
				+ Sort.texts[SortItems.language].asc + '</option>';
		options = options + '<option value="21">'
				+ Sort.texts[SortItems.language].name + ' '
				+ Sort.texts[SortItems.language].desc + '</option>';
		options = options + '<option value="30">'
				+ Sort.texts[SortItems.language].price + ' '
				+ Sort.texts[SortItems.language].asc + '</option>';
		options = options + '<option value="31">'
				+ Sort.texts[SortItems.language].price + ' '
				+ Sort.texts[SortItems.language].desc + '</option>';
		options = options + '<option value="40">'
				+ Sort.texts[SortItems.language].stock + ' '
				+ Sort.texts[SortItems.language].asc + '</option>';
		options = options + '<option value="41">'
				+ Sort.texts[SortItems.language].stock + ' '
				+ Sort.texts[SortItems.language].desc + '</option>';
		var idx = 5;
		for (value in additionalValues) {
			if (value != undefined) {
				options = options + '<option value="' + idx + '0">'
						+ additionalValues[value] + ' '
						+ Sort.texts[SortItems.language].asc + '</option>';
				options = options + '<option value="' + idx + '1">'
						+ additionalValues[value] + ' '
						+ Sort.texts[SortItems.language].desc + '</option>';
				idx++;
			}
		}

		$(parent).append(
				'    <div style="' + style + '">' + Sort.texts[SortItems.language].sort
						+ '      <select name="sort" id ="' + id + '">' + options
						+ '</select>' + '    </div>');
		$('#' + id).change(function() {
			Sort.stateChanged(grp);
		});
		Sort.tables[grp]["sortid"] = id;
	},

	showResultCount : function(parent, grp, selected, count) {
		var id = Sort.createID("SortResult");
		Sort.tables[grp]["resultid"] = id;
		var style = "float:right; margin:0px 10px; font-weight:normal;";
		$(parent)
				.parent()
				.parent()
				.find('h3')
				.append(
						'<button class="filterreset" style="visibility:hidden;" value="" name="filterreset">'
								+ Sort.texts[SortItems.language].reset
								+ '</button><div style="'
								+ style
								+ '" id="'
								+ id
								+ '">'
								+ Sort.texts[SortItems.language].count
								+ ": "
								+ selected
								+ ' '
								+ Sort.texts[SortItems.language].of
								+ ' '
								+ count
								+ '    </div>');
		$(".filterreset").click(function(event) {
			$(this).parent().parent().accordion("disable");
			Sort.preventActivation = true;
			event.preventDefault();
			Sort.doReset(grp);
			$(this).parent().parent().accordion("enable");
		});
	},

	updateResultCount : function(grp, selected, count) {
		var id = Sort.tables[grp]["resultid"];
		$('#' + id).html(
				Sort.texts[SortItems.language].count + ": " + selected + ' '
						+ Sort.texts[SortItems.language].of + ' ' + count);
		$('#' + id).parent().find("button").css("visibility",
				(selected == count) ? "hidden" : "visible");
	},

	doReset : function(grp) {
		for (idx in Sort.initvalues) {
			value = Sort.initvalues[idx];
			if (value != undefined) {
				if (value.aType == "rangelog") {
					$('#' + value.aID).slider("values", 0, value.aMin);
					$('#' + value.aID).slider("values", 1, value.aMax);
					var gBottom = Number(expon(value.aMin, value.aMin, value.aMax))
							.toFixed(0);
					var gTop = Number(expon(value.aMax, value.aMin, value.aMax)).toFixed(
							0);
					if (gBottom == gTop)
						$("#lbl" + value.aID).html(gBottom + ' ' + value.aUnit);
					else
						$("#lbl" + value.aID).html(
								gBottom + ' ' + value.aUnit + " - " + gTop + ' ' + value.aUnit);
				}
				if (value.aType == "range") {
					$('#' + value.aID).slider("values", 0, value.aMin);
					$('#' + value.aID).slider("values", 1, value.aMax);
					var gBottom = Number(value.aMin).toFixed(0);
					var gTop = Number(value.aMax).toFixed(0);
					if (gBottom == gTop)
						$("#lbl" + value.aID).html(gBottom + ' ' + value.aUnit);
					else
						$("#lbl" + value.aID).html(
								gBottom + ' ' + value.aUnit + " - " + gTop + ' ' + value.aUnit);
				}
				if (value.aType == "rangestep") {
					$('#' + value.aID).slider("values", 0, value.aMin);
					$('#' + value.aID).slider("values", 1, value.aMax);
					var gBottom = value.steps[value.aMin];
					var gTop = value.steps[value.aMax];
					if (gBottom == gTop)
						$("#lbl" + value.aID).html(gBottom + value.aUnit);
					else
						$("#lbl" + value.aID).html(
								gBottom + value.aUnit + " - " + gTop + value.aUnit);
				}
				if (value.aType == "check") {
					document.getElementById(value.aID).checked = value.aValue;
				}
				if (value.aType == "radio") {
					document.getElementById(value.aID + '_' + value.aValue).checked = true;
				}
			}
		}
		// Sortierung auf unsortiert setzen
		$('#' + Sort.tables[grp]["sortid"]).val('10');
	},

	addArea : function(parent, grp) {
		Sort.tables[grp]["position"] = Sort.tables[grp]["position"] + 1;
		if (Sort.tables[grp]["position"] > 3) {
			$(parent).append('<div style="clear:both"></div>');
			Sort.tables[grp]["position"] = 1;
		}
	},

	createFeatureList : function(parent, grp, aName, aValues) {
		var id = Sort.createID("FL");
		SortItems.settings[grp][aName].DomID = id;
		var style = "width:203px; float:left; margin:0 20px 10px 10px;";
		var optstyle = "position:relative; top:2px; margin-left:5px; float:right;";
		// var lblstyle = "padding:0 2px 0 1px; float:right;";
		var options = '';

		var idx = 1;
		for (value in aValues) {
			if (value != undefined) {
				count = aValues[value];
				options = options + value + ':'
				// + '<label for="' + id + '-' + idx + '_2" style="' + lblstyle
				// + '">' + Sort.texts[SortItems.language].no + '</label>'
				+ '<input type="radio" name="' + aName + idx + '" value="' + value
						+ '" id="' + id + '-' + idx + '_2" style="' + optstyle + '" />'
						// + '<label for="' + id + '-' + idx + '_1" style="' +
						// lblstyle + '">' + Sort.texts[SortItems.language].yes
						// + '</label>'
						+ '<input type="radio" name="' + aName + idx + '" value="' + value
						+ '" id="' + id + '-' + idx + '_1" style="' + optstyle + '" />'
						// + '<label for="' + id + '-' + idx + '_0" style="' +
						// lblstyle + '">' +
						// Sort.texts[SortItems.language].dontcare + '</label>'
						+ '<input type="radio" name="' + aName + idx + '" value="' + value
						+ '" id="' + id + '-' + idx + '_0" style="' + optstyle
						+ '" checked />' + '<br />';
				Sort.initvalues.push({
					aID : id + '-' + idx,
					aType : "radio",
					aValue : 0
				});
				idx++;
			}
		}
		Sort.addArea(parent, grp);
		$(parent)
				.append(
						'<div style="'
								+ style
								+ '">'
								+ aName
								+ ':<div class="Filterfeaturelist"></div><hr style="border-bottom:1px solid #BBBBBB; height: 0px; padding:0; margin:0"><div id="'
								+ id + '">' + options + '</div></div>');
		$('#' + id + ' input:radio').change(function() {
			Sort.stateChanged(grp);
		});
	},

	createCheckList : function(parent, grp, aName, aValues, twoCols) {
		var id = Sort.createID("CL");
		SortItems.settings[grp][aName].DomID = id;
		var style = "width:203px; float:left; margin:0 20px 10px 10px;";
		var optstyle = "position:relative; top:2px; margin-left:3px;";
		var lblstyle = "padding:0 2px 0 3px;";

		if (twoCols == true) {
			style = "width:446px; float:left; margin:0 10px 10px;";
			optstyle = "position:relative; top:2px; margin-left:3px; float:left;";
			lblstyle = "padding:0 2px 0 3px; float:left; display: block; width: 191px;";
		}
		var options = '';

		var idx = 1;
		for (value in aValues) {
			if (value != undefined) {
				count = aValues[value];
				options = options + '<input type="checkbox" name="' + aName + idx
						+ '" value="' + value + '" id="' + id + '-' + idx + '" style="'
						+ optstyle + '" />' + '<label for="' + id + '-' + idx + '" style="'
						+ lblstyle + '">' + value + '</label>';
				if (twoCols == false) {
					options = options + '<br />';
				} else {
					if (idx % 2 == 0) {
						options = options + '<br />';
					} else {
						options = options
								+ '<div style="width:20px; float:left;">&nbsp;</div>';
					}
				}
				Sort.initvalues.push({
					aID : id + '-' + idx,
					aType : "check",
					aValue : false
				});
				idx++;
			}
		}
		Sort.addArea(parent, grp);
		if (twoCols) {
			Sort.addArea(parent, grp);
		}
		$(parent)
				.append(
						'<div style="'
								+ style
								+ '">'
								+ aName
								+ ':<hr style="border-bottom:1px solid #BBBBBB; height: 0px; padding:0; margin:0"><div id="'
								+ id + '">' + options + '</div></div>');
		$('#' + id + ' input:checkbox').change(function() {
			Sort.stateChanged(grp);
		});
	},

	createCheckBox : function(parent, grp, aName, aValues) {
		var id = Sort.createID("Check");
		SortItems.settings[grp][aName].DomID = id;
		var style = "width:203px; float:left; margin:0 20px 10px 10px;";
		var optstyle = "position:relative; top:2px; margin-left:3px;";
		var lblstyle = "padding:0 10px 0 3px;";
		var options = '';

		var idx = 1;
		for (value in aValues) {
			if (value != undefined) {
				count = aValues[value];
				options = options + '<input type="checkbox" name="' + aName
						+ '" value="' + value + '" id="' + id + '-' + idx + '" style="'
						+ optstyle + '" /><label for="' + id + '-' + idx + '" style="'
						+ lblstyle + '">' + value + '</label><br />';
				Sort.initvalues.push({
					aID : id + '-' + idx,
					aType : "check",
					aValue : false
				});
				idx++;
			}
		}

		Sort.addArea(parent, grp);
		var showName = aName;
		if (SortItems.settings[grp]["AvailabilityFilter"].Unit == "true"
				& aName == "Stock")
			showName = Sort.texts[SortItems.language].stock;

		$(parent)
				.append(
						'<div style="'
								+ style
								+ '">'
								+ showName
								+ ':<hr style="border-bottom:1px solid #BBBBBB; height: 0px; padding:0; margin:0"><div id="'
								+ id + '">' + options + '</div></div>');

		var idx = 1;
		for (value in aValues) {
			if (value != undefined) {
				$('#' + id + '-' + idx).change(function() {
					Sort.stateChanged(grp);
				});
				idx++;
			}
		}
	},

	createRangeSelector : function(parent, grp, aName, aUnit, aMin, aMax, steps, isLog) {
		var id = Sort.createID("Range");
		SortItems.settings[grp][aName].DomID = id;
		var style = "width:213px; float:left; margin:0 10px 10px;";
		var spanstyle = "line-height:25px;";
		if (aName == "Stock") {
			style = "width:446px; float:left; margin:0 10px 10px;";
			spanstyle = "line-height:25px; font-size: 11px;";
			Sort.addArea(parent, grp);
		}
		var showName = aName;
		if (SortItems.settings[grp]["AvailabilityFilter"].Unit == "true"
				& aName == "Stock")
			showName = Sort.texts[SortItems.language].stock;
		if (aName == "Preis" || aName == "Price")
			showName = Sort.texts[SortItems.language].price;
		if (SortItems.settings[grp]["VariantFilter"].Unit == "true"
				& aName == "_Variant")
			showName = Sort.texts[SortItems.language].variant;

		if (isLog) {
			Sort.addArea(parent, grp);
			$(parent).append(
					'<div style="' + style + '">' + showName + ': <span id="lbl' + id
							+ '" style="' + spanstyle + '">' + aMin + ' ' + aUnit + ' - '
							+ aMax + ' ' + aUnit + '</span><div id="' + id
							+ '" style="margin:0 10px;"></div></div>');
			$("#" + id).slider(
					{
						range : true,
						min : aMin,
						max : aMax,
						values : [ aMin, aMax ],
						slide : function(event, ui) {
							var gBottom = Number(expon(ui.values[0], aMin, aMax)).toFixed(0);
							var gTop = Number(expon(ui.values[1], aMin, aMax)).toFixed(0);
							if (gBottom == gTop)
								$("#lbl" + id).html(gBottom + ' ' + aUnit);
							else
								$("#lbl" + id).html(
										gBottom + ' ' + aUnit + " - " + gTop + ' ' + aUnit);
						},
						change : function() {
							Sort.stateChanged(grp);
						}
					});
			Sort.initvalues.push({
				aID : id,
				aType : "rangelog",
				aMin : aMin,
				aMax : aMax,
				aUnit : aUnit
			});
		} else {
			if (steps.length == 0) {
				Sort.addArea(parent, grp);
				$(parent).append(
						'<div style="' + style + '">' + showName + ': <span id="lbl' + id
								+ '" style="' + spanstyle + '">' + aMin + ' ' + aUnit + ' - '
								+ aMax + ' ' + aUnit + '</span><div id="' + id
								+ '" style="margin:0 10px;"></div></div>');
				$("#" + id).slider(
						{
							range : true,
							min : aMin,
							max : aMax,
							values : [ aMin, aMax ],
							slide : function(event, ui) {
								var gBottom = Number(ui.values[0]).toFixed(0);
								var gTop = Number(ui.values[1]).toFixed(0);
								if (gBottom == gTop)
									$("#lbl" + id).html(gBottom + ' ' + aUnit);
								else
									$("#lbl" + id).html(
											gBottom + ' ' + aUnit + " - " + gTop + ' ' + aUnit);
							},
							change : function() {
								Sort.stateChanged(grp);
							}
						});
				Sort.initvalues.push({
					aID : id,
					aType : "range",
					aMin : aMin,
					aMax : aMax,
					aUnit : aUnit
				});
			} else {
				Sort.addArea(parent, grp);
				$(parent).append(
						'<div style="' + style + '">' + showName + ': <span id="lbl' + id
								+ '" style="' + spanstyle + '">' + aMin + aUnit + ' - ' + aMax
								+ aUnit + '</span><div id="' + id
								+ '" style="margin:0 10px;"></div></div>');
				$("#" + id).slider({
					range : true,
					min : 0,
					max : steps.length - 1,
					values : [ 0, steps.length - 1 ],
					slide : function(event, ui) {
						var gBottom = steps[ui.values[0]];
						var gTop = steps[ui.values[1]];
						if (gBottom == gTop)
							$("#lbl" + id).html(gBottom + aUnit);
						else
							$("#lbl" + id).html(gBottom + aUnit + " - " + gTop + aUnit);
					},
					change : function() {
						Sort.stateChanged(grp);
					}
				});
				Sort.initvalues.push({
					aID : id,
					aType : "rangestep",
					aMin : 0,
					aMax : steps.length - 1,
					steps : steps,
					aUnit : aUnit
				});
			}
		}
	},

	sortRangeSteps : function(steps, recalculate, getStock) {
		var tosort = new Array();
		for (step in steps) {
			if (recalculate)
				v = stepToValue(steps[step]);
			else
				v = steps[step];
			tosort.push(v);
		}
		tosort.sort(function() {
			a = arguments[0];
			b = arguments[1];
			if ((typeof a == "object") && (typeof b == "object")) {
				a = a.SortPosition;
				b = b.SortPosition;
			}
			return a - b;
		});
		steps = new Array();
		for (step in tosort) {
			if (recalculate)
				steps.push(valueToStep(tosort[step]));
			else {
				if (typeof tosort[step] == "object") {
					if (getStock === true)
						steps.push(tosort[step].SortPosition);
					else
						steps.push(tosort[step].Text);
				} else
					steps.push(tosort[step]);
			}
		}

		var uniqueSteps = [];
		$.each(steps, function(i, el) {
			if ($.inArray(el, uniqueSteps) === -1)
				uniqueSteps.push(el);
		});

		return uniqueSteps;
	},

	createFilterbox : function(scope, grp) {
		Sort.tables[grp]["items"].sort();

		var id = Sort.createID('Filter');
		$(scope).parent().find('.productfilter').remove();
		var hidden = '';
		if (Sort.sortOnly) {
			hidden = ' style="display:none;"';
		}
		$(scope).before(
				'  <div class="productfilter"' + hidden + '>' + '    <h3>'
						+ Sort.texts[SortItems.language].title + '</h3>' + '    <div id="'
						+ id + '"></div>' + '  </div>');
		var newscope = $("#" + id);

		var sortvalues = new Array();

		var adata = SortItems.settings[grp];
		if (adata != undefined) {
			for ( var Feature in adata) {

				var aUnit = adata[Feature]["Unit"];
				var myType = adata[Feature]["Type"];
				var types = myType.split('|');

				for (idx in types) {
					var aType = types[idx];
					if ((aType == "range") || (aType == "rangelog")) {
						var rangemin = -1;
						var rangemax = -1;

						for ( var itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
							var pid = Sort.tables[grp]["items"][itemID];
							if (pid == undefined)
								continue;
							var value = Number(SortItems.itemData[pid][Feature]);
							if (value == undefined)
								continue;
							if (rangemin == -1)
								rangemin = value;
							if (rangemax == -1)
								rangemax = value;
							if (value < rangemin)
								rangemin = value;
							if (value > rangemax)
								rangemax = value;
						}
						if (Math.floor(rangemin) < Math.ceil(rangemax)) {
							if (aType == "range") {
								Sort.createRangeSelector(newscope, grp, Feature, aUnit, Math
										.floor(rangemin), Math.ceil(rangemax), [], false);
							} else {
								Sort.createRangeSelector(newscope, grp, Feature, aUnit, Math
										.floor(rangemin), Math.ceil(rangemax), [], true);
							}
						}
					}
					if (aType == "rangestep" || aType == "rangestep2") {
						var rangesteps = new Array();

						for (itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
							var pid = Sort.tables[grp]["items"][itemID];
							if (pid == undefined)
								continue;
							var value = SortItems.itemData[pid][Feature];
							if (value == undefined)
								continue;
							if (Feature == "Stock") {
								for ( var idx in value) {
									var sstep = value[idx];
									if (sstep['StockState'] == '14')
										sstep['StockState'] = '10';
									if (sstep['SortPosition'] == '88600')
										sstep['SortPosition'] = '89000';
									if (sstep['StockState'] == '15')
										sstep['StockState'] = '10';
									if (sstep['SortPosition'] == '88500')
										sstep['SortPosition'] = '89000';
									if (sstep['StockState'] == '71')
										sstep['StockState'] = '10';
									if (sstep['SortPosition'] == '82900')
										sstep['SortPosition'] = '89000';
									rangesteps.push(sstep);
								}
							} else if (Feature == "_Variant") {
								// console.log(value);
								for ( var idx in value) {
									var sstep = value[idx];
									rangesteps.push(sstep);
								}
							} else
								rangesteps.push(value);
						}
						rangesteps = Sort.sortRangeSteps(rangesteps, aType == "rangestep");
						if (rangesteps.length > 1)
							Sort.createRangeSelector(newscope, grp, Feature, aUnit,
									rangesteps[0], rangesteps[rangesteps.length - 1], rangesteps,
									false);
					}
					if (aType == "check") {
						var values = new Array();
						for (itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
							var pid = Sort.tables[grp]["items"][itemID];
							if (pid == undefined)
								continue;
							var value = SortItems.itemData[pid][Feature];
							if (value != undefined) {
								value = value.toString();
								// var idx = $.inArray(value, values);
								if (values[value] != undefined) {
									values[value] = values[value] + 1;
								} else {
									values[value] = 1;
								}
							}
						}
						Sort.createCheckBox(newscope, grp, Feature, values);
					}
					if ((aType == "featurelist") || (aType == "checklist")
							|| (aType == "checklist2col")) {
						var features = aUnit.split('|');
						var values = new Array();
						for (itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
							var pid = Sort.tables[grp]["items"][itemID];
							if (pid == undefined)
								continue;
							var value = SortItems.itemData[pid][Feature];
							if (value != undefined) {
								value = value.toString();
								var itemfeatures = value.split('|');
								for ( var idx in itemfeatures) {
									var feat = itemfeatures[idx];
									var found = $.inArray(feat, features);
									if (found != -1) {
										if (values[feat] != undefined) {
											values[feat] = values[feat] + 1;
										} else {
											values[feat] = 1;
										}
									}
								}
							}
						}
						if (aType == "featurelist")
							Sort.createFeatureList(newscope, grp, Feature, values);
						else if (aType == "checklist")
							Sort.createCheckList(newscope, grp, Feature, values, false);
						else
							Sort.createCheckList(newscope, grp, Feature, values, true);
					}
					if (aType == "sort") {
						sortvalues.push(Feature);
					}
				}
			}
		}
		$(newscope)
				.append(
						'<hr style="border-bottom:1px solid #BBBBBB; height: 0px; padding:0; margin:0">');
		Sort.createSortBox(newscope, grp, sortvalues);
		var pcount = 0;
		for (itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
			if (Sort.tables[grp]["items"][itemID] == undefined)
				continue;
			pcount++;
		}
		Sort.showResultCount(newscope, grp, pcount, pcount);

		$("div.productfilter").accordion({
			collapsible : true,
			heightStyle : "content",
			active : 0,
			beforeActivate : function(event, ui) {
				if (ui.newHeader && Sort.preventActivation) {
					if (Sort.preventActivation) {
						Sort.preventActivation = false;
						Sort.stateChanged(grp);
					}
					event.preventDefault();
				}
			}
		});

	},

	printMetadata : function(grp) {
		console.log(SortItems);
		var itemID;
		var pid;
		for (itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
			pid = Sort.tables[grp]["items"][itemID];
			if (pid == undefined)
				continue;
			var title = "$Metadaten§*";
			title = title + "Product-ID: " + pid;
			var aset = SortItems.settings[grp];
			// console.log(aset);
			var adata = SortItems.itemData[pid];
			var hasExtraData = false;
			for ( var Feature in adata) {
				var atype = "";
				// console.log(Feature);
				if (aset)
					if (aset[Feature] !== undefined)
						atype = aset[Feature]['Type'];
				if (Feature == "ExtraData") {
					hasExtraData = adata[Feature];
				}
				if (Feature == "Html") {
					title = title + "|" + Feature + ": ...";
				} else if (Feature == "Stock") {
					var output = '';
					for (property in adata[Feature]) {
						output += property + ' (' + atype + '): ';
						var su = adata[Feature][property];
						for (prop in su) {
							output += '  ' + prop + ': ' + su[prop] + ' ['
									+ (typeof su[prop]) + ']<br/> ';
						}
					}
					title = title + "|" + Feature + " (" + atype + "): " + output;
				} else {
					title = title + "|" + Feature + " (" + atype + "): " + adata[Feature];
					if (atype == "rangestep") {
						title = title + " -> " + stepToValue(adata[Feature]);
					}
				}
			}
			title = title + "#";
			if (hasExtraData == false) {
				color = "#FF0000";
			} else {
				color = "#000000";
			}

			Sort.tables[grp]["scope"].find("#aid" + pid).before(
					'<div style="position:relative; margin-bottom:-16px; color:' + color
							+ '" class="tooltip" title="' + title + '">META</div>');
		}

		for (itemID = 0; itemID < SortItems.settings.length; ++itemID) {
			var adata = SortItems.settings[itemID];
			if (adata != undefined) {
				var title = "$Metadaten§*";
				for ( var Eigenschaft in adata) {
					var atype = adata[Eigenschaft]['Type'];
					title = title + "|" + Eigenschaft + " (" + atype + ") : ";
					for ( var Part in adata[Eigenschaft]) {
						title = title + "|     " + Part + ": " + adata[Eigenschaft][Part]
								+ " ";
					}
				}
				title = title + "#";
				$("#listgrp" + itemID).prepend(
						'<div style="position:relative;" class="tooltip" title="' + title
								+ '">META</div>');
				$("#ProductArea" + itemID).prepend(
						'<div style="position:relative;" class="tooltip" title="' + title
								+ '">META</div>');
			}
		}

		$(".tooltip").tooltip(
				{
					position : {
						my : "left+15 top",
						at : "left bottom"
					},
					content : function(callback) {
						callback($(this).prop('title').replace(/\|/g, "\n").replace('$',
								'<h1 style="border-bottom: 1px solid black;">').replace('§',
								'</h1>').replace('*', '<pre>').replace('#', '</pre>'));
					}
				});
	},

	collectData : function(grp) {

		// Bewertungen abfragen
		// utoken anfordern
/*		if (!Sort.reviewsCollected) {
			var yurl = "https://api.yotpo.com/oauth/token";
			$.ajax({
				type : 'POST',
				url : yurl,
				crossDomain : true,
				data : {
					client_id : "qPU0VVj1lTHhSP1DxFwugANHM89iiXBqFPhcBN6Z",
					client_secret : "n70SfwYxSoJ1I1mUSDql5y8UNsNsDM3GYeWH2vcv",
					grant_type : "client_credentials"
				},
				dataType : 'json',
				cache : true,
				beforeSend : function() {
					if (localCache.exist(yurl)) {
						var utoken = (localCache.get(yurl));
						Sort.requestReviews(utoken, grp);
						return false;
					}
					return true;
				},
				success : function(data) {
					localCache.set(yurl, data.access_token);
					Sort.requestReviews(data.access_token, grp);
				},
				error : function(responseData, textStatus, errorThrown) {
					console.warn(responseData, textStatus, errorThrown);
				}
			});
		} else {
			Sort.printReviews(grp);
		}*/

		var pidlist = "";
		var pids = new Array();

		Sort.tables[grp]["scope"].find('[class|="item"]').map(function() {
			var name = $(this).find("h2").text().trim();

			var price = $(this).find(".pricecartstock").data("price");
			if (price == '') {
				price = -1;
			}

			var pid = $(this).find('span[id*="ttid"]').attr('id');
			if (pid == undefined) {
				pid = $(this).find('a[id*="aid"]').attr('id');
			}
			if (pid) {
				pid = pid.replace(/ttid/, '');
				pid = pid.replace(/aid/, '');
				if (pidlist != '')
					pidlist += ',';
				pidlist += pid;
				pids.push(pid);
				SortItems.regData(pid, "ExtraData", SortItems.hasExtraData(pid));
				var html = $(this).html();
				var item = $(this).attr("class").replace('item-', '');
				Sort.tables[grp]["items"][item] = pid;
				SortItems.regData(pid, "Name", name);
				if (SortItems.isValueSet(pid, "Preis") == false)
					SortItems.regData(pid, "Preis", price);
				SortItems.regData(pid, "Html", html);
			}
		});

		if (Sort.collectStock) {
			var url = 'http://' + document.domain
					+ '/php/index.php?cmd=stockinfo&newresult&pids=' + pidlist;
			$.ajax({
				url : url,
				async : true,
				cache : true,
				beforeSend : function() {
					if (localCache.exist(url)) {
						var data = (localCache.get(url));
						Sort.prepareData(data);
						return false;
					}
					return true;
				},
				success : function(data) {
					localCache.set(url, data);
					Sort.prepareData(data);
				}
			});
		}
	},
/*	requestReviews : function(utoken, grp) {
		// mit utoken alle Bewertungen anfordern
		var url = "https://api.yotpo.com/apps/qPU0VVj1lTHhSP1DxFwugANHM89iiXBqFPhcBN6Z/bottom_lines?utoken="
				+ utoken;
		$.ajax({
			url : url,
			crossDomain : true,
			cache : true,
			dataType : 'json',
			beforeSend : function() {
				if (localCache.exist(url)) {
					var data = (localCache.get(url));
					Sort.assignReviews(data, grp);
					return false;
				}
				return true;
			},
			success : function(data) {
				localCache.set(url, data.response.bottomlines);
				Sort.assignReviews(data.response.bottomlines, grp);
			},
			error : function(responseData, textStatus, errorThrown) {
				console.warn(responseData, textStatus, errorThrown);
			}
		});
	},

	assignReviews : function(data, grp) {
		Sort.reviewsCollected = true;
		console.group("Review");
		var field, score, views;
		var pid;
		console.log(data);
		for (pid = 0; pid < SortItems.itemData.length; ++pid) {
			if (SortItems.itemData[pid] == undefined)
				continue;
			field = SortItems.itemData[pid]["Review"];
			views = 0;
			score = 0;
			$.each(data, function(index, review) {
				if (review.domain_key == field) {
					views = review.total_reviews;
					score = review.product_score;
				}
				SortItems.regData(pid, "_Score", score);
				SortItems.regData(pid, "_Views", views);
			});
			//console.log(field, views, score);
		}
		console.log("Print From collect()");

		Sort.printReviews(grp);
		console.groupEnd();
	},

	printReviews : function (grp) {
		var pid,p;
		var text;
		for (pid = 0; pid < SortItems.itemData.length; ++pid) {
			if (SortItems.itemData[pid] == undefined)
				continue;
			var views = SortItems.itemData[pid]["_Views"];
			if (views == 0)
				continue;
			var score = SortItems.itemData[pid]["_Score"];
			if (views==1)
			  text = Sort.texts[SortItems.language].review;
			else
			  text = Sort.texts[SortItems.language].reviews;
			p = 100/5*score;
			score = '<div class="stars" style="width:70px; height:14px; position:relative;float:left;top:-2px;"><div style="height:14px; background: url(http://images.batronix.com/shop/star_empty.png) repeat-x; position: absolute; width:100%;"></div><div style="height:14px; background: url(http://images.batronix.com/shop/star_full.png) repeat-x; position: absolute; width:'+p+'%;"></div></div>';
			Sort.tables[grp]["scope"].find(".starrating-" + pid).html('<div style="float:left; position:relative; margin-right:5px; top:-2px;"><strong>'+views+' '+text+'</strong></div>'+score+'<div class="clearboth"></div>');
			//score = '<div class="stars" style="margin-left:10px; width:70px; height:14px; position:relative;float:left;"><div style="height:14px; background: url(http://images.batronix.com/shop/star_empty.png) repeat-x; position: absolute; width:100%;"></div><div style="height:14px; background: url(http://images.batronix.com/shop/star_full.png) repeat-x; position: absolute; width:'+p+'%;"></div></div>';
			//Sort.tables[grp]["scope"].find("#aid" + pid).parent().find("a:eq(1)").first().after(score+'<div style="float:left; margin-right:5px;"><strong>('+views+')</strong></div><div class="clearboth"></div>');

		}
//
//		for (itemID = 0; itemID < SortItems.settings.length; ++itemID) {
//			var adata = SortItems.settings[itemID];
//			if (adata != undefined) {
//				var title = "$Metadaten§*";
//				for ( var Eigenschaft in adata) {
//					var atype = adata[Eigenschaft]['Type'];
//					title = title + "|" + Eigenschaft + " (" + atype + ") : ";
//					for ( var Part in adata[Eigenschaft]) {
//						title = title + "|     " + Part + ": " + adata[Eigenschaft][Part]
//								+ " ";
//					}
//				}
//				title = title + "#";
//				$("#listgrp" + itemID).prepend(
//						'<div style="position:relative;" class="tooltip" title="' + title
//								+ '">META</div>');
//				$("#ProductArea" + itemID).prepend(
//						'<div style="position:relative;" class="tooltip" title="' + title
//								+ '">META</div>');
//			}
//		}

	},*/
	prepareData : function(data) {
		for (key in data) {
			SortItems.regData(key, "Stock", data[key]);
			var variants = new Array();
			for (variant in data[key]) {
				variants.push(data[key][variant]['Name']);
			}
			SortItems.regData(key, "_Variant", variants);
		}
	},
	Show : function(grp, result) {
		var newhtml = '';
		var i = 0;
		for ( var itemID = 0; itemID < Sort.tables[grp]["items"].length; ++itemID) {
			var pid = Sort.tables[grp]["items"][itemID];
			if (pid == undefined)
				continue;
			if (contains(result, pid)) {
				newhtml += '<div class="item-' + (i + 1) + '">'
						+ SortItems.itemData[pid]['Html'] + '</div>';
				i++;
			}
		}
		var scope = $('#ProductArea' + grp).find(".sortcontent");
		if (scope.length == 0) {
			scope = $('#listgrp' + grp).find(".sortcontent");
		}

		scope.html(newhtml);
		scope.find('div[class*="producttablerow"]:even').removeClass(
				'producttablerow0 producttablerow1').addClass('producttablerow0');
		scope.find('div[class*="producttablerow"]:odd').removeClass(
				'producttablerow0 producttablerow1').addClass('producttablerow1');
		console.log("Print From SHOW()");
		//Sort.printReviews(grp);
		if ( typeof RegisterVariants == 'function' ) {
			RegisterVariants();
		}
	}
};

/**
 * 
 */

$(function () {
	
	//$('#featureslider1').coinslider({ width: 700, height: 420, opacity: 1, spw:1, sph:1, effect: 'straight', links: true });
	
//	$(window).resize(function() {
//	    if (BrowserDetect) BrowserDetect.updateInfo();
//	});

	//myResize();
	var occwidth = parseFloat($('#content-container').css('width'));
	var occleft = parseFloat($('#content-container').css('left'));
	var obbwidth = parseFloat($('#bigbox').css('width'));
	var obcwidth = parseFloat($('.bigbox_pdispcontent').css('width'));
	
	//myResize();

	$('#setw').click(function(){
		$('#resizer').width(980);
		myResize();
	});
	$('#setw2').click(function(){
		$('#resizer').width(740);
		myResize();
	});
	$('#setwm').click(function(){
		$('#resizer').width('');
		myResize();
	});
	$('#shrink').click(function(){
	    var bwidth = $('#resizer').width();
		$('#resizer').width(bwidth-1);
		myResize();
	});
	$('#expand').click(function(){
	    var bwidth = $('#resizer').width();
		$('#resizer').width(bwidth+1);
		myResize();
	});
	$('#shrink10').click(function(){
	    var bwidth = $('#resizer').width();
		$('#resizer').width(bwidth-10);
		myResize();
	});
	$('#expand10').click(function(){
	    var bwidth = $('#resizer').width();
		$('#resizer').width(bwidth+10);
		myResize();
	});

	
	function myResize() {
	    var bwidth = $(window).width();
	    
	    
	    //bwidth = $('#resizer').width();
		var ccwidth = parseFloat($('#content-container').css('width'));
		var ccleft = parseFloat($('#content-container').css('left'));
		var bbwidth = parseFloat($('#bigbox').css('width'));
		var bcwidth = parseFloat($('.bigbox_pdispcontent').css('width'));
		var corr = (obbwidth - (bwidth - 42));
		if (corr<0) corr = 0;
		if (corr>240) corr = 240;
		var corrh = corr / 2;
		if (corr>0) {
			$('#content-container').css('width',occwidth-corr);
			
            var bbp = 0;
			var pdcl = 0;
			var bbpl = 10;
			if (corr<=40) {
				bbp = 20-corrh;
				pdcl = 20;
			}
			if (corr>40 && corr<60) {
				pdcl = 20-(corr-40);
			}
			if (corr<=60) {
				bbpl = 20;
			}
			if (corr>60 && corr<80) {
				bbpl = 20-(corrh-30);
			}

			if (corr>80) {
				$('.bigbox_pdispcontent').css('width',obcwidth-(corr-80));
			}
			
			$('#bigbox').css('padding-left',bbp);
			$('#bigbox').css('padding-right',bbp);
			$('.bigbox_pdispcontent').css('padding-left',pdcl);
			$('.bigbox_pdispleft').css('padding-left',bbpl);
			$('.bigbox_pdispleft').css('padding-right',bbpl);
			
		} else {
			$('#content-container').css('width',occwidth);
			$('#bigbox').css('padding-left',20);
			$('#bigbox').css('padding-right',20);
			$('.bigbox_pdispcontent').css('padding-left',20);
			$('.bigbox_pdispcontent').css('width',420);
			$('.bigbox_pdispleft').css('padding-left',20);
			$('.bigbox_pdispleft').css('padding-right',20);
			
		}

		
	/*	$('#resize').html('<pre style="font-family: monospace;">'+
			    'window.width             : '+bwidth+'px<br/><br/>'+
			    'correction               : '+corr+'px<br/><br/>'+
			    'content-container.width  : '+ccwidth+'px ('+occwidth+'px)<br/>'+
			    'content-container.left   : '+ccleft+'px ('+occleft+'px)<br/><br/>'+
			    'bigbox.width             : '+bbwidth+'px ('+obbwidth+'px)<br/>'+
			    'bigbox_pdispcontent.width: '+bcwidth+'px ('+obcwidth+'px)<br/>'+
			    '</pre>'
		);
	*/
	};
});
/**
 * 
 */
/* USE config.js */
/* USE tools.js */

var easyNav = {
	delay: config.easynav.popupDelay,
	mouseOver: false,
	navtree: [],
	temptree: [],
	init: function() {
		$.getScript(config.easynav.treeDataFile)
		.done(function () {
	    	easyNav.navtree = navtree['home'+config.language];
	    	$("ul#navhelper").find('li').hover(
		    	  	  function () {
		    	  		  easyNav.mouseOver = $(this);
		    	  		  $('div#easyNav').remove();
		    	  		  $(this).append('<div id="easyNav"></div>');
		    	  	      setTimeout('easyNav.afterDelay()', easyNav.delay);
		    	  	  },
		    	  	  function () {
		    	  		  easyNav.mouseOver = false;
		    	  		  $('#easyNav').fadeOut(200);
		    	  	  }
		    );
	    })
	    .fail(function(jqxhr, settings, exception) {
	    	if (config.debug)  
	    	  alert( "Triggered ajaxError handler." );
	    });  
	},
	afterDelay: function () {
		if (easyNav.mouseOver) {
			var level = easyNav.mouseOver.index();
			var list = easyNav.mouseOver.parent();
			var count = list.find('li').size();
			if (level<count) {
				easyNav.temptree = easyNav.navtree;
				list.find('li').each(function () {
					if ($(this).index()<=level) {
						var text = $(this).text();
						if (text=="") text='home';
						text = tools.htmlEntities(text);
						if (text!='home') {
							easyNav.temptree = easyNav.temptree[text];
						}
					}
				});
				$('#easyNav').html('');
				$('#easyNav').append('<div id="easyNavCont"><ul id="easynavdd"></ul></div>');
				var typ = easyNav.temptree.constructor.toString();
				if (typ.indexOf("String") == -1) {
					for(var text in easyNav.temptree) {
						if (text=='__base_val') continue;
						var link = easyNav.temptree[text];
						var typ = link.constructor.toString();
						if (typ.indexOf("String") == -1) {
							link = link['__base_val'];
						}
						if (link)
						  $('#easynavdd').append('<li style="clear:left;"><a href="'+link+'" title="'+text+'"><span>'+text+'</span></a></li>');
					}
					var pos = easyNav.mouseOver.position().left;
					if (pos>0) pos = pos - 13;
					$('#easyNav').css('left',pos).slideDown(50);
				}				
			}
		}
	}
};

/* USE config.js */
// JS function for uncrypting spam-protected emails:
function UnCryptMailto(s) {
	var n=0;
	var r="";
	for(var i=0; i < s.length; i++) {
		n=s.charCodeAt(i);
		if (n>=8364) {n = 128;}
		r += String.fromCharCode(n-(1));
	}
	return r;
}

// JS function for uncrypting spam-protected emails:
// Verschlüsselungsseite: http://jumk.de/nospam/
function linkTo_ServiceMailto()	{
	location.href=UnCryptMailto('nbjmup;tfswjdfAcbuspojy/dpn');
}

// JS function for uncrypting spam-protected emails:
function linkTo_BewerbungMailto()	{
	location.href=UnCryptMailto('nbjmup;cfxfscvohAcbuspojy/dpn');
}

// JS function for uncrypting spam-protected emails:
function linkTo_ServiceWHMailto()	{
	location.href=UnCryptMailto('nbjmup;tfswjdfAxfuufsifmefo/ef');
}

// JS function for uncrypting spam-protected emails:
function linkTo_UnCryptMailto(s)	{
	location.href=UnCryptMailto(s);
}

var ChangeBecauseOfClick = false;

var popup = {
  settings: {
    height: 700,
    width: 1010
  },
  open: function(windowUri) {
    var windowWidth = popup.settings.width;
    var windowHeight = popup.settings.height;
    var a = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft;
    var i = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop;
    var g = typeof window.outerWidth!='undefined' ? window.outerWidth : document.documentElement.clientWidth;
    var f = typeof window.outerHeight != 'undefined' ? window.outerHeight: (document.documentElement.clientHeight - 22);
    var h = (a < 0) ? window.screen.width + a : a;
    var left = parseInt(h + ((g - windowWidth) / 2), 10);
    var top = parseInt(i + ((f-windowHeight) / 2.5), 10);
    var newWindow = window.open(windowUri, '_blank', 'location=0' +
                 ',toolbar=0' +
				 ',width=' + windowWidth +
				 ',height=' + windowHeight +
				 ',top=' + top +
				 ',left=' + left +
				 ',scrollbars=yes',
                 true);
  }
};
$(function() {
    $("#faqtv1").treeview({speed: "fast", collapsed: true});
    $("#faqtv2").treeview({speed: "fast", collapsed: true});
	$(".tab-container-nojs").removeClass('tab-container-nojs');
	$(".nojs").removeClass('nojs');
	$(".sidenojs").removeClass('sidenojs');
	$("#tabs").tabs({ selected : config.tabs.defaultTab,beforeActivate: function( event, ui ) {ChangeBecauseOfClick = true;}});

	MainMenu.init();
	Sort.init();
	$("ul#navhelper").find('li').hover(
		  	  function () {
		  	    $(this).find('span.navhome:not(.nolink)').removeClass('navhome').addClass('navhomesel');
		  	    $(this).find('span.navhelpleft:not(.nolink)').removeClass('navhelpleft').addClass('navhelpleftsel');
		  	    $(this).find('span.navhelpmid:not(.nolink)').removeClass('navhelpmid').addClass('navhelpmidsel');
		  	    $(this).find('span.navhelpright:not(.nolink)').removeClass('navhelpright').addClass('navhelprightsel');
		  	  },
		  	  function () {
		   	    $(this).find('span.navhomesel').removeClass('navhomesel').addClass('navhome');
		  	    $(this).find('span.navhelpleftsel').removeClass('navhelpleftsel').addClass('navhelpleft');
		  	    $(this).find('span.navhelpmidsel').removeClass('navhelpmidsel').addClass('navhelpmid');
		  	    $(this).find('span.navhelprightsel').removeClass('navhelprightsel').addClass('navhelpright');
		  	  }
		    );
	easyNav.init();

    $('.opener').each(function(){
        var anchor = $(this).attr('rel');
		if (typeof anchor=='undefined')
          anchor = $(this).attr('id');
		if (typeof anchor!='undefined') {
			var opener = $(this);
			$.ajax({url:config.detailDownload.url[config.language],async:true})
			  .done(function(data){
				opener.html('<div id="dlcont"></div>');
				var content = $(data).find('#'+anchor).clone(true);
				content.find('div').first().remove();
				content.find('span').first().remove();
				content.find('span.zipfile,span.rarfile,span.exefile').each(function(index) {
					var text = $(this).text();
					$(this).parent().addClass('btn_download');
					$(this).parent().parent().append($(this).parent());
					$(this).parent().parent().prepend($(this));
				});
				content = content.html();
				$("#dlcont").append(content);
			  });
		}
		return false;
      });

  	if($.fn.localScroll) {
  		$("#tabs ul").localScroll({
  		  target:"#tabs",
  		  duration:0,
  		  hash:false
  		});
  	}
  	if($.fn.scrollTo) {
 		  if($("#tabs") && document.location.hash){
 		  	var hash = document.location.hash;
   			if (hash=="#yoReviews")
   				hash = "#tabs-20";
   			if (hash.indexOf("tabs"))
   				$.scrollTo("#tabs",{offset:{top:-5,left:0}});
			  $('#tabs').selectTabByID(hash);
  		}
  	}
});
$(window).hashchange(function(){
		if (!ChangeBecauseOfClick) {
		  if($("#tabs") && document.location.hash){
 		  	var hash = document.location.hash;
				if (hash=="#yoReviews")
					hash = "#tabs-20";
   			if (hash.indexOf("tabs"))
  				$.scrollTo("#tabs",{offset:{ top:-5,left:0 } });
			  $('#tabs').selectTabByID(hash);
	  	}
		}
	  ChangeBecauseOfClick = false;
});
//$(window).load(
//		function() {
//		});
