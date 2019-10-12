<template>
    <div>
        <div class="card">
            <div class="card-header">
                <router-link class="text-primary" :to="{ name: 'guests.index' }">Guests</router-link>
                /
                <span class="text-secondary">View Guests</span>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <fieldset disabled>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Created By</label>
                                    <input type="text" class="form-control" v-model="guest.user.name">
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">First Name</label>
                                    <input type="text" class="form-control" v-model="guest.first_name">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Last Name</label>
                                    <input type="text" class="form-control" v-model="guest.last_name">
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Email Address</label>
                                    <input type="email" class="form-control" v-model="guest.email">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Phone Number</label>
                                    <input type="text" class="form-control" v-model="guest.phone_number">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-12">
                                <label>Gender</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="gender-male" class="custom-control-input" v-model="guest.gender" value="1">
                                            <label class="custom-control-label" for="gender-male">Male</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="gender-female" class="custom-control-input" v-model="guest.gender" value="0">
                                            <label class="custom-control-label" for="gender-female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Address</label>
                                    <textarea class="form-control" v-model="guest.address"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>

                <br>

                <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'guests.index' }"><i class="fas fa-chevron-left"></i>&nbsp; Back</router-link>
                <router-link class="btn btn-primary btn-sm" :to="{ name: 'guests.edit' , params: { id: guest.id }}"><i class="fas fa-edit"></i>&nbsp; Edit Guest</router-link>
                <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="openDeleteModal()"><i class="fas fa-trash-alt"></i>&nbsp; Delete Guest</button>
            </div>
            <div v-else>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">You're about to delete this Guest?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Guest?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="deleteGuest()">Confirm Delete</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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
                guest: '',
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/guests/' + this.$route.params.id).then(res => {
                    this.guest = res.data.guest;
                    resolve();
                }).catch(err => {
                    reject();
                    console.log(err);
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            openDeleteModal() {
                $('#deleteModal').modal('show');
            },
            deleteGuest() {
                this.ifReady = false;

                $('#deleteModal').modal('hide');

                axios.delete('/api/guests/' + this.$route.params.id).then(res => {
                    Broadcast.$emit('ToastMessage', { message: 'Guest Deleted Successfully' });

                    this.$router.push({ name: 'guests.index' });
                }).catch(err => {
                    this.ifReady = true;
                    console.log(err);
                });
            }
        }
    }
</script>
