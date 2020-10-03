<?php $allAdherents = \Page::get('allAdherents');?>

<div class="container">
	<!------------Entête--------------------->
	<div class="row jumbotron jumboAdherents">
		<h1>Gestion des Adhérents</h1>
	</div>

	<!---------------Corps------------------->
	<div class="row">
		<div class="col-12 btn-left-bloc">
			<button class="btn buttonAddExtend" data-toggle="modal" data-target ="#addAdherentsModale"
			data-ref ="<?php echo \Application::getRoute('adherent' , 'addAdherents');?>">
				<span class="circle">
                    <span class="icon arrow"></span>
                </span>
                <span class="button-text">Nouvel adhérent</span>
			</button>
		</div>
	</div>

	<!---------------------Affichage datatable-------------------------------->
	<table class="table table-striped table-bordered" id="AdherentsTable">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Age</th>
				<th>Adresse</th>
				<th>Téléphone</th>
				<th>Cotisation</th>
				<th>Ville</th>
				<th>Code Postal</th>
				<th>Modifier</th>
				<th>Supprimer</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($allAdherents as $Adherents):?>
			<tr>
				<td><?php echo \Db::decode($Adherents['Nom']); ?></td>
				<td><?php echo \Db::decode($Adherents['Prenom']);?></td>
				<td><?php echo \Db::decode($Adherents['Age']);?></td>
				<td><?php echo \Db::decode($Adherents['Adresse']);?></td>
				<td>+33<?php echo \Db::decode($Adherents['Telephone']);?></td>
				<td><?php echo \Db::decode($Adherents['Cotisation']);?></td>
				<td><?php echo \Db::decode($Adherents['Ville']);?></td>
				<td><?php echo \Db::decode($Adherents['CP']);?></td>
				<td class="center">
					<button class="btn btn-dark ModifyAdherentButton"
							data-toggle ="modal"
							data-target ="#addAdherentsModale"
							data-ref ="<?php echo Application::getRoute('adherent', 'modifyAdherents', array($Adherents['Id']));?>"
                            data-ref-ajax = "<?php echo \Application::getRoute('adherent', 'getAdherentsbyId');?>"
                            data-id ="<?php echo $Adherents['Id'];?>"><i class="far fa-edit"></i>
                            
					</button>
				</td>
				<td class="center">
					<button class="btn btn-danger SupprAdherent"
							data-toggle ="modal"
							data-target ="#deleteAdherentsModale"
							data-ref ="<?php echo \Application::getRoute('adherent', 'deleteAdherents', array($Adherents['Id'])) ?>">
                                        <i class="far fa-trash-alt"></i>
					</button>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<!----------------Parties en modale----------------------------------->
<form id="formModalAdd" action="" method="POST">
	<div class="modal fade" id="addAdherentsModale" tabindex="-1" role="dialog" aria-labelledby="addAdhérents" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitile">Nouvel Adhérent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nom</label>
                    <input class="form-control verifyText" data-name="Nom" name="nom" id="nom" type="text">
                </div>
                <div class="form-group">
                    <label>Prénom</label>
                    <input class="form-control verifyText" data-name="Prénom" name="prenom" id="prenom" type="text">
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input class="form-control verifyInt" data-name="Age" name="age" id="age" type="number">
                </div>
                <div class="form-group">
                    <label>Adresse</label>
                    <input class="form-control verifyText" data-min="10" data-max="9999" data-name="Adresse" name="adresse" id="adresse" type="text">
                </div>
                <div class="form-group">
                    <label>Téléphone</label>
                    <input class="form-control verifyText" data-name="Telephone" name="tel" id="telephone" type="text">
                </div>
                <div class="form-group">
                    <label>Cotisation</label>
                    <input class="form-control verifyText" data-name="Cotisation" name="cotisation" id="cotisation" type="text">
                </div>
                <div class="form-group">
                    <label>Ville</label>
                    <input class="form-control verifyText" data-name="Ville" name="ville" id="ville" type="text">
                </div>
                <div class="form-group">
                    <label>Code postal</label>
                    <input class="form-control verifyText" data-name="CP" name="zipcode" id="zipcode" type="number">
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="btnActionModal" type="submit" class="btn btn-primary submit-form-btn" >Ajouter l'adhérent</button>
            </div>
        </div>
      </div>
    </div>
</form>

<form id="formModalDelete" action="" method="POST">
    <div class="modal fade" id="deleteAdherentsModale" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supression d'un adhérent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Vous êtes sur le point de supprimer un adhérent. Etes-vous sûr ? 
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger submit-form-btn">Supprimer</button>
            </div>
        </div>
      </div>
    </div>
</form>



<script>

    var table =  $('#AdherentsTable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        pageLength: 25,
        lengthChange: false,
        buttons: [ {extend: 'excel', text: '<i class="fas fa-download"></i> Excel', className: 'btn btn-info'} ]
    });

    $('.buttonAddExtend').click(function(){
        $('#ModalTitile').html('Ajout d\'un adhérent');
        $('#formModalAdd').attr('action', $(this).attr('data-ref'));
        $('#btnActionModal').html('Ajouter');
        form_reset();
    });

    $('.ModifyAdherentButton').click(function(){
        $('#ModalTitile').html('Modification d\'un adhérent');
        $('#formModalAdd').attr('action', $(this).attr('data-ref'));  
        $('#btnActionModal').html('Modifier');
        
        $.ajax({
            url: $(this).attr('data-ref-ajax'),
            type: 'post',
            dataType: 'JSON',
            data: {id: $(this).attr('data-id')},
            success: function(result) {
                if (result.Id) {
                    $('#id').val(result.Id);
                    $('#nom').val(result.Nom);
                    $('#prenom').val(result.Prenom);
                    $('#age').val(result.Age);
                    $('#adresse').val(result.Adresse);
                    $('#telephone').val(result.Telephone);
                    $('#cotisation').val(result.Cotisation);
                    $('#ville').val(result.Ville);
                    $('#zipcode').val(result.CP);
                }else{
                    $.notify("Une erreur est survenue, contactez votre administrateur", 'error');
                        console.log('Erreur de AJAX');
                }
            }
        });
    });

    $('.SupprAdherent').click(function(){
        $('#formModalDelete').attr('action', $(this).attr('data-ref'));
    });

</script>