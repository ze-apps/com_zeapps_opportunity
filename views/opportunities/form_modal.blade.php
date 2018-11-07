
<div ng-controller="ComZeappsOpportunityEditCtrl">

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
                <input id="next_raise" type="text" ng-model="form.next_raise" class="form-control" ng-required="true">
            </div>
        </div>

        <script type="text/javascript">
            $('#next_raise').datepicker({
                uiLibrary: 'bootstrap',
                altField: "#next_raise",
                closeText: 'Fermer',
                prevText: 'Précédent',
                nextText: 'Suivant',
                currentText: 'Aujourd\'hui',
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
                dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                weekHeader: 'Sem.',
                dateFormat: 'dd/mm/yy'
            });
        </script>

    </div>

    <ul role="tablist" class="nav nav-tabs" ng-show="form.id">
        <li ng-class="isTabActive('general')"><a href="#" ng-click="setTab('general')">Notes</a></li>
        <li ng-class="isTabActive('documents')"><a href="#" ng-click="setTab('documents')">Documents</a></li>
        <li ng-class="isTabActive('devis')"><a href="#" ng-click="setTab('devis')">Devis</a></li>
    </ul>

    <div ng-if="displayTab('general') && form.id">

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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="note in notes">
                                <td class="col-md-3">@{{note.created_at || "-" | date:'dd/MM/yyyy'}}</td>
                                <td class="col-md-8">@{{note.comments}}</td>
                                <td class="col-md-1">
                                    <ze-btn fa="pencil" color="info" hint="Editer" direction="left"
                                             data-edit="note"
                                             ze-modalform="edit"
                                             data-template="templateForm"
                                             data-title="Modifier cette note"></ze-btn>
                                    <ze-btn fa="trash" color="danger" hint="Supprimer" direction="left" ng-click="delete(note)" data-title="Supprimer cette note" ze-confirmation></ze-btn>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <div ng-if="displayTab('documents') && form.id">

        <div class="row">

            <div class="col-md-12">

                <div class="form-group pull-right">
                    <ze-btn fa="plus" color="primary" hint="Document" always-on="true"
                            ze-modalform="addDoc"
                            data-template="templateDoc"
                            data-title="Ajouter de nouveaux documents"></ze-btn>
                </div>

                <div class="form-group">
                    <table class="table table-condensed table-striped" ng-if="documents">

                        <thead class="bg-primary">
                        <tr>
                            <th>Nom du fichier</th>
                            <th>Taille</th>
                            <th>Date d'envoi</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr ng-repeat="document in documents">
                            <td><strong>@{{document.label}}</strong></td>
                            <td>@{{document.size}}</td>
                            <td>@{{document.created_at || "-" | date:'dd/MM/yyyy'}}</td>
                            <td class="col-md-1">
                                <ze-btn fa="trash" color="danger" hint="Supprimer" direction="left" ng-click="delete(document)" data-title="Supprimer ce fichier" ze-confirmation></ze-btn>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

    <div ng-if="displayTab('devis') && form.id">

        <div class="row">
            <div class="col-md-12 text-center">
                <strong>Devis ici</strong>
            </div>
        </div>

    </div>

</div>