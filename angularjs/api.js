app.config(["$provide",
	function ($provide) {
		$provide.decorator("zeHttp", ["$delegate", function($delegate){
			var zeHttp = $delegate;

			zeHttp.opportunity = {
                company : {
                    context : context_company,
                    get : get_company,
                    all : getAll_company,
                    modal : modal_company,
                    save : save_company,
                    del : delete_company,
                    excel : {
                        make : makeExcel_company,
                        get : getExcel_company
                    }
                },
                contact : {
                    context : context_contact,
                    get : get_contact,
                    all : getAll_contact,
                    modal : modal_contact,
                    save : save_contact,
                    del : delete_contact,
                    excel : {
                        make : makeExcel_contact,
                        get : getExcel_contact
                    }
                },
				opportunity : {
					context : context_opportunity,
					get : get_opportunity,
					all : getAll_opportunities,
					modal : modal_opportunity,
					save : save_opportunity,
					del : delete_opportunity,
					excel : {
						make : makeExcel_opportunity,
						get : getExcel_opportunity
					}
				}
			};

			zeHttp.config = angular.extend(zeHttp.config || {}, {
			});

			return zeHttp;

            function context_company(){
                return zeHttp.get("/com_zeapps_contact/companies/context/");
            }
            function get_company(id){
                return zeHttp.get("/com_zeapps_contact/companies/get/" + id);
            }
            function getAll_company(limit, offset, context, filters){
                return zeHttp.post("/com_zeapps_contact/companies/getAll/" + limit + "/" + offset + "/" + context, filters);
            }
            function modal_company(limit, offset, filters){
                return zeHttp.post("/com_zeapps_contact/companies/modal/" + limit + "/" + offset, filters);
            }
            function save_company(data){
                return zeHttp.post("/com_zeapps_contact/companies/save", data);
            }
            function delete_company(id){
                return zeHttp.delete("/com_zeapps_contact/companies/delete/" + id);
            }
            function makeExcel_company(filters){
                return zeHttp.post("/com_zeapps_contact/companies/make_export/", filters);
            }
            function getExcel_company(){
                return "/com_zeapps_contact/companies/get_export/";
            }






            function context_contact(){
                return zeHttp.get("/com_zeapps_contact/contacts/context/");
            }
            function get_contact(id){
                return zeHttp.get("/com_zeapps_contact/contacts/get/" + id);
            }
            function getAll_contact(id, limit, offset, context, filters){
                id = id || 0;
                return zeHttp.post("/com_zeapps_contact/contacts/getAll/" + id + "/" + limit + "/" + offset + "/" + context, filters);
            }
            function modal_contact(limit, offset, filters, id_company){
                id_company = id_company || 0;
                return zeHttp.post("/com_zeapps_contact/contacts/modal/" + id_company + "/" + limit + "/" + offset, filters);
            }
            function save_contact(data){
                return zeHttp.post("/com_zeapps_contact/contacts/save/", data);
            }
            function delete_contact(id){
                return zeHttp.delete("/com_zeapps_contact/contacts/delete/" + id);
            }
            function makeExcel_contact(filters){
                return zeHttp.post("/com_zeapps_contact/contacts/make_export/", filters);
            }
            function getExcel_contact(){
                return "/com_zeapps_contact/contacts/get_export/";
            }



			function context_opportunity(){
				return zeHttp.get("/com_zeapps_opportunity/opportunities/context/");
			}
			function get_opportunity(id){
				return zeHttp.get("/com_zeapps_opportunity/opportunities/get/" + id);
			}
			function getAll_opportunities(limit, offset, context, filters){
				return zeHttp.post("/com_zeapps_opportunity/opportunities/getAll/" + limit + "/" + offset + "/" + context, filters);
			}
			function modal_opportunity(limit, offset, filters){
				return zeHttp.post("/com_zeapps_opportunity/opportunities/modal/" + limit + "/" + offset, filters);
			}
			function save_opportunity(data){
				return zeHttp.post("/com_zeapps_opportunity/opportunities/save", data);
			}
			function delete_opportunity(id){
				return zeHttp.delete("/com_zeapps_opportunity/opportunities/delete/" + id);
			}
            function makeExcel_opportunity(filters){
                return zeHttp.post("/com_zeapps_opportunity/opportunities/make_export/", filters);
            }
            function getExcel_opportunity(){
                return "/com_zeapps_opportunity/opportunities/get_export/";
            }



		}]);
	}]);