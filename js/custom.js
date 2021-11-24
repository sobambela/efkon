$(function(){
    
    $("form[name='registration']").validate({
        // Specify validation rules
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            name: "required",
            surname: "required",
            gender: "required",
            contact_number:  {
                required: true,
                digits: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        submitHandler: function(form) {
          form.submit();
        }
    });

    var dashboardApp = new Vue({
        el: '#dashboard-app',
        mounted(){
            var vm = this;
            vm.getUsers();
        },
        data: {
          users: [],
          sort: 'ASC'
        },
        methods: {
            sortUsers(){
                var vm = this;
                vm.sort = (vm.sort == 'ASC')?'DESC':'ASC';
                vm.getUsers();
            },
            getUsers(){
                var vm = this;
                axios.post('/users',{ 'sort': vm.sort})
                .then(function (response) {
                    // handle success
                    vm.users = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            }
        }
    });

    var profileApp = new Vue({
        el: '#profile-app',
        mounted(){
            var vm = this;
            vm.getUser();
        },
        data: {
          user: {},
          loading: false,
          updateSuccess: null,
          responseMessage: '',
        },
        methods: {
            getUser(){
                var vm = this;
                var id = (vm.$refs.userId !== undefined)?vm.$refs.userId.value : '';
                axios.post('/user',{ 'user_id': id})
                .then(function (response) {
                    // handle success
                    vm.user = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            updateUser(){
                var vm = this;
                vm.loading = true;
                axios.post('/update-user',{ user: vm.user })
                .then(function (response) {
                    // handle success
                    vm.updateSuccess = response.data.success
                    vm.responseMessage = response.data.message
                    vm.loading = false;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    vm.loading = false;
                });
            }
        }
    });


    var resetApp = new Vue({
        el: '#reset-app',
        mounted(){
            var vm = this;
        },
        data: {
          email: '',
          password: '',
          resetCode: '',
          loading: false,
          updateSuccess: null,
          responseMessage: '',
          step: 1,
        },
        methods: {
            getUser(){
                var vm = this;
                var id = (vm.$refs.userId !== undefined)?vm.$refs.userId.value : '';
                axios.post('/user',{ 'user_id': id})
                .then(function (response) {
                    // handle success
                    vm.user = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            updateUser(){
                var vm = this;
                vm.loading = true;
                axios.post('/update-user',{ user: vm.user })
                .then(function (response) {
                    // handle success
                    vm.updateSuccess = response.data.success
                    vm.responseMessage = response.data.message
                    vm.loading = false;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    vm.loading = false;
                });
            }
        }
    });

});