<?php
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>
<div class="album bg-light" id="dashboard-app">
    <div class="container">
        <section class="wrapper">
            <div class="row row-cols-1 row-cols-sm-12 row-cols-md-12 g-3">
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">
                                            <a href="" class="sort-by" v-on:click.prevent="sortUsers">Name</a>
                                        </th>
                                        <th scope="col">Surname</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Contact Number</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Password</th>
                                    </tr>
                                </thead>
                                <tbody v-if="users.length > 0">
                                    <tr v-for="(user,i) in users" :key="i">
                                        <td>{{ user.id }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.surname }}</td>
                                        <td>{{ user.gender }}</td>
                                        <td>{{ user.contact_number }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.password }}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="7">0 Records</td>
                                    </tr>
                                </tbody>
                            </table>              
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-12 row-cols-md-12 g-3 advanced">
                <div class="col">
                    <div class="card shadow-sm">  
                        <div class="card-body"> 
                            <form class="form-signin" id="equinox-form">
                                <h2 class="form-signin-heading">Autumnal Equinox</h2>
                                <div class="login-wrap">
                                    <label for="email" class="col-lg-12 center-text login-response">Please enter your start year.</label>
                                    <input type="text" name="year" id="year" class="form-control" placeholder="Year" v-model="year" autofocus>
                                    <button class="btn btn-lg btn-login btn-block" type="submit" v-on:click.prevent="equinoxDates">
                                        <img src="img/ajax-loader-2.gif" class="loader" v-if="loading" />
                                        Get Dates
                                    </button>
                                </div>
                            </form>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Year</th>
                                        <th scope="col">Autumnal Equinox</th>
                                    </tr>
                                </thead>
                                <tbody v-if="equinox.length > 0">
                                    <tr v-for="(date,i) in equinox" :key="i">
                                        <td>{{ date.year }}</td>
                                        <td>{{ date.date }}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="2">Start by entering a year</td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
require_once 'includes/footer.php';