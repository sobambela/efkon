<?php
require_once __DIR__.'/../includes/header.php';
?>
    <section class="wrapper" style="background: #2e353d;">
        <form class="form-signin" id="register-form" name="registration" method="post" action="/register">
            <h2 class="form-signin-heading">Register in now</h2>
            <div class="login-wrap">
                <?php if(isset($_GET['err']) && $_GET['err'] == 1){  ?>
                <label for="password" class="col-lg-12 center-text login-response error" >Email already exists</label>
                <?php }  ?>
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" autofocus>
                <input type="text" name="surname" id="surname" class="form-control" placeholder="Surname" autofocus>
                <select name="gender" id="gender" class="form-control">
                    <option value="">- Gender -</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="NA">NA</option>
                </select>
                <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Contact Number" autofocus>
                <input type="text" name="email" id="email" class="form-control" placeholder="Email" autofocus>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                <input type="hidden" name="redirect" id="redirect">
                <button class="btn btn-lg btn-login btn-block" id="register" type="submit">
                    <img src="img/ajax-loader-2.gif" class="loader" style="display:none;" />
                    Register
                </button>
            </div>
        </form>
    </section>
<?php
require_once  __DIR__.'/../includes/footer.php';