<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button @click="initAddDistrict()" class="btn btn-primary btn-xs pull-right">
                            + Add New District
                        </button>
                        My Districts
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive" v-if="districts.length > 0">
                            <tbody>
                            <tr>
                                <th>
                                    No.
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            <tr v-for="(district, index) in districts">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    {{ district.name }}
                                </td>
                                <td>
                                    <button @click="initUpdate(index)" class="btn btn-success btn-xs">Edit</button>
                                    <button @click="deleteDistrict(index)" class="btn btn-danger btn-xs">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="add_district_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add New District</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" placeholder="District Name" class="form-control"
                                   v-model="district.name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createDistrict" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="update_district_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update District</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" placeholder="District Name" class="form-control"
                                   v-model="update_district.name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateDistrict" class="btn btn-primary">Submit</button>
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
                district: {
                    name: ''
                },
                errors: [],
                districts: [],
                update_district: {}
            }
        },
        mounted() {
            this.readDistricts();
        },
        methods: {
            initAddDistrict() {
                $("#add_district_model").modal("show");
            },
            createDistrict() {
                axios.post('/district', {
                    name: this.district.name
                })
                    .then(response => {

                        this.reset();

                        this.districts.push(response.data.district);

                        $("#add_district_model").modal("hide");

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
            },
            readDistricts() {
                axios.get('/district')
                    .then(response => {

                        this.districts = response.data.districts;

                    });
            },
            initUpdate(index) {
                this.errors = [];
                $("#update_district_model").modal("show");
                this.update_district = this.districts[index];
            },
            updateDistrict() {
                axios.patch('/district/' + this.update_district.id, {
                    name: this.update_district.name
                })
                    .then(response => {

                        $("#update_district_model").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }
                    });
            },
            deleteDistrict(index) {
                let conf = confirm("Do you ready want to delete this district?");
                if (conf === true) {

                    axios.delete('/district/' + this.districts[index].id)
                        .then(response => {

                            this.districts.splice(index, 1);

                        })
                        .catch(error => {

                        });
                }
            }
        }
    }
</script>