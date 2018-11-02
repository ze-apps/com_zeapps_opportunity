app.controller("ComZeappsOpportunityOpportunitiesListCtrl", ["$scope", "$location", "$rootScope", "zeHttp", "zeapps_modal", "menu",

    function ($scope, $location, $rootScope, zhttp, zeapps_modal, menu) {

        menu("com_ze_apps_sales", "com_zeapps_sales_opportunity");

        $scope.filters = {
            main: [
                {
                    format: 'input',
                    field: 'name LIKE',
                    type: 'text',
                    label: 'Nom'
                },
                {
                    format: 'select',
                    field: 'id_activity',
                    type: 'text',
                    label: 'Activité',
                    options: []
                },
                {
                    format: 'select',
                    field: 'id_status',
                    type: 'text',
                    label: 'Statut',
                    options: []
                }
            ],
            secondaries: [
                {
                    format: 'input',
                    field: 'name_company LIKE',
                    type: 'text',
                    label: 'Entreprise',
                    size: 6
                },
                {
                    format: 'input',
                    field: 'name_contact LIKE',
                    type: 'text',
                    label: 'Contact',
                    size: 6
                }
            ]
        };
        $scope.filter_model = {};
        $scope.opportunities = [];
        $scope.page = 1;
        $scope.pageSize = 15;
        $scope.total = 0;
        $scope.templateForm = '/com_zeapps_opportunity/opportunities/form_modal';

        $scope.loadList = loadList;
        $scope.goTo = goTo;
        $scope.getExcel = getExcel;
        $scope.add = add;
        $scope.edit = edit;
        $scope.delete = del;

        loadList(true);

        function loadList(context) {
            context = context || "";
            var offset = ($scope.page - 1) * $scope.pageSize;
            var formatted_filters = angular.toJson($scope.filter_model);

            zhttp.opportunity.opportunity.all($scope.pageSize, offset, context, formatted_filters).then(function (response) {
                if (response.status == 200) {
                    if (context) {
                        $scope.filters.main[1].options = response.data.activities;
                        $scope.filters.main[2].options = response.data.status;
                    }
                    $scope.opportunities = response.data.opportunities;

                    // stock la liste des compagnies pour la navigation par fleche
                    $rootScope.opportunities_ids = response.data.ids;
                    $scope.total = response.data.total;
                }
            });
        }

        function goTo(id) {
            $location.url('/ng/com_zeapps_opportunity/opportunities/' + id);
        }


        function getExcel() {
            var formatted_filters = angular.toJson($scope.filter_model);
            zhttp.opportunity.opportunity.excel.make(formatted_filters).then(function (response) {
                if (response.data && response.data !== "false") {
                    window.document.location.href = zhttp.opportunity.opportunity.excel.get();
                }
                else {
                    toasts('info', "Aucune opportunité correspondant à vos critères n'a pu etre trouvée");
                }
            });
        }

        function add(opportunity) {
            var formatted_data = angular.toJson(opportunity);
            zhttp.opportunity.opportunity.save(formatted_data).then(function (response) {
                if (response.data && response.data !== "false") {
                    loadList();
                }
            });
        }

        function edit(opportunity) {
            var formatted_data = angular.toJson(opportunity);
            zhttp.opportunity.opportunity.save(formatted_data);
        }

        function del(opportunity) {
            zhttp.opportunity.opportunity.del(opportunity.id).then(function (response) {
                if (response.status == 200) {
                    loadList();
                }
            });
        }


    }]);