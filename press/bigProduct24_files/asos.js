var showCloseEffect = false;
function ShowVideo() {
	$(".show-video").hide();
	$(".show-image").show();
	// Google Analytics code Start - CATWALK
	var floorName = $("#FloorName").val();
	var categoryName = $("#CategoryName").val();
	pageTracker._trackPageview();
	pageTracker._trackEvent(floorName, 'Click View Catwalk', categoryName);
	// Google Analytics code End - CATWALK     
	loadFlash();
	$(".productImages").hide();
	$('#divFlash').show();
}
function HideVideo() {
	$(".productImages").show();
	$(".show-video").show();
	$(".show-image").hide();
    $('#divFlash').hide();
	loadFlash('/assets/asosCom/flash/blank.swf'); // Stop the music if a video is playing
}
function drpdwnColourChange(ClientId, currentArray, colourThumbsArray, productMode) {
	var drpdwnColour = document.getElementById(ClientId + '_drpdwnColour');
	var drpdwnSize = document.getElementById(ClientId + '_drpdwnSize');
	var drpdwnindex = drpdwnColour.selectedIndex;
	var SelectedColour = filterNonWordChars(drpdwnColour.options[drpdwnindex].value);
	var ChkPurchase = document.getElementById(ClientId + '_chkPurchase');

	PopulateDropDowns(ClientId, currentArray);
	showSelectedColourImage(ClientId, drpdwnColour, colourThumbsArray);
	if (drpdwnindex != 0) {
		var mainImageUrl = $(".main-image").attr("src");
		var mainImageUrlInsert = mainImageUrl.length-6;
		var mainThumbUrl = mainImageUrl.substr(0,mainImageUrlInsert) + "s.jpg";
		$("#productImageLayer .productThumbnails li:nth-child(1)").find("img").attr("src",mainThumbUrl);
	}
	else { 
		if (ChkPurchase) {
			ChkPurchase.disabled = true;
			ChkPurchase.parentNode.disabled = true;
		}
	}
	HideVideo();
	xxlImagesLoaded = false;
	apiScrollable.begin();
}
function showSelectedColourImage(id, currentColourDDL, colourThumbsArray) {
	var selectedColourIndex = currentColourDDL.selectedIndex;
	var selectedColourValue = filterNonWordChars(currentColourDDL.options[selectedColourIndex].value);
	$.each(colourThumbsArray, function(i){
		if (colourThumbsArray[i][3].toString().toLowerCase() == selectedColourValue.toString().toLowerCase()) {
			$(".main-image").attr("src",colourThumbsArray[i][1]);
			$(".main-image").siblings("img").attr("src","");
			$(".main-thumb").attr("src",colourThumbsArray[i][0]);
		}
	});
}
var selectedSizeIndex;
function drpdwnSizeChange(drpdwnSize, clientId, currentArray) {
	var SizeIndex = drpdwnSize.selectedIndex;
	var SizeId = drpdwnSize.options[SizeIndex].value;
	var ColourIndex = document.getElementById(clientId + '_drpdwnColour').selectedIndex;
	var Colour = filterNonWordChars(document.getElementById(clientId + '_drpdwnColour').options[ColourIndex].value);
	var ChkPurchase = document.getElementById(clientId + '_chkPurchase');

	if (SizeIndex != 0) {
		if (InStock(SizeId, Colour, currentArray) == false) {
			alert('Please select a size that is in stock');
			drpdwnSize.selectedIndex = 0;
			if (ChkPurchase) {
				ChkPurchase.disabled = true;
				ChkPurchase.parentNode.disabled = true;
				ChkPurchase.checked = false;
			}
		}
		else {
			if (ChkPurchase) {
				ChkPurchase.disabled = false;
				ChkPurchase.parentNode.disabled = false;
			}
			for (x = 0; x < currentArray.length; x++) {
				if (SizeId == currentArray[x][0] && Colour == currentArray[x][2]) {
					selectedSizeIndex = SizeIndex;
					break;
				};

			};
		};
	}
	else {
		selectedSizeIndex = SizeIndex;
		if (ChkPurchase) {
			ChkPurchase.disabled = true;
			ChkPurchase.parentNode.disabled = true;
			ChkPurchase.checked = false;
		}
	};
}
function PopulateDropDowns(clientId, currentArray) {
	if (currentArray.length == 0) { return false; };
	var drpdwnColour = document.getElementById(clientId + '_drpdwnColour');
	var ColourIndex = drpdwnColour.selectedIndex;
	var Colour = filterNonWordChars(drpdwnColour.options[ColourIndex].value);
	var drpdwnSize = document.getElementById(clientId + '_drpdwnSize');
	var SizeIndex = drpdwnSize.selectedIndex;
	if (SizeIndex == -1) { SizeIndex = 0 };
	var SizeId = (drpdwnSize.options.length > 0 ? drpdwnSize.options[SizeIndex].value : -1);
	var ChkPurchase = document.getElementById(clientId + '_chkPurchase');

	var w = 0;
	var x = 0;
	var y = 0;
	var z;
	var blnFoundSize;
	var arrInStockSizeId = new Array();

	drpdwnSize.options.length = 0;
	oNewOption = new Option();
	oNewOption.value = -1;
	oNewOption.text = "Select Size";
	drpdwnSize.options[drpdwnSize.length] = oNewOption;
	if (ColourIndex == 0) {
		drpdwnSize.disabled = true;
		for (x = 0; x < currentArray.length; x++) {
			if (currentArray[x][1] == 'No Size') {
				document.getElementById(clientId + '_pnlSize').style.display = "none";
			};
		};
	}
	else {
		drpdwnSize.disabled = false;

		for (x = 0; x < currentArray.length; x++) {
			blnFoundSize = false;
			for (z = 0; z < drpdwnSize.options.length; z++) {
				if (drpdwnSize.options[z].value == currentArray[x][0]) {
					blnFoundSize = true;
					break;
				};
			};
			if (blnFoundSize == false && Colour == currentArray[x][2]) {
				y += 1;
				oNewOption = new Option();
				oNewOption.value = currentArray[x][0];
				if (currentArray[x][3] == 'True') {
					if (currentArray[x][1] != 'No Size') {
						if (currentArray[x][4] == '') {
							oNewOption.text = currentArray[x][1];
						}
						else {
							oNewOption.text = currentArray[x][1] + ' - ' + currentArray[x][4];
						}
					}
					else {
						oNewOption.text = currentArray[x][1];
					}
					arrInStockSizeId[arrInStockSizeId.length] = currentArray[x][0];

					if (currentArray[x][0] == SizeId && ColourIndex != 0) {
						w = y;
						selectedSizeIndex = y;
					};
				}
				else {
				    oNewOption.text = currentArray[x][1] + ' - ' + document.getElementById(clientId + '_hidNotAvailableText').value;
				};

				var priceElement = document.getElementById(clientId + '_lblProductPrice');
				var lastPriceElement = document.getElementById(clientId + '_lblProductPreviousPrice');
				var rrpElement = document.getElementById(clientId + '_lblRRP');
				var redSaveElement = document.getElementById(clientId + '_lblRedSave')

				if (parseFloat(currentArray[x][6]) > parseFloat(currentArray[x][5])) {
					priceElement.innerHTML = currentArray[x][7] + '' + currentArray[x][6] + '' + currentArray[x][8];
					if (lastPriceElement) {
						lastPriceElement.innerHTML = 'NOW ' + currentArray[x][7] + '' + currentArray[x][5] + '' + currentArray[x][8];
					}
				} else {
					priceElement.innerHTML = currentArray[x][7] + '' + currentArray[x][5] + '' + currentArray[x][8];
					if (lastPriceElement) {
						lastPriceElement.innerHTML = '';
					}
				}

				if (parseFloat(currentArray[x][9]) > 0) {
					var pricetxt = priceElement.innerHTML;

					rrpElement.innerHTML = 'RRP ' + currentArray[x][7] + '' + currentArray[x][10] + '' + currentArray[x][8] + '<br />';
					redSaveElement.innerHTML = 'SAVE ' + currentArray[x][7] + '' + currentArray[x][9] + '' + currentArray[x][8];
					redSaveElement.innerHTML += ' (' + currentArray[x][11] + '%)';
					priceElement.innerHTML = pricetxt;
				} else {
					if (rrpElement) {
						rrpElement.innerHTML = '';
					}
				}
				drpdwnSize.options[drpdwnSize.length] = oNewOption;
				if (w != 0) { drpdwnSize.selectedIndex = w; };
			};
		};
		if (arrInStockSizeId.length == 1 && ColourIndex != 0) {
			for (z = 0; z < drpdwnSize.options.length; z++) {
				if (drpdwnSize.options[z].value == arrInStockSizeId[0]) {
					drpdwnSize.selectedIndex = z;
					if (ChkPurchase) {
						ChkPurchase.disabled = false;
						ChkPurchase.parentNode.disabled = false;
					}
					if (drpdwnSize.options[z].text == 'No Size') {
						document.getElementById(clientId + '_pnlSize').style.display = "none";
					};
				};
			};
		};
	};
	if (drpdwnSize.options.length == 2) {
		drpdwnSize.selectedIndex = 1;
		drpdwnSize.disabled = true;
	};
}
function InStock(SizeId, Colour, currentArray) {
	var i;
	if (SizeId == -1 && Colour != -1) {
		for (i = 0; i < currentArray.length; i++) {
			if (currentArray[i][2] == Colour && currentArray[i][3] == 'True') {
				return true;
			};
		};
	}
	else if (Colour == -1 && SizeId != -1) {
		for (i = 0; i < currentArray.length; i++) {
			if (currentArray[i][0] == SizeId && currentArray[i][3] == 'True') {
				return true;
			};
		};
	}
	else if (Colour != -1 && SizeId != -1) {
		for (i = 0; i < currentArray.length; i++) {
			if (currentArray[i][0] == SizeId && currentArray[i][2] == Colour && currentArray[i][3] == 'True') {
				return true;
			};
		};
	}
	else {
		return false;
	};
	return false;
}
function CanSubmitSeperate() {

	var canSubmit = false;
    sizeSelector = $('#separates_till_box').find('div.size select');
    colourSelector = $('#separates_till_box').find('div.colour select');
    
    isColourSelected = (colourSelector.attr("selectedIndex") > 0);
    isSizeSelected = (sizeSelector.attr("selectedIndex") > 0);
    
	if (!isColourSelected || !isSizeSelected) {
		alert("Please select from the available size and colour options");
		canSubmit = false;
	}
	else {
		sizeSelector.disabled = false;
		canSubmit = true;
	};
	
	return canSubmit;
}
function CanSubmit() {
    //TODO: id references need to be thrown into this function instead - hardcoding for now.
	var blnHasChecked
	for (var i = 1; i <= 6; i++) {
		if (document.getElementById("ctl00_ContentMainPage_ctlSeparate" + i + "_chkPurchase") && document.getElementById("ctl00_ContentMainPage_ctlSeparate" + i + "_chkPurchase").checked == true) {
			blnHasChecked = true;
		}
	}
	if (blnHasChecked) {
		return true;
	}
	else {
		alert("Please select at least one item for purchase");
		return false;
	};
}
function SetPopUpData(Title, InvLongDescription, ImageSrc, CareInfo, AdditionalInfo, SKU, ClientId, DefaultColour) {

	var strImageMainSrc;
	var drpdwnColour = document.getElementById(ClientId + '_drpdwnColour');
	var SelectedColour;
	var LoadingImage = document.getElementById('content_product_loading').innerHTML;

	if (drpdwnColour) { var drpdwnindex = drpdwnColour.selectedIndex; }
	else { var drpdwnindex = 0 }

	if (drpdwnindex == 0) {
		SelectedColour = DefaultColour;
	}
	else {
		SelectedColour = filterNonWordChars(drpdwnColour.options[drpdwnindex].value);
	}

    //load the images into temp holders
	eval("LoadTmpHolder(SelectedColour, arrSepImage_" + ClientId + ", arrThumbImage_" + ClientId + ", '_popup');");

	$.each($("#productImageLayer_Popup > ul > li"), function(i){
		$(this).find("img").attr("src",tmpHolder[i][0]);
	    $(this).find("img").attr("alt", 'Image ' + (i + 1) + ' of ' + Title);
		$(this).find("img").attr("title", 'Enlarge ' + Title);
	});
	$.each($("#productImageLayer_Popup img.xl"), function(){
		var itemId = parseInt($(this).parent().attr("id").substring(5,6))-1;
		$(this).attr("src",tmpHolder[itemId][1]);
	});

	$("#productImageLayer_Popup .next").show();
	$("#productImageLayer_Popup .prev").show();
	
	overlayContainer = $('#overlay-box-container'); //find the overlay box container so that we can find child classes from it

    productPrice = overlayContainer.find(".product-price-details");
    productPreviousPrice = overlayContainer.find(".product-previous-price");
    productRedSave = overlayContainer.find(".redsave");
    productRRP = overlayContainer.find(".product_rrp");
    productOutOfStock = overlayContainer.find(".product-out-of-stock");

	if (document.getElementById(ClientId + "_lblProductPrice")) { productPrice.innerHTML = document.getElementById(ClientId + "_lblProductPrice").innerHTML; }
	if (document.getElementById(ClientId + "_lblProductPreviousPrice")) { productPreviousPrice.innerHTML = document.getElementById(ClientId + "_lblProductPreviousPrice").innerHTML; }
	if (document.getElementById(ClientId + "_lblRedSave")) { productRedSave.innerHTML = document.getElementById(ClientId + "_lblRedSave").innerHTML; }
	if (document.getElementById(ClientId + "_lblRRP")) { productRRP.innerHTML = document.getElementById(ClientId + "_lblRRP").innerHTML; }
	if (document.getElementById(ClientId + "_pnlOutofStock")) { productOutOfStock.show(); }	else { productOutOfStock.hide(); }
	
	productTitle = overlayContainer.find(".product_title");
    productDescription = overlayContainer.find(".product_description");
    productCode = overlayContainer.find(".product-code");
    additionalInfo = overlayContainer.find(".additional-info");
    careInfo = overlayContainer.find(".care-info");
	
	productTitle.html(Title);
	productDescription.html(InvLongDescription);
	productCode.html(SKU);
	additionalInfo.html(AdditionalInfo);
	careInfo.html(CareInfo);
	
    //hide dropdown menus on the underlying page for IE6 show-through problem
	if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { //test for MSIE x.x;
		var ieversion = new Number(RegExp.$1)
		// capture x.x portion and store as a number
		if (ieversion <= 6) {  
		   $('select').hide();
		}
	}
	$("#productImageLayer_Popup img.xxl").attr("src","");
	var defaultImageSize = $("#productImageLayer_Popup .productImages").width();
	if(typeof apiScrollable_Popup == "undefined"){
		//mix and match not ready
	} else {
		setTimeout(function() {
			apiScrollable_Popup.begin();
			//maintainCurrentImage(true, "productImageLayer_Popup", 400);
		}, 1000);
	}
}

