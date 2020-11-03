<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="$gate.isOfficeUser()">
            <not-authorized></not-authorized>
        </div>
        <div class="col-md-12" v-if="!$gate.isOfficeUser()">
            <div class="card">
                <div class="card-header">Requests</div>

                <div class="card-body">
                    I'm an example component.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
