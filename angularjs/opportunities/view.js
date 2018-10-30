app.controller("ComZeappsOpportunityOpportunitiesViewCtrl", ["$scope", "$routeParams", "$location", "$rootScope", "zeHttp", "zeHooks", "menu",
    function ($scope, $routeParams, $location, $rootScope, zhttp, zeHooks, menu) {

        menu("com_ze_apps_sales", "com_zeapps_sales_opportunity");

        $scope.templateEdit = "/com_zeapps_opportunity/companies/form_modal";
        $scope.hooks = zeHooks.get("comZeappsContact_EntrepriseHook");
        $scope.activities = [];


        $scope.edit = edit;



        // charge la fiche
        if ($routeParams.id_opportunity && $routeParams.id_opportunity != 0) {
            zhttp.opportunity.opportunity.get($routeParams.id_opportunity).then(function (response) {
                if (response.status == 200) {
                    $scope.activities = response.data.activities;
                    $scope.opportunity = response.data.opportunity;
                }
            });
        }

        function edit() {
            var formatted_data = angular.toJson($scope.company);
            zhttp.contact.company.save(formatted_data);
        }
    }]);