<template>
    <div v-loading.fullscreen.lock="loading">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item>admin</el-breadcrumb-item>
            <el-breadcrumb-item>currencies</el-breadcrumb-item>
        </el-breadcrumb>
        <br>
        <div class="input-group">
            <input id="qry" type="text" v-model="qry" @keyup.enter.native="searchCurrency()" placeholder="Zoeken..." class="form-control" name="qry" autofocus>
            <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" @click="searchCurrency()">Zoeken!</button>
                        </span>
        </div>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <button @click="initCreate()" class="btn btn-primary btn-xs pull-right">
                    + Add New Currency
                </button>
                My Currencies
            </div>
            <div class="panel-body">
                <el-table
                        :data="currencies"
                        border
                        stripe
                        height="400"
                        :default-sort = "{prop: 'name', order: 'ascending'}"
                        style="width: 100%">
                    <el-table-column
                            prop="id"
                            label="#"
                            width="80"
                            sortable>
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="NAME"
                            width="400"
                            sortable>
                    </el-table-column>
                    <el-table-column
                            fixed="right"
                            label="Operations"
                            width="120">
                        <template scope="scope">
                            <el-button @click="initUpdate(scope.row)" type="text" size="small">Edit</el-button>
                            <el-button @click="initDelete(scope.row)" type="text" size="small">Delete</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>

        <el-dialog :title="dialogFormTitle" v-model="dialogFormVisible" @close="reset(), readCurrencies()">
        <span slot="header" class="dialog-header">
          <i class="glyphicon glyphicon-plus"></i> New
        </span>
            <hr>
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <el-form ref="currency" label-position="right" :model="currency" label-width="120px">
                <el-form-item label="Name" prop="name">
                    <el-input v-model="currency.name"></el-input>
                </el-form-item>
            </el-form>
            <hr>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="dialogFormVisible = false, reset()" icon="circle-cross">Cancel</el-button>
                <el-button v-if="create" type="primary" @click="createCurrency" icon="circle-check">Save</el-button>
                <el-button v-if="!create" type="primary" @click="updateCurrency" icon="circle-check">Save</el-button>
            </span>
        </el-dialog>

        <el-dialog title="Warning!" v-model="confirmationDialogVisible" size="tiny" @close="readCurrencies()">
            <span>Please confirm this action.</span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="confirmationDialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="deleteCurrency(rowToDelete)">Confirm</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                currency: {
                    name: ''
                },
                errors: [],
                currencies: [],
                update_currency: {},
                dialogFormVisible: false,
                dialogFormTitle: 'Add New Currency',
                confirmationDialogVisible: false,
                rowToDelete: null,
                create: true,
                qry: '',
                loading: false
            }
        },
        mounted() {
            this.readCurrencies();
        },
        methods: {
            initCreate() {
                this.dialogFormTitle = 'Add New Currency';
                this.dialogFormVisible = true;
                this.create = true;
            },
            createCurrency() {
                axios.post('/currency', {
                    name: this.currency.name
                })
                    .then(response => {

                        this.reset();
                        this.readCurrencies();
                        this.dialogFormVisible = false;

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
                this.errors = [];
            },
            readCurrencies() {
                this.loading = true;
                axios.get('/currency')
                    .then(response => {

                        this.currencies = response.data.currencies;
                        this.loading = false;

                    })
                    .catch(error => {
                        this.loading = false;
                    });
            },
            initUpdate(row) {
                this.errors = [];
                this.dialogFormTitle = 'Edit Currency';
                this.dialogFormVisible = true;
                this.currency = row;
                this.create = false;
            },
            updateCurrency() {
                axios.patch('/currency/' + this.currency.id, {
                    name: this.currency.name
                })
                    .then(response => {

                        this.reset();
                        this.dialogFormVisible = false;
                        this.readCurrencies();
                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }
                    });
            },
            initDelete(row) {
                this.rowToDelete = row.id;
                this.confirmationDialogVisible = true;
            },
            deleteCurrency(id) {
                axios.delete('/currency/' + id)
                    .then(response => {

                        this.confirmationDialogVisible = false;
                        this.readCurrencies();

                    })
                    .catch(error => {

                    });
            },
            searchCurrency() {
                this.loading = true;
                axios.post('/currency/search', {
                    qry: this.qry
                })
                    .then(response => {

                        console.log(response);
                        this.currencies = response.data.currencies;
                        this.loading = false;

                    })
                    .catch(error => {
                        this.loading = false;
                    });
            }
        }
    }
</script>
