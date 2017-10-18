<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button @click="initAddCategory()" class="btn btn-primary btn-xs pull-right">
                            + Add New Category
                        </button>
                        My Categorys
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive" v-if="categorys.length > 0">
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
                            <tr v-for="(category, index) in categorys">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    {{ category.name }}
                                </td>
                                <td>
                                    {{ category.description }}
                                </td>
                                <td>
                                    <button @click="initUpdate(index)" class="btn btn-success btn-xs">Edit</button>
                                    <button @click="deleteCategory(index)" class="btn btn-danger btn-xs">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="add_category_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add New Category</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" placeholder="Category Name" class="form-control"
                                   v-model="category.name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                      placeholder="Category Description" v-model="category.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createCategory" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="update_category_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Category</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" placeholder="Category Name" class="form-control"
                                   v-model="update_category.name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea cols="30" rows="5" class="form-control"
                                      placeholder="Category Description" v-model="update_category.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateCategory" class="btn btn-primary">Submit</button>
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
                category: {
                    name: '',
                    description: ''
                },
                errors: [],
                categorys: [],
                update_category: {}
            }
        },
        mounted() {
            this.readCategorys();
        },
        methods: {
            initAddCategory() {
                $("#add_category_model").modal("show");
            },
            createCategory() {
                axios.post('/category', {
                    name: this.category.name,
                    description: this.category.description,
                })
                    .then(response => {

                        this.reset();

                        this.categorys.push(response.data.category);

                        $("#add_category_model").modal("hide");

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
                this.category.name = '';
                this.category.description = '';
            },
            readCategorys() {
                axios.get('/category')
                    .then(response => {

                        this.categorys = response.data.categorys;

                    });
            },
            initUpdate(index) {
                this.errors = [];
                $("#update_category_model").modal("show");
                this.update_category = this.categorys[index];
            },
            updateCategory() {
                axios.patch('/category/' + this.update_category.id, {
                    name: this.update_category.name,
                    description: this.update_category.description,
                })
                    .then(response => {

                        $("#update_category_model").modal("hide");

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
            deleteCategory(index) {
                let conf = confirm("Do you ready want to delete this category?");
                if (conf === true) {

                    axios.delete('/category/' + this.categorys[index].id)
                        .then(response => {

                            this.categorys.splice(index, 1);

                        })
                        .catch(error => {

                        });
                }
            }
        }
    }
</script>