
<div ng-controller="ComZeappsContactCompaniesFormCtrl">

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Entreprise</label>
                        <span   ze-modalsearch="loadParentCompany"
                                data-http="parentCompanyHttp"
                                data-model="form.name_company"
                                data-fields="parentCompanyFields"
                                data-title="Choisir une entreprise"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Contact</label>
                        <span   ze-modalsearch="loadParentContact"
                                data-http="parentContactHttp"
                                data-model="form.name_contact"
                                data-fields="parentContactFields"
                                data-title="Choisir un contact"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Fiche client</label><br/>
                        <span>
                            Ici une description détaillée des informations personnelles et administratives du client ... <br />
                            ...<br>...<br>...<br>...
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label>Nom de l'opportunité</label>
                <input type="text" ng-model="form.name" class="form-control">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Activité</label>
                <select ng-model="form.id_activity" class="form-control" ng-change="updateActivity()">
                    <option ng-repeat="activity in activities" ng-value="@{{activity.id}}">
                        @{{ activity.label }}
                    </option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Budget (€)</label>
                <input type="text" ng-model="form.budget" class="form-control">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Statut</label>
                <select ng-model="form.id_status" class="form-control" ng-change="updateStatus()">
                    <option ng-repeat="statu in status" ng-value="@{{statu.id}}">
                        @{{ statu.label }}
                    </option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Prochaine relance <span class="required">*</span></label>
                <input type="text" ng-model="form.next_raise" class="form-control" ng-required="true">
            </div>
        </div>

    </div>

    <ul role="tablist" class="nav nav-tabs">
        <li ng-class="isTabActive('general')"><a href="#" ng-click="setTab('general')">Notes</a></li>
        <li ng-class="isTabActive('documents')"><a href="#" ng-click="setTab('documents')">Documents</a></li>
        <li ng-class="isTabActive('devis')"><a href="#" ng-click="setTab('devis')">Devis</a></li>
    </ul>

    <div ng-if="displayTab('general')">

        <div class="row">
            <div class="col-md-12">

                <div class="form-group pull-right">
                    <ze-btn fa="plus" color="info" hint="Note" always-on="true"
                        ze-modalform="add"
                        data-template="templateForm"
                        data-title="Ajouter une nouvelle note"></ze-btn>
                </div>

                <div class="form-group">
                    <table class="table table-condensed table-striped">
                        <thead class="bg-info">
                            <tr>
                                <th>Date</th>
                                <th>Commentaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>15/09/2018</td>
                                <td>Prendra sa décision en décembre après le conseil d'administration</td>
                            </tr>
                            <tr>
                                <td>10/09/2018</td>
                                <td>Trouve très intéressant le module des opportunités</td>
                            </tr>
                            <tr>
                                <td>02/09/2018</td>
                                <td>Il a fait la démo et semble intéressé</td>
                            </tr>
                            <tr>
                                <td>01/09/2018</td>
                                <td>Interessé par l'offre et doit en parler avec son directeur</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div ng-if="displayTab('documents')">

        <div class="row">
            <div class="col-md-12 text-center">
                <strong>Documents ici</strong>
            </div>
        </div>

    </div>

    <div ng-if="displayTab('devis')">

        <div class="row">
            <div class="col-md-12 text-center">
                <strong>Devis ici</strong>
            </div>
        </div>

    </div>

</div>