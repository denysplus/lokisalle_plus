<?php echo "<pre>"; print_r($_POST); echo "</pre>"; ?>

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2017</p>
    </div>
    <!-- /.container -->
</footer>

<!-- modal INSCRIPTION START-->
<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h1>INSCRIPTION</h1><br>
            <form method="post" action="">
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo..." value="<?php echo $pseudo; ?>">
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe..." value="<?php // echo $mdp; ?>">
                </div>
                <hr>
                <div class="form-group">
                    <label for="civilite">Civilité</label>
                    <select class="form-control" name="civilite" id="civilite" value="<?php echo $civilite; ?>">
                        <option value="m">Monsieur</option>
                        <option value="f">Madame</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom..." value="<?php echo $nom; ?>">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom..." value="<?php echo $prenom; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email..." value="<?php echo $email; ?>">
                </div>

                <hr>
                <button type="submit" class="btn btn-success col-sm-12"><span class="glyphicon glyphicon-ok" name="inscription"></span> S'inscrire</button>
            </form>

            <div class="login-help">
                <a href="#">Forgot Password</a>
            </div>
        </div>
    </div>
</div>
<!-- modal INSCRIPTION END-->

<!-- modal CONNEXION START-->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h1>CONNEXION</h1><br>
            <form method="post" action="">
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo..." value="<?php echo $pseudo; ?>">
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe..." value="<?php // echo $mdp; ?>">
                </div>
                <hr>
                <button type="submit" class="btn btn-success col-sm-12"><span class="glyphicon glyphicon-ok" name="inscription"></span> S'inscrire</button>
            </form>

            <div class="login-help">
                <a href="#">Forgot Password</a>
            </div>
        </div>
    </div>
</div>
<!-- modal CONNEXION END-->


<!-- Bootstrap core JavaScript -->
<script src="<?php echo URL; ?>vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo URL; ?>js/bootstrap.min.js"></script>

</body>

</html>


