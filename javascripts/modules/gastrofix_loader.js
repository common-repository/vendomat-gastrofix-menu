const $ = jQuery

const ajaxLoadGASTROFIX = (function() {
	function init() {
		const form = $('#plugin-page').find('form#ajaxLoadGASTROFIX')
		const loader = form.find('#loader')
		const field_gf_datas = form.find('input[name="gf_datas"]')
		const fake_submit_btn = form.find('button#fakeSubmit')
		const submit_btn = form.find('input[type="submit"]')

		fake_submit_btn.on('click', function(e) {
			e.preventDefault()
			if($(this).hasClass('disabled')) {
				alert('Ihr GASTROFIX Menu Plugin ist noch nicht aktiviert.')
				return false
			} else {
				loader.removeClass('hidden')
				submit_btn.prop('disabled', true);

				const submit_fnct = async function() {
					if(_checkOptions()) {
						_callDatas().then((gf_datas) => {
							field_gf_datas.val(JSON.stringify(gf_datas))

							loader.addClass('hidden')
							submit_btn.prop('disabled', false);

							submit_btn.trigger('click')
						}).catch((err) => {
							loader.addClass('hidden')
							submit_btn.prop('disabled', false);

							alert("Fehler beim Abrufen der Stammdaten")
							console.error(err)
						})
					}
				}
				submit_fnct()
			}
		})
	}

	function _checkOptions() {
		const api_load_error = $('#plugin-page').find('#api_load_error')

		let status

		if(
			gf_option.cloud_nr &&
			gf_option.consumer_key &&
			gf_option.secret_key &&
			gf_option.username &&
			gf_option.password
		) {
			status = true
		} else {
			api_load_error.html('Missing GASTROFIX API Credentials')
			api_load_error.show()
			status = false
		}

		return status
	}

	function _callDatas() {
		return new Promise((resolve, reject) => {
			const accessToken = _get_access_token()
			accessToken.then((accessTokenData) => {
				if(accessTokenData["expires_in"] <= 172800) {
					const refreshToken = _refresh_expiration_date(accessTokenData["refresh_token"]);

					resolve(_getMasterDatas(refreshToken["access_token"]));
				} else {
					resolve(_getMasterDatas(accessTokenData["access_token"]));
				}
			}).catch((err) => {
				reject(err)
			})
		})
	}

	function _get_access_token() {
		const url = ajax_object.ajaxurl
		const data = {
			action: "gastrofix_menu_send_request",
			type: "POST",
			url: "https://api.gastrofix.com/token",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded",
				"Accept": "application/json",
			},
			body: {
				"grant_type": "password",
				"username": gf_option.username,
				"password": gf_option.password,
				"client_secret": gf_option.secret_key,
				"client_id": gf_option.consumer_key,
			},
			save: false,
			security: ajax_object.ajax_nonce
		}

		return gastrofix_menu_sendAJAX(url, data)
	}

	function _refresh_expiration_date(refreshToken) {
		const url = ajax_object.ajaxurl
		const data = {
			action: "gastrofix_menu_send_request",
			type: "POST",
			url: "https://api.gastrofix.com/token",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded",
				"Accept": "application/json", 
				"Authorization": "Basic " + gastrofix_menu_b64Encode(`${gf_option.consumer_key}:${gf_option.secret_key}`)
			},
			body: {
				"grant_type": "refresh_token",
				"refresh_token": refreshToken,
				"scope": "PRODUCTION",
				"client_secret": $gf_option.secret_key
			},
			save: false,
			security: ajax_object.ajax_nonce
		}

		return gastrofix_menu_sendAJAX(url, data)
	}

	async function _getMasterDatas(accessToken) {
		let result_articlegroups
		let result_articles

		const articlegroups = _getArticlegroups(accessToken);
		const articles = _getArticles(accessToken);

		await Promise.all([articlegroups, articles]).then((masterDatas) => {
			result_articlegroups = masterDatas[0]
			result_articles = masterDatas[1]
		})

		const gf_datas = {
			'articlegroups': result_articlegroups,
			'articles': result_articles
		}

		return gf_datas
	}

	function _getArticlegroups(accessToken) {
		const headers = {}
		const url = ajax_object.ajaxurl
		const data = {
			action: "gastrofix_menu_send_request",
			type: "GET",
			url: `https://api.gastrofix.com/api/articles/v2.0/business_units/${gf_option.cloud_nr}/article_groups`,
			headers: {
				"Content-Type": "application/json",
				"Accept": "application/json", 
				"Authorization": `Bearer ${accessToken}`
			},
			security: ajax_object.ajax_nonce
		}

		return gastrofix_menu_sendAJAX(url, data)
	}

	function _getArticles(accessToken) {
		const url = ajax_object.ajaxurl
		const data = {
			action: "gastrofix_menu_send_request",
			type: "GET",
			url: `https://api.gastrofix.com/api/articles/v2.0/business_units/${gf_option.cloud_nr}/articles`,
			headers: {
				"Accept": "application/json", 
				"Authorization": `Bearer ${accessToken}`
			},
			security: ajax_object.ajax_nonce
		}

		return gastrofix_menu_sendAJAX(url, data)
	}

	return {
		init: init
	}
})()
