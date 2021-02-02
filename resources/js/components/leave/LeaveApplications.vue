<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Leave Applications</h2>
                    <small style="margin-left: 2px;">Subtitle Subtitle Subtitle Subtitle Subtitle Subtitle</small>
                    <div class="row mt-1">
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input v-model="search" @keyup.prevent="searchit" type="text" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <router-link class="btn btn-primary float-right" to="/leave-form">New Application</router-link>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 650px;">
                    <!-- <table class="table table-striped text-nowrap employees-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position <span style="font-weight: 100;">({{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.year }})</span></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="employee in employees.data" :key="employee.id">
                                <td style="width: calc(100%-150px);">
                                    <img style="width: 38px;height: 38px;" class="img-circle mr-2" :src="getAvatar(employee.picture)" alt="User Avatar">
                                    <div style="display: inline-block;vertical-align: middle;line-height: 1.2rem;height: 35px;">
                                        <span style="font-size: 1rem;">{{ employee.surname + ', ' + employee.firstname + ' ' + employee.nameextension + ' ' + employee.middlename }}</span>
                                        <br>
                                        <span style="font-size: 0.8rem;" class="text-muted"><i>{{ employee.status }}</i></span>
                                    </div>

                                </td>
                                <td>
                                    <p style="margin: 0;line-height: 1.2rem;" v-if="getPlantillaDetails(employee)">{{ getPlantillaDetails(employee).designation + (getPlantillaDetails(employee).sg ? ' (SG-' + getPlantillaDetails(employee).sg + ')' : '')  }}</p>
                                    <p style="margin: 0;line-height: 1.2rem;" class="text-muted" v-if="getPlantillaDetails(employee)">{{ getPlantillaDetails(employee).department }}</p>
                                </td>
                                <td style="width: 150px;">
                                    <div class="btn-group" style="float:right;">
                                        <button type="button" class="btn btn-sm btn-info">Action</button>
                                        <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" @click.prevent="viewProfileModal(employee.id)" href="#">View Profile</a>
                                                <a class="dropdown-item" href="#">Basic Information</a>
                                                <a class="dropdown-item" href="#">Latest Plantilla Record</a>
                                                <router-link class="dropdown-item" :to="{path: '/employees-pds', query: {id: employee.id}}" href="#">Edit Information</router-link>
                                                <div v-if="$gate.isAdministratorORAuthor()" class="dropdown-divider"></div>
                                                <a v-if="$gate.isAdministratorORAuthor()" class="dropdown-item" @click.prevent="generateBarcode(employee)" href="#">Generate Barcode</a>
                                                <a v-if="$gate.isAdministratorORAuthor()" class="dropdown-item" href="#" @click.prevent="generateIDModal(employee)" data-toggle="modal" data-target="#exampleModal">Generate ID</a>
                                            </div>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table> -->
                </div>
                <!-- <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="employees" @pagination-change-page="getResults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Showing {{ employees.meta && employees.meta.from | validateCount }} to {{ employees.meta && employees.meta.to | validateCount }} of {{ employees.meta && employees.meta.total }} records</span>
                </div> -->
            </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: '',
                form: new Form({

                })
            }
        },
        methods: {
            searchit: _.debounce(function(){

            }, 400)
        },
        created() {
            this.$Progress.start();
            
            this.$Progress.finish();
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
