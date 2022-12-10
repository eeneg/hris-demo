<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>NOSA</h2>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    
                })
            }
        },
        methods: {
            
        },
        mounted() {
            // console.log('Component mounted.')
        },
        created() {
            this.$Progress.start();

            this.$Progress.finish();
        }
    }
</script>
