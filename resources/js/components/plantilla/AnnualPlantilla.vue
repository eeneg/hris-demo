<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Annual Plantilla {{ this.$parent.settings.plantilla }}</h2>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Select Department</label>
                            <select class="custom-select">
                                <option v-for="department in departments" :key="department.id">{{ department.description }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped text-nowrap plantilla-table">
                        <thead>
                            <tr>
                                <th colspan="2" rowspan="2" style="font-size: 1rem;">Item No.</th>
                                <th rowspan="3" style="font-size: 1rem;">Position Title</th>
                                <th rowspan="3" style="font-size: 1rem;">Name of Incumbent</th>
                                <th colspan="2" style="font-size: 1rem;">Current Year Authorized</th>
                                <th colspan="2" style="font-size: 1rem;">Budget Year Proposed</th>
                                <th rowspan="3" style="font-size: 1rem;">Increase / Decrease</th>
                            </tr>
                            <tr>
                                <th colspan="2" style="font-weight: normal;">Rate/Annum Previous</th>
                                <th colspan="2" style="font-weight: normal;">Rate/Annum {{ this.$parent.settings.plantilla }}</th>
                            </tr>
                            <tr>
                                <th style="font-weight: normal;">Old</th>
                                <th style="font-weight: normal;">New</th>
                                <th style="font-weight: normal;">Salary Grade/Step</th>
                                <th style="font-weight: normal;">Amount</th>
                                <th style="font-weight: normal;">Salary Grade/Step</th>
                                <th style="font-weight: normal;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                departments: {}
            }
        },
        methods: {
            loadDepartments() {
                axios.get('api/department')
                    .then(({data}) => {
                        this.departments = data.data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            loadContents() {

            }
        },
        created() {
            this.$Progress.start();

            this.loadDepartments();
            this.loadContents();

            this.$Progress.finish();
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
