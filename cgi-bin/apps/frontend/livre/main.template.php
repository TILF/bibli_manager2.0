<?php $allLivres = \Page::get('allLivres'); ?>

<div class="container">
    
    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron jumbnoLivre">
        <h1>Gestion des livres</h1>
    </div>
    
    <!-------------------- CORPS  -------------------------------->
    <div class="row">
        <div class="col-12 btn-left-bloc">
            <button class="btn buttonAddExtend" data-toggle="modal" data-target="#addBookModale" data-ref="<?php echo \Application::getRoute('livre', 'addNewBook'); ?>">
                <span class="circle">
                    <span class="icon arrow"></span>
                </span>
                <span class="button-text">Ajouter un livre</span>
            </button>
        </div>
    </div>
    
    <!--------------------- Affochage de la datatable -------------------------------->
    <table class="table table-striped table-bordered" id="LivresTable">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Année</th>
                <th>Emplacement</th>
                <th>Etat</th>
                <th>Appartenance</th>
                <th>Modifier</th>
                <th>Supp.</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach($allLivres as $livre): ?>
            <tr>
                <td><?php echo $livre['Reference']; ?></td>
                <td><?php echo \Db::decode($livre['Titre']); ?></td>
                <td><?php echo \Db::decode($livre['Auteur']); ?></td>
                <td><?php echo \Date::format2LengthDate($livre['Annee_parution']); ?></td>
                <td><?php echo $livre['Emplacement']; ?></td>
                <td><?php echo $livre['Etat_actuel']; ?></td>
                <td><?php echo \Db::decode($livre['Bibli_media']); ?></td>
                <td class="center">
                    <button class="btn btn-dark ModifyLivreButton" 
                            data-toggle="modal" 
                            data-target="#addBookModale" 
                            data-ref="<?php echo \Application::getRoute('livre', 'modifyBook', array($livre['Reference'])); ?>" 
                            data-ref-ajax="<?php echo \Application::getRoute('livre', 'getBookInfosByRef'); ?>"
                            data-id="<?php echo $livre['Reference']; ?>"> <i class="far fa-edit"></i>
                    </button>
                </td>
                <td class="center"><button class="btn btn-danger supprLivre" data-toggle="modal" data-target="#deleteBook" data-ref="<?php echo \Application::getRoute('livre', 'deleteBook', array($livre['Reference'])); ?>"><i class="far fa-trash-alt"></i></button></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<!---------------------- MODALE  ------------------------------------------>
<form id="formModalAdd" action="" method="POST">
    <div class="modal fade" id="addBookModale" tabindex="-1" role="dialog" aria-labelledby="addLivre" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitile">Nouveau Livre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Reference</label>
                    <input class="form-control verifyInt" data-name="Reference" name="reference" id="reference" type="number">
                </div>
                <div class="form-group">
                    <label>Titre du livre</label>
                    <input class="form-control verifyText" data-name="Titre du livre" name="titre" id="titre" type="text">
                </div>
                <div class="form-group">
                    <label>Auteur</label>
                    <input class="form-control verifyText" data-name="Auteur" name="auteur" id="auteur" type="text">
                </div>
                <div class="form-group">
                    <label>Année de parution</label>
                    <input class="form-control verifyInt" data-min="10" data-max="9999" data-name="Année de parution" name="annee" id="annee" type="number">
                </div>
                <div class="form-group">
                    <label>Emplacement</label>
                    <input class="form-control verifyText" data-name="Emplacement" name="emplacement" id="emplacement" type="text">
                </div>
                <div class="form-group">
                    <label>Etat</label>
                    <input class="form-control verifyText" data-name="Etat" name="etat" id="etat" type="text">
                </div> 
                
                <div class="form-group">
                    <label>Appartenance</label>
                        <div class="col-12 col-md-6 form-check">
                            <input class="form-check-input verifyRadio" data-name="Appartenance" id="AppartenanceRadioBibli" name="AppartenanceRadio" value="Bibliothèque" type="radio" />
                            <label class="form-check-label">Bibliothèque</label>
                        </div>
                        <div class="col-12 col-md-6 form-check">
                            <input class="form-check-input verifyRadio" data-name="Appartenance" id="AppartenanceRadioMedia" name="AppartenanceRadio" value="Médiathèque" type="radio" />
                            <label class="form-check-label">Médiathèque</label>
                        </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="btnActionModal" type="submit" class="btn btn-primary submit-form-btn" >Ajouter le livre</button>
            </div>
        </div>
      </div>
    </div>
</form>


<!---------------------- MODALE SUPPRESSION ------------------------------------------>
<form id="formModalDelete" action="" method="POST">
    <div class="modal fade" id="deleteBook" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supression d'un livre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Vous êtes sur le point de supprimer un livre. Etes-vous sûr ? 
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
    var table =  $('#LivresTable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        pageLength: 25,
        lengthChange: false,
        buttons: [ {extend: 'excel', text: '<i class="fas fa-download"></i> Excel', className: 'btn btn-info'} ]
    });
    
    $('.buttonAddExtend').click(function(){
        $('#ModalTitile').html('Ajout d\'un nouveau livre');
        $('#formModalAdd').attr('action', $(this).attr('data-ref'));
        $('#btnActionModal').html('Ajouter');
        $('#reference').removeAttr('readonly');
        form_reset();
    });
    
    $('.ModifyLivreButton').click(function(){
        $('#ModalTitile').html('Modification d\'un livre');
        $('#formModalAdd').attr('action', $(this).attr('data-ref'));  
        $('#btnActionModal').html('Modifier');
        $('#reference').prop('readonly', 'true');
        
        // récupération des éléments pour insertion dans la fenêtre modale via Ajax
        $.ajax({
            url: $(this).attr('data-ref-ajax'),
            type: 'post',
            dataType: 'JSON',
            data: { reference: $(this).attr('data-id')},
            success: function (result) {
                if(result.Reference){
                    $('#reference').val(result.Reference);
                    $('#titre').val(result.Titre);
                    $('#auteur').val(result.Auteur);
                    $('#annee').val(result.Annee_parution);
                    $('#emplacement').val(result.Emplacement);
                    $('#etat').val(result.Etat_actuel);
                    
                    if(result.Bibli_media === 'Bibliothèque')
                        $('#AppartenanceRadioMedia').prop('checked', 'true');
                    else if(result.Bibli_media === 'Mediathèque')
                        $('#AppartenanceRadioBibli').prop('checked', 'true');
                }else{
                    $.notify("Une erreur est survenue, contactez votre administrateur", 'error');
                    console.log('Erreur de AJAX');
                }
            }
        });  
        
    });
    
    
    
    $('.supprLivre').click(function(){
        $('#formModalDelete').attr('action', $(this).attr('data-ref'));
    });
    
    function form_reset(){
        $('#reference').val('');
        $('#titre').val('');
        $('#auteur').val('');
        $('#annee').val('');
        $('#emplacement').val('');
        $('#etat').val('');
        $('#AppartenanceRadioMedia').prop('checked', 'false');
        $('#AppartenanceRadioBibli').prop('checked', 'false');
    }
    
</script>