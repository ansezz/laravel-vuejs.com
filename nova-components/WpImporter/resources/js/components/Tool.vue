<template>
    <div>
        <heading class="mb-6">Wp Importer</heading>

        <card class="flex flex-col items-center justify-center" style="min-height: 300px">
            <h1 class=" text-4xl  font-light mb-6">
                Select you XML exported file from WordPress
            </h1>

            <form class="w-full max-w-sm" @submit.prevent="submitFile()">
                <div class="flex items-center border-b border-b-2 border-teal py-2" v-show="!loading">
                    <input
                            ref="file"
                            v-on:change="handleFileUpload()"
                            class="appearance-none bg-transparent border-none w-full text-grey-darker mr-3 py-1 px-2 leading-tight focus:outline-none"
                            type="file" aria-label="File xml">
                    <button
                            class="flex-no-shrink bg-teal hover:bg-teal-dark border-teal hover:border-teal-dark text-sm border-4  py-1 px-2 rounded"
                            type="submit">
                        Importer
                    </button>
                </div>
                <div class="flex items-center border-b border-b-2 border-teal py-2" v-show="loading">
                    <h1 class=" text-4xl  font-light mb-6">
                        Uploading in progress ..., Importing will be done in background check jobs.
                    </h1>
                </div>
                <div class="flex items-center border-b border-b-2 border-teal py-2" v-show="message">
                    <h1 class=" text-4xl  font-light mb-6">
                        {{message}}
                    </h1>
                </div>
            </form>

            <p class="text-white-50% text-lg">
                Export your wordpress posts
            </p>
        </card>
    </div>
</template>

<script>
    export default {
        mounted() {
            //
        },
        data() {
            return {
                file: '',
                message: '',
                loading: false,
            }
        },
        methods: {
            /*
              Submits the file to the server
            */
            submitFile() {
                let formData = new FormData();
                formData.append('file', this.file);
                this.loading = true;
                axios.post('/nova-vendor/wp-importer/upload',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                    .then(({data}) => {
                        this.message = data.message;
                        console.log(data);
                        console.log('SUCCESS!!');
                    })
                    .catch((error) => {
                        console.log(error)
                        console.log('FAILURE!!');
                    }).finally(() => {
                    this.loading = false;
                })
            },

            /*
              Handles a change on the file upload
            */
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            }
        }
    }
</script>

<style>
    /* Scoped Styles */
</style>
