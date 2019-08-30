<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Neon Admin Panel"/>
    <meta name="author" content=""/>

    <link rel="icon" href="assets/images/favicon.ico">

    <title>Plainty | Connexion</title>

    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/neon-core.css">
    <link rel="stylesheet" href="assets/css/neon-theme.css">
    <link rel="stylesheet" href="assets/css/neon-forms.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <script src="assets/js/jquery-1.11.3.min.js"></script>

    <!--[if lt IE 9]>
    <script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body class="page-body login-page login-form-fall" data-url="http://neon.dev">


<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
    var baseurl = '';
</script>

<div class="login-container">

    <div class="login-header login-caret">

        <div class="login-content">

            <a href="index.html" class="logo">
                <img src="assets/images/logo@2x.png" width="120" alt=""/>
            </a>

            <p class="description">Bienvenue, connectez vous !</p>

            <!-- progress bar indicator -->
            <div class="login-progressbar-indicator">
                <h3>43%</h3>
                <span>logging in...</span>
            </div>
        </div>

    </div>

    <div class="login-progressbar">
        <div></div>
    </div>

    <div class="login-form">

        <div class="login-content">

            <form method="post" role="form" id="login_form">
                @csrf
                <div class="form-group">

                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="entypo-user"></i>
                        </div>

                        <input type="text" class="form-control" name="phone" id="phone"
                               placeholder="Numéro de téléphone" autocomplete="off"/>
                    </div>

                </div>

                <div class="form-group">

                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="entypo-key"></i>
                        </div>

                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Mot de passe" autocomplete="off"/>
                    </div>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-login">
                        <i class="entypo-login"></i>
                        Se connecter
                    </button>
                </div>

                <!-- Implemented in v1.1.4 -->
                <div class="form-group">
                    <em>- ou -</em>
                </div>

                <div class="form-group">

                    <button type="button" class="btn btn-default btn-lg btn-block btn-icon icon-left facebook-button">
                        Créer un compte
                        <i class="entypo-user-add"></i>
                    </button>

                </div>

                <!--

                You can also use other social network buttons
                <div class="form-group">

                    <button type="button" class="btn btn-default btn-lg btn-block btn-icon icon-left twitter-button">
                        Login with Twitter
                        <i class="entypo-twitter"></i>
                    </button>

                </div>

                <div class="form-group">

                    <button type="button" class="btn btn-default btn-lg btn-block btn-icon icon-left google-button">
                        Login with Google+
                        <i class="entypo-gplus"></i>
                    </button>

                </div> -->

            </form>


            <div class="login-bottom-links">

                <a href="extra-forgot-password.html" class="link">Mot de passe oublié ?</a>

                <br/>

                <a href="#">Conditions d'utilisation</a> - <a href="#">Politique de confidentialité</a>

            </div>

        </div>

    </div>

</div>


<!-- Bottom scripts (common) -->
<script src="assets/js/gsap/TweenMax.min.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/neon-login.js"></script>
<script src="assets/js/toastr.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="assets/js/neon-demo.js"></script>

<script>
    $('#login_form').submit(function (e) {
        e.preventDefault();
        e.stopPropagation();

        const phone = $('#phone').val();
        const password = $('#password').val();

        $.ajax({
            url: "{{ route('login.auth') }}",
            method: 'POST',
            data: {_token: "{{ csrf_token() }}", phone: phone, password: password},
            success: function (data) {
                toastr.success(data.message, 'Connexion réussie');
                setTimeout(() => {
                    window.location.replace("{{ route('dashboard') }}")
                }, 3000);
            },
            error: function (data) {
                console.log(data);
                toastr.error(data.responseJSON.message, 'Erreur');
            }
        });
    });
</script>

</body>
</html>