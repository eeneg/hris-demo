<template>
    <div class="modal fade" id="duplicate-plantilla-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header modal-border">
                    <h5 class="modal-title">Duplicate Annual Plantilla {{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.year }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
                <!-- <form autocomplete="off" @submit.prevent="duplicatePlantilla()">
                    <div class="modal-body">
                        <p style="margin-bottom: 5px;"><b>Authorized Salary Schedule: </b>{{ prevSalaryproposed.tranche }}</p>
                        <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                            <label style="font-weight: normal; margin: 0;">Proposed Salary Schedule</label>
                            <select v-model="plantillaForm.salary_prop" class="custom-select form-control-border border-width-2">
                                <option :value="salaryschedule.id" v-for="salaryschedule in schedules" :key="salaryschedule.id">{{ salaryschedule.tranche }}</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label for="year" style="font-weight: normal; margin: 0;">Plantilla Year</label>
                                    <input v-model="plantillaForm.year" id="year" class="form-control form-control-border border-width-2" type="text" name="year" placeholder="Year"
                                    :class="{ 'is-invalid': plantillaForm.errors.has('year') }" required>
                                    <has-error :form="plantillaForm" field="year"></has-error>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-border" style="display: flow-root;padding: 6px 10px;">
                        <div id="duplicateLoadingIcon" class="spinner-border text-success d-none" role="status" style="float: left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <button id="duplicateButton" type="submit" class="btn btn-success" style="float: right;">Create</button>
                    </div>
                </form> -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                // plantillaForm: new Form({
                //     'year': '',
                //     'salary_auth': '',
                //     'salary_prop': '',
                //     'date_approved': '',
                //     'plantilla_depts': [],
                // }),
                // schedules: [],
                // departments: [],
                // loading: false,
            }
        },
        components: {
            // draggable
        },
        props: {
            // key: Number,
        },
        methods: {
            // createPlantilla() {
            //     this.$Progress.start();
            //     this.loading = true;
            //     this.plantillaForm.plantilla_depts = this.departments;
            //     this.plantillaForm.post('api/plantilla')
            //         .then(() => {
            //             Swal.fire({
            //                 icon: 'success',
            //                 title: 'Success',
            //                 text: 'Annual Plantilla ' + this.plantillaForm.year + ' created successfully',
            //             })
            //             $('#create-plantilla-modal').modal('hide');
            //             this.$Progress.finish();
            //             this.loading = false;
            //             this.$emit('exit');
            //         })
            //         .catch(error => {
            //             this.$Progress.fail();
            //             console.log(error.response.data.message);
            //             this.loading = false;
            //         });
            // },
            // exitModal() {
            //     this.$emit('exit');
            // },
            // remove_item(index) {
            //     this.departments.splice(index, 1);
            // },
            // init_contents() {
            //     axios.get('api/salaryschedule')
            //         .then(({data}) => {
            //             this.schedules = data;
            //         })
            //         .catch(error => {
            //             console.log(error.response.data.message);
            //         });

            //     axios.get('api/complete_depts')
            //         .then(({data}) => {
            //             this.departments = data.data;
            //         })
            //         .catch(error => {
            //             console.log(error.response.data.message);
            //         });
            // }
        },
        mounted() {
            // this.init_contents()
        },
        created() {
            
        }
    }
</script>