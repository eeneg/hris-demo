<template>
    <div class="row justify-content-center">
        <div class="text-center col-md-12" v-if="!$gate.isAdministrator()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-6">
            <div class="card">
                <div>
                    <div class="py-0 card-header">
                        <div class="row">
                            <h3 class="my-3 d-inline-block col-12 col-xl-6">
                                Daily Time Record
                            </h3>
                            <div class="my-3 row gx-3 card-tools col-12 col-xl-6">
                                <div class="pl-1 col-6 input-group w-100">
                                    <input v-model="month" type="month" class="float-right form-control h-100" placeholder="Search">
                                </div>
                                <div class="pl-1 col-6 input-group w-100">
                                    <select v-model="period" class="custom-select">
                                        <option value="full">FULL</option>
                                        <option value="1st">1ST</option>
                                        <option value="2nd">2ND</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <v-select
                            v-model="employee"
                            :options="employees"
                            class="form-control form-control-border border-width-2"
                            placeholder="Select Employee"
                            label="name"
                        />
                    </div>
                </div>
                <div class="px-4 pt-0 pb-4 card-body">
                    <iframe title="DTR" hidden class="w-100" frameborder="0" scrolling="no" onload="this.style.height = this.contentWindow.document.documentElement.scrollHeight + 'px';"></iframe>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
const queryString = require('querystring');

export default ({

    data() {
        return {
            period: 'full',
            month: `${new Date().getFullYear()}-${new Date().getMonth() + 1 >= 10 ? new Date().getMonth() + 1 : '0' + (new Date().getMonth() + 1)}`,
            search: null,
            employee: {
                name: '',
                id: '',
            },
            employees: [],
            token: null,
            url: null,
            src: null,
        }
    },

    methods: {
        getDtr(employee) {
            const iframe = document.querySelector('iframe')

            const headers = new Headers();

            headers.append("Authorization", `Bearer ${this.token}`);

            this.src = fetch(`${this.url}?` + queryString.stringify({
                    "name[first]": employee.firstname,
                    "name[middle]": employee.middlename,
                    "name[last]": employee.surname,
                    "name[extension]": employee.nameextension,
                    period: this.period,
                    month: this.month,
            }), {
                cache: 'no-cache',
                method: 'GET',
                headers,
            }).then(r => r)
            .then(async function (response) {
                if (! response.ok) {
                    toast.fire({
                        icon: 'error',
                        title: `${employee.surname + ', ' + employee.firstname + ' ' + (employee.nameextension || '') + ' ' + (employee.middlename || '')} not found in the system.`,
                    });

                    iframe.removeAttribute("src")

                    iframe.setAttribute("hidden", true)

                    return;
                }

                iframe.setAttribute("src", URL.createObjectURL(await response.blob()))

                iframe.removeAttribute("hidden")

            }).catch(error => console.error(error))
        },
        async init() {
            this.employees = await axios.get('api/current-employees')
                .then(({data}) => data)
                .catch(error => console.error(error.response.data.message));

            axios.get('api/setting?token=true')
                .then(({ data }) => {
                    this.token = data.dtr_token
                    this.url = data.dtr_url
                })
                .catch(error => console.error(error.response.data.message));
        },
    },
    watch: {
        employee: {
            deep: true,
            handler(employee) {
                this.getDtr(employee)
            },
        },
        month() {
            this.getDtr(this.employee)
        },
        period() {
            this.getDtr(this.employee)
        }
    },
    mounted() {
        this.init();
    }
})
</script>
