<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Annual Plantilla</h2>
                </div>

                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        methods: {
            loadContents() {

            }
        },
        created() {
            this.$Progress.start();

            this.loadContents();

            this.$Progress.finish();
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
