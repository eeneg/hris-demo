<template>
    <div class="row">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator()">
            <not-authorized></not-authorized>
        </div>

        <div v-else class="col-md-12">
            <div class="mb-3 clearfix">
                <h1 class="d-inline">
                    Organizational Chart
                </h1>
                <button class="btn btn-primary float-right mt-2" data-toggle="modal" data-target="#exampleModal">
                    Create New
                </button>
            </div>
            <div class="my-3">
                <input type="text" class="input">
            </div>
            <div class="table-responsive">
                <table class="table table-fixed">
                    <thead>
                        <tr> <th> Name </th> <th> Office </th> <th> Created At </th> </tr>
                    </thead>
                    <tbody>
                        <tr v-for="organization in organizations.data" class="cursor-pointer">
                            <td>
                                <router-link class="text-dark" :to="'/org-view?id=' + organization.id">
                                    {{ organization.name }}
                                </router-link>
                            </td>
                            <td>
                                <router-link class="text-dark" :to="'/org-view?id=' + organization.id">
                                    {{ organization.department?.title }}
                                </router-link>
                            </td>
                            <td>
                                <router-link class="text-dark" :to="'/org-view?id=' + organization.id">
                                    {{ organization.created_at }}
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal" tabindex="-1" id="exampleModal" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create New Organizational Chart</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="create()" id="form">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input v-model="form.name" type="text" class="form-control" id="name" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="name">Office</label>
                                    <select v-model="form.department_id" class="form-control">
                                        <option hidden :value="null">Select Office</option>
                                        <option v-for="department in departments" :value="department.id">
                                            {{ department.title }}
                                        </option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" form="form" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="css" scoped>
td {
    padding: 0;
    height: fit-content !important;
}
td a {
    padding: 0.55rem !important;
    width: 100% !important;
    display: block;
}
</style>

<script lang="js">
export default {
    data() {
        return {
            organizations: {},
            departments: {},
            form: new Form({
                name: '',
                department_id: '',
            }),
        }
    },
    methods: {
        create() {
            this.$Progress.start();

            axios.post('api/organization', this.form)
                .then(() => {
                    Swal.fire(
                        'Successfull!',
                        'New Organization creation successful',
                        'success'
                    )

                    this.form.reset()

                    this.$Progress.finish()
                })
                .catch(e => {
                    console.error(e)

                    this.$Progress.finish()
                })
        },
    },
    async mounted() {
        const data = await axios.get('api/organization/').then(response => response.data)

        this.organizations = data.organizations

        this.departments = data.departments
    },
}
</script>
