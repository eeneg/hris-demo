
<template>
    <div class="row justify-content-center" style="min-height: 100vh;">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">

                    <div class="row mt-1">
                        <div class="col-md-6">
                            <h2>Leave Credits</h2>
                            <small style="margin-left: 2px;">Subtitle Subtitle Subtitle Subtitle Subtitle Subtitle</small>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="row mt-1">
                        <div class="col-md-5">
                            <v-select @input="get_leave_info(false)" class="form-control form-control-border border-width-2" v-model="selected_employee" placeholder="Select Employee" :options="employees" label="name"
                            :reduce="employees => employees"></v-select>
                        </div>
                        <div class="col-md-7">
                            <div class="float-right" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-warning" :disabled="selected_employee == null" @click="print_leave_card"><i class="fas fa-print"></i> Print</button>
                                <button type="button" class="btn btn-primary" :disabled="selected_employee == null" @click="[edit_mode = true, edited = true]"><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" class="btn btn-success" :disabled="edit_mode == false" @click="submit_leave(false)"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1" v-if="selected_employee !== null">
                        <div class="col-md-6 p-2" v-for="(data, index) in leave_credit" :key="data.id">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    {{data.title}}
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Balance: {{data.balance}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-md-12 tableFixHead">
                            <table class="table table-borderless text-center" v-if="selected_employee !== null">
                                <thead>
                                    <tr>
                                        <th rowspan="2" colspan="1">#</th>
                                        <th rowspan="2" colspan="1">
                                            Period
                                        </th>
                                        <th rowspan="2" colspan="1">
                                            Particulars
                                        </th>
                                        <th rowspan="1" colspan="4">
                                            Vacation Leave
                                        </th>
                                        <th rowspan="1" colspan="4" >
                                            Sick Leave
                                        </th>
                                        <th rowspan="2" colspan="1" >
                                            Remarks
                                        </th>
                                        <th rowspan="2" colspan="1" v-if="edit_mode">Action</th>
                                    </tr>
                                    <tr>
                                        <th>EARNED</th>
                                        <th>Absence undertime w/ pay</th>
                                        <th>Absence undertime w/o pay</th>
                                        <th>BALANCE</th>
                                        <th>EARNED</th>
                                        <th>Absence undertime w/ pay</th>
                                        <th>Absence undertime w/o pay</th>
                                        <th>BALANCE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in leave_summary" :key="data.id" style="width: 100%">
                                        <td class="p-0"><input class="form-control p-0 text-center" type="text" :value="index+1" style="border-radius: 0; width: 33px" disabled></td>
                                        <td class='p-0'><input :disabled="edit_mode == false"  class="form-control p-0" type="text" id="period" v-model="leave_summary[index].period" style="border-radius: 0;"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="particulars" v-model="leave_summary[index].particulars" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" v-on:keyup.enter="press_enter(index, 'vl_earned', 'vl', $event)" v-on:blur="calculate_balance(index, 'vl_earned', 'vl')" v-on:focus="save_old_value(index, 'vl_earned')" id="vl_earned" v-model="leave_summary[index].vl_earned" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" v-on:keyup.enter="press_enter(index, 'vl_withpay', 'vl',$event)" v-on:blur="calculate_balance(index, 'vl_withpay', 'vl')" v-on:focus="save_old_value(index, 'vl_withpay')" id="vl_withpay" v-model="leave_summary[index].vl_withpay" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="vl_withoutpay" v-model="leave_summary[index].vl_withoutpay" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="vl_balance" v-model="leave_summary[index].vl_balance" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" v-on:keyup.enter="press_enter(index, 'sl_earned', 'sl',$event)" v-on:blur="calculate_balance(index, 'sl_earned', 'sl')" v-on:focus="save_old_value(index, 'sl_earned')" id="sl_earned" v-model="leave_summary[index].sl_earned" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" v-on:keyup.enter="press_enter(index, 'sl_withpay', 'sl',$event)" v-on:blur="calculate_balance(index, 'sl_withpay', 'sl')" v-on:focus="save_old_value(index, 'sl_withpay')" id="sl_withpay" v-model="leave_summary[index].sl_withpay" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="psl_withoutpayeriod" v-model="leave_summary[index].sl_withoutpay" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="sl_balance" v-model="leave_summary[index].sl_balance" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="remarks" v-model="leave_summary[index].remarks" style="border-radius: 0"></td>
                                        <td class='p-0' v-if="edit_mode">
                                            <div class="" style="display:inline-flex">
                                                <button type="button" class="btn d-inline btn-primary" style="border-radius: 0" @click="add_leave_data(index)"><i class="fas fa-plus"></i></button>
                                                <button type="button" class="btn d-inline btn-danger" style="border-radius: 0" @click="delete_leave_data(index)"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="pdfModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Print Leave Card</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="pdf-viewer">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
        </div>

    </div>
</template>

<style>
    .tableFixHead {
        overflow-y: auto;
        max-height: 55vh;
    }
    .tableFixHead thead {
        position: sticky;
        top: 0;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 8px 16px;
        border: none;
    }
    th {
        background: #eee;
    }
</style>

<script>
import axios from 'axios'
    export default {
        data() {
            return {
                selected_employee: null,
                selected_summary: [],
                edit_mode: false,
                disable: true,
                edited: false,
                employees: [],
                leave_credit: [],
                leave_summary: [],
                form: [],
                input_history: null,
                running: false
            }
        },
        components: {

        },
        beforeRouteLeave (to, from , next) {
            if(this.edited)
            {
                const answer = window.confirm('Do you really want to leave? you have unsaved changes!')
                if (answer) {
                    next()
                } else {
                    next(false)
                }
            }else{
                next()
            }
        },
        beforeRouteUpdate()
        {
            window.confirm('Do you really want to leave? you have unsaved changes!')
        },
        computed: {
            leave_summary_length: function()
            {
                return this.summary.length
            }

        },
        watch: {
            leave_summary: {
                handler: function(){
                    if(this.leave_summary.length == 0)
                    {
                        this.add_leave_data()
                    }
                },
                deep: true
            }
        },
        methods: {

            get_employees: function(){

                axios.get('api/leavecredits')
                .then(({data}) => {
                    this.employees = data.data
                }).catch(e => {
                    console.log(e)
                })
            },

            get_leave_info: function(edit){

                if(this.selected_employee !== null)
                {
                    this.$Progress.start()
                    axios.get('api/leavecredits/'+this.selected_employee.id)
                    .then(({data}) => {

                        this.leave_summary = data.summary

                        this.leave_credit = data.credit

                        this.$Progress.finish()

                        if(data.length == 0 && this.selected_employee.id !== null)
                        {
                            this.add_leave_data(-1)
                        }
                    })
                    .catch(e => {
                        console.log(e)
                    })
                }

            },

            submit_leave: function(delete_save)
            {

                if(delete_save == false)
                {
                    Swal.fire({
                        title: '<strong>Saving...</strong>',
                        html: 'Dont <u>reload</u> or <u>close</u> the application ...',
                        icon: 'info',
                        willOpen () {
                            Swal.showLoading ()
                        },
                        didClose () {
                            Swal.hideLoading()
                        },
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            showConfirmButton: false
                    })
                }

                for (let x = 0; x < this.leave_summary.length; x++) {
                    this.leave_summary[x].sort = x
                }

                axios.post('api/leavecredits', {data: this.leave_summary, id: this.selected_employee.id})
                .then(e => {
                    this.edited = false
                    this.get_leave_info(true)
                    if(delete_save == false)
                    {
                        Swal.close()
                    }
                })
                .catch(e => {
                    console.log(e)
                })

            },

            add_leave_data(index)
            {

                this.leave_summary.splice(index+1, 0, {
                    'personal_information_id': this.selected_employee.id,
                    'particulars': '',
                    'period': '',
                    'vl_earned': 1.25,
                    'vl_withpay': 0,
                    'vl_balance': 1.25,
                    'vl_withoutpay': '',
                    'sl_earned': 1.25,
                    'sl_balance': 1.25,
                    'sl_withpay': 0,
                    'sl_withoutpay': '',
                    'remarks': '',
                    'sort': index+1
                })

                  if(this.leave_summary.length != 1)
                {
                    for(let x = index+1; x < this.leave_summary.length; x++)
                    {
                        this.leave_summary[x]['vl_balance'] = this.leave_summary[x-1]['vl_balance'] + 1.25
                        this.leave_summary[x]['sl_balance'] = this.leave_summary[x-1]['sl_balance'] + 1.25
                    }
                }


            },

            calculate_balance: function(index, field, leave_type)
            {

                if(this.running == false)
                {
                    let data = this.leave_summary

                    let x = index

                    if(this.input_history != data[index][field])
                    {
                        for (let index = x; index < data.length; index++) {

                            this.leave_summary[index][leave_type + '_balance'] = 0
                            this.leave_summary[index][leave_type + '_balance'] = data[index][leave_type + '_earned'] - data[index][leave_type + '_withpay'] + (this.leave_summary[index][leave_type + '_balance'] + this.leave_summary[index != 0 ? index-1 : index][leave_type + '_balance'])

                        }

                        this.input_history = null
                    }

                    this.running = true
                }
            },


            press_enter(index, field, leave_type, event)
            {
                this.calculate_balance(index, field, leave_type)
                event.target.blur()

                console.log('1')
            },

            save_old_value(index, field)
            {
                this.running = false
                this.input_history = this.leave_summary[index][field]
            },

            delete_leave_data: _.debounce(function(index)
            {

                var id = this.leave_summary[index].id

                var length = this.leave_summary.length

                if(id)
                {
                    Swal.fire({
                    title: 'Delete and Save Leave Summary?',
                    text: "You cannot revert this!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                        }).then((result) => {
                        if(result.isDismissed == true)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Cancelled'
                            });
                        }else{

                            this.$Progress.start()

                            Swal.fire({
                                title: '<strong>Deleting...</strong>',
                                html: 'Dont <u>reload</u> or <u>close</u> the application ...',
                                icon: 'info',
                                willOpen () {
                                    Swal.showLoading ()
                                },
                                didClose () {
                                    Swal.hideLoading()
                                },
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    showConfirmButton: false
                            })

                            this.decrease_balance(index)
                            axios.delete('api/leavecredits/'+this.leave_summary[index].id)
                            .then(e => {
                                this.leave_summary.splice(index, 1)
                                this.submit_leave(true)
                                this.$Progress.finish()
                                Swal.close()
                                toast.fire({
                                    icon: 'success',
                                    title: 'Deleted'
                                });
                            })
                            .catch(e => {
                                Swal.fire(
                                    'Oops...',
                                    'Failed to Delete Item',
                                    'error'
                                )
                                this.$Progress.finish()
                                console.log(e)
                            })

                        }
                    })
                }else{
                    this.decrease_balance(index)
                    this.leave_summary.splice(index, 1)
                }

            }, 300),

            decrease_balance: function(index)
            {

                let vl_balance = this.leave_summary[index]['vl_earned'] - this.leave_summary[index]['vl_withpay']

                let sl_balance = this.leave_summary[index]['sl_earned'] - this.leave_summary[index]['sl_withpay']

                for(let x = index; x < this.leave_summary.length; x++)
                {
                    this.leave_summary[x]['vl_balance'] = this.leave_summary[x]['vl_balance'] - vl_balance
                    this.leave_summary[x]['sl_balance'] = this.leave_summary[x]['sl_balance'] - sl_balance
                }

            },

            print_leave_card(){

                if(this.edited && this.leave_summary.length == 0)
                {
                    toast.fire({
                        icon: 'error',
                        title: 'Save Changes First'
                    })
                }else{
                    Swal.fire({
                        title: '<strong>Generating Leave Card</strong>',
                        html: 'Dont <u>reload</u> or <u>close</u> the application ...',
                        icon: 'info',
                        willOpen () {
                            Swal.showLoading ()
                        },
                        didClose () {
                            Swal.hideLoading()
                        },
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            showConfirmButton: false
                    })

                    axios.post('generateleavecard', {id: this.selected_employee.id})
                    .then(response => {
                        let options = {
                            height: screen.height * 0.65 + 'px',
                            page: '1'
                        };
                        Swal.close()
                        $('#summaryModal').modal('hide');
                        $('#pdfModal').modal('show');
                        PDFObject.embed("/storage/employee_leave_card/" + response.data.title, "#pdf-viewer", options);
                    })
                    .catch(error => {
                        Swal.close()
                        Swal.fire(
                            'Failed',
                            'Something went wrong',
                            'warning'
                        )
                        console.log(error);
                    });
                }

            },

        },
        mounted() {
            console.log('Component mounted.')
            this.get_employees()
        }
    }
</script>
