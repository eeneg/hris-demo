<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Leave Card</h2>
                    <small style="margin-left: 2px;">Allows employees to view their leave card.</small>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-inline-block" style="width: 12rem;">
                                        {{ 'Vacation Leave Balance:' }}
                                    </div>
                                    <div class="d-inline-block">
                                        {{ leaveCard.vl_balance?.balance ?? 0 }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-inline-block" style="width: 12rem;">
                                        {{ 'Sick Leave Balance:' }}
                                    </div>
                                    <div class="d-inline-block">
                                        {{ leaveCard.sl_balance?.balance ?? 0  }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="tableFixHead mt-4" ref="credit_table">
                                <table class="table text-center">
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
                                            <th rowspan="2" colspan="1" class="">
                                                Remarks
                                            </th>
                                            <th rowspan="2" colspan="1" >
                                                FT
                                            </th>
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
                                        <tr class="" :class="{'tr-color' : index % 2 != 0}" v-for="(data, index) in leaveCard.leave_card" :key="data.id" style="width: 100%;">
                                            <td class='p-2'>
                                                <!-- sort -->
                                                {{ data.sort + 1 }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- period -->
                                                 {{ format_period(data.period) }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- particulars -->
                                                 {{ format_particulars(data.particulars) }}
                                            </td>
                                            <td class='p-2' :class="{'text-primary': data.vl_earned != 0 && data.vl_earned != null}">
                                                <!-- vl earned -->
                                                 {{ data.vl_earned }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- vl absence undertime w/ pay -->
                                                {{ data.vl_withpay }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- vl balance -->
                                                {{ data.vl_balance }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- vl absence undertime w/o pay -->
                                                {{ data.vl_withoutpay }}
                                            </td>
                                            <td class='p-2' :class="{'text-primary': data.sl_earned != 0 && data.sl_earned != null}">
                                                <!-- sl earned -->
                                                {{ data.sl_earned }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- sl absence undertime w/ pay -->
                                                {{ data.sl_withpay }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- sl balance -->
                                                {{ data.sl_balance }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- sl absence undertime w/o pay -->
                                                {{ data.sl_withoutpay }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- remarks -->
                                                {{ data.remarks }}
                                            </td>
                                            <td class='p-2'>
                                                <!-- FT -->
                                                <i v-if="data.foreign_travel" class="fas fa-check"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <!-- footer -->
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios'
import { Toast } from 'bootstrap';
import moment from 'moment';

    export default {
        data() {
            return {
                leaveCard: {}
            }
        },
        computed: {

        },
        watch: {

        },

        methods:{

            getLeaveCard() {
                axios.get('/api/getEmployeeLeaveCard')
                    .then(response => {
                        this.leaveCard = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },

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

                        return formatted.join(' , ')
                    }else if(data.mode == 4){
                        return moment(data.data).format('MMMM YYYY')
                    }
                }
            }

        },

        created(){
        },
        mounted() {
            this.getLeaveCard();
            console.log('Component mounted.')
        }
    }
</script>
