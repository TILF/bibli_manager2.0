<?php $allReservationsCourantes=\Page::get('allReservationsCourantes');
		$allReservationsRetard=\Page::get('allReservationsRetard');?>

<div class="container">
	<!------------Entête--------------------->
	<div class="row jumbotron jumboIndex">
		<h1>Accueil</h1>
	</div>
	<!---------------Corps------------------->

	<h2>Réservations en retard</h2>
	<table class="table table-striped table-bordered" id="ReservationsRetardTable">
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
			</tr>
		</thead>

		<tbody>
			<?php foreach($allReservationsRetard as $ReservationsR):?>
			<tr>
				<td><?php echo \Db::decode($ReservationsR['Date_debut']); ?></td>
				<td><?php echo \Db::decode($ReservationsR['Date_fin']);?></td>
				<td><?php echo \Db::decode($ReservationsR['Reference']);?></td>
				<td><?php echo \Db::decode($ReservationsR['Titre']);?></td>
				<td><?php echo \Db::decode($ReservationsR['Nom']);?></td>
				<td><?php echo \Db::decode($ReservationsR['Prenom']);?></td>
				<td><?php echo \Db::decode($ReservationsR['Date_rendu']);?></td>
				<td><?php echo \Db::decode($ReservationsR['Etat_actuel']);?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

<h2>Réservations en cours</h2>
<table class="table table-striped table-bordered" id="ReservationsCourantesTable">
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
			<?php foreach($allReservationsCourantes as $ReservationsC):?>
			<tr>
				<td><?php echo \Db::decode($ReservationsC['Date_debut']); ?></td>
				<td><?php echo \Db::decode($ReservationsC['Date_fin']);?></td>
				<td><?php echo \Db::decode($ReservationsC['Reference']);?></td>
				<td><?php echo \Db::decode($ReservationsC['Titre']);?></td>
				<td><?php echo \Db::decode($ReservationsC['Nom']);?></td>
				<td><?php echo \Db::decode($ReservationsC['Prenom']);?></td>
				<td><?php echo \Db::decode($ReservationsC['Date_rendu']);?></td>
				<td><?php echo \Db::decode($ReservationsC['Etat_actuel']);?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script>

	var tableC =  $('#ReservationsCourantesTable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        pageLength: 25,
        lengthChange: false,
        buttons: [ {extend: 'excel', text: '<i class="fas fa-download"></i> Excel', className: 'btn btn-info'} ]
    });

	var tableR =  $('#ReservationsRetardTable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        pageLength: 25,
        lengthChange: false,
        buttons: [ {extend: 'excel', text: '<i class="fas fa-download"></i> Excel', className: 'btn btn-info'} ]
    });

</script>
