app.controller("ComZeappsOpportunityEditCtrl", ["$scope", "$rootScope", "zeHttp",

	function ($scope, $rootScope, zhttp) {

        //**************************** Spécial modal note (onglets) ****************************

        $scope.templateForm = '/com_zeapps_opportunity/notes/form_modal';

        $scope.add = add;
        $scope.edit = edit;
        $scope.delete = del;

        $scope.upload = upload;
        function upload(document) {
            note.id_opportunity = $scope.form.id ;
            var formatted_data = angular.toJson(document);
            zhttp.opportunity.document.save(formatted_data).then(function (response) {
                if (response.data && response.data !== "false") {
                    loadList();
                }
            });
        }


        function add(note) {
            note.id_opportunity = $scope.form.id ;
            var formatted_data = angular.toJson(note);
            zhttp.opportunity.note.save(formatted_data).then(function (response) {
                if (response.data && response.data !== "false") {
                    loadList();
                }
            });
        }

        function edit(note) {
            note.id_opportunity = $scope.form.id ;
            var formatted_data = angular.toJson(note);
            zhttp.opportunity.note.save(formatted_data).then(function (response) {
                if (response.data && response.data !== "false") {
                    loadList();
                }
            });
        }

        function del(note) {
            zhttp.opportunity.note.del(note.id).then(function (response) {
                if (response.status == 200) {
                    loadList();
                }
            });
        }

        function loadList() {

            // Notes
            zhttp.opportunity.note.all($scope.form.id).then(function (response) {
                if (response.status == 200) {
                    $scope.notes = response.data.notes;
                    if ($scope.notes) {
                        formatDates($scope.notes);
                    }
                }
            });

            // Documents
            zhttp.opportunity.document.all(1, $scope.form.id).then(function (response) {

                if (response.status == 200) {
                    $scope.documents = response.data.documents;
                    if ($scope.documents) {
                        formatDates($scope.documents);
                    }
                }
            });
        }

        //***********************************************************************************

        var currentTab = 'general';

		$scope.accountManagerHttp = zhttp.app.user;
		$scope.accountManagerFields = [
			{label:'Prénom', key:'firstname'},
			{label:'Nom', key:'lastname'}
		];

		$scope.parentCompanyHttp = zhttp.contact.company;
		$scope.parentCompanyFields = [
			{label:'Nom',key:'company_name'},
			{label:'Téléphone',key:'phone'},
			{label:'Ville',key:'billing_city'},
			{label:'Gestionnaire du compte',key:'name_user_account_manager'}
		];

        $scope.parentContactHttp = zhttp.contact.contact;
        $scope.parentContactFields = [
            {label:'Prénom', key: 'first_name'},
            {label:'Nom', key: 'last_name'},
            {label:'E-mail', key:'email'},
            {label:'Fonction', key:'job'}
        ];

		$scope.codeNafHttp = zhttp.contact.code_naf;
		$scope.codeNafFields = [
			{label:'Code NAF',key:'code_naf'},
			{label:'Libellé',key:'libelle'}
		];

		$scope.countriesHttp = zhttp.contact.countries;
		$scope.countriesFields = [
			{label:'Code ISO',key:'iso_code'},
			{label:'Pays',key:'name'}
		];

        $scope.statesHttp = zhttp.contact.states;
        $scope.statesFields = [
            {label:'Code ISO',key:'iso_code'},
            {label:'Etat',key:'name'}
        ];

        $scope.accountingNumberHttp = zhttp.contact.accounting_number;
        $scope.accountingNumberTplNew = '/com_zeapps_opportunity/accounting_numbers/form_modal';
        $scope.accountingNumberFields = [
            {label:'Numero',key:'number'},
            {label:'Libelle',key:'label'},
            {label:'Type',key:'type_label'}
        ];

        $scope.isTabActive = isTabActive;
        $scope.setTab = setTab;
        $scope.displayTab = displayTab;

        $scope.updateStatus = updateStatus;
        $scope.updateActivity = updateActivity;

		$scope.loadParentCompany = loadParentCompany;
        $scope.loadParentContact = loadParentContact;

        zhttp.opportunity.opportunity.context().then(function (response) {

            if (response.status == 200) {

                $scope.activities = response.data.activities;
                $scope.status = response.data.status;

                var id_opportunity = $scope.form.id;
                $scope.notes = loadList(id_opportunity);
                formatDates($scope.notes);

                $scope.$parent.form.id_user_account_manager = $rootScope.user.id;
                $scope.$parent.form.name_user_account_manager =  $rootScope.user.firstname + " " +  $rootScope.user.lastname;

            }

        });

        function isTabActive(tab){
            return currentTab === tab ? 'active' : '';
        }

        function setTab(tab){
            return currentTab = tab;
        }

        function displayTab(tab){
            return currentTab === tab;
        }

        function updateStatus(){
            angular.forEach($scope.status, function(status){
                if($scope.form.id_status === status.id){
                    $scope.form.name_status = status.label;
                    $scope.form.progression = status.progression;
                }
            });
        }

        function updateActivity(){
            angular.forEach($scope.activities, function(activity){
                if($scope.form.id_activity === activity.id){
                    $scope.form.name_activity = activity.label;
                }
            });
        }

		function loadParentCompany(company) {
            if (company) {
                $scope.$parent.form.id_company = company.id;
                $scope.$parent.form.name_company = company.company_name;
            } else {
                $scope.$parent.form.id_company = 0;
                $scope.$parent.form.name_company = "";
            }
		}

        function loadParentContact(contact) {
            if (contact) {
                $scope.$parent.form.id_contact = contact.id;
                $scope.$parent.form.name_contact = contact.first_name + ' ' + contact.last_name;
            } else {
                $scope.$parent.form.id_contact = 0;
                $scope.$parent.form.name_contact = "";
            }
        }


        // ********************* Private ************************
        function formatDates(notes) {
            if (notes != undefined) {
                notes.forEach(function(element) {
                    element.created_at = element.created_at.replace(" ", "T");
                    var new_date = new Date(element.created_at);
                    element.created_at = new_date.toLocaleString();
                });
            }
        }

	}]);