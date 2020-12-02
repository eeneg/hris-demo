<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Settings</h2>
                </div>
                <form @submit.prevent="save_settings()">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select latest approved Annual Plantilla</label>
                                <select class="custom-select" v-model="form.plantilla" :class="{ 'is-invalid': form.errors.has('plantilla') }">
                                    <option v-for="plantilla in plantillas" :key="plantilla.id">{{ plantilla.year }}</option>
                                </select>
                                <has-error :form="form" field="plantilla"></has-error>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                plantillas: {},
                form: new Form({
                    'plantilla': '',
                })
            }
        },
        methods: {
            load_plantillas() {
                axios.get('api/plantilla')
                    .then(({data}) => {
                        this.plantillas = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            load_settings() {
                axios.get('api/setting')
                    .then(({data}) => {
                        this.form.fill(data);
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            save_settings() {
                this.$Progress.start();
                this.form.post('api/setting')
                    .then(response => {                 
                        toast.fire({
                            icon: 'success',
                            title: 'Settings updated successfully'
                        });
                        this.$parent.getSettings();
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        console.log(error);
                    });
            }
        },
        mounted() {
            // console.log('Component mounted.')
        },
        created() {
            this.$Progress.start();

            this.load_plantillas();
            this.load_settings();

            this.$Progress.finish();
        }
    }
</script>