function OnPopupOk() {
	if (document.getElementById("lblProductPreviousPrice_popup")) {document.getElementById("lblProductPreviousPrice_popup").innerHTML = ''; }
	if (document.getElementById("lblRedSave_popup")) { document.getElementById("lblRedSave_popup").innerHTML = ''; }
	if (document.getElementById("lblRRP_popup")) { document.getElementById("lblRRP_popup").innerHTML = ''; }

	if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { //test for MSIE x.x;
	    var ieversion = new Number(RegExp.$1)
	    // capture x.x portion and store as a number
	    if (ieversion <= 6) {
	        $('select').show();
	    }
	}
	document.getElementById("lblOutofStock_popup").style.display = 'none';
}
function positionSaveForLaterNotification() {
	$.facebox.settings.overlay = false;
	$.facebox.settings.centered = false;
	$.facebox.settings.topPosition = ($(".save-for-later").offset().top + 25) + 'px';
	$.facebox.settings.leftPosition = ($(".save-for-later").offset().left - 145) + 'px';
	$.facebox.settings.width = 350;
}
function createStringFromSeparates() {

    var invSeperator = '|';
    var propertySeperator = ',';

    var seperateId = null;
    var colour = null;
    var sizeId = null;
    var parentId = null;

    var strElem = null;
    var strSeparates = '';

    //loop through checked checkboxes
    $("span.select-for-purchase input:checked").each(function() {
        seperateId = $(this).parent().attr("class").replace('select-for-purchase ', '').replace('-checkbox', '');

        if (seperateId != null && seperateId.length > 0) {
            parentId = $("span." + seperateId + "-parentId input").val();
            colour = $("select." + seperateId + "-colour option:selected").val();
            sizeId = $("select." + seperateId + "-size option:selected").val();

            if (parentId.length > 0 && colour.length > 0 && sizeId.length > 0) {

                strElem = parentId + propertySeperator + colour + propertySeperator + sizeId;

                if (strSeparates != null && strSeparates.length > 0 && strSeparates.substring(strSeparates.length - 2, strSeparates.length - 1) != invSeperator) {
                    strSeparates += invSeperator;
                }

                strSeparates += strElem;
            }
        }
    });


    return strSeparates;
}

