<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button @click="initAddCurrency()" class="btn btn-primary btn-xs pull-right">
                            + Add New Currency
                        </button>
                        My Currencys
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive" v-if="currencys.length > 0">
                            <tbody>
                            <tr>
                                <th>
                                    No.
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Description
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            <tr v-for="(currency, index) in currencys">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    {{ currency.name }}
                                </td>
                                <td>
                                    {{ currency.description }}
                                </td>
                                <td>
                                    <button @click="initUpdate(index)" class="btn btn-success btn-xs">Edit</button>
                                    <button @click="deleteCurrency(index)" class="btn btn-danger btn-xs">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="add_currency_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add New Currency</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" placeholder="Currency Name" class="form-control"
                                   v-model="currency.name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                      placeholder="Currency Description" v-model="currency.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createCurrency" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="update_currency_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Currency</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" placeholder="Currency Name" class="form-control"
                                   v-model="update_currency.name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea cols="30" rows="5" class="form-control"
                                      placeholder="Currency Description" v-model="update_currency.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateCurrency" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
</template>

<script>
    export default {
        data() {
            return {
                currency: {
                    name: '',
                    description: ''
                },
                errors: [],
                currencys: [],
                update_currency: {}
            }
        },
        mounted() {
            this.readCurrencys();
        },
        methods: {
            initAddCurrency() {
                $("#add_currency_model").modal("show");
            },
            createCurrency() {
                axios.post('/currency', {
                    name: this.currency.name,
                    description: this.currency.description,
                })
                    .then(response => {

                        this.reset();

                        this.currencys.push(response.data.currency);

                        $("#add_currency_model").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];

                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.description) {
                            this.errors.push(error.response.data.errors.description[0]);
                        }
                    });
            },
            reset() {
                this.currency.name = '';
                this.currency.description = '';
            },
            readCurrencys() {
                axios.get('/currency')
                    .then(response => {

                        this.currencys = response.data.currencys;

                    });
            },
            initUpdate(index) {
                this.errors = [];
                $("#update_currency_model").modal("show");
                this.update_currency = this.currencys[index];
            },
            updateCurrency() {
                axios.patch('/currency/' + this.update_currency.id, {
                    name: this.update_currency.name,
                    description: this.update_currency.description,
                })
                    .then(response => {

                        $("#update_currency_model").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.description) {
                            this.errors.push(error.response.data.errors.description[0]);
                        }
                    });
            },
            deleteCurrency(index) {
                let conf = confirm("Do you ready want to delete this currency?");
                if (conf === true) {

                    axios.delete('/currency/' + this.currencys[index].id)
                        .then(response => {

                            this.currencys.splice(index, 1);

                        })
                        .catch(error => {

                        });
                }
            }
        }
    }
</script>