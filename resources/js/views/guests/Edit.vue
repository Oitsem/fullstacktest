<template>
    <div>
        <div class="card">
            <div class="card-header">
                <router-link class="text-primary" :to="{ name: 'guests.index' }">Guests</router-link>
                /
                <span class="text-secondary">Edit Guest</span>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <form v-on:submit.prevent="updateGuest()">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="name">First Name</label>
                                    <input type="text" class="form-control" v-model="first_name" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="name">Last Name</label>
                                    <input type="text" class="form-control" v-model="last_name" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="name">Email Address</label>
                                    <input type="text" class="form-control" v-model="email" autocomplete="off" maxlength="255">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="name">Phone Number</label>
                                    <input type="text" class="form-control" v-model="phone_number" autocomplete="off" maxlength="255">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <label>Gender</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="gender-male" class="custom-control-input" v-model="gender" value="1">
                                            <label class="custom-control-label" for="gender-male">Male</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="gender-female" class="custom-control-input" v-model="gender" value="0">
                                            <label class="custom-control-label" for="gender-female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" v-model="address" autocomplete="off" minlength="2" maxlength="255" required></textarea>
                                </div>
                            </div>
                        </div>

                        <br>

                        <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'guests.index' }">
                            <i class="fas fa-chevron-left"></i>&nbsp;
                            <strong>Back</strong>
                        </router-link>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i>&nbsp;
                            <strong>Update Guest</strong>
                        </button>
                    </form>
                </div>
                <div v-else>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady: false,
                first_name: '',
                last_name: '',
                email: '',
                phone_number: '',
                gender: '',
                address: ''
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/guests/' + this.$route.params.id).then(res => {
                    this.first_name   = res.data.guest.first_name;
                    this.last_name    = res.data.guest.last_name;
                    this.email        = res.data.guest.email;
                    this.phone_number = res.data.guest.phone_number;
                    this.gender       = res.data.guest.gender;
                    this.address      = res.data.guest.address;

                    resolve();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            updateGuest() {
                this.ifReady = false;

                let data = {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    email: this.email,
                    phone_number: this.phone_number,
                    gender: this.gender,
                    address: this.address
                };

                axios.patch('/api/guests/' + this.$route.params.id, this.$data).then(res => {
                    Broadcast.$emit('ToastMessage', { message: 'Guest Updated Successfully' });
                    this.$router.push({
                        name: 'guests.view',
                        params: { id: this.$route.params.id }
                    });
                }).catch(err => {
                    this.ifReady = true;
                    console.log(err);
                });
            }
        }
    }
</script>
