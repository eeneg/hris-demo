<script setup>
import { reactive, ref, onMounted, watch } from 'vue'

const data = reactive({})
const step = ref(1)
const vacancies = ref({})
const query = reactive({
    search: '',
    office: '',
    except: '',
})

const form = new Form({
    closing_date: (new Date()).toLocaleDateString('en-CA'),
    name: '',
    office: '',
    position: '',
    address: '',
    vacancies: [],
})

const publishErrors = ref({})

const searchVacancies = async () => {
    vacancies.value = await axios.get('api/vacanciesforpublication', { params: { ...query } }).then(e => e.data)
}

const clearSelection = () => form.vacancies = []

const openAddPublicationsModal = async () => {
    query.search = ''

    step.value = 1

    clearSelection()

    await searchVacancies()

    $('#addPublicationsModal').modal('toggle')
}

const publish = async () => {
    const file = await form.post('api/publishvacancies')
        .catch(e => console.log(e.response.data.errors))
        .then(e => e.data)

    const href = URL.createObjectURL(file)

    const link = document.createElement('a')

    link.href = href

    link.setAttribute('download', 'publication.xlsx')

    document.body.appendChild(link)

    link.click()

    document.body.removeChild(link);
    URL.revokeObjectURL(href);
}

onMounted(async () => Object.assign(data, await axios.get('api/plantillapublications').then(e => e.data)))

watch(() => query.office, () => searchVacancies())
</script>

<template>
<div>
    <button class="btn btn-primary" @click="openAddPublicationsModal">
        Add
    </button>

    <div id="addPublicationsModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Publication for Vacant vacancies</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="step == 1" class="row px-4">
                        <div class="form-group col-6" style="padding-left: 0; padding-right: 0.75em; margin-bottom: 0;">
                            <label style="margin: 0">Search</label>
                            <div class="input-group mb-2">
                                <input @keyup.enter="searchVacancies" v-model="query.search" type="text" class="form-control">
                                <div @click="searchVacancies" class="input-group-append" style="cursor: pointer;">
                                    <span class="input-group-text">
                                        <i class="fas fa-search" ></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-6" style="padding-left: 0.75em; padding-right: 0; margin-bottom: 0;">
                            <label style="margin: 0">Office</label>
                            <div class="input-group mb-2">
                                <select v-model="query.office" class="custom-select">
                                    <option :value="null"></option>
                                    <option v-for="department in data.departments" :value="department.id">{{ department.title }}</option>
                                </select>
                                <div @click="query.office = ''" class="input-group-append" style="cursor: pointer;">
                                    <span class="input-group-text">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" v-for="vacancy in vacancies" :key="vacancy.id" style="padding: 0; height: 23.05px!important;">
                            <label class="m-0" style="cursor: pointer; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <input v-model="form.vacancies" :value="vacancy.id" type="checkbox">
                                <span style="font-weight: normal;">{{ `${vacancy.position.title} [${vacancy.new_number ?? vacancy.old_number}] — ${vacancy.position.department.title}` }}</span>
                            </label>
                        </div>
                    </div>

                    <div v-else-if="step == 2" class="row px-4">
                        <div class="form-group col-12 px-0">
                            <label class="m-0">Name</label>
                            <input v-model="form.name" type="text" class="form-control">
                        </div>
                        <div class="form-group col-12 px-0">
                            <label class="m-0">Office</label>
                            <input v-model="form.office" type="text" class="form-control">
                        </div>
                        <div class="form-group col-12 px-0">
                            <label class="m-0">Position</label>
                            <input v-model="form.position" type="text" class="form-control">
                        </div>
                        <div class="form-group col-12 px-0">
                            <label class="m-0">Address</label>
                            <input v-model="form.address" type="text" class="form-control">
                            <has-error :form="form" field="address"></has-error>
                        </div>
                        <div class="form-group col-12 px-0">
                            <label class="m-0">Closing Date</label>
                            <input v-model="form.closing_date" type="date" class="form-control">
                            <has-error :form="form" field="closing_date"></has-error>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: end;">
                    <div>
                        <button @click="step = step == 1 ? 2 : 1" type="button" class="btn btn-primary" :disabled="form.busy">
                            <template v-if="step == 1">
                                Next
                            </template>
                            <template v-else-if="step == 2">
                                Back
                            </template>
                        </button>
                        <button @click="step == 1 ? clearSelection() : publish()" type="button" class="btn" :class="[step == 1 ? 'btn-secondary' : 'btn-primary']" :disabled="form.busy">
                            <template v-if="step == 1">
                                Clear
                            </template>
                            <template v-else-if="step == 2">
                                Publish
                            </template>
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" :disabled="form.busy">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
