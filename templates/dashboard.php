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
        </section>
    </div>
</div>
<?php
require_once 'includes/footer.php';