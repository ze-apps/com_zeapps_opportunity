<div id="breadcrumb">
    Opportunités
</div>
<div id="content">

    <div class="row">
        <div class="col-md-12">
            <ze-filters class="pull-right" data-model="filter_model" data-filters="filters" data-update="loadList"></ze-filters>

            <ze-btn fa="plus" color="success" hint="Opportunité" always-on="true"
                    ze-modalform="add"
                    data-template="templateForm"
                    data-title="Ajouter une nouvelle opportunité"></ze-btn>

            <ze-btn fa="download" color="primary" hint="Excel" always-on="true"
                    ng-click="getExcel()"></ze-btn>
        </div>
    </div>

    <div class="text-center" ng-show="total > pageSize">
        <ul uib-pagination total-items="total" ng-model="page" items-per-page="pageSize" ng-change="loadList()"
            class="pagination-sm" boundary-links="true" max-size="15"
            previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-condensed table-responsive" ng-show="opportunities.length">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Entreprise</th>
                    <th>Contact</th>
                    <th>Activité</th>
                    <th>Budget</th>
                    <th>Statut</th>
                    <th>Progression</th>
                    <th>Prochaine relance</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="opportunity in opportunities">
                    <td ng-click="goTo(opportunity.id)">@{{opportunity.name}}</td>
                    <td ng-click="goTo(opportunity.id)">@{{opportunity.name_company}}</td>
                    <td ng-click="goTo(opportunity.id)">@{{opportunity.name_contact}}</td>
                    <td ng-click="goTo(opportunity.id)">@{{opportunity.name_activity}}</td>
                    <td ng-click="goTo(opportunity.id)">@{{opportunity.budget | number:2}} €</td>
                    <td ng-click="goTo(opportunity.id)">@{{opportunity.name_status}}</td>
                    <td ng-click="goTo(opportunity.id)">@{{opportunity.progression}}</td>
                    <td ng-click="goTo(opportunity.id)">@{{opportunity.next_raise || "-" | date:'dd/MM/yyyy'}}</td>

                    <td class="text-right">
                        <ze-btn fa="pencil" color="info" hint="Editer" direction="left"
                                ze-modalform="edit"
                                data-edit="opportunity"
                                data-template="templateForm"
                                data-title="Modifier l'opportunité"></ze-btn>
                        <ze-btn fa="trash" color="danger" hint="Supprimer" direction="left" ng-click="delete(opportunity)" ze-confirmation></ze-btn>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center" ng-show="total > pageSize">
        <ul uib-pagination total-items="total" ng-model="page" items-per-page="pageSize" ng-change="loadList()"
            class="pagination-sm" boundary-links="true" max-size="15"
            previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></ul>
    </div>

</div>