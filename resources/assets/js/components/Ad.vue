<template>
    <div v-loading.fullscreen.lock="loading">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item>admin</el-breadcrumb-item>
            <el-breadcrumb-item>ads</el-breadcrumb-item>
        </el-breadcrumb>
        <br>
        <div class="input-group">
            <input id="qry" type="text" v-model="qry" @keyup.enter.native="searchAd()" placeholder="Zoeken..." class="form-control" name="qry" autofocus>
            <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" @click="searchAd()">Zoeken!</button>
                        </span>
        </div>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <button @click="initCreate()" class="btn btn-primary btn-xs pull-right">
                    + Add New Ad
                </button>
                My Ads
            </div>
            <div class="panel-body">
                <el-table
                        :data="ads"
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
                            prop="title"
                            label="Titel"
                            width="400"
                            sortable>
                    </el-table-column>
                    <el-table-column
                            prop="description"
                            label="Omschrijving"
                            width="400"
                            sortable>
                    </el-table-column>
                    <el-table-column
                            prop="price"
                            label="Prijs"
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

        <el-dialog :title="dialogFormTitle" v-model="dialogFormVisible" @close="reset(), readAds()">
        <span slot="header" class="dialog-header">
          <i class="glyphicon glyphicon-plus"></i> New
        </span>
            <hr>
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <el-form ref="ad" label-position="right" :model="ad" label-width="120px">
                <el-form-item label="Title" prop="title">
                    <el-input v-model="ad.title"></el-input>
                </el-form-item>
                <el-form-item label="Description" prop="description">
                    <el-input  type="textarea" :rows="3" v-model="ad.description"></el-input>
                </el-form-item>
                <el-form-item label="Currency" prop="currency">
                    <el-select placeholder="Select" filterable v-model="ad.currency">
                        <el-option
                                v-for="item in currencies"
                                :label="item.name"
                                v-bind:value="item.id"
                                :key="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Price" prop="price">
                    <el-input-number v-model="ad.price" :min="1"></el-input-number>
                </el-form-item>
                <el-form-item label="Category" prop="category">
                    <el-select placeholder="Select" filterable v-model="ad.category">
                        <el-option
                                v-for="item in categories"
                                :label="item.name"
                                v-bind:value="item.id"
                                :key="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Condition" prop="condition">
                    <el-select placeholder="Select" filterable v-model="ad.condition">
                        <el-option
                                v-for="item in conditions"
                                :label="item.name"
                                v-bind:value="item.id"
                                :key="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="District" prop="district">
                    <el-select placeholder="Select" filterable v-model="ad.district">
                        <el-option
                                v-for="item in districts"
                                :label="item.name"
                                v-bind:value="item.id"
                                :key="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <span>{{ad}}</span>
            <hr>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="dialogFormVisible = false, reset()" icon="circle-cross">Cancel</el-button>
                <el-button v-if="create" type="primary" @click="createAd" icon="circle-check">Save</el-button>
                <el-button v-if="!create" type="primary" @click="updateAd" icon="circle-check">Save</el-button>
            </span>
        </el-dialog>

        <el-dialog title="Warning!" v-model="confirmationDialogVisible" size="tiny" @close="readAds()">
            <span>Please confirm this action.</span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="confirmationDialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="deleteAd(rowToDelete)">Confirm</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                ad: {
                    title: '',
                    description: '',
                    currency: '',
                    price: 0,
                    condition: '',
                    category: '',
                    district: '',
                    deleted: false
                },
                errors: [],
                ads: [],
                categories: [],
                conditions: [],
                currencies: [],
                districts: [],
                update_ad: {},
                dialogFormVisible: false,
                dialogFormTitle: 'Add New Ad',
                confirmationDialogVisible: false,
                rowToDelete: null,
                create: true,
                qry: '',
                loading: false
            }
        },
        mounted() {
            this.readAds();
            this.readCategories();
            this.readConditions();
            this.readCurrencies();
            this.readDistricts();
        },
        methods: {
            initCreate() {
                this.dialogFormTitle = 'Add New Ad';
                this.dialogFormVisible = true;
                this.create = true;
            },
            createAd() {
                axios.post('/ad', {
                    title: this.ad.title,
                    description: this.ad.description,
                    currency: this.ad.currency,
                    price: this.ad.price,
                    condition: this.ad.condition,
                    category: this.ad.category,
                    district: this.ad.district,
                    deleted: this.ad.deleted
                })
                    .then(response => {

                        this.reset();
                        this.readAds();
                        this.dialogFormVisible = false;
                        Vue.prototype.$message({message: response.data.message, type: 'success'});

                    })
                    .catch(error => {
                        this.errors = [];

//                        console.log(error.response);

                        if (error.response.data.errors) {
                            this.errors.push(error.response.data.errors);
                        } else {
                            Vue.prototype.$message({message: error.response.data.message, type: 'error'});
                        }
                    });
            },
            reset() {
                this.ad = {
                    title: '',
                    description: '',
                    currency: '',
                    price: 0,
                    condition: '',
                    category: '',
                    district: '',
                    deleted: false
                };
                this.errors = [];
            },
            readAds() {
                this.loading = true;
                axios.get('/ad')
                    .then(response => {

                        this.ads = response.data.ads;
                        this.loading = false;

                    })
                    .catch(error => {
                        this.loading = false;
                    });
            },
            readCategories() {
                this.loading = true;
                axios.get('/category')
                    .then(response => {

                        this.categories = response.data.categories;
                        this.loading = false;

                    })
                    .catch(error => {
                        this.loading = false;
                    });
            },
            readConditions() {
                this.loading = true;
                axios.get('/condition')
                    .then(response => {

                        this.conditions = response.data.conditions;
                        this.loading = false;

                    })
                    .catch(error => {
                        this.loading = false;
                    });
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
            readDistricts() {
                this.loading = true;
                axios.get('/district')
                    .then(response => {

                        this.districts = response.data.districts;
                        this.loading = false;

                    })
                    .catch(error => {
                        this.loading = false;
                    });
            },
            initUpdate(row) {
                this.errors = [];
                this.dialogFormTitle = 'Edit Ad';
                this.dialogFormVisible = true;
                this.ad = row;
                this.create = false;
            },
            updateAd() {
                axios.patch('/ad/' + this.ad.id, {
                    title: this.ad.title,
                    description: this.ad.description,
                    currency: this.ad.currency,
                    price: this.ad.price,
                    condition: this.ad.condition,
                    category: this.ad.category,
                    district: this.ad.district,
                    deleted: this.ad.deleted
                })
                    .then(response => {

                        this.reset();
                        this.dialogFormVisible = false;
                        this.readAds();
                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors) {
                            this.errors.push(error.response.data.errors);
                        }
                    });
            },
            initDelete(row) {
                this.rowToDelete = row.id;
                this.confirmationDialogVisible = true;
            },
            deleteAd(id) {
                axios.delete('/ad/' + id)
                    .then(response => {

                        this.confirmationDialogVisible = false;
                        this.readAds();

                    })
                    .catch(error => {

                    });
            },
            searchAd() {
                this.loading = true;
                axios.post('/ad/search', {
                    qry: this.qry
                })
                    .then(response => {

                        console.log(response);
                        this.ads = response.data.ads;
                        this.loading = false;

                    })
                    .catch(error => {
                        this.loading = false;
                    });
            }
        }
    }
</script>
