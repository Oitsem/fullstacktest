<template>
    <div>
        <div class="card">
            <div class="card-header clearfix">
                <div class="float-left">
                    <router-link class="text-primary" :to="{ name: 'guests.index' }">Guests</router-link>
                    /
                    <span class="text-secondary">View Guests</span>
                </div>
                <div class="float-right">
                    <router-link class="btn btn-success btn-sm" :to="{ name: 'guests.create' }">
                        <i class="fas fa-plus"></i>&nbsp;
                        <strong>Create New Guest</strong>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover table-sm">
                    <caption>
                        <div class="row">
                            <div class="col-md-9">
                                List of Guests - <strong>Total Items {{ this.meta.total }}</strong>
                            </div>
                            <div class="col-md-3">
                                <div class="progress" height="30px;" v-if="showProgress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody v-if="guests">
                        <tr v-for="guest in guests">
                            <td>{{ guest.first_name }}</td>
                            <td>{{ guest.last_name }}</td>
                            <td>{{ guest.email }}</td>
                            <td>{{ guest.phone_number }}</td>
                            <td>
                                <router-link class="text-secondary" :to="{ name: 'guests.view', params: { id: guest.id } }">
                                    <i class="fas fa-eye"></i>&nbsp;
                                    <strong>View</strong>
                                </router-link>
                                &nbsp; | &nbsp;
                                <router-link class="text-secondary" :to="{ name: 'guests.edit', params: { id: guest.id }}">
                                    <i class="fas fa-edit"></i>&nbsp;
                                    <strong>Edit</strong>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>

        <div class="clearfix">
            <div v-if="pageCount">
                <nav class="float-left">
                    <ul class="pagination">
                        <li class="page-item" v-bind:class="isPrevDisabled">
                            <a class="page-link" href="#" @click.prevent="goToPreviousPage" disabled><strong>Previous</strong></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" @click.prevent="goToFirstPage"><strong>First</strong></a>
                        </li>
                        <li class="page-item" v-for="pageNumber in pageNumbers" v-bind:class="isPageActive(pageNumber)">
                            <a class="page-link" href="#" @click.prevent="goToPage(pageNumber)"><strong>{{ pageNumber }}</strong></a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToLastPage"><strong>Last</strong></a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToNextPage"><strong>Next</strong></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div v-else>
                <nav class="float-left">
                    <ul class="pagination">
                        <li class="page-item" v-bind:class="isPrevDisabled">
                            <a class="page-link" href="#" @click.prevent="goToPreviousPage" disabled><strong>Previous</strong></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" @click.prevent="goToFirstPage"><strong>First</strong></a>
                        </li>
                        <li class="page-item" v-for="pageNumber in pageNumbers" v-bind:class="isPageActive(pageNumber)">
                            <a class="page-link" href="#" @click.prevent="goToPage(pageNumber)"><strong>{{ pageNumber }}</strong></a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToLastPage"><strong>Last</strong></a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToNextPage"><strong>Next</strong></a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="float-right">
                <form class="form-inline">
                    <label class="sr-only" for="number-of-items">Number of Items</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Items per page</div>
                        </div>
                        <select class="custom-select" id="number-of-items" v-model="meta.per_page" v-on:change="changePerPage">
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    const getGuests = (
            page,
            per_page,
            first_name,
            last_name,
            email_address,
            phone_number,
            gender,
            address,
            order_by,
            callback
        ) => {
            const params = {
                page,
                per_page,
                first_name,
                last_name,
                email_address,
                phone_number,
                gender,
                address,
                order_by
        };

        axios.get('/api/guests', { params }).then(res => {
            callback(null, res.data);
        }).catch(error => {
            if (error.response.status == 401) {
                location.reload();
            }

            if (error.response.status == 500) {
                alert('Kindly report this issue to the devs.');
            }
        });
    };

    export default {
        data() {
            return {
                guests: null,
                first_name: '',
                last_name: '',
                email_address: '',
                phone_number: '',
                gender: '',
                address: '',
                order_by: '',
                meta: {
                    current_page: null,
                    from: null,
                    last_page: null,
                    path: null,
                    per_page: 10,
                    to: null,
                    total: null
                },
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },
                error: null,
                showProgress: false,
                pageNumbers: []
            };
        },

        beforeRouteEnter (to, from, next) {
            if (to.query.per_page == null) {
                getGuests(
                    to.query.page,
                    10,
                    to.query.first_name,
                    to.query.last_name,
                    to.query.email_address,
                    to.query.phone_number,
                    to.query.gender,
                    to.query.address,
                    to.query.order_by,
                    (err, data) => {
                        next(vm => vm.setData(err, data));
                    }
                    );
            } else {
                getGuests(
                    to.query.page,
                    to.query.per_page,
                    to.query.first_name,
                    to.query.last_name,
                    to.query.email_address,
                    to.query.phone_number,
                    to.query.gender,
                    to.query.address,
                    to.query.order_by,
                    (err, data) => {
                        next(vm => vm.setData(err, data));
                    }
                );
            }
        },

        beforeRouteUpdate (to, from, next) {
            getGuests(
                to.query.page,
                this.meta.per_page,
                this.first_name,
                this.last_name,
                this.email_address,
                this.phone_number,
                this.gender,
                this.address,
                this.order_by,
                (err, data) => {
                    this.setData(err, data);
                    next();
                }
            );
        },

        computed: {
            nextPage() {
                return this.meta.current_page + 1;
            },
            prevPage() {
                return this.meta.current_page - 1;
            },
            paginatonCount() {
                if (! this.meta) {
                    return;
                }

                const { current_page, last_page } = this.meta;

                return `${current_page} of ${last_page}`;
            },
            pageCount() {
                if (this.meta.last_page > 10) {
                    return false;
                }

                return true;
            },
            isPrevDisabled() {
                if (this.links.prev == null) {
                    return 'disabled';
                }

                return;
            },
            isNextDisabled() {
                if (this.links.next == null) {
                    return 'disabled';
                }

                return;
            }
        },

        methods: {
            goToFirstPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'guests.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email_address: this.email_address,
                        phone_number: this.phone_number,
                        gender: this.gender,
                        address: this.address,
                        order_by: this.order_by
                    },
                });
            },
            goToPage(page = null) {
                this.showProgress = true;
                this.$router.push({
                    name: 'guests.index',
                    query: {
                        page,
                        per_page: this.meta.per_page,
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email_address: this.email_address,
                        phone_number: this.phone_number,
                        gender: this.gender,
                        address: this.address,
                        order_by: this.order_by
                    },
                });
            },
            goToLastPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'guests.index',
                    query: {
                        page: this.meta.last_page,
                        per_page: this.meta.per_page,
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email_address: this.email_address,
                        phone_number: this.phone_number,
                        gender: this.gender,
                        address: this.address,
                        order_by: this.order_by
                    }
                });
            },
            goToNextPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'guests.index',
                    query: {
                        page: this.nextPage,
                        per_page: this.meta.per_page,
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email_address: this.email_address,
                        phone_number: this.phone_number,
                        gender: this.gender,
                        address: this.address,
                        order_by: this.order_by
                    }
                });
            },
            goToPreviousPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'guests.index',
                    query: {
                        page: this.prevPage,
                        per_page: this.meta.per_page,
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email_address: this.email_address,
                        phone_number: this.phone_number,
                        gender: this.gender,
                        address: this.address,
                        order_by: this.order_by
                    }
                });
            },
            setData(err, { data: guests, links, meta }) {
                this.pageNumbers = [];

                if (err) {
                    this.error = err.toString();
                } else {
                    this.guests = guests;
                    this.links = links;
                    this.meta = meta;
                }

                this.showProgress = false;
                this.populatePages();
            },
            populatePages() {
                if (this.pageCount) {
                    for (let i = 1; i <= this.meta.last_page; i++) {
                        this.pageNumbers.push(i);
                    }
                } else if (this.meta.current_page <= 6) {
                    let page = 1;
                    this.pageNumbers.push(page);
                    this.pageNumbers.push(page + 1);
                    this.pageNumbers.push(page + 2);
                    this.pageNumbers.push(page + 3);
                    this.pageNumbers.push(page + 4);
                    this.pageNumbers.push(page + 5);
                    this.pageNumbers.push(page + 6);
                    this.pageNumbers.push('...');
                    this.pageNumbers.push(this.meta.last_page - 1);
                    this.pageNumbers.push(this.meta.last_page);
                } else if ((this.meta.current_page + 6) >= this.meta.last_page) {
                    this.pageNumbers.push(1);
                    this.pageNumbers.push(2);
                    this.pageNumbers.push('...');
                    this.pageNumbers.push(this.meta.last_page - 7);
                    this.pageNumbers.push(this.meta.last_page - 6);
                    this.pageNumbers.push(this.meta.last_page - 5);
                    this.pageNumbers.push(this.meta.last_page - 4);
                    this.pageNumbers.push(this.meta.last_page - 3);
                    this.pageNumbers.push(this.meta.last_page - 2);
                    this.pageNumbers.push(this.meta.last_page - 1);
                    this.pageNumbers.push(this.meta.last_page);
                } else {
                    this.pageNumbers.push(1);
                    this.pageNumbers.push(2);
                    this.pageNumbers.push('...');
                    this.pageNumbers.push(this.meta.current_page - 2);
                    this.pageNumbers.push(this.meta.current_page - 1);
                    this.pageNumbers.push(this.meta.current_page);
                    this.pageNumbers.push(this.meta.current_page + 1);
                    this.pageNumbers.push(this.meta.current_page + 2);
                    this.pageNumbers.push('...');
                    this.pageNumbers.push(this.meta.last_page - 1);
                    this.pageNumbers.push(this.meta.last_page);
                }
            },
            isPageActive(page) {
                if (page == this.$route.query.page || (page == 1 && this.$route.query.page == null)) {
                    return 'active';
                }

                return;
            },
            changePerPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'guests.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        first_name: this.first_name,
                        last_name: this.last_name,
                        email_address: this.email_address,
                        phone_number: this.phone_number,
                        gender: this.gender,
                        address: this.address,
                        order_by: this.order_by
                    }
                });
            }
        }
    }
</script>