$(document).ready(function() {
    //tabbed content
    $("#delivery").show();
    $("#freeReturns").show();
    $(".product-tabs > ul").tabs({ selected: 0 });
    $("#productTabs").show();
    $("#loadingTabs").hide();

    //Save for later
    $("a.product_SaveForLater").click(function() {
        positionSaveForLaterNotification();
        if (CanSubmitSeperate()) {
            var url = "/services/srvSaveForLater.asmx/SaveInventoryForLater";
            var errorMessage = '<div class="saved-for-later-notification"><p>Sorry this item could not be saved. Please try again.</p><p><a href="#" class="close">Continue shopping</a></p></div>';
            var successMessage = null;

            var parentId = $("span.ctlSeparateProduct-parentId input").val();
            var colour = $("div.colour select option:selected").val();
            var sizeId = $("div.size select option:selected").val();

            var catRefineInfo = $("input#hdn-cat-refine-values").val();

            if (parentId.length > 0 && colour.length > 0 && sizeId.length > 0) {

                if (catRefineInfo.length > 0) {
                    successMessage = '<div class="saved-for-later-notification"><p>This item has been saved for 30 days.</p><p><a href="#" class="close">Continue shopping</a> | <a href="/basket/pgebasket.aspx?iid=' + parentId + '&' + catRefineInfo + '#your-saved-items">View saved items</a></p></div>';
                } else {
                    successMessage = '<div class="saved-for-later-notification"><p>This item has been saved for 30 days.</p><p><a href="#" class="close">Continue shopping</a> | <a href="/basket/pgebasket.aspx?iid=' + parentId + '#your-saved-items">View saved items</a></p></div>';
                }

                $.ajax({
                    type: "POST",
                    url: url,
                    data: "{ParentId : " + parentId + ", Colour : '" + colour + "' , SizeId : '" + sizeId + "'}",
                    dataType: "json",
                    contentType: "application/json; charset=utf-8",
                    success: function(data) {
                        if (data.d == true) {
                            $.facebox(successMessage);
                            if (mini_basket_holder) {
                                mini_basket_holder.showViewSavedItemsButtonOnEmptyBag();
                            }
                        } else {
                            $.facebox(errorMessage);
                        }
                    },
                    error: function() {
                        $.facebox(errorMessage);
                    }
                });
                try {
                    PageTrackerClickEvent('Product Page', 'Save for Later');
                }
                catch (err) { };
            } else {
                $.facebox(errorMessage);
            }
        }
        return false;
    });
    $("a.save-for-later-mix-and-match").click(function() {
        positionSaveForLaterNotification();

        if (CanSubmit()) {

            var url = "/services/srvSaveForLater.asmx/SaveInventorysForLater";
            var errorMessage = '<div class="saved-for-later-notification"><p>Sorry this item could not be saved. Please try again.</p><p><a href="#" class="close">Continue shopping</a></p></div>';
            var successMessage = null;

            var invSeperator = '|';
            var propertySeperator = ',';

            var seperateId = null;
            var colour = null;
            var sizeId = null;
            var parentId = null;

            var catRefineInfo = $("input#hdn-cat-refine-values").val();

            var strElem = null;
            var strSeparates = '';

            var redirectParentId = null;

            strSeparates = createStringFromSeparates();

            if (strSeparates.length > 0) {

                redirectParentId = strSeparates.substring(0, strSeparates.indexOf(',', 0));

                if (catRefineInfo.length > 0) {
                    successMessage = '<div class="saved-for-later-notification"><p>This item has been saved for 30 days.</p><p><a href="#" class="close">Continue shopping</a> | <a href="/basket/pgebasket.aspx?iid=' + redirectParentId + '&' + catRefineInfo + '#your-saved-items">View saved items</a></p></div>';
                } else {
                    successMessage = '<div class="saved-for-later-notification"><p>This item has been saved for 30 days.</p><p><a href="#" class="close">Continue shopping</a> | <a href="/basket/pgebasket.aspx?iid=' + redirectParentId + '#your-saved-items">View saved items</a></p></div>';
                }

                $.ajax({
                    type: "POST",
                    url: url,
                    data: "{StrSeparates : '" + strSeparates + "'}",
                    dataType: "json",
                    contentType: "application/json; charset=utf-8",
                    success: function(data) {
                        if (data.d == true) {
                            $.facebox(successMessage);
                            if (mini_basket_holder) {
                                mini_basket_holder.showViewSavedItemsButtonOnEmptyBag();
                            }
                        } else {
                            $.facebox(errorMessage);
                        }
                    },
                    error: function() {
                        $.facebox(errorMessage);
                    }
                });
                try {
                    PageTrackerClickEvent('Mix Match Page', 'Save for Later');
                }
                catch (err) { };
            } else {
                $.facebox(errorMessage);
            }
        }

        return false;
    });
    $('#content_product_images_box .other-categories .item a').click(function() {
        try {
            PageTrackerClickEvent('Product Page More From', 'Click on More From link');
        }
        catch (err) { };
    });
});

