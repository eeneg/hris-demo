<template>
    <div class="row">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator()">
            <not-authorized></not-authorized>
        </div>

        <div v-else class="col-md-12">
            <div class="mb-3 clearfix">
                <h1 class="d-inline">
                    {{ organization?.name }}
                </h1>
                <button class="btn btn-primary float-right mt-2" data-toggle="modal" data-target="#exampleModal">
                    Insert
                </button>
            </div>
            <div>
                <img :src="chart" alt="">
            </div>
            <div class="modal" tabindex="-1" id="exampleModal" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Insert</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="create()" id="form">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input v-model="insert.name" type="text" class="form-control" id="name" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="name">Group</label>
                                    <input v-model="insert.group" type="text" class="form-control" id="name" placeholder="Enter group name">
                                </div>
                                <div class="form-group">
                                    <label for="name">Plantilla</label>
                                    <select v-model="insert.plantilla_contents_id" class="form-control">
                                        <option hidden :value="null">Select Plantilla</option>
                                        <option v-for="plantilla in plantillas" :value="plantilla.id">
                                            {{ `${plantilla.position?.title} (${plantilla.new_number})` }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Parent</label>
                                    <select v-model="insert.parent_id" class="form-control">
                                        <option hidden :value="null">Select Parent</option>
                                        <option v-for="unit in organizational_units" :value="unit.id">
                                            {{ `${unit.name}` }}
                                            <template v-if="unit.group">
                                                {{ ` - (${unit.group}) - ${unit.plantilla?.position?.title ?? ''} (${unit?.plantilla?.new_number ?? ''})` }}
                                            </template>
                                            <template v-else-if="unit.plantilla_contents_id">
                                                {{ ` - ${unit.plantilla?.position?.title ?? ''} (${unit?.plantilla?.new_number ?? ''})` }}
                                            </template>
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

<script>
export default {
    data() {
        return {
            organization: null,
            organizational_units: null,
            plantillas: null,
            plantilla_contents_id: null,
            insert: new Form({
                name: '',
                group: '',
                parent_id: '',
            }),
            chart: null,
        }
    },

    beforeRouteEnter(to, from, next) {
        next(vm => vm.fetch(to.query.id))
    },

    methods: {
        fetch(id) {
            axios.get('api/organization/' + id)
                .then(response => response.data)
                .then(data => {
                    this.organization = data.organization
                    this.plantillas = data.plantilla
                    this.organizational_units = data.organizational_units
                    this.chart = 'http://localhost:8080/png/' + data.plantuml
                })
        },
        create() {
            axios.post('api/organization', this.insert)
                .then(() => {
                    Swal.fire(
                        'Successfull!',
                        'New unit creation successful',
                        'success'
                    )

                    this.insert.reset()

                    this.$Progress.finish()
                })
                .catch(e => {
                    console.error(e)
                    this.$Progress.finish()
                })
        },
        mounted() {

        }
    },
}
</script>
