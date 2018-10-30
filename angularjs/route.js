app.config(["$routeProvider",
	function ($routeProvider) {
		$routeProvider

		// OPPORTUNITIES
		.when("/ng/com_zeapps_opportunity/opportunities", {
			templateUrl: "/com_zeapps_opportunity/opportunities/search",
			controller: "ComZeappsOpportunityOpportunitiesListCtrl"
		})
		.when("/ng/com_zeapps_opportunity/opportunities/:id_opportunity", {
			templateUrl: "/com_zeapps_opportunity/opportunities/view",
			controller: "ComZeappsOpportunityOpportunitiesViewCtrl"
		});

	}]);

