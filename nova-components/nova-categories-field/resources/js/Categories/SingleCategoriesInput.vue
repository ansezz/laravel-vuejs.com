<template>
    <select
        v-if="loaded"
        class="w-full form-control form-select"
        :id="name"
        :value="categories[0]"
        @input="$emit('input', [$event.target.value])"
    >
        <option value="" selected disabled>
            {{ __('Choose an option') }}
        </option>
        <option
            v-for="category in availableCategories"
            :key="category"
            :value="category"
        >
            {{ category }}
        </option>
    </select>
</template>

<script>
    export default {
        props: ['categories', 'type', 'name', 'suggestionLimit'],

        model: {
            prop: 'categories',
        },

        data: () => ({
            loaded: false,
            availableCategories: [],
        }),

        mounted() {
            this.getAvailableCategories();
        },

        methods: {
            getAvailableCategories() {
                const queryString = this.type ? `filter[type]=${this.type}` : '';

                window.axios
                    .get(`/nova-vendor/ansezz/nova-categories-field?${queryString}`)
                    .then(response => {
                        this.availableCategories = response.data;

                        this.loaded = true;
                    });
            },
        },
    };
</script>
