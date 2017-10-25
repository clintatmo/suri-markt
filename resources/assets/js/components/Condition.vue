<template>
    <div v-loading.fullscreen.lock="loading">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item>admin</el-breadcrumb-item>
            <el-breadcrumb-item>conditions</el-breadcrumb-item>
        </el-breadcrumb>
        <br>
        <div class="input-group">
            <input id="qry" type="text" v-model="qry" @keyup.enter.native="searchCondition()" placeholder="Zoeken..." class="form-control" name="qry" autofocus>
            <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" @click="searchCondition()">Zoeken!</button>
                        </span>
        </div>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <button @click="initCreate()" class="btn btn-primary btn-xs pull-right">
                    + Add New Condition
                </button>
                My Conditions
            </div>
            <div class="panel-body">
                <el-table
                        :data="conditions"
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

        <el-dialog :title="dialogFormTitle" v-model="dialogFormVisible" @close="reset(), readConditions()">
        <span slot="header" class="dialog-header">
          <i class="glyphicon glyphicon-plus"></i> New
        </span>
            <hr>
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <el-form ref="condition" label-position="right" :model="condition" label-width="120px">
                <el-form-item label="Name" prop="name">
                    <el-input v-model="condition.name"></el-input>
                </el-form-item>
            </el-form>
            <hr>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="dialogFormVisible = false, reset()" icon="circle-cross">Cancel</el-button>
                <el-button v-if="create" type="primary" @click="createCondition" icon="circle-check">Save</el-button>
                <el-button v-if="!create" type="primary" @click="updateCondition" icon="circle-check">Save</el-button>
            </span>
        </el-dialog>

        <el-dialog title="Warning!" v-model="confirmationDialogVisible" size="tiny" @close="readConditions()">
            <span>Please confirm this action.</span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="confirmationDialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="deleteCondition(rowToDelete)">Confirm</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                condition: {
                    name: ''
                },
                errors: [],
                conditions: [],
                update_condition: {},
                dialogFormVisible: false,
                dialogFormTitle: 'Add New Condition',
                confirmationDialogVisible: false,
                rowToDelete: null,
                create: true,
                qry: '',
                loading: false
            }
        },
        mounted() {
            this.readConditions();
        },
        methods: {
            initCreate() {
                this.dialogFormTitle = 'Add New Condition';
                this.dialogFormVisible = true;
                this.create = true;
            },
            createCondition() {
                axios.post('/condition', {
                    name: this.condition.name
                })
                    .then(response => {

                        this.reset();
                        this.readConditions();
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
                this.condition.name = '';
                this.errors = [];
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
            initUpdate(row) {
                this.errors = [];
                this.dialogFormTitle = 'Edit Condition';
                this.dialogFormVisible = true;
                this.condition = row;
                this.create = false;
            },
            updateCondition() {
                axios.patch('/condition/' + this.condition.id, {
                    name: this.condition.name
                })
                    .then(response => {

                        this.reset();
                        this.dialogFormVisible = false;
                        this.readConditions();
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
            deleteCondition(id) {
                axios.delete('/condition/' + id)
                    .then(response => {

                        this.confirmationDialogVisible = false;
                        this.readConditions();

                    })
                    .catch(error => {

                    });
            },
            searchCondition() {
                this.loading = true;
                axios.post('/condition/search', {
                    qry: this.qry
                })
                    .then(response => {

                        console.log(response);
                        this.conditions = response.data.conditions;
                        this.loading = false;

                    })
                    .catch(error => {
                        this.loading = false;
                    });
            }
        }
    }
</script>
