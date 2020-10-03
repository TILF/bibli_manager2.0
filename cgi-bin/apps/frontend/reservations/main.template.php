<?php 
    $allReservations    = \Page::get('allReservations') ? \Page::get('allReservations') : array();
	// $allHistorique      = \Page::get('allHistorique') ? \Page::get('allHistorique') : array();
	$allAdh             = \Page::get('allAdh') ? \Page::get('allAdh') : array();
	$allBooks           = \Page::get('allBooks') ? \Page::get('allBooks') : array();
?>

<div class="container">

    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron jumbnoLivre">
        <h1>Reservations</h1>
    </div>

    <!-------------------- AJOUT RESA -------------------------------->
    <form id="formModalAdd" action="<?php echo \Application::getRoute('reservations', 'addReservation');?>" method="POST">
        <div class="addBlock row">
       
            <div class="col-md-3">
                <div class="form-group">
                    <label>Réservé le:</label>
                    <input class="form-control datepiqueur verifyText" data-name="Date de réservation" name="date_d" id="date_d"   value="<?php echo date('d/m/Y'); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>A rendre le:</label>
                    <input class="form-control datepiqueur verifyText" data-name="Date de rendu" name="date_f" id="date_f">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Adhérent</label>
                    <select class="form-control verifySelect selectpicker " data-name="Adherent" data-live-search="true" id="id_adh" name="id_adh">
                        <option value="null">Choissiez un Adhérent</option>
                        <?php foreach($allAdh as $adh) :?>
                            <option value="<?php echo $adh['Id']; ?>"><?php echo $adh['Nom'] . ' ' . $adh['Prenom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Livre</label>
                    <select class="form-control verifySelect selectpicker " data-name="Livre" data-live-search="true" id="id_livre" name="id_livre">
                        <option value="null">Choissiez un Livre</option>
                        <?php foreach($allBooks as $book) :?>
                            <option value="<?php echo $book['Reference']; ?>"><?php echo $book['Titre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> 
            </div>
            <div class="col-md-12">
                <div class="btn-line">
                    <button type="submit" class="btn btn-primary submit-form-btn"><i class="fas fa-plus"></i>Nouvelle réservation</button>
                </div>
            </div>
        
        </div>
    </form>

    <div class="row">
        <!---------------------Affichage datatable-------------------------------->
        <div class="col-12">
            <h3>Emprunts en cours</h3>
            <table class="table table-striped table-bordered" id="ReservationsTable">
                <thead>
                    <tr>
                        <th>Réservé le</th>
                        <th>A rendre le</th>
                        <th>Référence</th>
                        <th>Titre</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Rendu le</th>
                        <th>Etat actuel</th>
                        <th>Mettre à jour</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($allReservations as $Reservations):?>
                        <tr>
                            <td><?php echo \Date::dbDateToString(($Reservations['Date_Debut'])); ?></td>
                            <td><?php echo \Date::dbDateToString(($Reservations['Date_fin']));?></td>
                            <td><?php echo $Reservations['Reference'];?></td>
                            <td><?php echo $Reservations['Titre'];?></td>
                            <td><?php echo \Db::decode($Reservations['Nom']);?></td>
                            <td><?php echo \Db::decode($Reservations['Prenom']);?></td>
                            <td><?php echo \Date::dbDateToString(($Reservations['Date_Rendu']));?></td>
                            <td><?php echo \Db::decode($Reservations['Etat_actuel']);?></td>
                            <td class="center">
                                <!-- <button class="btn btn-warning ModifyReservationsButton"
                                        data-toggle ="modal"
                                        data-target ="#ModifyReservationsModale"
                                        data-ref ="<?php echo Application::getRoute('reservations', 'modifyReservations', array($Reservations['Id_emprunt']));?>"
                                        data-ref-ajax = "<?php echo \Application::getRoute('reservations', 'getReservationsById', array($Reservations['Id_emprunt']));?>"
                                        data-id ="<?php echo $Reservations['Id_emprunt'];?>"><i class="far fa-edit"></i>     
                                </button> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!----------------------------Partie Modale -------------------------------------------------------->
<!-- <form id="formModalAdd" action="" method="POST"> -->
    <div class="modal fade" id="addResModale" tabindex="-1" role="dialog" aria-labelledby="addReservation" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTitile">Nouvelle Réservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button id="btnActionModal" type="submit" class="btn btn-primary submit-form-btn" >Créer Réservation</button>
                </div>
            </div>
        </div>
    </div>
<!-- </form> -->

<!-- <form id="formModalModify" action="" method="POST">
    <div class="modal fade" id="ModifyReservationsModale" tabindex="-1" role="dialog" aria-labelledby="modifyReservations" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitile">Actualiser la Réservation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Adhérent</label>
                    <input class="form-control verifyInt" data-name="Adherents_fk" name="id_adh" id="id_adhM" type="number">
                </div>
                <div class="form-group">
                    <label>Livre</label>
                    <input class="form-control verifyInt" data-name="Livres_fk" name="id_livre" id="id_livreM" type="number">
                </div>
                <div class="form-group">
                    <label>Réservé le:</label>
                    <input class="form-control verifyInt" data-name="Date_debut" name="date_d" id="date_dM" type="date">
                </div>
                <div class="form-group">
                    <label>A rendre le:</label>
                    <input class="form-control verifyInt" data-name="Date_fin" name="date_f" id="date_fM" type="date">
                </div>
                <div class="form-group">
                    <label>Rendu le:</label>
                    <input class="form-control" data-name="Date_rendu" name="date_r" id="date_rM" type="date">
                </div>
                <div class="form_group">
                    <label>Etat</label>
                    <input type="text" name="etat" id="etat" data_name="Etat_actuel" class="form-control verifyText">
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="btnActionModalM" type="submit" class="btn btn-primary submit-form-btn" >Actualiser la Réservation</button>
            </div>
        </div>
    </div>
    </div>
</form> -->



<!-------------------Partie Scripts ----------------------------------------------->

<script type="text/javascript" src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>js/typeahead.js"></script>
<script>
    
    var table =  $('#ReservationsTable').DataTable({
        dom: 'Bfrtip',
        pageLength: 25,
        format: 'dd/mm/yyyy',
        lengthChange: false,
        buttons: [ {extend: 'excel', text: '<i class="fas fa-download"></i> Excel', className: 'btn btn-info'} ]
    });

    $(function(){
        $(".datepiqueur").datepicker();
    });


</script>