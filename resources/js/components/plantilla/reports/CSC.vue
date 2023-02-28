<template>
    <div v-else class="col-md-12">
        <!-- Report -->
        <div class="row" id="csc_report" style="display: none;margin-top: -1.5rem !important;">
            <div class="col-md-12 csc_report">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h4 class="m-0">Republic of the Philippines</h4>
                        <h4 class="m-0 font-weight-bold">PROVINCE OF DAVAO DEL SUR</h4>
                        <h5 class="m-0">Matti, Digos City</h5>
                        <h4 class="m-0 font-weight-bold">Provincial Human Resource Management Office</h4>
                    </div>
                </div>
                <div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <h3 class="m-0"><b>Office:</b> qweasdasd</h3>
                            <h3 class="m-0"><b>Gender:</b> 123 qweasdcasdc</h3>
                            <h3 class="m-0"><b>Result count:</b> 213adasd23</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered m-0">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">1.</td>
                                        <td class="align-middle pt-1 pb-1">Edwin Rojo<small class="d-block">PGO-PICTO</small></td>
                                        <td class="align-middle pt-1 pb-1">lqwkjela lkdjalskdj lqjwelk j</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style type="text/css">
    @media print {
        body * { visibility: hidden !important; }
        body { -webkit-print-color-adjust: exact; }
        .csc_report * { 
            visibility: visible !important; 
        }
        .csc_report {  
            max-width: 100%; 
            flex: unset; 
            padding-top: 0px !important; 
        }
        .csc_report th { font-size: 1.275rem }
        .csc_report td { font-size: 1rem }
        .csc_report h3 { font-size: 1rem }
        .csc_report h4 { font-size: 1.5rem }
        .csc_report h5 { font-size: 1.275rem }
        #csc_report { 
            display: block !important;
            width: 43cm;
            height: 28.12cm;
        }
    }
</style>

<script>
    export default {
        data() {
            return {
                print_data: []
            }
        },
        filters: {
            get_year: (value) => {
                return moment(value).format('YYYY')
            },
            yesterday: (value) => {
                return moment(value).subtract(1, 'days').format('YYYY-MM-DD')
            }
        },
        watch: {

        },
        methods: {
            
        },
        mounted() {
            
        },
        created() {
            
        }
    }
</script>
