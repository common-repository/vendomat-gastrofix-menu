class WPTabs {
	constructor(pageId) {
		const $this = this

		$this.page = $('#' + pageId);
		$this.navTabs = $this.page.getElementsByClassName('nav-tab');
		$this.navTabActive = $this.page.getElementsByClassName('nav-tab-active')
		$this.tabContents = $this.page.getElementsByClassName('nav-content');

		// init default tab
		$this._showTab($this.navTabActive[0])

		// tab switch
		for(var i = 0; i<$this.navTabs.length; i++) {
		    $this.navTabs[i].onclick = function() {
		    	$this._showTab(this)
		    }
		}
	}

	_showTab(tabTrigger) {
		const $this = this

		// Show active tab content
		if(!tabTrigger.classList.contains('nav-tab-active')) {
			// Remove active state of active tab
			$this.navTabActive[0].classList.remove('nav-tab-active')

			// Add active state to new clicked tab
			tabTrigger.classList.add('nav-tab-active')
		}

		// Hide all tab contents
		for(let tab of $this.tabContents) {
			tab.style.display = 'none'
		}

		// Show according tabContent
		$this.tabContentActive = tabTrigger.getAttribute('href').replace('#', '');

		// Display active tab content
		document.getElementById($this.tabContentActive).style.display = "block"
	}
}