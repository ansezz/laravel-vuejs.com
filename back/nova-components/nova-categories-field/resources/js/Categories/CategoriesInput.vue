<script>
    export default {
        props: {
            categories: {required: true},
            type: {default: null},
            suggestionLimit: {required: true},
            removeOnBackspace: {default: true},
        },

        model: {
            prop: 'categories',
        },

        data() {
            return {
                input: '',
                suggestions: [],
            };
        },

        created() {
            this.throttledGetSuggested = window._.throttle(this.getSuggested, 400);
        },

        computed: {
            newCategory() {
                return this.input.trim();
            },
        },

        methods: {
            addCategory() {
                if (this.newCategory.length === 0 || this.categories.includes(this.newCategory)) {
                    return;
                }

                this.$emit('input', [...this.categories, this.newCategory]);

                this.clearInput();
            },

            removeCategory(category) {
                this.$emit('input', this.categories.filter(t => t !== category));
            },

            selectCategory(category) {
                this.$emit('input', category);
            },

            clearInput() {
                this.input = '';

                this.suggestions = [];
            },

            handleBackspace() {
                if (this.newCategory.length === 0) {
                    this.$emit('input', this.categories.slice(0, -1));
                }
            },

            getSuggested() {
                if (!this.input) {
                    this.suggestions = [];

                    return;
                }

                if (this.suggestionLimit === 0) {
                    this.suggestions = [];

                    return;
                }

                let queryString = `?filter[containing]=${this.input}&limit=${this.suggestionLimit}`;

                if (this.type) {
                    queryString += `&filter[type]=${this.type}`;
                }

                window.axios.get(`/nova-vendor/ansezz/nova-categories-field${queryString}`).then(response => {
                    // If the input was cleared by the time the request finished,
                    // clear the suggestions too.
                    if (!this.input) {
                        this.suggestions = [];

                        return;
                    }

                    this.suggestions = response.data.filter(suggestion => {
                        return !this.categories.find(category => category === suggestion);
                    });
                });
            },

            insertSuggestion(suggestion) {
                this.$emit('input', [...this.categories, suggestion]);

                this.clearInput();
            },
        },

        render() {
            return this.$scopedSlots.default({
                categories: this.categories,
                addCategory: this.addCategory,
                removeCategory: this.removeCategory,
                selectCategory: this.selectCategory,
                suggestions: this.suggestions,
                insertSuggestion: this.insertSuggestion,
                inputProps: {
                    value: this.input,
                },
                inputEvents: {
                    input: e => {
                        this.input = e.target.value;

                        this.throttledGetSuggested();
                    },
                    keydown: e => {
                        if (e.key === 'Backspace' && this.removeOnBackspace) {
                            this.handleBackspace();
                        }
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            this.addCategory();
                        }
                    },
                },
            });
        },
    };
</script>
