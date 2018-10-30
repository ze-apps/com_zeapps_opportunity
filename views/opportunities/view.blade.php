<div id="content">
    <div class="well">
        <div class="row">
            <div class="col-md-3">
                <div class="titleWell">
                    @{{opportunity.name}}
                </div>
            </div>

            <div class="col-md-3">
                <strong>Famille : </strong>@{{company.name_account_family}}
            </div>

            <div class="col-md-3">
                <strong>Manager : </strong>@{{company.name_user_account_manager}}
            </div>

            <div class="col-md-3">
                <div class="pull-right">
                    <ze-btn fa="arrow-left" color="primary" hint="Retour" direction="left" ng-click="back()"></ze-btn>
                    <ze-btn fa="pencil" color="info" hint="Editer" direction="left"
                            ze-modalform="edit"
                            data-edit="company"
                            data-template="templateEdit"
                            data-title="Modifier l'entreprise"></ze-btn>


                    <div class="btn-group btn-group-xs" role="group" ng-if="nb_companies > 0">
                        <button type="button" class="btn btn-default" ng-class="company_first == 0 ? 'disabled' :''" ng-click="first_company()"><span class="fa fa-fw fa-fast-backward"></span></button>
                        <button type="button" class="btn btn-default" ng-class="company_previous == 0 ? 'disabled' :''" ng-click="previous_company()"><span class="fa fa-fw fa-chevron-left"></span></button>
                        <button type="button" class="btn btn-default disabled">@{{companie_order}}/@{{nb_companies}}</button>
                        <button type="button" class="btn btn-default" ng-class="company_next == 0 ? 'disabled' :''" ng-click="next_company()"><span class="fa fa-fw fa-chevron-right"></span></button>
                        <button type="button" class="btn btn-default" ng-class="company_last == 0 ? 'disabled' :''" ng-click="last_company()"><span class="fa fa-fw fa-fast-forward"></span></button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <ul role="tablist" class="nav nav-tabs">
        <li role="presentation" ng-class="isTabActive('summary') ? 'active' : ''"><a href="#" ng-click="setTab('summary')">Résumé</a></li>
        <li role="presentation" ng-class="isTabActive('contacts') ? 'active' : ''"><a href="#" ng-click="setTab('contacts')">Contacts</a></li>

        <li role="presentation" ng-class="isTabActive(hook.label) ? 'active' : ''" ng-repeat="hook in hooks">
            <a href="#" ng-click="setTab(hook.label)">@{{ hook.label }}</a>
        </li>

        <li role="presentation" ng-class="isTabActive('email') ? 'active' : ''"><a href="#" ng-click="setTab('email')">Email</a></li>
    </ul>

    <div ng-if="isTabActive(hook.label)" ng-repeat="hook in hooks">
        <div ng-include="hook.template"></div>
    </div>

    <div ng-if="isTabActive('summary')">
        <div ng-include="'/com_zeapps_opportunity/companies/summary_partial'"></div>
    </div>

    <div ng-if="isTabActive('contacts')">
        <div ng-include="'/com_zeapps_opportunity/contacts/list_partial'"></div>
    </div>

    <div ng-if="isTabActive('email')">
        <div ng-include="'/zeapps/email/list_partial'" ng-init="module = 'com_zeapps_opportunity'; id = 'compagnies_' + company.id"></div>
    </div>
</div>