function filterNonWordChars(text) {
    if (text) {
        if (text === '') {
            return text
        } else {
            return text.replace(/[^\w]/g, '');
        }
    } else {
        return text;
    }
   }
function hideFlash() {
	$(".flash").hide();
}
function getMovie() {
	var flashMovie;
	var movieName = "objFlashVideo";
	
	if (window.document[movieName]) {
		return window.document[movieName];
	}
	if (navigator.appName.indexOf("Microsoft Internet")==-1) {
		if (document.embeds && document.embeds[movieName])
			return document.embeds[movieName]; 
	} else {
		return document.getElementById(movieName);
	}
}
			
function getFlash() {
	var finishedHtml;
	
	window.open('http://www.macromedia.com/go/getflashplayer');
	
	finishedHtml = '<table cellpadding="0" cellspacing="0" border="0" height="370" width="290"><tr>';
	finishedHtml += '<td valign="middle" class="product_grey_dark_sml" height="370" width="290">';
	finishedHtml += 'If you have successfully installed the flash player then reload the page or <br/>';
	finishedHtml += '<a href="javascript:location.reload();">click here to view the video</a>.';
	finishedHtml += '<br/><br/>';
	finishedHtml += 'You may need to close all of your browser windows in order for the install to complete.';
	finishedHtml += '<br/><br/>';
	finishedHtml += '<a href="/infopages/pgehelpdesk.aspx#cantviewvid">Click here to visit our help section</a> if you\'re still having problems.';
	finishedHtml += '</td></tr></table>';
	pnlFlashObject.innerHTML = finishedHtml;
}
function checkFlashIsInstalled(){
    var requiredVersion = "9.0.124";
    var hasRequestedVersion = swfobject.hasFlashPlayerVersion(requiredVersion);
    var alternateContent = '<div class="alternative-content"><p>To view this feature you\'ll need to install ';
    if (hasRequestedVersion) {
        alternateContent += 'the latest version of '
    }
    alternateContent += 'Macromedia\'s Flash player.</p>'
		+'<ol>'
        + '<li><a href="javascript:getFlash();">Click here to get flash player</a> (opens in a new window).</li>'
        + '<li>Follow the on screen instructions.</li>'
        + '<li>Close the window to come back to ASOS.</li>'
        + '</ol>'
        + '<p><a href="/infopages/pgehelpdesk.aspx#cantviewvid">Visit our help section</a> if you\'re still having problems.</p>'
        + '</div>';
	$(".content_product_images_video").append(alternateContent);
}
function loadXXLImage(imageContainer){
	if(!xxlImagesLoaded){
		var xlImage = imageContainer.find("img.xl");
		var xxlImage = imageContainer.find("img.xxl");
		var xlImageSource = xlImage.attr("src");
		var xxlImageSource = xxlImage.attr("src");
		if(xlImageSource != null && xxlImageSource == ""){
			var xlImageSoucreInsert = xlImageSource.length-6;
			xxlImageSource = xlImageSource.substr(0,xlImageSoucreInsert) + "x" + xlImageSource.substr(xlImageSoucreInsert);
			xxlImage.attr("src",xxlImageSource);
		}
	}
}
function loadAllXXLImages() {
	if(!xxlImagesLoaded){
		$.each($(".productImagesItems > div "), function(){
			loadXXLImage($(this))
		});
		xxlImagesLoaded = true;
	}
}
function raiseZIndex(layer,layerIdToStopAt) {
	var parent = layer.parent();
	if(parent!=null && parent.attr("id")!==layerIdToStopAt){
		parent.css("z-index","9999"); //TODO remove hardcoded 9999
		raiseZIndex(parent);
	}
}
function resetZIndex(layer,layerIdToStopAt) {
	var parent = layer.parent();
	if(parent!=null && parent.attr("id")!==layerIdToStopAt){
		parent.css("z-index","");
		resetZIndex(parent);
	}
}
function resizeImage(imageContainer, largeImageSize, event, delta, productImageLayerName) {
	var defaultImageSize = $("#" + productImageLayerName + " .productImages").width();
	var oldWidth = imageContainer.find("img").width();
	var newWidth = oldWidth + (delta*60);
	if (newWidth <= defaultImageSize) {
		if(defaultImageSize != largeImageSize) {
			repositionImageAccordingToMouse(imageContainer, 0, 0, productImageLayerName);
		} else {
			repositionImageAccordingToMouse(imageContainer, 0, event.pageY, productImageLayerName);
		}
		resetImages(defaultImageSize, largeImageSize);
		
	} else {
		loadXXLImage(imageContainer);
		imageContainer.find("img.xxl").show();
		$("#" + productImageLayerName + " .reset-button").show();
		imageContainer.find("img").css("width", newWidth + "px");
		repositionImageAccordingToMouse(imageContainer, event.pageX, event.pageY, productImageLayerName);
	}
}
function resizeImageFixedSize(imageContainer, event, largeImageSize, productImageLayerName) {
	loadXXLImage(imageContainer);
	$("#" + productImageLayerName + " .xxl").show();
	$("#" + productImageLayerName + " .reset-button").show();
	imageContainer.find("img").css("width", largeImageSize + "px");
	repositionImageAccordingToMouse(imageContainer, event.pageX, event.pageY, productImageLayerName);
}
function resetImages(defaultImageSize, largeImageSize){
	$("div.productImagesItems > div > img").css("width",defaultImageSize);
	if(defaultImageSize < largeImageSize - 10) { //for some reason IE7 doesn't like largeImageSize?
		$(".xxl").hide();
	}
	$(".reset-button").hide();
}
function repositionImageAccordingToMouse(container, leftPosition, topPosition, productImageLayerName) {
   	var mouseXPosition = leftPosition - $("#" + productImageLayerName + " .productImages").offset().left;
   	var mouseYPosition = topPosition - $("#" + productImageLayerName + " .productImages").offset().top;
   	var imageWidth = container.find("img").width();
   	var imageHeight = container.find("img").height();
   	var zoomWindowWidth = $("#" + productImageLayerName + " .productImages").width();
   	var zoomWindowHeight = $("#" + productImageLayerName + " .productImages").height();
   	var newXPosition = 0 - ((mouseXPosition / zoomWindowWidth * imageWidth) - mouseXPosition);
   	var newXPosition = Math.ceil(newXPosition);
   	var newYPosition = 0 - ((mouseYPosition / zoomWindowHeight * imageHeight) - mouseYPosition);
   	var newYPosition = Math.ceil(newYPosition);
	if(newXPosition>0){
		newXPosition = 0;
	}
	if(newYPosition>0){
		newYPosition = 0;
	}
	container.find("img").css({
		left: newXPosition+"px",
		top: newYPosition+"px"
	});
}
function maintainCurrentImage(productIsMixAndMatch, productImageLayerName, scrollingSpeed) {
	var imageWidth = $("#" + productImageLayerName + " .productImages").width();
	$("#" + productImageLayerName + " div.productImagesItems > div > img").css("width",imageWidth);
	if(imageWidth==0){ //For mix and match bug
		setTimeout(function(){
			maintainCurrentImage(productIsMixAndMatch, productImageLayerName, scrollingSpeed)
		},100);
	} else {
		if(productIsMixAndMatch) { //TODO - remove duplication of code - have to wait until we can re-architect mix and match
			var currentImage = apiScrollable_Popup.getIndex() + 1;
			apiScrollable_Popup.onBeforeSeek(function(){
				this.getConf().speed = 0;
			});
			apiScrollable_Popup.begin(); //TODO this works but is a bit weird
			if(currentImage<=1){ //TODO this works but is a bit weird
				apiScrollable_Popup.seekTo(2);
			}
			apiScrollable_Popup.seekTo(currentImage);
			apiScrollable_Popup.onBeforeSeek(function(){
				this.getConf().speed = scrollingSpeed;
			});
			manageNextPrevButtonVisibility(apiScrollable_Popup, productImageLayerName);
		} else {
			var currentImage = apiScrollable.getIndex() + 1;
			apiScrollable.onBeforeSeek(function(){
				this.getConf().speed = 0;
			});
			apiScrollable.begin();
			if(currentImage<=1){ //TODO this works but is a bit weird
				apiScrollable.seekTo(2);
			}
			apiScrollable.seekTo(currentImage);
			apiScrollable.onBeforeSeek(function(){
				this.getConf().speed = scrollingSpeed;
			});
			manageNextPrevButtonVisibility(apiScrollable, productImageLayerName);
		}
	}
}
function manageNextPrevButtonVisibility(apiScrollableName, productImageLayerName){
	if(apiScrollableName.getItems().size() <= 3) {
		$("#" + productImageLayerName + " .next").hide();
		$("#" + productImageLayerName + " .prev").hide();
	} else {
		$("#" + productImageLayerName + " .next").show();
		$("#" + productImageLayerName + " .prev").show();
	}
}
function loadZoom(productIsMixAndMatch, productImageLayerName, productImagesOffset, animationSpeed, topSpace, largeImageSize, siteContentOffsetLeft, siteContentWidth){	
	$("div.ad-banner").fadeOut(animationSpeed);
    // Google Analytics code Start - ZOOM
    var floorName = $("#FloorName").val();
    var categoryName = $("#CategoryName").val();
    pageTracker._trackPageview();
    pageTracker._trackEvent(floorName, 'Click Zoom', categoryName);
    // Google Analytics code End - ZOOM
	if(productIsMixAndMatch){
		xxlImagesLoaded = false;
		var currentImage = apiScrollable_Popup.getIndex() + 1 + 1;
	} else {
		var currentImage = apiScrollable.getIndex() + 1 + 1;
	}
	loadAllXXLImages();
	if($.browser.msie){ //this should be done with bgiframe plugin
		if($.browser.version < 7){
			$("select").hide();
		}
	}
	if(productIsMixAndMatch && $.browser.msie){
		var event = new Object();
		event.pageX = largeImageSize/2;
		event.pageY = 0;
		resizeImageFixedSize($("#productImageLayer_Popup div.productImagesItems > div"), event, largeImageSize, productImageLayerName)
	} else {
		var overlayMaskLeft = Math.ceil(productImagesOffset.left);
		var overlayMaskTop = Math.ceil(productImagesOffset.top);
		currentImageUrl = $("#" + productImageLayerName + " .productImagesItems > div:nth-child("+currentImage+")").find("img.xxl").attr("src");
		if(currentImageUrl == null){
			currentImageUrl = "";
		}

		$("#overlayMask").attr("src",currentImageUrl).css({
			left: overlayMaskLeft + "px",
			top: overlayMaskTop + "px",
			opacity: 1,
			position: "absolute",
			width: "290px", //TODO - remove hardcoded value
			zIndex: 1000001 //TODO - remove hardcoded value
		}).fadeIn(100).animate({
			borderWidth: 0,
			left: siteContentOffsetLeft + (siteContentWidth - largeImageSize)/2 + "px",
			top: $(window).scrollTop() + topSpace + "px",
			width: largeImageSize + "px"
		},
		animationSpeed,	function(){
			if(productIsMixAndMatch) {
				zoomMixAndMatchOverlayAPI.load();

			} else {
				zoomOverlayAPI.load();
			}
		});
	}
}
function onZoomStarted(productIsMixAndMatch, productImageLayerName, largeImageSize, windowHeight, zoomWindowHeight, zoomXPosition, zoomYPosition, scrollingSpeed) {
	$("#" + productImageLayerName + " .productImagesItems > div").removeClass("zoom-trigger");
	$("#" + productImageLayerName + " .zoom-button").hide();
	$("#" + productImageLayerName + " .reset-button").hide();
	$("#" + productImageLayerName).addClass("modal");
	$("#" + productImageLayerName + " .productImages").css({
		height: zoomWindowHeight,
		borderWidth: "0px" //IE6+7 need this
	});
	$("#" + productImageLayerName + " .productImages div").css({
		height: zoomWindowHeight
	});
	$("#" + productImageLayerName + " .productThumbnails").css("height", windowHeight);
	$("#"+ productImageLayerName).css({
		height: zoomWindowHeight,
		left: zoomXPosition + "px",
		top: zoomYPosition + "px",
		width: largeImageSize + "px"
	});
	$("#" + productImageLayerName + " .xl").css("opacity","0.5");
	$("#" + productImageLayerName + " .xxl").show();
	maintainCurrentImage(productIsMixAndMatch, productImageLayerName, 0);
}
function onZoomLoaded(productImageLayerName, animationSpeed, scrollingSpeed, productIsMixAndMatch) {
	if($.browser.msie && $.browser.version < 8){ //to fix z-index bug in IE
		raiseZIndex($("#" + productImageLayerName),"aspnetForm");
	}
	if(productIsMixAndMatch){
		var currentImage = apiScrollable_Popup.getIndex() + 1;
		repositionImageAccordingToMouse($("#" + productImageLayerName + " div.productImagesItems > div#image" + currentImage + "_Popup"), 0, 0, productImageLayerName);
	} else {
		var currentImage = apiScrollable.getIndex() + 1;
		repositionImageAccordingToMouse($("#" + productImageLayerName + " div.productImagesItems > div"), 0, 0, productImageLayerName); //TODO - be more specific
	}
	$("#overlayMask").animate({
		opacity: 0
	}, animationSpeed, function(){
		$(this).hide();
		$(this).attr("src","");
	});
}
function onBeforeCloseZoom(productImageLayerName, animationSpeed, productImagesOffset, currentImage) {
	if(showCloseEffect){
	if($.browser.msie && $.browser.version < 7){
		//IE6 can't handle this.
	} else {
		currentImageUrl = $("#" + productImageLayerName + " .productImagesItems > div:nth-child("+currentImage+")").find("img.xxl").attr("src");
		if(currentImageUrl == null){
			currentImageUrl = "";
		}
		$("#overlayMask").attr("src",currentImageUrl).css("opacity",1).show().animate({
				borderWidth: "1px",
				left: productImagesOffset.left + "px",
				top: productImagesOffset.top + "px",
				width: "290px"
			}, animationSpeed, function(){
				$("#overlayMask").fadeOut(100);
		});
	}
}
}
function closeZoom(productIsMixAndMatch, productImageLayerName, scrollingSpeed) {
	$("#" + productImageLayerName + " .productImagesItems > div").addClass("zoom-trigger");
	$("#" + productImageLayerName + " .zoom-button").show();
	$("#" + productImageLayerName + " .xl").show();
	$("#" + productImageLayerName + " .productImages").css({
		height: "",
		borderWidth: "1px"
	});
	$("#" + productImageLayerName + " .productThumbnails").css("height", "");
	$("#" + productImageLayerName).removeClass("modal").css({
		display: "block",
		height: "",
		left: "0",
		position: "relative",
		top: "0",
		width: "",
		zIndex:""
	});
	$("#" + productImageLayerName + " .xl").css("opacity","1");
	$("#" + productImageLayerName + " .xxl").hide();

	maintainCurrentImage(productIsMixAndMatch, productImageLayerName, scrollingSpeed);
	if(productIsMixAndMatch) {
		var currentImage = apiScrollable_Popup.getIndex() + 1;
		repositionImageAccordingToMouse($("#" + productImageLayerName + " div.productImagesItems > div#image" + currentImage + "_Popup"), 0, 0, productImageLayerName);
	} else {
		var currentImage = apiScrollable.getIndex() + 1;
		repositionImageAccordingToMouse($("#" + productImageLayerName + " div.productImagesItems > div#image" + currentImage), 0, 0, productImageLayerName);
	}
	$("div.ad-banner").show();
	$("#" + productImageLayerName + " .reset-button").hide();

	if($.browser.msie && $.browser.version < 8){
		resetZIndex($("#" + productImageLayerName),"aspnetForm");
		if($.browser.version < 7){
			$("select").show();
		}
	}
}
function fixIE8Bug(productImageLayerName, imageWidth) {
	if($.browser.msie && $.browser.version < 9){ //for a bug with the jQuery position function in IE	
		$("#" + productImageLayerName + " .productImagesItems").css("left",Math.round( $("#" + productImageLayerName + " .productImagesItems").position().left / imageWidth ) * imageWidth );
	}
}
Versions.use('jquery', 'latest')(function($) {
	xxlImagesLoaded = false;
	var	topSpace = 20;
	var largeImageSize = 870;
	var animationSpeed = 500;
	var scrollingSpeed = 400;
	var siteContentOffsetLeft = $(".site-content").offset().left;
	var siteContentWidth = $(".site-content").width();
	zoomMixAndMatchOverlayAPI = $("#productImageLayer_Popup").overlay({ //TODO - too much duplication of code - have to wait until we rearchitect mix and match
		absolute: false,
		closeOnClick: true,
		onStart: function() {
			var windowOffsetTop = $(window).scrollTop();
			var windowHeight = parseInt($(window).height());
			var zoomWindowHeight = windowHeight - (topSpace*2);
			var siteContentOffsetLeft_Popup = $("#overlay-box-container").offset().left;
			var productImagesOffset_Popup = $("#content_popup_left_container").offset();
			var zoomXPosition = (siteContentWidth - largeImageSize)/2 - productImagesOffset_Popup.left + siteContentOffsetLeft;
			var zoomYPosition = 0 - productImagesOffset_Popup.top + windowOffsetTop + topSpace;
			onZoomStarted(true, "productImageLayer_Popup", largeImageSize, windowHeight, zoomWindowHeight, zoomXPosition, zoomYPosition, scrollingSpeed);
		},
		onLoad: function() {
			onZoomLoaded("productImageLayer_Popup", animationSpeed, scrollingSpeed, true);
		},
		onBeforeClose: function() {
			var currentImage = apiScrollable_Popup.getIndex() + 1 + 1;
			var productImagesOffset_Popup = $("#content_popup_left_container").offset();
			onBeforeCloseZoom("productImageLayer_Popup", animationSpeed, productImagesOffset_Popup, currentImage);
		},
		onClose: function() {
			closeZoom(true, "productImageLayer_Popup", scrollingSpeed);
		},
		api: true
	});
	zoomOverlayAPI = $("#productImageLayer").overlay({
		expose: {
			color: '#000',
			closeSpeed: animationSpeed,
			loadSpeed: animationSpeed,
			maskId: 'overlay',
			opacity: 0.5,
			zIndex: 1000000,
			onLoad: function(){
				var productImagesOffset = $("#content_product_images_box").offset();
				if($.browser.msie && $.browser.version < 8){ //to fix z-index bug in IE
					$("#overlay").css({
						left: "-" + productImagesOffset.left+"px",
						top: "-" + productImagesOffset.top+"px"
					}).prependTo($("#productImageLayer").parent());
				}
			}
		},
		absolute: false,
		closeOnClick: true,
		onStart: function() {
			var windowOffsetTop = $(window).scrollTop();
			var windowHeight = parseInt($(window).height());
			var zoomWindowHeight = windowHeight - (topSpace*2);
			var productImagesOffset = $("#content_product_images_box").offset();
			var zoomXPosition = (siteContentWidth - largeImageSize)/2 - productImagesOffset.left + siteContentOffsetLeft;
			var zoomYPosition = 0 - productImagesOffset.top + windowOffsetTop + topSpace;
			onZoomStarted(false, "productImageLayer", largeImageSize, windowHeight, zoomWindowHeight, zoomXPosition, zoomYPosition, scrollingSpeed);
		},
		onLoad: function() {
			onZoomLoaded("productImageLayer", animationSpeed, scrollingSpeed, false);
		},
		onBeforeClose: function() {
			var currentImage = apiScrollable.getIndex() + 1 + 1;
			var productImagesOffset = $("#content_product_images_box").offset();
			currentImageUrl = $("#productImageLayer .productImagesItems > div:nth-child("+currentImage+")").find("img.xxl").attr("src");
			onBeforeCloseZoom("productImageLayer", animationSpeed, productImagesOffset, currentImage);
		},
		onClose: function() {
			closeZoom(false, "productImageLayer", scrollingSpeed);
		},
		api: true
	});
	apiScrollable = $("#productImageLayer .productImages").scrollable({
		size: 1,
		clickable: false,
		onBeforeSeek: function(event,i){
			HideVideo();
			hideFlash();
		},
		onSeek: function(event, i) {
			repositionImageAccordingToMouse($("div.productImagesItems > div"), 0, 0, "productImageLayer");
			var imageWidth = $("#productImageLayer .productImages").width();
			resetImages(imageWidth, largeImageSize);
			loadXXLImage($(".image"+i));
			fixIE8Bug("productImageLayer", imageWidth);
		},
		speed: scrollingSpeed
	}).circular().navigator({
		navi: ".productThumbnails",
		naviItem: 'a',
		activeClass: 'current',
		api: true
	});
	apiScrollable_Popup = $("#productImageLayer_Popup .productImages").scrollable({
		size: 1,
		clickable: false,
		onBeforeSeek: function(){
			HideVideo();
			hideFlash();
		},
		onSeek: function(event, i) {
			repositionImageAccordingToMouse($("div.productImagesItems > div"), 0, 0, "productImageLayer");
			var imageWidth = $("#productImageLayer_Popup .productImages").width();
			resetImages(imageWidth, largeImageSize);
			loadXXLImage($(".image"+i+"_Popup"));
			fixIE8Bug("productImageLayer_Popup", imageWidth);
		},
		speed: scrollingSpeed
	}).circular().navigator({
		navi: ".productThumbnails",
		naviItem: 'a',
		activeClass: 'current',
		api: true
	});
	if(apiScrollable.getItems().size() <= 3) {
		$("#productImageLayer").addClass("only-one-thumb");
	}
	manageNextPrevButtonVisibility(apiScrollable, "productImageLayer");
	$("#productImageLayer .reset-button").click(function(){
		var currentImage = apiScrollable.getIndex() + 1;
		repositionImageAccordingToMouse($("#productImageLayer div.image" + currentImage), 0, 0, "productImageLayer");
		defaultImageSize = $("#productImageLayer .productImages").width();
		resetImages(defaultImageSize, largeImageSize); //TODO - could just reset this image
		return false;
	});
	$("#productImageLayer_Popup .reset-button").click(function(){
		var currentImage = apiScrollable_Popup.getIndex() + 1;
		repositionImageAccordingToMouse($("#productImageLayer_Popup div.image" + currentImage + "_Popup"), 0, 0, "productImageLayer_Popup");
		defaultImageSize = $("#productImageLayer_Popup .productImages").width();
		resetImages(defaultImageSize, largeImageSize); //TODO - could just reset this image
		return false;
	});
	$(".zoom-button").show().addClass("zoom-trigger");
	$("#productImageLayer .productImagesItems > div").addClass("zoom-trigger");
	$("#productImageLayer_Popup .productImagesItems > div").addClass("zoom-trigger");
	$("#productImageLayer .zoom-trigger").live("click", function(){
		var productImagesOffset = $("#content_product_images_box").offset();
		loadZoom(false, "productImageLayer", productImagesOffset, animationSpeed, topSpace, largeImageSize, siteContentOffsetLeft, siteContentWidth);
		return false;
	});
	$("#productImageLayer_Popup .zoom-trigger").live("click", function(){
		var productImagesOffset_Popup = $("#content_popup_left_container").offset();
		loadZoom(true, "productImageLayer_Popup", productImagesOffset_Popup, animationSpeed, topSpace, largeImageSize, siteContentOffsetLeft, siteContentWidth);
		return false;
	});
	$("#productImageLayer div.productImagesItems > div").live("mousemove", function(event) {
		repositionImageAccordingToMouse($(this), event.pageX, event.pageY, "productImageLayer");
		return false;
	});
	$("#productImageLayer_Popup div.productImagesItems > div").live("mousemove", function(event) {
		repositionImageAccordingToMouse($(this), event.pageX, event.pageY, "productImageLayer_Popup");
		return false;
	});
	$("#productImageLayer div.productImagesItems > div").mousewheel(function(event, delta){
		resizeImage($(this), largeImageSize, event, delta, "productImageLayer");
		return false;
	});
	$("#productImageLayer_Popup div.productImagesItems > div").mousewheel(function(event, delta){
		resizeImage($(this), largeImageSize, event, delta, "productImageLayer_Popup");
		return false;
	});
	loadXXLImage($(".image1"));
	$("body").append("<img id='overlayMask'/>");
	checkFlashIsInstalled();
	$(".close-popup").bind("click",function(){
		$(".reset-button").click();
	});
});

