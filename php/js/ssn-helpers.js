function setCookie(cname, cvalue, exdays) {
    var expires;
    if (exdays == 0) {
	    expires = "expires=0";
    } else { 
	    var d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    expires = "expires="+d.toUTCString();
    }
    document.cookie = cname + "=" + cvalue + "; " + expires;
} 

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

function ssn_lang_chg(element) {
 var lang = element.parentElement.id;
// alert( "FFF: Handler for ssn-lang-en called = "+lang );
 setCookie("ssn-lang",lang, 365);
 window.location.assign(element.baseURI);
}

function ssn_get_device_type_info(devices_info, dev_type_code) {
    for(var i=0; i<devices_info.length; i++) {
	if (devices_info[i].dt_code == dev_type_code) {
		return devices_info[i];
	}
    }
    return null;
}

