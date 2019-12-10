<!--Main layout-->
<main class="pt-5 mx-lg-5">
    <div id="container" class="container-fluid mt-5">

        <!-- Heading -->
        <div class="card mb-4 wow fadeIn">

            <!--Card content-->
            <div class="card-body d-sm-flex justify-content-between">

                <h4 class="mb-2 mb-sm-0 pt-1">
                    <span class="blue-text font-weight-bold">Admin Panel</span>
                    <span>/</span>
                    <span>Gestione utenti</span>

                </h4>
            </div>

        </div>
        <!-- Heading -->
        <div class="row wow fadeIn">
            <div class="col-md-12">
                <br>
                <div class="card" id="aggiungi-categoria">
                    <div class="card-header"><h3 class="h3-responsive">Notifiche</h3></div>
                    <div class="card-body">
                        <?php if (count($GLOBALS["NOTIFIER"]->getNotifications())): ?>
                            <?php foreach ($GLOBALS["NOTIFIER"]->getNotifications() as $notification): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $notification ?>
                                </div>
                                <?php $GLOBALS["NOTIFIER"]->clear(); ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <h4 class="h4-responsive">Al momento non ci sono notifiche.</h4>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if(PermissionManager::getPermissions()->canCreareUtenti()): ?>
            <div class="row wow fadeIn">
                <div class="col-md-12">
                    <br>
                    <div class="card" id="aggiungi-categoria">
                        <div class="card-header"><h3 class="h3-responsive">Aggiungi utente</h3></div>
                        <div class="card-body">
                            <form class="form" method="post" action="<?php echo RedirectManager::buildUrl("api/user/add"); ?>">

                                <!-- Grid row -->
                                <div class="form-row">
                                    <!-- Grid column -->
                                    <div class="col">
                                        <!-- Material input -->
                                        <div class="md-form mt-0">
                                            <input type="text" id="nome" class="form-control" name="nome" required>
                                            <label for="nome">Nome</label>
                                        </div>
                                    </div>
                                    <!-- Grid column -->

                                    <!-- Grid column -->
                                    <div class="col">
                                        <!-- Material input -->
                                        <div class="md-form mt-0">
                                            <input type="text" class="form-control" id="cognome" name="cognome" required>
                                            <label for="cognome">Cognome</label>
                                        </div>
                                    </div>
                                    <!-- Grid column -->
                                </div>
                                <!-- Grid row -->

                                <div class="md-form input-group mb-4">
                                    <input type="text" id="email" class="form-control" aria-label="Email"
                                           aria-describedby="material-addon2" name="email" required>
                                    <label for="email">Email</label>
                                    <div class="input-group-append">
                                        <span class="input-group-text md-addon" id="material-addon2">@<?php echo EMAIL_ALLOWED_DOMAIN; ?></span>
                                    </div>
                                </div>

                                <div class="md-form">
                                    <input type="text" id="username" class="form-control" name="username" required>
                                    <label for="username">Username</label>
                                </div>

                                <div class="md-form">
                                    <h4 class="h4-responsive">Permessi utente</h4>
                                    <select id="imageSelector" name="tipo_utente"
                                            class="browser-default custom-select">
                                        <?php foreach (PermissionModel::getUniquePermissionTypes() as $userType): ?>
                                            <option value="<?php echo $userType ?>"><?php echo $userType ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Add category button -->
                                <button class="btn btn-dark-green btn-block my-4" type="submit">Crea utente</button>
                                <br>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>

        <br>
        <!--Grid row-->
        <div class="row wow fadeIn">
            <div class="col-md-12">

                <div class="card" id="categorie">
                    <div class="card-header"><h3 class="h3-responsive">Utenti</h3></div>
                    <div class="card-body">
                        <table id="userTable" class="table-responsive-xl table-striped" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Nome</th>
                                <th scope="col">cognome</th>
                                <th scope="col">Permessi</th>
                                <th scope="col">Password cambiata</th>
                                <th scope="col">Opzioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (count($users) > 0): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr id="<?php echo $user->getUsername();?>">
                                        <td class="username"><?php echo $user->getUsername(); ?></td>
                                        <td class="email" partial-mail="<?php echo $user->getPartialEmailAddress();?>"><?php echo $user->getFullEmailAddress(); ?></td>
                                        <td class="nome"><?php echo $user->getNome(); ?></td>
                                        <td class="cognome"><?php echo $user->getCognome(); ?></td>
                                        <td class="permessi"><?php echo $user->getTipoUtente(); ?></td>

                                        <td id="psw-changed">
                                            <?php echo $user->isDefaultPasswordChanged() ? "Si" : "No"; ?>
                                        </td>

                                        <td>
                                            <!-- Check for permissions -->
                                            <?php if(PermissionManager::getPermissions()->canUserAction()): ?>
                                                <?php if(PermissionManager::getPermissions()->canModificareUtenti()): ?>
                                                    <button class="btn btn-primary edit-user-button" data-toggle="tooltip" title="Modifica utente" user-target="<?php echo $user->getUsername();?>">
                                                        <i class="fas fa-user-edit"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if(PermissionManager::getPermissions()->canEliminareUtenti()): ?>
                                                    <button class="btn btn-danger delete-user-button" data-toggle="tooltip" title="Elimina utente" user-target="<?php echo $user->getUsername();?>">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if(PermissionManager::getPermissions()->canPromozioneUtenti()): ?>
                                                    <button class="btn btn-warning promote-user-button" data-toggle="tooltip" title="Promuovi utente" user-target="<?php echo $user->getUsername();?>">
                                                        <i class="fas fa-user-tag"></i>
                                                    </button>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <p>No perm.</p>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <td colspan="5">Non ci sono utenti.</td>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modals -->

        <!--Modal: modalConfirmDelete-->
        <div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog"
             aria-labelledby="modalEliminaMessaggio"
             aria-hidden="true">
            <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
                <!--Content-->
                <div class="modal-content text-center">
                    <!--Header-->
                    <div class="modal-header d-flex justify-content-center">
                        <p class="heading" id="modalEliminaMessaggio">INSERT MESSAGE HERE</p>
                    </div>

                    <!--Body-->
                    <div class="modal-body">

                        <i class="fas fa-times fa-4x animated rotateIn"></i>

                    </div>

                    <!--Footer-->
                    <div class="modal-footer flex-center">
                        <a href="emptylink.com" id="eliminaButton" class="btn btn-outline-danger">Si</a>
                        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">No</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!--Modal: modalConfirmDelete-->

        <!--Modal: editModal -->
        <div class="modal fade " id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">

            <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
            <div class="modal-dialog modal-notify modal-primary" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modifica utente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="text-center">
                            <i class="fas fa-user-edit fa-4x animated rotateIn"></i>
                        </div>

                        <form id="editModalForm" class="form" method="post">
                            <!-- Username -->
                            <div class="md-form">
                                <input type="text" id="editModalUsername" class="form-control" name="username"
                                       required>
                                <label for="nomeCategoriaModal">Nome utente</label>
                            </div>

                            <!-- Name -->
                            <div class="md-form">
                                <input type="text" id="editModalNome" class="form-control" name="nome"
                                       required>
                                <label for="nomeCategoriaModal">Nome</label>
                            </div>

                            <!-- Surname -->
                            <div class="md-form">
                                <input type="text" id="editModalCognome" class="form-control" name="cognome"
                                       required>
                                <label for="nomeCategoriaModal">Cognome</label>
                            </div>

                            <div class="md-form input-group mb-4">
                                <input type="text" id="editModalEmail" class="form-control" aria-label="Email"
                                       aria-describedby="material-addon2" name="email" required>
                                <label for="email">Email</label>
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon" id="material-addon2">@<?php echo EMAIL_ALLOWED_DOMAIN; ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="editModalSubmitButton" class="btn btn-dark-green waves-effect">Applica
                            <i class="fas fa-check ml-1 text-white"></i>
                        </button >

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Annulla</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal: editModal -->


        <!-- Central Modal Success Demo-->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-notify modal-success" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading lead" id="promoteModalTitle">Promuovi utente </p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-user-tag fa-4x mb-3 animated rotateIn"></i>
                            <form id="updateModalForm" class="form" method="post">
                                <!-- Category name -->
                                <div class="md-form">

                                    <input type="text" id="updateModalCurrentPermissions" class="form-control" name="categoryName"
                                           readonly>

                                    <label for="nomeCategoriaModal">Permessi attuali</label>

                                    <div class="md-form">
                                        <h4 class="h4-responsive">Permessi disponibili</h4>
                                        <select id="imageSelectorModal" name="tipo_utente"
                                                class="browser-default custom-select">

                                            <?php foreach (PermissionModel::getUniquePermissionTypes() as $userType): ?>
                                                <option value="<?php echo $userType ?>"><?php echo $userType ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a type="button" id="updateModalSubmitButton" class="btn btn-dark-green waves-effect">Applica
                            <i class="fas fa-check ml-1 text-white"></i>
                        </a>
                        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Annulla</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Success Demo-->

        <footer>
            <!--Copyright-->
            <div class="footer-copyright py-3">
                © 2019 Copyright:
                <a href="<?php echo URL;?>" target="_blank"><?php echo APP_NAME ?></a>
            </div>
            <!--/.Copyright-->

        </footer>
        <!--/.Footer-->
    </div>
</main>

<!-- Load modalmanager.js for modal management -->
<script src="/application/assets/js/admin/gestione_utenti/modalmanager.js"></script>

<!-- Load datatables.js -->
<script src="/application/assets/mdb/js/addons/datatables.min.js"></script>

<!-- Popper.js for tooltips -->
<script type="text/javascript" src="/application/assets/mdb/js/popper.min.js"></script>
<script>
    $(document).ready(function () {
        $('#userTable').dataTable({
            responsive: true,
            "scrollX": false
        });

        $('.dataTables_length').addClass('bs-select');

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    })
</script>