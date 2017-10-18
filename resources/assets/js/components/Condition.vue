<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button @click="initAddCondition()" class="btn btn-primary btn-xs pull-right">
                            + Add New Condition
                        </button>
                        My Conditions
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive" v-if="conditions.length > 0">
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
                            <tr v-for="(condition, index) in conditions">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    {{ condition.name }}
                                </td>
                                <td>
                                    {{ condition.description }}
                                </td>
                                <td>
                                    <button @click="initUpdate(index)" class="btn btn-success btn-xs">Edit</button>
                                    <button @click="deleteCondition(index)" class="btn btn-danger btn-xs">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="add_condition_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add New Condition</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" placeholder="Condition Name" class="form-control"
                                   v-model="condition.name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                      placeholder="Condition Description" v-model="condition.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createCondition" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="update_condition_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Condition</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" placeholder="Condition Name" class="form-control"
                                   v-model="update_condition.name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea cols="30" rows="5" class="form-control"
                                      placeholder="Condition Description" v-model="update_condition.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateCondition" class="btn btn-primary">Submit</button>
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
                condition: {
                    name: '',
                    description: ''
                },
                errors: [],
                conditions: [],
                update_condition: {}
            }
        },
        mounted() {
            this.readConditions();
        },
        methods: {
            initAddCondition() {
                $("#add_condition_model").modal("show");
            },
            createCondition() {
                axios.post('/condition', {
                    name: this.condition.name,
                    description: this.condition.description,
                })
                    .then(response => {

                        this.reset();

                        this.conditions.push(response.data.condition);

                        $("#add_condition_model").modal("hide");

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
                this.condition.description = '';
            },
            readConditions() {
                axios.get('/condition')
                    .then(response => {

                        this.conditions = response.data.conditions;

                    });
            },
            initUpdate(index) {
                this.errors = [];
                $("#update_condition_model").modal("show");
                this.update_condition = this.conditions[index];
            },
            updateCondition() {
                axios.patch('/condition/' + this.update_condition.id, {
                    name: this.update_condition.name,
                    description: this.update_condition.description,
                })
                    .then(response => {

                        $("#update_condition_model").modal("hide");

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
            deleteCondition(index) {
                let conf = confirm("Do you ready want to delete this condition?");
                if (conf === true) {

                    axios.delete('/condition/' + this.conditions[index].id)
                        .then(response => {

                            this.conditions.splice(index, 1);

                        })
                        .catch(error => {

                        });
                }
            }
        }
    }
</script>