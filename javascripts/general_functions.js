function gastrofix_menu_b64Encode(str) {
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function gastrofix_menu_toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}

async function gastrofix_menu_sendAJAX(_url, _data) {    
	try {
		const result = $.ajax({
			type: "POST",
			url: _url,
			data: _data,
            dataType: "json"
        });

		return result

	} catch (error) {
        console.error(error);
    }
}