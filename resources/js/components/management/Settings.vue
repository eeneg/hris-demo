<template>
    <div class="row justify-content-center">
        <div class="text-center col-md-12" v-if="!$gate.isAdministrator()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Settings</h2>
                </div>
                <form @submit.prevent="save_settings()">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="margin: 0 0 0 2px;">Select latest approved Annual Plantilla</label>
                                <p class="text-muted" style="margin: 0 0 0 2px;"><i class="fas fa-info-circle blue"></i> This will be the reference of most of the HRIS transactions</p>
                                <select class="custom-select" v-model="form.plantilla" :class="{ 'is-invalid': form.errors.has('plantilla') }">
                                    <option v-for="plantilla in plantillas" :key="plantilla.id" :value="plantilla">{{ plantilla.year }}</option>
                                </select>
                                <has-error :form="form" field="plantilla"></has-error>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="margin: 0 0 0 2px;">
                                    Set DTR API Token
                                    <i class="fas" :class="{
                                        'fa-check-circle green' : api_set,
                                        'fa-exclamation-circle orange' : ! api_set,
                                    }"></i>
                                </label>
                                <p class="text-muted" style="margin: 0 0 0 2px;"><i class="fas fa-info-circle blue"></i> Used in authenticating the <br>DTR System</p>
                                <input v-model="form.dtr_api_token" type="text" class="form-control">
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
                api_set: null,
                form: new Form({
                    'plantilla': {},
                    'year': '',
                    'dtr_api_token': '',
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
                        this.form.dtr_api_token = null;
                        this.api_set = data.dtr_api_token;
                        this.form.year = data != null ? data.year : '';
                    })
                    .catch(error => {
                        console.log(error.error.data.message);
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
