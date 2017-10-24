<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <button @click="initCreate()" class="btn btn-primary btn-xs pull-right">
                    + Add New District
                </button>
                My Districts
            </div>
            <div class="panel-body">
                <el-table
                        :data="districts"
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

        <el-dialog :title="dialogFormTitle" v-model="dialogFormVisible" @close="reset(), readDistricts()">
        <span slot="header" class="dialog-header">
          <i class="glyphicon glyphicon-plus"></i> New
        </span>
            <hr>
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <el-form ref="district" label-position="right" :model="district" label-width="120px">
                <el-form-item label="Name" prop="name">
                    <el-input v-model="district.name"></el-input>
                </el-form-item>
            </el-form>
            <hr>
            <span slot="footer" class="dialog-footer">
            <el-button type="default" @click="dialogFormVisible = false, reset()" icon="circle-cross">Cancel</el-button>
            <el-button v-if="create" type="primary" @click="createDistrict" icon="circle-check">Save</el-button>
            <el-button v-if="!create" type="primary" @click="updateDistrict" icon="circle-check">Save</el-button>
        </span>
        </el-dialog>

        <el-dialog title="Warning!" v-model="confirmationDialogVisible" size="tiny" @close="readDistricts()">
            <span>Please confirm this action.</span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="confirmationDialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="deleteDistrict(rowToDelete)">Confirm</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                district: {
                    name: ''
                },
                errors: [],
                districts: [],
                update_district: {},
                dialogFormVisible: false,
                dialogFormTitle: 'Add New District',
                confirmationDialogVisible: false,
                rowToDelete: null,
                create: true
            }
        },
        mounted() {
            this.readDistricts();
        },
        methods: {
            initCreate() {
                this.dialogFormTitle = 'Add New District';
                this.dialogFormVisible = true;
                this.create = true;
            },
            createDistrict() {
                axios.post('/district', {
                    name: this.district.name
                })
                    .then(response => {

                        this.reset();
                        this.readDistricts();
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
                this.district.name = '';
                this.errors = [];
            },
            readDistricts() {
                axios.get('/district')
                    .then(response => {

                        this.districts = response.data.districts;

                    });
            },
            initUpdate(row) {
                this.errors = [];
                this.dialogFormTitle = 'Edit District';
                this.dialogFormVisible = true;
                this.district = row;
                this.create = false;
            },
            updateDistrict() {
                axios.patch('/district/' + this.district.id, {
                    name: this.district.name
                })
                    .then(response => {

                        this.reset();
                        this.dialogFormVisible = false;
                        this.readDistricts();
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
            deleteDistrict(id) {
                axios.delete('/district/' + id)
                    .then(response => {

                        this.confirmationDialogVisible = false;
                        this.readDistricts();

                    })
                    .catch(error => {

                    });
            }
        }
    }
</script>
