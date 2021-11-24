<?php

use App\Controllers\AuthController;

require_once 'includes/header.php';
require_once 'includes/nav.php';
?>
<div class="album bg-light" id="profile-app">
    <div class="container">
        <section class="wrapper">
            <div>
                <div class="col">
                    <div>
                        <div class="card-body"> 
                            <?php 
                            $auth = new AuthController;
                            $user = $auth->user(); 
                            ?>  
                            <form class="form-signin" id="profile-form">
                                <h2 class="form-signin-heading">profile update</h2>
                                <div class="login-wrap">
                                    <label for="password" class="col-lg-12 center-text login-response success" v-if="updateSuccess == true" >{{ responseMessage }}</label>
                                    <label for="password" class="col-lg-12 center-text login-response error" v-if="updateSuccess == false">{{ responseMessage }}</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" v-model="user.name" autofocus>
                                    <input type="text" name="surname" id="surname" class="form-control" placeholder="Surname" v-model="user.surname" autofocus>
                                    <select name="gender" id="gender" class="form-control" v-model="user.gender">
                                        <option value="">- Gender -</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="NA">NA</option>
                                    </select>
                                    <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Contact Number" v-model="user.contact_number" autofocus>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" v-model="user.email" autofocus>
                                    <input type="password" name="new_password" id="old_password" class="form-control" placeholder="Old Password" v-model="user.old_password">
                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" v-model="user.new_password">
                                    <input type="hidden" name="user_id" id="user_id" ref="userId" value="<?php echo $user['id']  ?>">
                                    <button class="btn btn-lg btn-login btn-block" id="update" type="submit" v-on:click.prevent="updateUser">
                                        <img src="img/ajax-loader-2.gif" class="loader" v-if="loading" />
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
require_once 'includes/footer.php';