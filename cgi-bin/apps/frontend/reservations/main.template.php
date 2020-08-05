<?php $allReservations = \Page::get('allReservations');
	  $allHistorique = \Page::get('allHistorique'); ?>

<div class="container">
	<!------------Entête--------------------->
	<div class="row jumbotron jumboRes">
		<h1>Gestion des reservations</h1>
	</div>
	<!---------------Corps------------------->
	

<div class="row">
	<div class="col-12 btn-left-bloc">
		<button class="btn buttonAddExtend" data-toggle="modal" data-target ="#addResModale"
				data-ref ="<?php echo \Application::getRoute('reservations' , 'addReservation')?>">
			<span class="circle">
               <span class="icon arrow"></span>
            </span>
               <span class="button-text">Réservation</span>
		</button>
</div>

<!---------------------Affichage datatable-------------------------------->
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
				<td><?php echo \Db::decode($Reservations['Date_debut']); ?></td>
				<td><?php echo \Db::decode($Reservations['Date_fin']);?></td>
				<td><?php echo \Db::decode($Reservations['Reference']);?></td>
				<td><?php echo \Db::decode($Reservations['Titre']);?></td>
				<td><?php echo \Db::decode($Reservations['Nom']);?></td>
				<td><?php echo \Db::decode($Reservations['Prenom']);?></td>
				<td><?php echo \Db::decode($Reservations['Date_rendu']);?></td>
				<td><?php echo \Db::decode($Reservations['Etat_actuel']);?></td>
				<td class="center">
					<button class="btn btn-dark ModifyReservationsButton"
				    		data-toggle ="modal"
							data-target ="#ModifyReservationsModale"
							data-ref ="<?php echo Application::getRoute('reservations', 'modifyReservations', array($Reservations['Id_emprunt']));?>"
                            data-ref-ajax = "<?php echo \Application::getRoute('reservations', 'getReservationsById');?>"
                            data-id ="<?php echo $Reservations['Id_emprunt'];?>"><i class="far fa-edit"></i>     
					</button>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<!----------------------------Partie Modale -------------------------------------------------------->
<form id="formModalAdd" action="" method="POST">
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
                <div class="form-group">
                    <label>Réservé le:</label>
                    <input class="form-control" data-name="Date_debut" name="date_d" id="date_d" type="date">
                </div>
                <div class="form-group">
                    <label>A rendre le:</label>
                    <input class="form-control" data-name="Date_fin" name="date_f" id="date_f" type="date">
                </div>
                <div class="form-group">
                    <label>Adhérent</label>
                    <input class="form-control verifyInt" data-name="Adherents_fk" name="id_adh" id="id_adh" type="number" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Livre</label>
                    <input class="form-control verifyInt" data-name="Livres_fk" name="id_livre" id="id_livre" type="number" autocomplete="off">
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="btnActionModal" type="submit" class="btn btn-primary submit-form-btn" >Créer Réservation</button>
            </div>
        </div>
      </div>
    </div>
</form>

<form id="formModalModify" action="" method="POST">
	<div class="modal fade" id="ModifyReservationsModale" tabindex="-1" role="dialog" aria-labelledby="modifyReservations" aria-hidden="true">
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
                    <input class="form-control verifyInt" data-name="Adherents_fk" name="id_adh" id="id_adh" type="number">
                </div>
                <div class="form-group">
                    <label>Livre</label>
                    <input class="form-control verifyInt" data-name="Livres_fk" name="id_livre" id="id_livre" type="number">
                </div>
                <div class="form-group">
                    <label>Réservé le:</label>
                    <input class="form-control verifyInt" data-name="Date_debut" name="date_d" id="date_d" type="date">
                </div>
                <div class="form-group">
                    <label>A rendre le:</label>
                    <input class="form-control verifyInt" data-name="Date_fin" name="date_f" id="date_f" type="date">
                </div>
                <div class="form-group">
                    <label>Rendu le:</label>
                    <input class="form-control" data-name="Date_rendu" name="date_r" id="date_r" type="date">
                </div>
                <div class="form_group">
                	<label>Etat</label>
                	<input type="text" name="etat" id="etat" data_name="Etat_actuel" class="form-control verifyText">
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="btnActionModal" type="submit" class="btn btn-primary submit-form-btn" >Actualiser la Réservation</button>
            </div>
        </div>
      </div>
    </div>
</form>

<!-------------------Partie Scripts ----------------------------------------------->
<script>

	 var table =  $('#ReservationsTable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        pageLength: 25,
        lengthChange: false,
        buttons: [ {extend: 'excel', text: '<i class="fas fa-download"></i> Excel', className: 'btn btn-info'} ]
    });

	$('.buttonAddExtend').click(function(){
        $('#formModalAdd').attr('action', $(this).attr('data-ref'));
        form_reset();
    });

     $('.ModifyReservationsButton').click(function(){
        $('#formModalModify').attr('action', $(this).attr('data-ref'));
        $('#id_adh').prop('readonly', 'true');
        $('#id_livre').prop('readonly', 'true');
        $('#date_d').prop('readonly', 'true');
        $('#date_f').prop('readonly', 'true');
    });

</script>