//Associated Products
$(document).ready(function() {
    (function() {
        var constant = {
            currentlyPaging: false,
            currentPageIndex: 1,
            totalItems: parseInt($('#associated-products-container input.items-count').val(), 10),
            pageSize: parseInt($('#associated-products-container input.page-size').val(), 10),
            associatedProductsPrevious: $('#associated-products-container div.carousel-controls a.previous > span:first'),
            associatedProductsNext: $('#associated-products-container div.carousel-controls a.next > span:first')
        };

        var updatePagingState = function() {
        var pageItemsText = $('#associated-products-container div.control-wrapper span.current-page-results');
            var pageItemsLowerBound = 0;
            var pageItemsUpperBound = 0;
            var isLastPage = constant.currentPageIndex === Math.ceil(constant.totalItems / constant.pageSize);

            pageItemsLowerBound = ((constant.currentPageIndex - 1) * constant.pageSize) + 1;
            pageItemsUpperBound = constant.currentPageIndex * constant.pageSize;

            if (isLastPage && (constant.totalItems % constant.pageSize != 0)) {
                pageItemsUpperBound = pageItemsUpperBound - (constant.pageSize - (constant.totalItems % constant.pageSize));
            }

            pageItemsText.text(pageItemsLowerBound + '-' + pageItemsUpperBound);

            if (constant.currentPageIndex > 1) {
                constant.associatedProductsPrevious.removeClass('inactive');
            } else {
                constant.associatedProductsPrevious.addClass('inactive');
            }

            if (isLastPage) {
                constant.associatedProductsNext.addClass('inactive');
            } else {
                constant.associatedProductsNext.removeClass('inactive');
            }
        };

        var viewPreviousPage = function() {
            if (constant.currentlyPaging) {
                return;
            }
            constant.currentlyPaging = true;
            constant.currentPageIndex--;
            var self = this;
            $('#associated-products-container div.carousel-wrapper').animate({ left: '+=250px' }, 600, 'swing', function() { constant.currentlyPaging = false; });
            updatePagingState();
            return false;
        };

        var viewNextPage = function() {
            if (constant.currentlyPaging) {
                return;
            }
            constant.currentlyPaging = true;
            constant.currentPageIndex++;
            var self = this;
            $('#associated-products-container div.carousel-wrapper').animate({ left: '-=250px' }, 600, 'swing', function() { constant.currentlyPaging = false; });
            updatePagingState();
            return false;
        };

        var init = function() {
            if (constant.totalItems > constant.pageSize && constant.associatedProductsNext.hasClass('inactive')) {
                constant.associatedProductsNext.removeClass('inactive');
            }

            constant.associatedProductsPrevious.click(function() {
                if (!$('#associated-products-container div.carousel-controls a.previous > span').hasClass('inactive')) {
                    viewPreviousPage();
                    this.blur();
                }
                return false;
            });

            constant.associatedProductsNext.click(function() {
                if (!$('#associated-products-container div.carousel-controls a.next > span').hasClass('inactive')) {
                    viewNextPage();
                    this.blur();
                }
                return false;
            });

            var controlWrapper = $('#associated-products-container div.control-wrapper');
            if (controlWrapper.hasClass('hide')) {
                controlWrapper.removeClass('hide');
            }
        };

        init();
    })();
});

