<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <button @click="initAddCategory()" class="btn btn-primary btn-xs pull-right">
                    + Add New Category
                </button>
                My Categories
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-responsive" v-if="categories.length > 0">
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
                    <tr v-for="(category, index) in categories">
                        <td>{{ index + 1 }}</td>
                        <td>
                            {{ category.name }}
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
                    name: ''
                },
                errors: [],
                categories: [],
                update_category: {}
            }
        },
        mounted() {
            this.readCategories();
        },
        methods: {
            initAddCategory() {
                $("#add_category_model").modal("show");
            },
            createCategory() {
                axios.post('/category', {
                    name: this.category.name
                })
                    .then(response => {

                        this.reset();

                        this.categories.push(response.data.category);

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
            },
            readCategories() {
                axios.get('/category')
                    .then(response => {

                        this.categories = response.data.categories;

                    });
            },
            initUpdate(index) {
                this.errors = [];
                $("#update_category_model").modal("show");
                this.update_category = this.categories[index];
            },
            updateCategory() {
                axios.patch('/category/' + this.update_category.id, {
                    name: this.update_category.name
                })
                    .then(response => {

                        $("#update_category_model").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }
                    });
            },
            deleteCategory(index) {
                let conf = confirm("Do you ready want to delete this category?");
                if (conf === true) {

                    axios.delete('/category/' + this.categories[index].id)
                        .then(response => {

                            this.categories.splice(index, 1);

                        })
                        .catch(error => {

                        });
                }
            }
        }
    }
</script>