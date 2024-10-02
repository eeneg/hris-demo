<template>
    <div class="modal fade" id="jd-form-modal-div" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header modal-border">
                    <h5 class="modal-title"><strong>Job Description</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="exitModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off" @submit.prevent="createRecord()" v-if="is_edit">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label for="add_position" style="margin: 0;font-weight: normal;">Department: <b>{{ details.department }}</b></label><br>
                                    <label for="add_position" style="margin: 0;font-weight: normal;">Position: <b>{{ details.position }}</b></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <vue-editor v-model="form.description" :editorOptions="{placeholder: 'Enter job description here...'}"></vue-editor>
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
                <div v-else>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label for="add_position" style="margin: 0;font-weight: normal;">Department: <b>{{ details.department }}</b></label><br>
                                    <label for="add_position" style="margin: 0;font-weight: normal;">Position: <b>{{ details.position }}</b></label><br>
                                    <label for="add_position" style="margin: 0;font-weight: normal;">Job Description:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div v-html="form.description"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-foote modal-border" style="display: flow-root;padding: 6px 10px;">
                        <button @click="switch_to_edit" type="button" class="btn btn-primary" style="float: left;" :disabled="loading">Edit Record</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { VueEditor } from "vue2-editor/dist/vue2-editor.core.js";

    export default {
        data() {
            return {
                loading: false,
                is_edit: false,
                form: new Form( {
                    'id': '',
                    'plantilla_content_id': '',
                    'description': '',
                }),
            }
        },
        components: {
            'vue-editor': VueEditor,
            // draggable
        },
        props: {
            foredit: Object,
            details: Object,
            plantilla_content_id: String,
        },
        computed: {

        },
        watch: {
            foredit: function(newData) {
                let data = newData.data
                if (data.id) {
                    this.form.id = data.id
                    this.form.plantilla_content_id = data.plantilla_content_id
                    this.form.description = data.description
                } else {
                    this.form = new Form( {
                        'id': '',
                        'plantilla_content_id': this.plantilla_content_id,
                        'description': '',
                    })
                    this.is_edit = true
                }
            },
        },
        methods: {
            switch_to_edit() {
                this.is_edit = true
            },
            createRecord() {
                this.$Progress.start();
                this.loading = true;
                if (this.form.id == '') {
                    this.form.post('api/jobdescription')
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Record added successfully',
                            })
                            this.$emit('exit', 'sync');
                            this.$Progress.finish();
                            this.loading = false;
                            $('#jd-form-modal-div').modal('hide');
                        })
                        .catch(error => {
                            this.$Progress.fail();
                            console.log(error.response.data.message);
                            this.loading = false;
                        });
                } else {
                    this.form.put('api/jobdescription/' + this.form.id)
                        .then(() => {
                            toast.fire({
                                icon: 'success',
                                title: 'Record updated successfully'
                            });
                            this.$emit('exit', 'sync');
                            this.$Progress.finish();
                            this.loading = false;
                            $('#jd-form-modal-div').modal('hide');
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