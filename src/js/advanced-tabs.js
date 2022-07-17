ts.hooks.addAction("init", "ts", () => {
	elementorFrontend.hooks.addAction(
		"frontend/element_ready/ts-adv-tabs.default",
		function ($scope, $) {
			const $currentTab = $scope.find('.ts-advance-tabs');
			if ( !$currentTab.attr( 'id' ) ) {
				return false;
			}
			const $currentTabId = '#' + $currentTab.attr('id').toString();
			let hashTag = window.location.hash.substr(1);
				hashTag = hashTag === 'safari' ? 'ts-safari' : hashTag;
			var hashLink = false;
			$($currentTabId + ' > .ts-tabs-nav ul li', $scope).each(function (index) {
				if (hashTag && $(this).attr("id") == hashTag) {
					$($currentTabId + ' .ts-tabs-nav > ul li', $scope)
					.removeClass("active")
					.addClass("inactive");
					
					$(this).removeClass("inactive").addClass("active");

					hashLink = true;
				} else {
					if ($(this).hasClass("active-default") && !hashLink) {
						$($currentTabId + ' .ts-tabs-nav > ul li', $scope)
						.removeClass("active")
						.addClass("inactive");
						$(this).removeClass("inactive").addClass('active');
					} else {
						if (index == 0) {
							if( $currentTab.hasClass('ts-tab-auto-active') ) {
								$(this).removeClass("inactive").addClass("active");
							}
						}
					}
				}
			});
			
			var hashContent = false;
			$($currentTabId + ' > .ts-tabs-content > div', $scope).each(function (index) {
				if (hashTag && $(this).attr("id") == hashTag + '-tab') {
					$($currentTabId + ' > .ts-tabs-content > div', $scope).removeClass("active");
					let nestedLink = $(this).closest('.ts-tabs-content').closest('.ts-tab-content-item');
					if (nestedLink.length) {
						let parentTab = nestedLink.closest('.ts-advance-tabs'),
							titleID = $("#"+nestedLink.attr("id")),
							contentID = titleID.data('title-link');
						parentTab.find(" > .ts-tabs-nav > ul > li").removeClass('active');
						parentTab.find(" > .ts-tabs-content > div").removeClass('active');
						titleID.addClass("active")
						$("#" + contentID).addClass("active")
					}
					$(this).removeClass("inactive").addClass("active");
					hashContent = true
				} else {
					if ($(this).hasClass("active-default") && !hashContent) {
						$($currentTabId + ' > .ts-tabs-content > div', $scope).removeClass("active");
						$(this).removeClass("inactive").addClass("active");
					} else {
						if (index == 0) {
							if( $currentTab.hasClass('ts-tab-auto-active') ) {
								$(this).removeClass("inactive").addClass("active");
							}
						}
					}
				}
			});
			
			$($currentTabId + ' .ts-tabs-nav ul li', $scope).on("click", function (e) {
				e.preventDefault();
				
				var currentTabIndex = $(this).index();
				var tabsContainer = $(this).closest(".ts-advance-tabs");
				var tabsNav = $(tabsContainer)
				.children(".ts-tabs-nav")
				.children("ul")
				.children("li");
				var tabsContent = $(tabsContainer)
				.children(".ts-tabs-content")
				.children("div");
				
				$(this).parent("li").addClass("active");
				
				$(tabsNav).removeClass("active active-default").addClass("inactive").attr('aria-selected', 'false').attr('aria-expanded', 'false');
				$(this).addClass("active").removeClass("inactive");
				$(this).attr("aria-selected", 'true').attr("aria-expanded", 'true');
				
				$(tabsContent).removeClass("active").addClass("inactive");
				$(tabsContent)
				.eq(currentTabIndex)
				.addClass("active")
				.removeClass("inactive");

                ts.hooks.doAction("ts-advanced-tabs-triggered", $(tabsContent).eq(currentTabIndex));
				
				$(tabsContent).each(function (index) {
					$(this).removeClass("active-default");
				});
				
			});
		}
	);
});