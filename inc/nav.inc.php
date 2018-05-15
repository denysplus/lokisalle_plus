<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Lokisalle</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo URL; ?>index.php">Qui Sommes Nous
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URL; ?>contact.php">Contact</a>
                </li>

                <!-- DROPDOWN MENU START -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Espace Membre <span class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <?php
                            if(utilisateur_est_connecte())
                            {
                                ?>
                                <li><a href="<?php echo URL; ?>profil.php"><span class="glyphicon glyphicon-user"></span>Profil</a></li>
                                <li><a href="<?php echo URL; ?>connexion.php?action=deconnexion">Déconnexion</a></li>
                                <?php
                            } else {
                                ?>
                                <li><a href="#" data-toggle="modal" data-target="#signin-modal">Inscription</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#login-modal">Connexion</a></li>
                                <?php
                            }

                            if(utilisateur_est_admin())
                            {
                                echo '<li><a href="'.URL.'admin/gestion_boutique.php"><span class="glyphicon glyphicon-th-list
"></span> Gestion boutique</a></li>';
                                echo '<li><a href="'.URL.'admin/gestion_membre.php">Gestion membre</a></li>';
                                echo '<li><a href="'.URL.'admin/gestion_commande.php">Gestion commande</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                <!-- DROPDOWN MENU END -->
            </ul>
        </div>
    </div>
</nav>




<?php