$(window).load(function() {
    (function() {
        try {
            if (dcsMultiTrack) {
                $('#associated-products-container div.carousel-wrapper div.items-grid div.item').each(function(index) {
                    var associatedProductWrapper = $(this);
                    associatedProductWrapper.children('a:first').click(function() {
                        var associatedProductSKU = associatedProductWrapper.children('input.associated-product-sku:first');
                        var associatedProductCampaignUsed = associatedProductWrapper.children('input.associated-product-campaign-used:first');
                        dcsMultiTrack('DCS.dcsuri', '/ProductRecommendation.aspx', 'WT.ti', 'FH Product Recommendation', 'WT.dl', '1000', 'DCSext.sf', 'FH Product Recommendation', 'DCSext.sfValue', 'click', 'DCSext.sfPosition', (index + 1).toString(), 'DCSext.sfSku', associatedProductSKU.val(), 'DCSext.sfAlgorithm', associatedProductCampaignUsed.val(), 'WT.oss', '', 'WT.oss_r', '', 'DCSext.oss_is', '', 'DCSext.oss_pv', '', 'DCSext.oss_rs', '', 'DCSext.oss_s', '');
                    });
                });

                $('#associated-products-container div.control-wrapper div.carousel-controls a.previous > span:first').click(function() {
                dcsMultiTrack('DCS.dcsuri', '/ProductRecommendation.aspx', 'WT.ti', 'FH Product Recommendation', 'WT.dl', '1000', 'DCSext.sf', 'FH Product Recommendation', 'DCSext.sfPosition', 'Scroll Left', 'DCSext.sfValue', 'Scroll', 'WT.oss', '', 'WT.oss_r', '', 'DCSext.oss_is', '', 'DCSext.oss_pv', '', 'DCSext.oss_rs', '', 'DCSext.oss_s', '');
                });

                $('#associated-products-container div.control-wrapper div.carousel-controls a.next > span:first').click(function() {
                dcsMultiTrack('DCS.dcsuri', '/ProductRecommendation.aspx', 'WT.ti', 'FH Product Recommendation', 'WT.dl', '1000', 'DCSext.sf', 'FH Product Recommendation', 'DCSext.sfPosition', 'Scroll Right', 'DCSext.sfValue', 'Scroll', 'WT.oss', '', 'WT.oss_r', '', 'DCSext.oss_is', '', 'DCSext.oss_pv', '', 'DCSext.oss_rs', '', 'DCSext.oss_s', '');
                });
            }
        } catch (err) { };
    })();
});
