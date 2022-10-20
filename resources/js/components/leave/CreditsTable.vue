<template>
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
                <th class="text-success">BALANCE</th>
                <th class="text-danger">Absence undertime w/o pay</th>
                <th>EARNED</th>
                <th>Absence undertime w/ pay</th>
                <th class="text-success">BALANCE</th>
                <th class="text-danger">Absence undertime w/o pay</th>
            </tr>
        </thead>
        <tbody>
            <tr :class="{'border border-success': data.newly_added}" v-for="(data, index) in leave_summary" :key="data.id" style="width: 100%;">
                <td class="p-0">
                    <input
                        class="form-control p-0 text-center"
                        type="text"
                        :value="index+1"
                        style="width: 33px;"
                        disabled
                    >
                </td>
                <td class='p-0' v-bind:class="{'border border-danger': leave_summary[index].period == null || leave_summary[index].period.mode == null}">

                    <input
                        :disabled="edit_mode == false"
                        class="form-control p-0"
                        v-on:focus="period_input(index)"
                        type="text"
                        id="period"
                        :value="format_period(leave_summary[index].period)"
                        style="border-radius: 0; min-width: 300px;"
                        required
                    >

                </td>
                <td class='p-0'>
                    <input
                        :disabled="edit_mode == false"
                        v-on:focus="particulars_input(index, false)"
                        class="form-control p-0" id="particulars"
                        :value="format_particulars(leave_summary[index].particulars)"
                        style="border-radius: 0"
                    >
                </td>
                <td class='p-0'>
                    <input
                        type="number"
                        :disabled="edit_mode == false"
                        class="form-control p-0"
                        v-on:keyup.enter="press_enter(index, 'vl_earned', 'vl', $event)"
                        v-on:blur="calculate_balance(index, 'vl_earned', 'vl')"
                        v-on:focus="save_old_value(index, 'vl_earned')"
                        id="vl_earned"
                        v-model.lazy="leave_summary[index].vl_earned"
                        style="border-radius: 0"
                    >
                </td>
                <td class='p-0'>
                    <input
                        type="number"
                        :disabled="edit_mode == false"
                        class="form-control p-0"
                        v-on:keyup.enter="press_enter(index, 'vl_withpay', 'vl',$event)"
                        v-on:blur="calculate_balance(index, 'vl_withpay', 'vl')"
                        v-on:focus="save_old_value(index, 'vl_withpay')"
                        id="vl_withpay"
                        v-model.lazy="leave_summary[index].vl_withpay"
                        style="border-radius: 0"
                    >
                </td>
                <td class='p-0'>
                    <input
                        type="number"
                        class="form-control p-0"
                        id="vl_balance"
                        v-model.lazy="leave_summary[index].vl_balance"
                        style="border-radius: 0"
                        disabled
                    >
                </td>
                <td class='p-0'>
                    <input
                        type="number"
                        :disabled="edit_mode == false"
                        class="form-control p-0"
                        id="vl_withoutpay"
                        v-model.lazy="leave_summary[index].vl_withoutpay"
                        style="border-radius: 0"
                    >
                </td>
                <td class='p-0'>
                    <input
                        type="number"
                        :disabled="edit_mode == false"
                        class="form-control p-0"
                        v-on:keyup.enter="press_enter(index, 'sl_earned', 'sl',$event)"
                        v-on:blur="calculate_balance(index, 'sl_earned', 'sl')"
                        v-on:focus="save_old_value(index, 'sl_earned')"
                        id="sl_earned"
                        v-model.lazy="leave_summary[index].sl_earned"
                        style="border-radius: 0"
                    >
                </td>
                <td class='p-0'>
                    <input
                        type="number"
                        :disabled="edit_mode == false"
                        class="form-control p-0"
                        v-on:keyup.enter="press_enter(index, 'sl_withpay', 'sl',$event)"
                        v-on:blur="calculate_balance(index, 'sl_withpay', 'sl')"
                        v-on:focus="save_old_value(index, 'sl_withpay')"
                        id="sl_withpay"
                        v-model.lazy="leave_summary[index].sl_withpay"
                        style="border-radius: 0"
                    >
                </td>
                <td class='p-0'>
                    <input
                        type="number"
                        class="form-control p-0"
                        id="sl_balance"
                        v-model.lazy="leave_summary[index].sl_balance"
                        style="border-radius: 0"
                        disabled
                    >
                </td>
                <td class='p-0'>
                    <input
                        type="number"
                        :disabled="edit_mode == false"
                        class="form-control p-0"
                        id="psl_withoutpayeriod"
                        v-model.lazy="leave_summary[index].sl_withoutpay"
                        style="border-radius: 0"
                    >
                </td>
                <td class='p-0'>
                    <input
                        :disabled="edit_mode == false"
                        class="form-control p-0"
                        id="remarks"
                        v-model="leave_summary[index].remarks"
                        style="border-radius: 0; min-width: 200px;"
                    >
                </td>
                <td class='p-0' v-if="edit_mode">
                    <div class="" style="display:inline-flex">
                        <button
                            type="button"
                            class="btn d-inline btn-primary"
                            style="border-radius: 0"
                            @click="add_leave_data(index)">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button
                            type="button"
                            class="btn d-inline btn-danger"
                            style="border-radius: 0"
                            @click="delete_leave_data(index)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {

    props: ['leave_summary', 'selected_employee', 'edit_mode'],
    data() {
        return {

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
    methods:{

        period_input: function(index)
        {
            let data = this.leave_summary[index].period
            this.$emit('period_input', index)

            if(data == null || data.mode == null && data.data == null)
            {
                this.options = null
                this.period_date = null
                this.range = {
                        start: null,
                        end: null,
                    }
                this.dates = []
            }else if(data != null && data.mode == 1){
                this.options = 1
                this.period_date = data.data
            }else if(data != null && data.mode == 2){
                this.options = 2
                this.range = data.data
            }else if(data != null && data.mode == 3){
                this.options = 3
                this.dates = data.data
            }else if(data != null && data.mode == 4){
                this.options = 4
                this.period_month = data.data
            }

            this.validation = true

            $("#periodModal").modal('show');
        },

        particulars_input: function(index)
        {
            $("#exampleModal").modal('show');
            this.$emit('particulars_input', index)
            this.particulars = this.leave_summary[index].particulars ??
            {
                leave_type: "",
                days: null,
                hours: null,
                mins: null
            }
        },

        calculate_balance: _.debounce(function(index, field, leave_type)
        {
            console.log(1)

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
        }, 100),


        press_enter(index, field, leave_type, event)
        {
            console.log(3)
            this.calculate_balance(index, field, leave_type)
            event.target.blur()
        },

        save_old_value(index, field)
        {
            console.log(2)
            this.running = false
            this.input_history = this.leave_summary[index][field]
        },

        add_leave_data(index)
        {

            this.leave_summary.splice(index+1, 0, {
                'personal_information_id': this.selected_employee.id,
                'period': {
                    mode: null,
                    data: null
                },
                'particulars': {
                    leave_type: '',
                    count: null,
                    days: null,
                    hours: null,
                    mins: null
                },
                'vl_earned': 1.25,
                'vl_withpay': 0,
                'vl_balance': 1.25,
                'vl_withoutpay': '',
                'sl_earned': 1.25,
                'sl_balance': 1.25,
                'sl_withpay': 0,
                'sl_withoutpay': '',
                'remarks': '',
                'sort': index+1,
                'newly_added': true
            })

            this.check_balance(index)

        },

        check_balance(index){

            let prev_slbalance = 0

            let prev_vlbalance = 0

            if(this.leave_summary.length != 1)
            {
                for(let x = index+1; x < this.leave_summary.length; x++)
                {

                    if(this.leave_summary[x-1]['vl_balance'] == 0 || this.leave_summary[x-1]['vl_balance'] == null)
                    {
                        let index = x-1

                        do{
                            prev_vlbalance = this.leave_summary[index]['vl_balance']
                            index--
                        }while(prev_vlbalance == 0 || prev_vlbalance == null && index != -1)

                        if(this.leave_summary[x]['particulars']['leave_type'] != 'SPL')
                        {
                            this.leave_summary[x]['vl_balance'] = prev_vlbalance + this.leave_summary[x]['vl_earned'] - this.leave_summary[x]['vl_withpay']
                        }

                    }else{

                        if(this.leave_summary[x]['particulars']['leave_type'] != 'SPL')
                        {
                            this.leave_summary[x]['vl_balance'] = this.leave_summary[x-1]['vl_balance'] + this.leave_summary[x]['vl_earned'] - this.leave_summary[x]['vl_withpay']
                        }

                    }

                    if(this.leave_summary[x-1]['sl_balance'] == 0 || this.leave_summary[x-1]['sl_balance'] == null)
                    {
                        let index = x-1

                        do{
                            prev_slbalance = this.leave_summary[index]['sl_balance']
                            index--
                        }while(prev_slbalance == 0 || prev_slbalance == null && index != -1)

                        if(this.leave_summary[x]['particulars']['leave_type'] != 'SPL')
                        {
                            this.leave_summary[x]['sl_balance'] = prev_slbalance + this.leave_summary[x]['sl_balance'] - this.leave_summary[x]['vl_withpay']
                        }

                    }else{

                        if(this.leave_summary[x]['particulars']['leave_type'] != 'SPL')
                        {
                            this.leave_summary[x]['sl_balance'] = this.leave_summary[x-1]['sl_balance'] + this.leave_summary[x]['vl_earned'] - this.leave_summary[x]['vl_withpay']
                        }

                    }
                    // this.formatNumber(this.leave_summary[x]['sl_balance'])
                }
            }

        },

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

        delete_leave_data: _.debounce(function(index)
        {

            var id = this.leave_summary[index].id

            var length = this.leave_summary.length

            if(id)
            {
                Swal.fire({
                title: 'Delete and Save Leave Summary?',
                text: "This is saved data!! You cannot revert this!!",
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
                            this.$parent.submit_leave(true)
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

        format_particulars: function(particulars)
        {
            return particulars?  `${particulars?.leave_type == 'Tardy' ? 'T' :  particulars?.leave_type == 'Undertime' ? 'UT' : particulars?.leave_type == null ? '' : particulars?.leave_type}${particulars?.leave_type == 'Tardy' || particulars?.leave_type == 'Undertime' || particulars?.leave_type == 'UA' || particulars?.leave_type == 'AWOL' ? particulars?.count+'x' : ''} ${particulars?.days ?? 0}-${particulars?.hours ?? 0}-${particulars?.mins ?? 0}` : '';
        },

        format_period: function(data)
        {
            if(data != null)
            {
                if(data.mode == 1){
                    return moment(data.data).format("MMM DD, YYYY")
                }else if(data.mode == 2){
                    return moment(data.data.start).format("MMM DD, YYYY") + ' to ' +  moment(data.data.end).format("MMM DD, YYYY")

                }else if(data.mode == 3){

                    let dates = data.data
                        .filter(function(el){
                            return el.date != null
                        })
                        .map(e => moment(e.date).format('YYYY-MM-DD'))
                        .sort()
                        .map(function (date) {
                            return {
                                month: moment(date).format('YYYY-MM'),
                                date: moment(date).format('DD')
                            }
                        })

                    let formatted = _.map(_.groupBy(dates, 'month'), function (dates) {
                        return moment(_.head(dates).month).format('MMM') + ' ' + dates.map(e => e.date).join(',') + ' ' + moment(_.head(dates).month).format('YYYY')
                    })

                    return formatted.join(' — ')
                }else if(data.mode == 4){
                    return moment(data.data).format('MMMM YYYY')
                }
            }
        },
    },
    mounted(){

    }
}
</script>
