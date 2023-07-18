<template>
    <div class="modal fade" id="qs-form-modal-div" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header modal-border">
                    <h5 class="modal-title"><strong>Add Record</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="exitModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off" @submit.prevent="createRecord()">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-sm-9">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label for="add_position" style="font-weight: bold; margin: 0;">Position</label>
                                    <v-select taggable class="form-control form-control-border border-width-2" v-model="form.position_id" :reduce="position => position.id" :options="positions" label="title" placeholder="Select Position">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" :required="!form.position_id" v-bind="attributes" v-on="events" />
                                        </template>
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Salary Grade</label>
                                    <input v-model="form.sg" class="form-control form-control-border border-width-2" min="1" max="30" type="number" name="salary_grade_auth" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Educational Requirements</label>
                                    <textarea v-model="form.education" class="form-control form-control-border border-width-2" rows="2" placeholder="Enter requirements..." required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Experience Requirements</label>
                                    <textarea v-model="form.experience" class="form-control form-control-border border-width-2" rows="2" placeholder="Enter requirements..." required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Training Requirements</label>
                                    <textarea v-model="form.training" class="form-control form-control-border border-width-2" rows="2" placeholder="Enter requirements..." required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Eligibility Requirements</label>
                                    <textarea v-model="form.eligibility" class="form-control form-control-border border-width-2" rows="2" placeholder="Enter requirements..." required></textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer modal-border" style="display: flow-root;padding: 6px 10px;">
                        <div v-if="loading" class="spinner-border text-primary" role="status" style="float: right;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: left;" :disabled="loading">Save Record</button>
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
                loading: false,
                selected_position: {},
                form: new Form( {
                    'id': '',
                    'position_id': '',
                    'sg': '',
                    'education': '',
                    'experience': '',
                    'training': '',
                    'eligibility': ''
                }),
            }
        },
        components: {
            // draggable
        },
        props: {
            positions: Array,
            foredit: Object
        },
        computed: {

        },
        watch: {
            foredit: function(newData) {
                if (newData.id) {
                    this.form.id = newData.id
                    this.form.position_id = newData.position.id
                    this.form.sg = newData.sg
                    this.form.education = newData.education
                    this.form.experience = newData.experience
                    this.form.training = newData.training
                    this.form.eligibility = newData.eligibility
                } else {
                    this.form = new Form( {
                        'id': '',
                        'position_id': '',
                        'sg': '',
                        'education': '',
                        'experience': '',
                        'training': '',
                        'eligibility': ''
                    })
                }
            },
        },
        methods: {
            createRecord() {
                this.$Progress.start();
                this.loading = true;
                if (this.form.id == '') {
                    this.form.post('api/qs')
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Record added successfully',
                            })
                            this.$emit('exit', 'sync');
                            this.$Progress.finish();
                            this.loading = false;
                            $('#qs-form-modal-div').modal('hide');
                        })
                        .catch(error => {
                            this.$Progress.fail();
                            console.log(error.response.data.message);
                            this.loading = false;
                        });
                } else {
                    this.form.put('api/qs/' + this.form.id)
                        .then(() => {
                            toast.fire({
                                icon: 'success',
                                title: 'Record updated successfully'
                            });
                            this.$emit('exit', 'sync');
                            this.$Progress.finish();
                            this.loading = false;
                            $('#qs-form-modal-div').modal('hide');
                        })
                        .catch((error) => {
                            this.$Progress.fail();
                            console.log(error.response.data.message);
                            this.loading = false;
                        });
                }
            },
            exitModal() {
                this.$emit('exit');
            }
        },
        mounted() {
            // this.init_contents()
        },
        created() {
            
        }
    }
</script>